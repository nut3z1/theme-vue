import { ref, computed } from 'vue';
import axios from 'axios';

/**
 * Composable: Fetch & manage WordPress posts
 * Uses WordPress REST API
 */
export function usePosts() {
  const posts = ref([]);
  const post = ref(null);
  const loading = ref(false);
  const error = ref(null);
  const totalPosts = ref(0);
  const totalPages = ref(0);
  const currentPage = ref(1);

  const restUrl = window.wpVueTheme?.restUrl || '/wp-json/';
  const excludeCatId = window.wpVueTheme?.excludeCatId || 0;

  /**
   * Fetch posts list
   */
  async function fetchPosts(params = {}) {
    loading.value = true;
    error.value = null;

    try {
      const apiParams = {
        per_page: params.perPage || 9,
        page: params.page || 1,
        search: params.search || undefined,
        categories: params.category || undefined,
        orderby: params.orderby || 'date',
        order: params.order || 'desc',
        _embed: true,
      };

      if (excludeCatId && !params.category) {
        apiParams.categories_exclude = excludeCatId;
      }

      const response = await axios.get(`${restUrl}wp/v2/posts`, {
        params: apiParams,
      });

      posts.value = response.data.map(formatPost);
      totalPosts.value = parseInt(response.headers['x-wp-total'] || '0');
      totalPages.value = parseInt(response.headers['x-wp-totalpages'] || '0');
      currentPage.value = params.page || 1;
    } catch (err) {
      error.value = 'Không thể tải bài viết. Vui lòng thử lại.';
      console.error('Failed to fetch posts:', err);
    } finally {
      loading.value = false;
    }
  }

  /**
   * Fetch latest posts (for homepage)
   */
  async function fetchLatestPosts(limit = 3) {
    loading.value = true;
    error.value = null;

    try {
      const apiParams = {
        per_page: limit,
        orderby: 'date',
        order: 'desc',
        _embed: true,
      };

      if (excludeCatId) {
        apiParams.categories_exclude = excludeCatId;
      }

      const response = await axios.get(`${restUrl}wp/v2/posts`, {
        params: apiParams,
      });

      posts.value = response.data.map(formatPost);
    } catch (err) {
      error.value = 'Không thể tải bài viết.';
      console.error('Failed to fetch latest posts:', err);
    } finally {
      loading.value = false;
    }
  }

  /**
   * Fetch single post by ID
   */
  async function fetchPost(postId) {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get(`${restUrl}wp/v2/posts/${postId}`, {
        params: { _embed: true },
      });

      post.value = formatPost(response.data);
    } catch (err) {
      error.value = 'Không thể tải bài viết.';
      console.error('Failed to fetch post:', err);
    } finally {
      loading.value = false;
    }
  }

  /**
   * Format post data from REST API
   */
  function formatPost(item) {
    const embedded = item._embedded || {};
    const featuredMedia = embedded['wp:featuredmedia'];
    const author = embedded.author;
    const terms = embedded['wp:term'];

    // Get featured image
    let featuredImage = '';
    if (featuredMedia && featuredMedia[0]) {
      featuredImage = featuredMedia[0].source_url || 
                      (featuredMedia[0].media_details?.sizes?.['post-thumb']?.source_url) ||
                      item.featured_image_url || '';
    }

    // Get categories
    let categories = [];
    if (terms && terms[0]) {
      categories = terms[0].map((t) => ({
        id: t.id,
        name: t.name,
        slug: t.slug,
      }));
    }

    // Get author info
    let authorInfo = { name: 'Admin', avatar: '' };
    if (author && author[0]) {
      authorInfo = {
        name: author[0].name,
        avatar: author[0].avatar_urls?.['48'] || '',
      };
    }

    return {
      id: item.id,
      title: item.title.rendered,
      excerpt: stripHtml(item.excerpt.rendered),
      content: item.content.rendered,
      slug: item.slug,
      link: item.link,
      date: item.date,
      dateFormatted: formatDate(item.date),
      featuredImage,
      author: authorInfo,
      categories,
    };
  }

  /**
   * Strip HTML tags
   */
  function stripHtml(html) {
    const div = document.createElement('div');
    div.innerHTML = html;
    return div.textContent || div.innerText || '';
  }

  /**
   * Format date to Vietnamese
   */
  function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('vi-VN', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });
  }

  const hasPosts = computed(() => posts.value.length > 0);
  const hasMorePages = computed(() => currentPage.value < totalPages.value);

  return {
    posts,
    post,
    loading,
    error,
    totalPosts,
    totalPages,
    currentPage,
    hasPosts,
    hasMorePages,
    fetchPosts,
    fetchLatestPosts,
    fetchPost,
    formatDate,
  };
}

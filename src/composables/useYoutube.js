import { ref, computed } from 'vue';
import axios from 'axios';

/**
 * Composable: Fetch YouTube videos via WordPress REST proxy
 * Endpoint: /wp-json/vuecommerce/v1/youtube
 * API key is stored server-side (wp-config.php or WP options).
 */
export function useYoutube() {
  const videos = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const nextPageToken = ref(null);
  const prevPageToken = ref(null);

  const restUrl = window.wpVueTheme?.restUrl || '/wp-json/';

  /**
   * Fetch videos from the proxy endpoint
   * @param {string} pageToken - YouTube pagination token (optional)
   * @param {number} maxResults - videos per page (default 10)
   */
  async function fetchVideos(pageToken = '', maxResults = 10) {
    loading.value = true;
    error.value = null;

    try {
      const params = { maxResults };
      if (pageToken) params.pageToken = pageToken;

      const response = await axios.get(`${restUrl}vuecommerce/v1/youtube`, { params });
      const data = response.data;

      videos.value = (data.items || []).map(formatVideo);
      nextPageToken.value = data.nextPageToken || null;
      prevPageToken.value = data.prevPageToken || null;
    } catch (err) {
      const msg =
        err.response?.data?.message ||
        'Không thể tải video. Vui lòng thử lại.';
      error.value = msg;
      console.error('[useYoutube] fetchVideos failed:', err);
    } finally {
      loading.value = false;
    }
  }

  /**
   * Go to next page
   */
  async function nextPage(maxResults = 10) {
    if (nextPageToken.value) {
      await fetchVideos(nextPageToken.value, maxResults);
    }
  }

  /**
   * Go to previous page
   */
  async function prevPage(maxResults = 10) {
    if (prevPageToken.value) {
      await fetchVideos(prevPageToken.value, maxResults);
    }
  }

  /**
   * Format a raw YouTube search result item
   */
  function formatVideo(item) {
    return {
      videoId: item.id?.videoId || '',
      title: item.snippet?.title || '',
      description: item.snippet?.description || '',
      thumbnail: item.snippet?.thumbnails?.medium?.src
        || item.snippet?.thumbnails?.medium?.url
        || item.snippet?.thumbnails?.default?.url
        || '',
      channelTitle: item.snippet?.channelTitle || '',
      publishedAt: item.snippet?.publishedAt || '',
      publishedFormatted: formatDate(item.snippet?.publishedAt || ''),
      embedUrl: item.id?.videoId
        ? `https://www.youtube.com/embed/${item.id.videoId}`
        : '',
    };
  }

  /**
   * Format ISO date to Vietnamese locale
   */
  function formatDate(dateStr) {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('vi-VN', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });
  }

  const hasVideos = computed(() => videos.value.length > 0);
  const hasNext = computed(() => !!nextPageToken.value);
  const hasPrev = computed(() => !!prevPageToken.value);

  return {
    videos,
    loading,
    error,
    nextPageToken,
    prevPageToken,
    hasVideos,
    hasNext,
    hasPrev,
    fetchVideos,
    nextPage,
    prevPage,
  };
}

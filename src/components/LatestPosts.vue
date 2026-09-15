<template>
  <section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50">
            Tin Tức <span class="bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">Mới Nhất</span>
          </h2>
          <p class="text-dark-400 mt-1 text-sm">Cập nhật tin tức, xu hướng và kiến thức hữu ích</p>
        </div>
        <a :href="blogUrl" 
           class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors group">
          Xem tất cả
          <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div v-for="i in 5" :key="i" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
          <div class="aspect-[4/3] bg-dark-700"></div>
          <div class="p-4 space-y-2">
            <div class="h-3 bg-dark-700 rounded w-1/3"></div>
            <div class="h-4 bg-dark-700 rounded w-3/4"></div>
            <div class="h-3 bg-dark-700 rounded w-full"></div>
          </div>
        </div>
      </div>

      <!-- Posts Grid (1 large + 4 small) -->
      <div v-else-if="posts.length > 0" class="grid grid-cols-1 lg:grid-cols-5 gap-4">
        <!-- Featured Post (large - 2 columns) -->
        <a v-if="posts[0]" :href="posts[0].link" 
           class="lg:col-span-2 lg:row-span-2 group block bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden hover:border-primary-500/30 transition-all">
          <div class="relative h-full">
            <div class="aspect-[4/3] lg:aspect-auto lg:h-full overflow-hidden bg-dark-800">
              <img v-if="posts[0].featuredImage"
                   :src="posts[0].featuredImage"
                   :alt="posts[0].title"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                   loading="lazy">
              <div v-else class="w-full h-full min-h-[200px] flex items-center justify-center bg-gradient-to-br from-primary-500/10 to-secondary-500/10">
                <svg class="w-16 h-16 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
              </div>
              <!-- Overlay gradient -->
              <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-dark-900/40 to-transparent"></div>
            </div>
            <!-- Content overlay -->
            <div class="absolute bottom-0 left-0 right-0 p-5 lg:p-6">
              <div v-if="posts[0].categories?.length" class="mb-2">
                <span class="px-2.5 py-0.5 text-xs font-semibold text-primary-300 bg-primary-500/20 backdrop-blur-sm rounded-full">
                  {{ posts[0].categories[0].name }}
                </span>
              </div>
              <h3 class="text-lg lg:text-xl font-display font-bold text-dark-50 group-hover:text-primary-300 transition-colors line-clamp-2 mb-2">
                {{ posts[0].title }}
              </h3>
              <p class="text-sm text-dark-300 line-clamp-2 hidden lg:block">{{ posts[0].excerpt }}</p>
              <div class="flex items-center gap-2 mt-3 text-xs text-dark-400">
                <time>{{ posts[0].dateFormatted }}</time>
                <span>•</span>
                <span>{{ posts[0].author.name }}</span>
              </div>
            </div>
          </div>
        </a>

        <!-- 4 Small Posts (3 columns, 2 rows) -->
        <template v-for="(post, index) in posts.slice(1, 5)" :key="post.id">
          <a :href="post.link"
             class="group flex lg:flex-col bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden hover:border-primary-500/30 transition-all">
            <!-- Image -->
            <div class="relative w-28 sm:w-32 lg:w-full shrink-0 overflow-hidden bg-dark-800">
              <div class="aspect-square lg:aspect-[4/3]">
                <img v-if="post.featuredImage"
                     :src="post.featuredImage"
                     :alt="post.title"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     loading="lazy">
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500/5 to-secondary-500/5">
                  <svg class="w-8 h-8 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7"/>
                  </svg>
                </div>
              </div>
            </div>
            <!-- Content -->
            <div class="flex-1 p-3 lg:p-4 flex flex-col justify-center">
              <time class="text-[10px] text-dark-500 mb-1">{{ post.dateFormatted }}</time>
              <h3 class="text-sm font-semibold text-dark-100 group-hover:text-primary-400 transition-colors line-clamp-2 leading-snug">
                {{ post.title }}
              </h3>
            </div>
          </a>
        </template>
      </div>

      <!-- Empty -->
      <div v-else class="text-center py-12 bg-dark-800/30 rounded-2xl border border-dark-700">
        <p class="text-dark-500 text-sm">Chưa có bài viết nào</p>
      </div>

      <!-- Mobile View All -->
      <div class="sm:hidden text-center mt-6">
        <a :href="blogUrl" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-400">
          Xem tất cả bài viết →
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const wpData = window.wpVueTheme || {};
const restUrl = wpData.restUrl || '/wp-json/';
const blogUrl = wpData.homeUrl ? wpData.homeUrl + 'blog' : '/blog';

const posts = ref([]);
const loading = ref(true);

function stripHtml(html) {
  const div = document.createElement('div');
  div.innerHTML = html;
  return div.textContent || div.innerText || '';
}

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString('vi-VN', { year: 'numeric', month: 'long', day: 'numeric' });
}

function formatPost(item) {
  const embedded = item._embedded || {};
  const featuredMedia = embedded['wp:featuredmedia'];
  const author = embedded.author;
  const terms = embedded['wp:term'];

  let featuredImage = '';
  if (featuredMedia && featuredMedia[0]) {
    featuredImage = featuredMedia[0].source_url || '';
  }

  let categories = [];
  if (terms && terms[0]) {
    categories = terms[0].map(t => ({ id: t.id, name: t.name, slug: t.slug }));
  }

  return {
    id: item.id,
    title: item.title.rendered,
    excerpt: stripHtml(item.excerpt.rendered),
    slug: item.slug,
    link: item.link,
    date: item.date,
    dateFormatted: formatDate(item.date),
    featuredImage,
    author: { name: author?.[0]?.name || 'Admin' },
    categories,
  };
}

onMounted(async () => {
  try {
    const res = await axios.get(`${restUrl}wp/v2/posts`, {
      params: { per_page: 5, orderby: 'date', order: 'desc', _embed: true },
    });
    posts.value = res.data.map(formatPost);
  } catch (e) {
    console.error('Failed to fetch latest posts:', e);
  } finally {
    loading.value = false;
  }
});
</script>

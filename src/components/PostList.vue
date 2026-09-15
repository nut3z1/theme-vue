<template>
  <section class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Header -->
      <div class="text-center mb-14">
        <h1 class="text-3xl sm:text-4xl font-display font-bold text-dark-50 mb-4">
          Bài Viết <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">Mới Nhất</span>
        </h1>
        <p class="text-dark-400 max-w-2xl mx-auto text-lg">
          Cập nhật tin tức, xu hướng và kiến thức hữu ích
        </p>
      </div>

      <!-- Filters Bar -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10 p-4 bg-dark-800/50 rounded-2xl border border-dark-700">
        <!-- Search -->
        <div class="relative w-full sm:w-80">
          <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input v-model="searchQuery"
                 @keyup.enter="handleFilter"
                 type="text"
                 placeholder="Tìm kiếm bài viết..."
                 class="w-full pl-10 pr-4 py-2.5 bg-dark-900 border border-dark-600 rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500/30 text-sm">
        </div>

        <!-- Category Filter -->
        <select v-model="selectedCategory"
                @change="handleFilter"
                class="w-full sm:w-auto px-4 py-2.5 bg-dark-900 border border-dark-600 rounded-xl text-dark-200 text-sm focus:outline-none focus:border-primary-500 appearance-none cursor-pointer">
          <option value="">Tất cả chuyên mục</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">
            {{ cat.name }} ({{ cat.count }})
          </option>
        </select>
      </div>

      <!-- Loading -->
      <div v-if="loading && !hasPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="i in 9" :key="i" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
          <div class="aspect-[16/10] bg-dark-700"></div>
          <div class="p-5 space-y-3">
            <div class="flex items-center gap-3">
              <div class="w-6 h-6 bg-dark-700 rounded-full"></div>
              <div class="h-3 bg-dark-700 rounded w-20"></div>
              <div class="h-3 bg-dark-700 rounded w-24"></div>
            </div>
            <div class="h-5 bg-dark-700 rounded w-3/4"></div>
            <div class="h-4 bg-dark-700 rounded w-full"></div>
            <div class="h-4 bg-dark-700 rounded w-2/3"></div>
          </div>
        </div>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-500/10 flex items-center justify-center">
          <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
          </svg>
        </div>
        <p class="text-dark-400">{{ error }}</p>
      </div>

      <!-- Posts Grid -->
      <div v-else-if="hasPosts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <PostCard v-for="post in posts" :key="post.id" :post="post" />
      </div>

      <!-- Empty -->
      <div v-else class="text-center py-20">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-dark-800 flex items-center justify-center">
          <svg class="w-10 h-10 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
          </svg>
        </div>
        <h3 class="text-xl font-display font-semibold text-dark-200 mb-2">Chưa có bài viết</h3>
        <p class="text-dark-400">Nội dung sẽ sớm được cập nhật</p>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="flex items-center justify-center gap-2 mt-12">
        <button @click="goToPage(currentPage - 1)"
                :disabled="currentPage <= 1"
                class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>

        <button v-for="page in totalPages" :key="page"
                @click="goToPage(page)"
                class="min-w-[40px] h-10 px-3 rounded-xl text-sm font-medium transition-all"
                :class="page === currentPage 
                  ? 'bg-primary-500 text-white shadow-glow' 
                  : 'border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400'">
          {{ page }}
        </button>

        <button @click="goToPage(currentPage + 1)"
                :disabled="currentPage >= totalPages"
                class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePosts } from '../composables/usePosts.js';
import PostCard from './PostCard.vue';

const { posts, loading, error, totalPages, currentPage, hasPosts, fetchPosts } = usePosts();

const wpData = window.wpVueTheme || {};
const restUrl = wpData.restUrl || '/wp-json/';

const searchQuery = ref('');
const selectedCategory = ref('');
const categories = ref([]);

function handleFilter() {
  fetchPosts({ 
    page: 1, 
    search: searchQuery.value, 
    category: selectedCategory.value 
  });
}

function goToPage(page) {
  if (page < 1 || page > totalPages.value) return;
  fetchPosts({ 
    page, 
    search: searchQuery.value, 
    category: selectedCategory.value 
  });
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function fetchCategories() {
  try {
    const res = await axios.get(`${restUrl}wp/v2/categories`, {
      params: { hide_empty: true }
    });
    categories.value = res.data;
  } catch (err) {
    console.error('Failed to fetch post categories:', err);
  }
}

onMounted(() => {
  const wpPage = window.wpVueTheme?.currentPage || 1;
  fetchPosts({ page: wpPage });
  fetchCategories();
});
</script>

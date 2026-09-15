<template>
  <section class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Header -->
      <div class="mb-10">
        <h1 class="text-3xl sm:text-4xl font-display font-bold text-dark-50 mb-3">
          Sản Phẩm
        </h1>
        <p class="text-dark-400">Khám phá bộ sưu tập sản phẩm đa dạng của chúng tôi</p>
      </div>

      <!-- Filters Bar -->
      <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-8 p-4 bg-dark-800/50 rounded-2xl border border-dark-700">
        <!-- Search -->
        <div class="relative w-full lg:w-80">
          <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input v-model="searchQuery"
                 @input="debouncedSearch"
                 type="text"
                 placeholder="Tìm kiếm sản phẩm..."
                 class="w-full pl-10 pr-4 py-2.5 bg-dark-900 border border-dark-600 rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500/30 text-sm">
        </div>

        <div class="flex items-center gap-3 w-full lg:w-auto">
          <!-- Category Filter -->
          <select v-model="selectedCategory"
                  @change="handleFilter"
                  class="flex-1 lg:flex-none px-4 py-2.5 bg-dark-900 border border-dark-600 rounded-xl text-dark-200 text-sm focus:outline-none focus:border-primary-500 appearance-none cursor-pointer">
            <option value="">Tất cả danh mục</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
              {{ cat.name }} ({{ cat.count }})
            </option>
          </select>

          <!-- Sort -->
          <select v-model="sortBy"
                  @change="handleFilter"
                  class="flex-1 lg:flex-none px-4 py-2.5 bg-dark-900 border border-dark-600 rounded-xl text-dark-200 text-sm focus:outline-none focus:border-primary-500 appearance-none cursor-pointer">
            <option value="date">Mới nhất</option>
            <option value="price-asc">Giá thấp → cao</option>
            <option value="price-desc">Giá cao → thấp</option>
            <option value="popularity">Phổ biến nhất</option>
            <option value="rating">Đánh giá cao</option>
          </select>
        </div>
      </div>

      <!-- Results Count -->
      <div v-if="totalProducts > 0" class="mb-6 text-sm text-dark-400">
        Hiển thị <span class="text-dark-200 font-medium">{{ products.length }}</span> 
        trong <span class="text-dark-200 font-medium">{{ totalProducts }}</span> sản phẩm
      </div>

      <!-- Loading -->
      <div v-if="loading && products.length === 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <div v-for="i in 12" :key="i" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
          <div class="aspect-square bg-dark-700"></div>
          <div class="p-4 space-y-3">
            <div class="h-3 bg-dark-700 rounded w-1/3"></div>
            <div class="h-4 bg-dark-700 rounded w-3/4"></div>
            <div class="h-5 bg-dark-700 rounded w-1/2"></div>
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
        <p class="text-dark-400 mb-4">{{ error }}</p>
        <button @click="handleFilter" class="px-6 py-2.5 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition-colors text-sm font-medium">
          Thử lại
        </button>
      </div>

      <!-- Products Grid -->
      <div v-else-if="hasProducts" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <ProductCard v-for="product in products" :key="product.id" :product="product" />
      </div>

      <!-- Empty -->
      <div v-else class="text-center py-20">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-dark-800 flex items-center justify-center">
          <svg class="w-10 h-10 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <h3 class="text-xl font-display font-semibold text-dark-200 mb-2">Không tìm thấy sản phẩm</h3>
        <p class="text-dark-400 mb-6">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
        <button @click="resetFilters" class="px-6 py-2.5 border border-dark-600 text-dark-300 rounded-xl hover:border-primary-500/50 hover:text-primary-400 transition-all text-sm font-medium">
          Xóa bộ lọc
        </button>
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

        <template v-for="page in paginationPages" :key="page">
          <button v-if="page !== '...'"
                  @click="goToPage(page)"
                  class="min-w-[40px] h-10 px-3 rounded-xl text-sm font-medium transition-all"
                  :class="page === currentPage 
                    ? 'bg-primary-500 text-white shadow-glow' 
                    : 'border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400'">
            {{ page }}
          </button>
          <span v-else class="px-2 text-dark-500">...</span>
        </template>

        <button @click="goToPage(currentPage + 1)"
                :disabled="currentPage >= totalPages"
                class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>

      <!-- Loading overlay for page transitions -->
      <div v-if="loading && products.length > 0" 
           class="fixed inset-0 bg-dark-900/50 backdrop-blur-sm z-40 flex items-center justify-center">
        <div class="w-12 h-12 border-4 border-dark-600 border-t-primary-500 rounded-full animate-spin"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useProducts } from '../composables/useProducts.js';
import ProductCard from './ProductCard.vue';

const { products, loading, error, totalProducts, totalPages, currentPage, categories, hasProducts, fetchProducts, fetchCategories } = useProducts();

const searchQuery = ref('');
const selectedCategory = ref('');
const sortBy = ref('date');
let searchTimeout = null;

// Pagination
const paginationPages = computed(() => {
  const pages = [];
  const total = totalPages.value;
  const current = currentPage.value;

  if (total <= 7) {
    for (let i = 1; i <= total; i++) pages.push(i);
  } else {
    pages.push(1);
    if (current > 3) pages.push('...');
    for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
      pages.push(i);
    }
    if (current < total - 2) pages.push('...');
    pages.push(total);
  }

  return pages;
});

function getSortParams() {
  switch (sortBy.value) {
    case 'price-asc': return { orderby: 'price', order: 'asc' };
    case 'price-desc': return { orderby: 'price', order: 'desc' };
    case 'popularity': return { orderby: 'popularity', order: 'desc' };
    case 'rating': return { orderby: 'rating', order: 'desc' };
    default: return { orderby: 'date', order: 'desc' };
  }
}

function handleFilter() {
  const sort = getSortParams();
  fetchProducts({
    page: 1,
    search: searchQuery.value,
    category: selectedCategory.value || undefined,
    ...sort,
  });
}

function debouncedSearch() {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    handleFilter();
  }, 400);
}

function goToPage(page) {
  if (page < 1 || page > totalPages.value) return;
  const sort = getSortParams();
  fetchProducts({
    page,
    search: searchQuery.value,
    category: selectedCategory.value || undefined,
    ...sort,
  });
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetFilters() {
  searchQuery.value = '';
  selectedCategory.value = '';
  sortBy.value = 'date';
  fetchProducts({ page: 1 });
}

onMounted(() => {
  fetchProducts({ page: 1 });
  fetchCategories();
});
</script>

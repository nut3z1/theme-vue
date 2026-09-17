<template>
  <section class="py-20 relative">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-14">
        <h2 class="text-3xl sm:text-4xl font-display font-bold text-dark-50 mb-4">
          Sản Phẩm <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">Nổi Bật</span>
        </h2>
        <p class="text-dark-400 max-w-2xl mx-auto text-lg">
          Những sản phẩm được yêu thích nhất, chất lượng đảm bảo với giá tốt nhất
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <div v-for="i in 8" :key="i" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
          <div class="aspect-square bg-dark-700"></div>
          <div class="p-4 space-y-3">
            <div class="h-3 bg-dark-700 rounded w-1/3"></div>
            <div class="h-4 bg-dark-700 rounded w-3/4"></div>
            <div class="h-5 bg-dark-700 rounded w-1/2"></div>
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-500/10 flex items-center justify-center">
          <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
          </svg>
        </div>
        <p class="text-dark-400">{{ error }}</p>
      </div>

      <!-- Products Grid -->
      <div v-else-if="hasProducts" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <ProductCard v-for="product in products" :key="product.id" :product="product" />
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-12">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-dark-800 flex items-center justify-center">
          <svg class="w-8 h-8 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        </div>
        <p class="text-dark-400">Chưa có sản phẩm nào</p>
      </div>

      <!-- View All Button -->
      <div v-if="hasProducts" class="text-center mt-12">
        <a :href="shopUrl" 
           class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl border border-dark-700 text-dark-300 hover:text-dark-50 hover:border-primary-500/50 hover:bg-primary-500/5 font-medium transition-all duration-300 group">
          <span>Xem tất cả sản phẩm</span>
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue';
import { useProducts } from '../composables/useProducts.js';
import ProductCard from './ProductCard.vue';

const { products, loading, error, hasProducts, fetchFeaturedProducts } = useProducts();

const wpData = window.wpVueTheme || {};
const shopUrl = wpData.wcActive ? (wpData.shopUrl || ((wpData.homeUrl || '/') + 'cua-hang')) : '#';

onMounted(() => {
  fetchFeaturedProducts(8);
});
</script>

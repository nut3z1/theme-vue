<template>
  <section class="py-12">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50">
            Sản Phẩm <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">Mới Nhất</span>
          </h2>
          <p class="text-dark-400 mt-1 text-sm">Cập nhật những sản phẩm mới nhất tại cửa hàng</p>
        </div>
        <a :href="shopUrl" 
           class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors group">
          Xem tất cả
          <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div v-for="i in 10" :key="i" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
          <div class="aspect-square bg-dark-700"></div>
          <div class="p-3 space-y-2">
            <div class="h-3 bg-dark-700 rounded w-1/3"></div>
            <div class="h-4 bg-dark-700 rounded w-3/4"></div>
            <div class="h-4 bg-dark-700 rounded w-1/2"></div>
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div v-else-if="products.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <ProductCard v-for="product in products" :key="product.id" :product="product" />
      </div>

      <!-- Empty -->
      <div v-else class="text-center py-12 bg-dark-800/30 rounded-2xl border border-dark-700">
        <svg class="w-12 h-12 mx-auto text-dark-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <p class="text-dark-500 text-sm">Chưa có sản phẩm mới</p>
      </div>

      <!-- Mobile View All -->
      <div class="sm:hidden text-center mt-6">
        <a :href="shopUrl" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-400">
          Xem tất cả sản phẩm →
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ProductCard from './ProductCard.vue';

const wpData = window.wpVueTheme || {};
const restUrl = wpData.restUrl || '/wp-json/';
const shopUrl = wpData.shopUrl || ((wpData.homeUrl || '/') + 'cua-hang');

const products = ref([]);
const loading = ref(true);

function formatProduct(item) {
  const prices = item.prices || {};
  const currencyMinorUnit = prices.currency_minor_unit || 0;
  const divisor = Math.pow(10, currencyMinorUnit);
  return {
    id: item.id,
    name: item.name,
    slug: item.slug,
    permalink: item.permalink,
    price: prices.price ? parseFloat(prices.price) / divisor : 0,
    regularPrice: prices.regular_price ? parseFloat(prices.regular_price) / divisor : 0,
    salePrice: prices.sale_price ? parseFloat(prices.sale_price) / divisor : 0,
    currencySymbol: prices.currency_symbol || '₫',
    onSale: item.on_sale || false,
    images: (item.images || []).map(img => ({ id: img.id, src: img.src, thumbnail: img.thumbnail, alt: img.alt || item.name })),
    categories: (item.categories || []).map(c => ({ id: c.id, name: c.name, slug: c.slug })),
    averageRating: parseFloat(item.average_rating || '0'),
    reviewCount: item.review_count || 0,
    isInStock: item.is_in_stock,
    stockStatus: item.is_in_stock ? 'instock' : 'outofstock',
  };
}

onMounted(async () => {
  try {
    const res = await axios.get(`${restUrl}wc/store/v1/products`, {
      params: { per_page: 10, orderby: 'date', order: 'desc' },
    });
    products.value = res.data.map(formatProduct);
  } catch (e) {
    console.error('Failed to fetch new products:', e);
  } finally {
    loading.value = false;
  }
});
</script>

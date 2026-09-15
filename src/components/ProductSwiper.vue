<template>
  <section class="py-12 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50">
            Sản Phẩm <span class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">Nổi Bật</span>
          </h2>
          <p class="text-dark-400 mt-1 text-sm">Những sản phẩm được yêu thích nhất</p>
        </div>
        <!-- Swiper Navigation -->
        <div class="flex items-center gap-2">
          <button ref="prevBtn"
                  class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </button>
          <button ref="nextBtn"
                  class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="flex gap-4 overflow-hidden">
        <div v-for="i in 5" :key="i" class="shrink-0 w-[220px] bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
          <div class="aspect-square bg-dark-700"></div>
          <div class="p-3 space-y-2">
            <div class="h-4 bg-dark-700 rounded w-3/4"></div>
            <div class="h-4 bg-dark-700 rounded w-1/2"></div>
          </div>
        </div>
      </div>

      <!-- Swiper -->
      <div v-else-if="products.length > 0" ref="swiperContainer" class="swiper product-swiper">
        <div class="swiper-wrapper">
          <div v-for="product in products" :key="product.id" class="swiper-slide">
            <a :href="product.permalink || '#'" 
               class="group block bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden hover:border-primary-500/30 hover:shadow-glow transition-all duration-300">
              <!-- Image -->
              <div class="relative aspect-square overflow-hidden bg-dark-800">
                <img v-if="product.images && product.images.length > 0"
                     :src="product.images[0].src"
                     :alt="product.images[0].alt || product.name"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     loading="lazy">
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-dark-700 to-dark-800">
                  <svg class="w-12 h-12 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <!-- Sale Badge -->
                <span v-if="product.onSale" 
                      class="absolute top-2 left-2 px-2.5 py-0.5 text-[10px] font-bold text-white bg-secondary-500 rounded-full">
                  SALE
                </span>
              </div>

              <!-- Info -->
              <div class="p-3">
                <p v-if="product.categories?.length" class="text-[10px] text-primary-400 font-medium uppercase tracking-wider mb-1">
                  {{ product.categories[0].name }}
                </p>
                <h3 class="text-sm font-semibold text-dark-100 group-hover:text-dark-50 transition-colors line-clamp-2 mb-1.5 leading-snug">
                  {{ product.name }}
                </h3>
                <div class="flex items-center gap-1.5">
                  <span class="text-base font-bold" :class="product.onSale ? 'text-secondary-400' : 'text-dark-50'">
                    {{ formatPrice(product.onSale ? product.salePrice : product.price) }}
                  </span>
                  <span v-if="product.onSale" class="text-xs text-dark-500 line-through">
                    {{ formatPrice(product.regularPrice) }}
                  </span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else class="text-center py-12 bg-dark-800/30 rounded-2xl border border-dark-700">
        <p class="text-dark-500 text-sm">Chưa có sản phẩm nổi bật</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import axios from 'axios';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';
import 'swiper/css';

const wpData = window.wpVueTheme || {};
const restUrl = wpData.restUrl || '/wp-json/';

const products = ref([]);
const loading = ref(true);
const swiperContainer = ref(null);
const prevBtn = ref(null);
const nextBtn = ref(null);

function formatPrice(price, symbol = '₫') {
  if (!price && price !== 0) return '';
  return new Intl.NumberFormat('vi-VN').format(price) + (symbol || '₫');
}

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
  };
}

onMounted(async () => {
  try {
    const res = await axios.get(`${restUrl}wc/store/v1/products`, {
      params: { per_page: 10, featured: true, orderby: 'date', order: 'desc' },
    });
    let data = res.data;
    // Fallback nếu không có featured
    if (!data || data.length === 0) {
      const fallback = await axios.get(`${restUrl}wc/store/v1/products`, {
        params: { per_page: 10, orderby: 'popularity', order: 'desc' },
      });
      data = fallback.data;
    }
    products.value = data.map(formatProduct);
  } catch (e) {
    console.error('Failed to fetch swiper products:', e);
  } finally {
    loading.value = false;
  }

  // Init Swiper after data loaded
  await nextTick();
  if (swiperContainer.value && products.value.length > 0) {
    new Swiper(swiperContainer.value, {
      modules: [Navigation, Autoplay],
      slidesPerView: 2,
      spaceBetween: 16,
      loop: products.value.length > 4,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        prevEl: prevBtn.value,
        nextEl: nextBtn.value,
      },
      breakpoints: {
        640: { slidesPerView: 3, spaceBetween: 16 },
        768: { slidesPerView: 4, spaceBetween: 16 },
        1024: { slidesPerView: 5, spaceBetween: 20 },
      },
    });
  }
});
</script>

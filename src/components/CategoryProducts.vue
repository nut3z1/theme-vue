<template>
  <section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50">
            Sản Phẩm Theo <span class="bg-gradient-to-r from-secondary-400 to-accent-400 bg-clip-text text-transparent">Danh Mục</span>
          </h2>
          <p class="text-dark-400 mt-1 text-sm">Khám phá sản phẩm theo từng danh mục</p>
        </div>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="space-y-10">
        <div v-for="i in 2" :key="i">
          <div class="h-6 w-40 bg-dark-700 rounded mb-4 animate-pulse"></div>
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div v-for="j in 4" :key="j" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden animate-pulse">
              <div class="aspect-square bg-dark-700"></div>
              <div class="p-3 space-y-2">
                <div class="h-4 bg-dark-700 rounded w-3/4"></div>
                <div class="h-4 bg-dark-700 rounded w-1/2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Category Sections -->
      <div v-else class="space-y-12">
        <div v-for="cat in categoryData" :key="cat.id">
          <!-- Category Header -->
          <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
              <div class="w-1 h-6 bg-gradient-to-b from-primary-500 to-secondary-500 rounded-full"></div>
              <h3 class="text-lg font-display font-bold text-dark-100">{{ cat.name }}</h3>
              <span class="text-xs text-dark-500 bg-dark-800 px-2 py-0.5 rounded-full">{{ cat.count }} sản phẩm</span>
            </div>
            <a :href="cat.url"
               class="text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors flex items-center gap-1 group">
              Xem thêm
              <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>

          <!-- Products Grid (4 per category) -->
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <ProductCard v-for="product in cat.products" :key="product.id" :product="product" />
          </div>
        </div>

        <!-- No categories -->
        <div v-if="categoryData.length === 0" class="text-center py-12 bg-dark-800/30 rounded-2xl border border-dark-700">
          <p class="text-dark-500 text-sm">Chưa có danh mục sản phẩm</p>
        </div>
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
const homeUrl = wpData.homeUrl || '/';

const categoryData = ref([]);
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
    // Fetch categories
    const catRes = await axios.get(`${restUrl}wc/store/v1/products/categories`, {
      params: { per_page: 20, orderby: 'count', order: 'desc' },
    });

    // Get top 4 categories that have products (skip "Uncategorized")
    const topCats = catRes.data
      .filter(c => c.count > 0 && c.name.toLowerCase() !== 'uncategorized' && c.name !== 'Chưa phân loại')
      .slice(0, 4);

    // Fetch 4 products for each category (in parallel)
    const promises = topCats.map(async (cat) => {
      try {
        const prodRes = await axios.get(`${restUrl}wc/store/v1/products`, {
          params: { per_page: 4, category: cat.id, orderby: 'date', order: 'desc' },
        });
        return {
          id: cat.id,
          name: cat.name,
          slug: cat.slug,
          count: cat.count,
          url: `${homeUrl}product-category/${cat.slug}/`,
          products: prodRes.data.map(formatProduct),
        };
      } catch (e) {
        return null;
      }
    });

    const results = await Promise.all(promises);
    categoryData.value = results.filter(r => r && r.products.length > 0);
  } catch (e) {
    console.error('Failed to fetch category products:', e);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <section class="py-12">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Breadcrumb -->
      <nav class="mb-8 flex items-center gap-2 text-sm text-dark-400">
        <a :href="homeUrl" class="hover:text-primary-400 transition-colors">Trang chủ</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a :href="shopUrl" class="hover:text-primary-400 transition-colors">Sản phẩm</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-dark-200">{{ productData.name }}</span>
      </nav>

      <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
        <!-- Image Gallery -->
        <div class="space-y-4">
          <!-- Main Image -->
          <div class="relative aspect-square rounded-2xl overflow-hidden bg-dark-800 border border-dark-700">
            <img v-if="activeImage"
                 :src="activeImage.src"
                 :alt="activeImage.alt || productData.name"
                 class="w-full h-full object-cover transition-transform duration-500"
                 :class="zoomed ? 'scale-150 cursor-zoom-out' : 'cursor-zoom-in'"
                 @click="zoomed = !zoomed">
            <div v-else class="w-full h-full flex items-center justify-center">
              <svg class="w-24 h-24 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>

            <!-- Sale Badge -->
            <span v-if="productData.on_sale" 
                  class="absolute top-4 left-4 px-4 py-1.5 text-sm font-bold text-white bg-secondary-500 rounded-full shadow-lg">
              GIẢM GIÁ
            </span>
          </div>

          <!-- Thumbnails -->
          <div v-if="images.length > 1" class="flex gap-3 overflow-x-auto pb-2">
            <button v-for="(img, index) in images" 
                    :key="img.id || index"
                    @click="activeImageIndex = index"
                    class="shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 transition-all"
                    :class="activeImageIndex === index ? 'border-primary-500 shadow-glow' : 'border-dark-700 hover:border-dark-500'">
              <img :src="img.thumbnail || img.src" :alt="img.alt" class="w-full h-full object-cover">
            </button>
          </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
          <!-- Categories -->
          <div v-if="productData.categories && productData.categories.length" class="flex flex-wrap gap-2">
            <span v-for="cat in productData.categories" :key="cat" 
                  class="px-3 py-1 text-xs font-medium text-primary-400 bg-primary-500/10 rounded-full border border-primary-500/20">
              {{ typeof cat === 'string' ? cat : cat.name }}
            </span>
          </div>

          <!-- Name -->
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-dark-50 leading-tight">
            {{ productData.name }}
          </h1>

          <!-- Rating -->
          <div v-if="productData.average_rating > 0" class="flex items-center gap-3">
            <div class="flex items-center gap-1">
              <svg v-for="i in 5" :key="i" class="w-5 h-5" 
                   :class="i <= Math.round(parseFloat(productData.average_rating)) ? 'text-accent-400' : 'text-dark-600'"
                   fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
              </svg>
            </div>
            <span class="text-sm text-dark-400">{{ productData.average_rating }} ({{ productData.review_count }} đánh giá)</span>
          </div>

          <!-- Price -->
          <div class="flex items-baseline gap-3">
            <span v-if="productData.on_sale" class="text-3xl font-bold text-secondary-400">
              {{ formatDisplayPrice(productData.sale_price) }}
            </span>
            <span class="text-3xl font-bold" :class="productData.on_sale ? 'text-dark-500 line-through text-xl' : 'text-dark-50'">
              {{ formatDisplayPrice(productData.regular_price || productData.price) }}
            </span>
            <span v-if="productData.on_sale && discountPercent > 0" 
                  class="px-2 py-0.5 text-sm font-bold text-secondary-400 bg-secondary-500/10 rounded-lg">
              -{{ discountPercent }}%
            </span>
          </div>

          <!-- Divider -->
          <hr class="border-dark-700">

          <!-- Short Description -->
          <div v-if="productData.short_description" 
               class="text-dark-300 leading-relaxed prose prose-invert prose-sm max-w-none"
               v-html="productData.short_description">
          </div>

          <!-- SKU & Stock -->
          <div class="flex flex-wrap items-center gap-4 text-sm">
            <span v-if="productData.sku" class="text-dark-400">
              SKU: <span class="text-dark-200">{{ productData.sku }}</span>
            </span>
            <span class="flex items-center gap-1.5"
                  :class="isInStock ? 'text-green-400' : 'text-red-400'">
              <span class="w-2 h-2 rounded-full" :class="isInStock ? 'bg-green-400' : 'bg-red-400'"></span>
              {{ isInStock ? 'Còn hàng' : 'Hết hàng' }}
              <span v-if="productData.stock_quantity && isInStock" class="text-dark-400">
                ({{ productData.stock_quantity }})
              </span>
            </span>
          </div>

          <!-- Quantity & Add to Cart -->
          <div v-if="isInStock" class="flex items-center gap-4">
            <!-- Quantity Selector -->
            <div class="flex items-center border border-dark-700 rounded-xl overflow-hidden">
              <button @click="decreaseQty" 
                      class="p-3 text-dark-400 hover:text-dark-50 hover:bg-dark-700 transition-colors"
                      :disabled="quantity <= 1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                </svg>
              </button>
              <input v-model.number="quantity" 
                     type="number" 
                     min="1"
                     class="w-14 text-center bg-transparent text-dark-50 font-medium border-x border-dark-700 py-2.5 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
              <button @click="increaseQty" 
                      class="p-3 text-dark-400 hover:text-dark-50 hover:bg-dark-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
              </button>
            </div>

            <!-- Add to Cart -->
            <button @click="handleAddToCart" 
                    :disabled="adding"
                    class="flex-1 flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
              <svg v-if="!adding" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
              </svg>
              <svg v-else class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              <span>{{ adding ? 'Đang thêm...' : addedSuccess ? 'Đã thêm ✓' : 'Thêm vào giỏ hàng' }}</span>
            </button>
          </div>

          <!-- Out of stock message -->
          <div v-else class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm">
            Sản phẩm hiện đang hết hàng. Vui lòng quay lại sau.
          </div>

          <!-- Product Attributes -->
          <div v-if="productData.attributes && productData.attributes.length" class="space-y-3">
            <div v-for="attr in productData.attributes" :key="attr.name" 
                 class="flex items-start gap-3 text-sm">
              <span class="text-dark-400 min-w-[100px]">{{ attr.name }}:</span>
              <span class="text-dark-200">{{ Array.isArray(attr.options) ? attr.options.join(', ') : attr.options }}</span>
            </div>
          </div>

          <!-- Tags -->
          <div v-if="productData.tags && productData.tags.length" class="flex flex-wrap gap-2 pt-2">
            <span v-for="tag in productData.tags" :key="tag" 
                  class="px-3 py-1 text-xs text-dark-400 bg-dark-800 rounded-full border border-dark-700">
              #{{ typeof tag === 'string' ? tag : tag.name }}
            </span>
          </div>
        </div>
      </div>

      <!-- Description and Specifications Tabs -->
      <div class="mt-16 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Description -->
        <div class="lg:col-span-2">
          <div class="border-b border-dark-700 mb-8">
            <h3 class="px-6 py-3 text-lg font-semibold text-primary-400 border-b-2 border-primary-500 inline-block">
              Mô tả sản phẩm
            </h3>
          </div>
          <div v-if="productData.description" class="prose prose-invert prose-lg max-w-none 
                      prose-headings:font-display
                      prose-a:text-primary-400
                      prose-img:rounded-2xl"
               v-html="productData.description">
          </div>
          <div v-else class="text-dark-400 italic">Chưa có mô tả chi tiết.</div>
        </div>

        <!-- Specifications -->
        <div>
          <div class="border-b border-dark-700 mb-8">
            <h3 class="px-6 py-3 text-lg font-semibold text-secondary-400 border-b-2 border-secondary-500 inline-block">
              Thông số kỹ thuật
            </h3>
          </div>
          <div v-if="productData.attributes && productData.attributes.length > 0" class="bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden">
            <table class="w-full text-sm">
              <tbody>
                <tr v-for="(attr, index) in productData.attributes" :key="index"
                    :class="index % 2 === 0 ? 'bg-dark-800/30' : 'bg-transparent'">
                  <td class="py-3 px-4 text-dark-300 font-medium w-1/3 border-r border-dark-700/50">{{ attr.name }}</td>
                  <td class="py-3 px-4 text-dark-100">{{ attr.options.join(', ') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="text-dark-400 italic">Đang cập nhật thông số.</div>
        </div>
      </div>

      <!-- Related Products -->
      <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-20 pt-12 border-t border-dark-700">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50">
              Sản Phẩm <span class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent">Tương Tự</span>
            </h2>
          </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <ProductCard v-for="rel in relatedProducts" :key="rel.id" :product="rel" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useCart } from '../composables/useCart.js';
import ProductCard from './ProductCard.vue';

const { addToCart } = useCart();

// Get product data from server-rendered page
const productData = window.__PRODUCT_DATA__ || {};
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || '/';
const shopUrl = homeUrl + 'shop';
const currency = wpData.currency || '₫';

// Images
const images = computed(() => productData.images || []);
const activeImageIndex = ref(0);
const activeImage = computed(() => images.value[activeImageIndex.value] || null);
const zoomed = ref(false);

// Stock
const isInStock = computed(() => productData.stock_status === 'instock');

// Quantity
const quantity = ref(1);
const adding = ref(false);
const addedSuccess = ref(false);

// Discount
const discountPercent = computed(() => {
  if (!productData.on_sale || !productData.regular_price || !productData.sale_price) return 0;
  return Math.round((1 - parseFloat(productData.sale_price) / parseFloat(productData.regular_price)) * 100);
});

// Related Products
const relatedProducts = computed(() => productData.related_products || []);

function formatDisplayPrice(price) {
  if (!price && price !== 0) return '';
  return new Intl.NumberFormat('vi-VN').format(parseFloat(price)) + currency;
}

function decreaseQty() {
  if (quantity.value > 1) quantity.value--;
}

function increaseQty() {
  quantity.value++;
}

async function handleAddToCart() {
  adding.value = true;
  const result = await addToCart(productData.id, quantity.value);
  adding.value = false;
  
  if (result.success) {
    addedSuccess.value = true;
    setTimeout(() => { addedSuccess.value = false; }, 2000);
  }
}
</script>

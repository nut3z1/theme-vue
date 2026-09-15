<template>
  <!-- Cart Sidebar Overlay -->
  <transition name="fade">
    <div v-if="cartOpen" 
         class="fixed inset-0 bg-dark-950/60 backdrop-blur-sm z-50"
         @click="closeCart">
    </div>
  </transition>

  <!-- Cart Sidebar -->
  <transition name="slide-right">
    <div v-if="cartOpen" 
         class="fixed top-0 right-0 bottom-0 w-full max-w-md bg-dark-900 border-l border-dark-700 shadow-2xl z-50 flex flex-col">
      
      <!-- Header -->
      <div class="flex items-center justify-between px-6 py-4 border-b border-dark-700">
        <h3 class="text-lg font-display font-bold text-dark-50 flex items-center gap-2">
          <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          Giỏ hàng
          <span v-if="cartCount > 0" class="text-sm font-normal text-dark-400">({{ cartCount }})</span>
        </h3>
        <button @click="closeCart" 
                class="p-2 text-dark-400 hover:text-dark-50 hover:bg-dark-800 rounded-xl transition-all">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Cart Items -->
      <div class="flex-1 overflow-y-auto px-6 py-4">
        <!-- Loading -->
        <div v-if="cartLoading && isCartEmpty" class="space-y-4">
          <div v-for="i in 3" :key="i" class="flex gap-4 animate-pulse">
            <div class="w-20 h-20 bg-dark-800 rounded-xl shrink-0"></div>
            <div class="flex-1 space-y-2">
              <div class="h-4 bg-dark-800 rounded w-3/4"></div>
              <div class="h-3 bg-dark-800 rounded w-1/2"></div>
              <div class="h-4 bg-dark-800 rounded w-1/3"></div>
            </div>
          </div>
        </div>

        <!-- Empty Cart -->
        <div v-else-if="isCartEmpty" class="flex flex-col items-center justify-center h-full text-center">
          <div class="w-20 h-20 rounded-full bg-dark-800 flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
          </div>
          <p class="text-dark-300 font-medium mb-1">Giỏ hàng trống</p>
          <p class="text-sm text-dark-500 mb-6">Hãy thêm sản phẩm vào giỏ hàng</p>
          <a :href="shopUrl" @click="closeCart"
             class="px-6 py-2.5 bg-primary-500 text-white text-sm font-medium rounded-xl hover:bg-primary-600 transition-colors">
            Tiếp tục mua sắm
          </a>
        </div>

        <!-- Cart Items List -->
        <div v-else class="space-y-4">
          <div v-for="item in cartItems" :key="item.key"
               class="flex gap-4 p-3 bg-dark-800/50 rounded-xl border border-dark-700 animate-fade-in">
            <!-- Image -->
            <a :href="item.permalink" class="shrink-0">
              <img v-if="item.image" 
                   :src="item.imageThumbnail || item.image" 
                   :alt="item.name"
                   class="w-20 h-20 rounded-lg object-cover">
              <div v-else class="w-20 h-20 rounded-lg bg-dark-700 flex items-center justify-center">
                <svg class="w-8 h-8 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
            </a>

            <!-- Info -->
            <div class="flex-1 min-w-0">
              <a :href="item.permalink" class="text-sm font-medium text-dark-100 hover:text-primary-400 transition-colors line-clamp-2">
                {{ item.name }}
              </a>
              <p class="text-sm font-semibold text-dark-200 mt-1">
                {{ formatPrice(item.price, item.currencySymbol) }}
              </p>

              <!-- Quantity Control -->
              <div class="flex items-center justify-between mt-2">
                <div class="flex items-center border border-dark-600 rounded-lg">
                  <button @click="updateCartItem(item.key, Math.max(0, item.quantity - 1))"
                          class="p-1.5 text-dark-400 hover:text-dark-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                  </button>
                  <span class="px-3 text-sm font-medium text-dark-200">{{ item.quantity }}</span>
                  <button @click="updateCartItem(item.key, item.quantity + 1)"
                          class="p-1.5 text-dark-400 hover:text-dark-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                  </button>
                </div>

                <button @click="removeCartItem(item.key)"
                        class="p-1.5 text-dark-500 hover:text-red-400 transition-colors"
                        aria-label="Xóa sản phẩm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div v-if="!isCartEmpty" class="px-6 py-4 border-t border-dark-700 space-y-4">
        <!-- Subtotal -->
        <div class="flex items-center justify-between text-sm">
          <span class="text-dark-400">Tạm tính</span>
          <span class="font-semibold text-dark-100">{{ formatPrice(cartSubtotal) }}</span>
        </div>

        <!-- Checkout Button -->
        <a :href="checkoutUrl" 
           class="flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 hover:-translate-y-0.5">
          <span>Thanh toán</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>

        <!-- Continue Shopping -->
        <button @click="closeCart"
                class="w-full px-6 py-2.5 text-sm text-dark-400 hover:text-dark-200 transition-colors text-center">
          ← Tiếp tục mua sắm
        </button>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { onMounted } from 'vue';
import { useCart } from '../composables/useCart.js';

const {
  cartItems, cartLoading, cartOpen, cartCount, cartSubtotal, isCartEmpty,
  closeCart, fetchCart, updateCartItem, removeCartItem, formatPrice,
} = useCart();

const wpData = window.wpVueTheme || {};
const shopUrl = (wpData.homeUrl || '/') + 'shop';
const checkoutUrl = wpData.checkoutUrl || '#';

onMounted(() => {
  if (wpData.wcActive) {
    fetchCart();
  }
});
</script>

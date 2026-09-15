<template>
  <section class="relative py-20 overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-primary-900/30 via-dark-900 to-secondary-900/30"></div>
    <div class="absolute inset-0 opacity-[0.03]" 
         style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <!-- Icon -->
      <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-500/20 to-secondary-500/20 flex items-center justify-center border border-primary-500/20">
        <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>

      <!-- Text -->
      <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50 mb-4">
        Đăng Ký Nhận <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">Ưu Đãi</span>
      </h2>
      <p class="text-dark-400 max-w-xl mx-auto mb-8 text-lg">
        Nhận thông tin về sản phẩm mới, khuyến mãi đặc biệt và nhiều hơn thế nữa
      </p>

      <!-- Form -->
      <form @submit.prevent="handleSubscribe" class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
        <input v-model="email"
               type="email"
               required
               placeholder="Nhập email của bạn"
               class="flex-1 px-5 py-3.5 bg-dark-800 border border-dark-600 rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-sm">
        <button type="submit"
                :disabled="subscribed"
                class="px-8 py-3.5 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-80 whitespace-nowrap text-sm">
          {{ subscribed ? 'Đã đăng ký ✓' : 'Đăng ký' }}
        </button>
      </form>

      <p class="text-xs text-dark-500 mt-4">
        Chúng tôi tôn trọng quyền riêng tư của bạn. Hủy đăng ký bất cứ lúc nào.
      </p>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const email = ref('');
const subscribed = ref(false);

function handleSubscribe() {
  if (!email.value.trim()) return;
  // In production, this would call an API endpoint
  subscribed.value = true;
  setTimeout(() => {
    email.value = '';
    subscribed.value = false;
  }, 3000);
}
</script>

<template>
  <div>
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white">
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20 ">
          <!-- Logo -->
          <a :href="homeUrl" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-shadow">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <span class="text-xl font-display font-bold text-dark-50 hidden sm:block">
              {{ siteTitle }}
            </span>
          </a>

          <!-- Desktop Navigation -->
          <nav class="hidden lg:flex items-center gap-1">
            <a v-for="item in menuItems" 
               :key="item.slug"
               :href="item.url"
               class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200"
               :class="[
                 isActive(item.slug) 
                   ? 'text-primary-400 bg-primary-500/10' 
                   : 'text-dark-300 hover:text-dark-50 hover:bg-dark-800/50'
               ]">
              {{ item.title }}
              <span v-if="isActive(item.slug)" 
                    class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary-400"></span>
            </a>
          </nav>

          <!-- Right Actions -->
          <div class="flex items-center gap-2">
            <!-- Search Toggle -->
            <!-- Search Toggle -->
            <InstantSearch>
              <template #trigger>
                <button class="p-2.5 text-dark-400 hover:text-dark-50 hover:bg-dark-800/50 rounded-xl transition-all"
                        aria-label="Tìm kiếm">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                </button>
              </template>
            </InstantSearch>

            <!-- Cart Button -->
            <button v-if="wcActive" 
                    @click="toggleCart" 
                    class="relative p-2.5 text-dark-400 hover:text-dark-50 hover:bg-dark-800/50 rounded-xl transition-all"
                    aria-label="Giỏ hàng">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
              </svg>
              <span v-if="cartItemCount > 0" 
                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] flex items-center justify-center text-[10px] font-bold text-white bg-secondary-500 rounded-full px-1 animate-scale-in">
                {{ cartItemCount > 99 ? '99+' : cartItemCount }}
              </span>
            </button>

            <!-- Mobile Menu Toggle -->
            <button @click="toggleMobileMenu" 
                    class="lg:hidden p-2.5 text-dark-400 hover:text-dark-50 hover:bg-dark-800/50 rounded-xl transition-all"
                    aria-label="Menu">
              <svg v-if="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      </div>



      <!-- Mobile Menu -->
      <transition name="slide-down">
        <div v-if="mobileMenuOpen" class="lg:hidden absolute top-full left-0 right-0 bg-dark-900/98 backdrop-blur-xl border-b border-dark-800 shadow-2xl">
          <nav class="max-w-8xl mx-auto px-4 py-4 space-y-1 bg-white h-[calc(100vh-100px)]" :class="[mobileMenuOpen ? 'border-t border-solid border-primary-50' : '']">
            <a v-for="item in menuItems"
               :key="item.slug"
               :href="item.url"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-base font-medium transition-all"
               :class="[
                 isActive(item.slug) 
                   ? 'text-primary-400 bg-primary-500/10' 
                   : 'text-dark-300 hover:text-dark-50 hover:bg-dark-800/50'
               ]">
              {{ item.title }}
            </a>
          </nav>
        </div>
      </transition>
    </header>

    <!-- Spacer for fixed header -->
    <div class="h-16 lg:h-20"></div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { useCart } from '../composables/useCart.js';
import InstantSearch from './InstantSearch.vue';

const { cartCount: cartItemCount, toggleCart } = useCart();

const scrolled = ref(false);
const mobileMenuOpen = ref(false);

// Get data from WordPress
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || '/';
const siteTitle = wpData.siteTitle || 'VueCommerce';
const wcActive = wpData.wcActive || false;

const menuItems = wpData.primaryMenu || [
  { title: 'Trang chủ', url: homeUrl, slug: 'home' },
  { title: 'Sản phẩm', url: homeUrl + 'cua-hang', slug: 'shop' },
  { title: 'Bài viết', url: homeUrl + 'tin-tuc', slug: 'tin-tuc' },
  { title: 'Video', url: homeUrl + 'video', slug: 'video' },
  { title: 'Liên hệ', url: homeUrl + 'lien-he', slug: 'lien-he' },
];

function isActive(slug) {
  const path = window.location.pathname;
  if (slug === 'home') return path === '/' || wpData.isHome;
  if (slug === 'shop') return path.includes('/cua-hang') || path.includes('/product') || wpData.isShop || wpData.isProduct;
  if (slug === 'tin-tuc') return path.includes('/tin-tuc');
  if (slug === 'video') return path.includes('/video');
  if (slug === 'lien-he') return path.includes('/lien-he');
  return path.includes(`/${slug}`);
}

function toggleMobileMenu() {
  mobileMenuOpen.value = !mobileMenuOpen.value;
}

function handleScroll() {
  scrolled.value = window.scrollY > 20;
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

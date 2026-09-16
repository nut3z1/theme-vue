<template>
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
          <button @click="toggleSearch" 
                  class="p-2.5 text-dark-400 hover:text-dark-50 hover:bg-dark-800/50 rounded-xl transition-all"
                  aria-label="Tìm kiếm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </button>

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

    <!-- Search Overlay -->
    <transition name="slide-down">
      <div v-if="searchOpen" class="absolute top-full left-0 right-0 bg-dark-900/98 backdrop-blur-xl border-b border-dark-800 shadow-2xl">
        <div class="max-w-3xl mx-auto px-4 py-6">
          <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input ref="searchInput"
                   v-model="searchQuery"
                   @keydown.enter="handleSearch"
                   @keydown.escape="toggleSearch"
                   type="text"
                   placeholder="Tìm kiếm sản phẩm, bài viết..."
                   class="w-full pl-12 pr-4 py-4 bg-dark-800 border border-dark-700 rounded-2xl text-dark-50 placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-lg">
          </div>
        </div>
      </div>
    </transition>

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
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { useCart } from '../composables/useCart.js';

const { cartCount: cartItemCount, toggleCart } = useCart();

const scrolled = ref(false);
const mobileMenuOpen = ref(false);
const searchOpen = ref(false);
const searchQuery = ref('');
const searchInput = ref(null);

// Get data from WordPress
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || '/';
const siteTitle = wpData.siteTitle || 'VueCommerce';
const wcActive = wpData.wcActive || false;

const menuItems = wpData.primaryMenu || [
  { title: 'Trang chủ', url: '/', slug: 'home' },
  { title: 'Sản phẩm', url: '/shop', slug: 'shop' },
  { title: 'Bài viết', url: '/blog', slug: 'blog' },
  { title: 'Video', url: '/video', slug: 'video' },
  { title: 'Liên hệ', url: '/lien-he', slug: 'contact' },
];

function isActive(slug) {
  const path = window.location.pathname;
  if (slug === 'home') return path === '/' || wpData.isHome;
  if (slug === 'shop') return path.includes('/shop') || path.includes('/product') || wpData.isShop || wpData.isProduct;
  if (slug === 'blog') return path.includes('/blog') || path.includes('/category') || wpData.isBlog;
  if (slug === 'video') return path.includes('/video');
  if (slug === 'contact') return path.includes('/contact') || path.includes('/lien-he') || wpData.isContact;
  return path.includes(`/${slug}`);
}

function toggleMobileMenu() {
  mobileMenuOpen.value = !mobileMenuOpen.value;
  if (mobileMenuOpen.value) searchOpen.value = false;
}

async function toggleSearch() {
  searchOpen.value = !searchOpen.value;
  if (searchOpen.value) {
    mobileMenuOpen.value = false;
    await nextTick();
    searchInput.value?.focus();
  }
}

function handleSearch() {
  if (searchQuery.value.trim()) {
    window.location.href = `${homeUrl}?s=${encodeURIComponent(searchQuery.value.trim())}`;
  }
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

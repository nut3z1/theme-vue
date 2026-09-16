<template>
  <footer class="relative bg-dark-950 border-t border-dark-800">
    <!-- Gradient Divider -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary-500/50 to-transparent"></div>

    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Main Footer -->
      <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <!-- Brand Column -->
        <div class="lg:col-span-1">
          <a :href="homeUrl" class="flex items-center gap-3 group mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <span class="text-xl font-display font-bold text-dark-50">{{ siteTitle }}</span>
          </a>
          <p class="text-dark-400 text-sm leading-relaxed mb-6">
            {{ siteDesc || 'Cửa hàng trực tuyến uy tín với hàng ngàn sản phẩm chất lượng cao. Mua sắm dễ dàng, giao hàng nhanh chóng.' }}
          </p>
          <!-- Social Icons -->
          <div class="flex items-center gap-3">
            <a v-for="social in socials" :key="social.name"
               :href="social.url" target="_blank" rel="noopener"
               class="w-10 h-10 flex items-center justify-center rounded-xl bg-dark-800 text-dark-400 hover:bg-primary-500/20 hover:text-primary-400 transition-all border border-dark-700 hover:border-primary-500/30"
               :aria-label="social.name">
              <span v-html="social.icon" class="w-4 h-4"></span>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-sm font-semibold text-dark-50 uppercase tracking-wider mb-6">Liên Kết</h4>
          <ul class="space-y-3">
            <li v-for="link in quickLinks" :key="link.title">
              <a :href="link.url" 
                 class="text-sm text-dark-400 hover:text-primary-400 transition-colors flex items-center gap-2 group">
                <svg class="w-3.5 h-3.5 text-dark-600 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                {{ link.title }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Customer Service -->
        <div>
          <h4 class="text-sm font-semibold text-dark-50 uppercase tracking-wider mb-6">Hỗ Trợ</h4>
          <ul class="space-y-3">
            <li v-for="link in supportLinks" :key="link.title">
              <a :href="link.url" 
                 class="text-sm text-dark-400 hover:text-primary-400 transition-colors flex items-center gap-2 group">
                <svg class="w-3.5 h-3.5 text-dark-600 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                {{ link.title }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="text-sm font-semibold text-dark-50 uppercase tracking-wider mb-6">Liên Hệ</h4>
          <ul class="space-y-4">
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-primary-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <span class="text-sm text-dark-400">123 Đường ABC, Quận 1, TP.HCM</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-primary-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              <span class="text-sm text-dark-400">0123 456 789</span>
            </li>
            <li class="flex items-start gap-3">
              <svg class="w-5 h-5 text-primary-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <span class="text-sm text-dark-400">info@vuecommerce.vn</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="py-6 border-t border-dark-800 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-sm text-dark-500">
          © {{ currentYear }} {{ siteTitle }}. All rights reserved.
        </p>
        <div class="flex items-center gap-6">
          <a href="#" class="text-xs text-dark-500 hover:text-dark-300 transition-colors">Chính sách bảo mật</a>
          <a href="#" class="text-xs text-dark-500 hover:text-dark-300 transition-colors">Điều khoản sử dụng</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || '/';
const siteTitle = wpData.siteTitle || 'VueCommerce';
const siteDesc = wpData.siteDesc || '';
const currentYear = new Date().getFullYear();

const quickLinks = [
  { title: 'Trang chủ', url: homeUrl },
  { title: 'Sản phẩm', url: `${homeUrl}shop` },
  { title: 'Bài viết', url: `${homeUrl}blog` },
  { title: 'Liên hệ', url: `${homeUrl}lien-he` },
];

const supportLinks = [
  { title: 'Hướng dẫn mua hàng', url: '#' },
  { title: 'Chính sách đổi trả', url: '#' },
  { title: 'Chính sách vận chuyển', url: '#' },
  { title: 'Câu hỏi thường gặp', url: '#' },
];

const socials = [
  {
    name: 'Facebook',
    url: '#',
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
  },
  {
    name: 'YouTube',
    url: '#',
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
  },
  {
    name: 'Zalo',
    url: '#',
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.066 10.978c0 5.418-4.706 9.816-10.51 9.816-1.306 0-2.556-.216-3.716-.613-2.616 2.18-5.748 1.988-5.748 1.988.407-1.848.096-3.32-.123-4.14-1.253-1.776-1.966-3.9-1.966-6.155 0-5.417 4.706-9.815 10.51-9.815s10.509 4.398 10.509 9.815v.9l-.02-.8zm-4.771 1.947c0-.236-.188-.426-.419-.426H13.62l1.966-2.565c.34-.44.02-.916-.549-.916H11.59c-.234 0-.422.188-.422.426v.426c0 .235.188.426.422.426h3.256l-1.967 2.564c-.339.44-.02.916.549.916h3.447c.231 0 .419-.188.419-.426v-.425zm-6.22 0c0-.236-.188-.426-.418-.426H9.288c-.232 0-.42.188-.42.426v.426c0 .235.188.426.42.426h1.369c.23 0 .418-.188.418-.426v-.425zm0-2.31c0-.44-.356-.798-.795-.798H9.066c-.44 0-.796.357-.796.798 0 .441.356.799.796.799h1.22c.439 0 .795-.358.795-.799zm-4.766 2.736v-3.567c0-.236-.188-.426-.42-.426h-.425c-.23 0-.418.188-.418.426v3.567c0 .235.188.426.418.426h.425c.232 0 .42-.188.42-.426z"/></svg>',
  },
  {
    name: 'TikTok',
    url: '#',
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v7.2c0 1.96-.5 3.97-1.84 5.42-1.38 1.48-3.35 2.37-5.38 2.4-2.28.02-4.64-.81-6.17-2.58-1.55-1.78-2.07-4.32-1.39-6.6.61-2.06 2.05-3.8 4.02-4.63 2.1-.88 4.54-.7 6.46.46v4.22c-1.04-.6-2.31-.76-3.41-.33-1.1.43-1.9 1.4-2.12 2.56-.25 1.34.42 2.8 1.65 3.39 1.25.6 2.81.4 3.86-.48.91-.77 1.4-1.93 1.4-3.13V.02z"/></svg>',
  },
];
</script>

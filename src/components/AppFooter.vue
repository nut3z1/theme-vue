<template>
  <footer class="relative bg-dark-950 border-t border-dark-800">
    <!-- Gradient Divider -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary-500/50 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
    name: 'Instagram',
    url: '#',
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
  },
  {
    name: 'YouTube',
    url: '#',
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
  },
];
</script>

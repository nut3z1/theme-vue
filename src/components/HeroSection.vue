<template>
  <section class="py-6">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-5">
        <!-- Banner Lớn (2/3 width) -->
        <div class="lg:col-span-2 relative group rounded-2xl overflow-hidden bg-dark-800 border border-dark-700 hover:border-primary-500/30 transition-all cursor-pointer"
             @click="goTo(mainBanner.url)">
          <div class="relative aspect-[16/9] lg:aspect-[16/8] overflow-hidden">
            <!-- Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-900/80 via-dark-900/60 to-secondary-900/80"></div>
            <!-- Animated Orbs -->
            <div class="absolute top-1/4 -left-10 w-72 h-72 bg-primary-500/15 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 -right-10 w-60 h-60 bg-secondary-500/15 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>
            <!-- Grid Pattern -->
            <div class="absolute inset-0 opacity-[0.04]" 
                 style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex items-center">
              <div class="px-8 sm:px-12 lg:px-16 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-500/15 border border-primary-500/25 text-primary-400 text-xs font-medium mb-4">
                  <span class="w-1.5 h-1.5 rounded-full bg-primary-400 animate-pulse"></span>
                  {{ mainBanner.badge }}
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-dark-50 leading-tight mb-3">
                  {{ mainBanner.title }}
                </h2>
                <p class="text-dark-300 text-sm sm:text-base mb-6 line-clamp-2">{{ mainBanner.description }}</p>
                <span class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl shadow-glow group-hover:shadow-glow-lg transition-all">
                  {{ mainBanner.cta }}
                  <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                  </svg>
                </span>
              </div>
            </div>

            <!-- Decorative Product Icon -->
            <div class="absolute right-8 bottom-8 hidden sm:block opacity-20 group-hover:opacity-30 transition-opacity">
              <svg class="w-40 h-40 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- 2 Banner Nhỏ (1/3 width, stacked) -->
        <div class="flex flex-col gap-4 lg:gap-5">
          <!-- Banner nhỏ 1 -->
          <div class="relative group flex-1 rounded-2xl overflow-hidden bg-dark-800 border border-dark-700 hover:border-secondary-500/30 transition-all cursor-pointer"
               @click="goTo(smallBanners[0].url)">
            <div class="relative h-full min-h-[160px] overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-br from-secondary-900/70 via-dark-900/50 to-primary-900/60"></div>
              <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-secondary-500/10 rounded-full blur-2xl"></div>
              
              <div class="absolute inset-0 flex items-center px-6 sm:px-8">
                <div class="flex-1">
                  <p class="text-xs font-medium text-secondary-400 uppercase tracking-wider mb-1.5">{{ smallBanners[0].badge }}</p>
                  <h3 class="text-lg sm:text-xl font-display font-bold text-dark-50 mb-2 leading-tight">{{ smallBanners[0].title }}</h3>
                  <span class="inline-flex items-center gap-1 text-sm font-medium text-secondary-400 group-hover:text-secondary-300 transition-colors">
                    {{ smallBanners[0].cta }}
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </span>
                </div>
                <div class="shrink-0 w-16 h-16 rounded-xl bg-secondary-500/15 flex items-center justify-center ml-4">
                  <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Banner nhỏ 2 -->
          <div class="relative group flex-1 rounded-2xl overflow-hidden bg-dark-800 border border-dark-700 hover:border-accent-500/30 transition-all cursor-pointer"
               @click="goTo(smallBanners[1].url)">
            <div class="relative h-full min-h-[160px] overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-br from-accent-900/60 via-dark-900/50 to-primary-900/50"></div>
              <div class="absolute -left-8 -top-8 w-40 h-40 bg-accent-500/10 rounded-full blur-2xl"></div>

              <div class="absolute inset-0 flex items-center px-6 sm:px-8">
                <div class="flex-1">
                  <p class="text-xs font-medium text-accent-400 uppercase tracking-wider mb-1.5">{{ smallBanners[1].badge }}</p>
                  <h3 class="text-lg sm:text-xl font-display font-bold text-dark-50 mb-2 leading-tight">{{ smallBanners[1].title }}</h3>
                  <span class="inline-flex items-center gap-1 text-sm font-medium text-accent-400 group-hover:text-accent-300 transition-colors">
                    {{ smallBanners[1].cta }}
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </span>
                </div>
                <div class="shrink-0 w-16 h-16 rounded-xl bg-accent-500/15 flex items-center justify-center ml-4">
                  <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || '/';

const mainBanner = {
  badge: 'Bộ sưu tập mới 2026',
  title: 'Khám Phá Phong Cách Của Riêng Bạn',
  description: 'Hàng ngàn sản phẩm chất lượng cao, giá tốt nhất thị trường. Giao hàng nhanh chóng, đổi trả miễn phí.',
  cta: 'Mua sắm ngay',
  url: homeUrl + 'shop',
};

const smallBanners = [
  {
    badge: 'Khuyến mãi',
    title: 'Giảm đến 50% cho đơn đầu tiên',
    cta: 'Xem ưu đãi',
    url: homeUrl + 'shop?on_sale=true',
  },
  {
    badge: 'Flash Sale',
    title: 'Deal hot mỗi ngày, số lượng có hạn',
    cta: 'Mua ngay',
    url: homeUrl + 'shop',
  },
];

function goTo(url) {
  window.location.href = url;
}
</script>

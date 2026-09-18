<template>
  <section class="pb-6">
    <div class="">
      <div class="grid grid-cols-1">
        <!-- Banner Lớn (2/3 width) -->
        <div class="lg:col-span-2 relative group overflow-hidden bg-gray-100 border border-gray-200">
          <div ref="heroSwiper" class="swiper hero-swiper w-full h-[650px] aspect-[16/9] lg:aspect-[16/8]">
            <div class="swiper-wrapper">
              <div v-for="(img, idx) in sliderImages" :key="idx" class="swiper-slide">
                <img :src="img" class="w-full h-full object-cover" alt="Banner Slider" />
              </div>
            </div>
            <!-- Navigation -->
            <div ref="prevBtn" class="swiper-button-prev !text-white after:!text-2xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md"></div>
            <div ref="nextBtn" class="swiper-button-next !text-white after:!text-2xl opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md"></div>
            <!-- Pagination -->
            <div ref="paginationEl" class="swiper-pagination"></div>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || '/';

const sliderImages = [
  'https://hoanglongamthanhso.com/wp-content/uploads/2026/09/113ce1f3-16c6-472f-a2ba-a7d8da21ff7f.jpeg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2026/09/c3ba7532-1397-48b6-b6a2-b4a6f5c255d0.jpeg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2026/09/Gemini_Generated_Image_hpgs03hpgs03hpgs.png'
];

const heroSwiper = ref(null);
const prevBtn = ref(null);
const nextBtn = ref(null);
const paginationEl = ref(null);

onMounted(async () => {
  await nextTick();
  if (heroSwiper.value) {
    new Swiper(heroSwiper.value, {
      modules: [Navigation, Pagination, Autoplay],
      slidesPerView: 1,
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      navigation: {
        prevEl: prevBtn.value,
        nextEl: nextBtn.value,
      },
      pagination: {
        el: paginationEl.value,
        clickable: true,
      }
    });
  }
});

const smallBanners = [
  {
    badge: 'Khuyến mãi',
    title: 'Giảm đến 50% cho đơn đầu tiên',
    cta: 'Xem ưu đãi',
    url: homeUrl + 'cua-hang?on_sale=true',
  },
  {
    badge: 'Flash Sale',
    title: 'Deal hot mỗi ngày, số lượng có hạn',
    cta: 'Mua ngay',
    url: homeUrl + 'cua-hang',
  },
];

function goTo(url) {
  window.location.href = url;
}
</script>

<style>
/* Swiper Customizations */
.hero-swiper .swiper-pagination-bullet {
  background: white;
  opacity: 0.5;
}
.hero-swiper .swiper-pagination-bullet-active {
  opacity: 1;
  background: #2563eb; /* blue-600 */
}
</style>

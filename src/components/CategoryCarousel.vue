<template>
  <section class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 px-4">
  <div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
      <div>
        <h2 class="text-xl font-semibold xl:text-2xl text-dark">Danh Mục Sản Phẩm</h2>
      </div>
      <div class="flex items-center gap-3">
        <button
          ref="prevBtn"
          class="cat-swiper-prev p-2 rounded-full border border-gray-200 text-gray-600 hover:text-gray-700 hover:border-gray-400 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed cursor-pointer"
          aria-label="previous button"
        >
          <svg width="24" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.2335 5.21967C15.5263 5.51256 15.5263 5.98744 15.2335 6.28033L9.51379 12L15.2335 17.7197C15.5263 18.0126 15.5263 18.4874 15.2335 18.7803C14.9406 19.0732 14.4657 19.0732 14.1728 18.7803L7.92279 12.5303C7.6299 12.2374 7.6299 11.7626 7.92279 11.4697L14.1728 5.21967C14.4657 4.92678 14.9406 4.92678 15.2335 5.21967Z" fill="currentColor"/>
          </svg>
        </button>
        <button
          ref="nextBtn"
          class="cat-swiper-next p-2 rounded-full border border-gray-200 text-gray-600 hover:text-gray-700 hover:border-gray-400 transition-all duration-200 disabled:opacity-30 disabled:cursor-not-allowed cursor-pointer"
          aria-label="next button"
        >
          <svg width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.08979 19.2803C8.79689 18.9874 8.79689 18.5126 9.08979 18.2197L14.8095 12.5L9.08979 6.78033C8.7969 6.48744 8.7969 6.01256 9.08979 5.71967C9.38268 5.42678 9.85756 5.42678 10.1504 5.71967L16.4004 11.9697C16.6933 12.2626 16.6933 12.7374 16.4004 13.0303L10.1504 19.2803C9.85755 19.5732 9.38268 19.5732 9.08979 19.2803Z" fill="currentColor"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Loading Skeleton -->
    <div v-if="loading" class="flex gap-4">
      <div
        v-for="i in 9"
        :key="i"
        class="shrink-0 flex flex-col items-center gap-3 animate-pulse"
        style="width: 130px"
     >
        <div class="w-[130px] h-[130px] rounded-full bg-gray-200"></div>
        <div class="h-4 bg-gray-200 rounded w-20"></div>
      </div>
    </div>

    <!-- Swiper -->
    <div v-else-if="categories.length > 0" ref="swiperContainer" class="swiper categories-carousel">
      <div class="swiper-wrapper">
        <div
          v-for="cat in categories"
          :key="cat.id"
          class="swiper-slide"
        >
          <a
            :href="cat.permalink"
            class="group flex flex-col items-center"
          >
            <!-- Image Circle -->
            <div class="max-w-[130px] w-full bg-[#F2F3F8] h-[130px] rounded-full flex items-center justify-center mb-4 overflow-hidden group-hover:bg-blue-50 transition-colors duration-300">
              <img
                v-if="cat.image"
                :src="cat.image"
                :alt="cat.name"
                loading="lazy"
                width="82"
                height="82"
                class="object-contain rounded-full w-[82px] h-[82px] group-hover:scale-110 transition-transform duration-300"
              />
              <svg v-else class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
              </svg>
            </div>
            <!-- Name -->
            <div class="flex justify-center px-2">
              <h3 class="text-sm font-medium text-center text-gray-800 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                {{ cat.name }}
              </h3>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Empty -->
    <div v-else class="text-center py-8 text-gray-400 text-sm">
      Chưa có danh mục nào
    </div>
  </div>
  </section>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css';

const wpData = window.wpVueTheme || {};

// Dùng data từ PHP inject sẵn — không cần API call, hiện ngay lập tức
const rawCats = wpData.productCategories || [];
const categories = ref(
  rawCats.map(item => ({
    id: item.id,
    name: item.name,
    slug: item.slug,
    count: item.count,
    permalink: item.permalink || `${wpData.homeUrl || '/'}danh-muc-san-pham/${item.slug}/`,
    image: item.image || null,
  }))
);
const loading = ref(false); // không cần loading vì data có sẵn
const swiperContainer = ref(null);
const prevBtn = ref(null);
const nextBtn = ref(null);

onMounted(async () => {
  await nextTick();
  if (swiperContainer.value && categories.value.length > 0) {
    new Swiper(swiperContainer.value, {
      modules: [Navigation],
      slidesPerView: 2,
      spaceBetween: 12,
      loop: categories.value.length > 6,
      navigation: {
        prevEl: prevBtn.value,
        nextEl: nextBtn.value,
      },
      breakpoints: {
        480: { slidesPerView: 3, spaceBetween: 16 },
        640: { slidesPerView: 4, spaceBetween: 16 },
        768: { slidesPerView: 5, spaceBetween: 16 },
        1024: { slidesPerView: 6, spaceBetween: 24 },
      },
    });
  }
});
</script>

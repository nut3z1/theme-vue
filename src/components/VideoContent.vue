<template>
  <section class="py-12 bg-dark-900">
    <div class="container mx-auto px-4">
      <!-- Heading -->
      <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white font-outfit">Video</h2>
        <p class="mt-2 text-dark-300 text-sm">Kênh YouTube của chúng tôi</p>
      </div>

      <!-- Error state -->
      <div v-if="error" class="text-center py-10">
        <p class="text-red-400 mb-4">{{ error }}</p>
        <button
          @click="reload"
          class="px-5 py-2 bg-primary-600 hover:bg-primary-500 text-white rounded-lg transition-colors"
        >
          Thử lại
        </button>
      </div>

      <!-- Loading skeleton -->
      <div v-else-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="n in perPage"
          :key="n"
          class="rounded-xl overflow-hidden bg-dark-800 animate-pulse"
        >
          <div class="w-full aspect-video bg-dark-700"></div>
          <div class="p-3 space-y-2">
            <div class="h-4 bg-dark-700 rounded w-3/4"></div>
            <div class="h-3 bg-dark-700 rounded w-1/2"></div>
          </div>
        </div>
      </div>

      <!-- Video grid -->
      <div v-else-if="hasVideos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <article
          v-for="video in videos"
          :key="video.videoId"
          class="rounded-xl overflow-hidden bg-dark-800 hover:bg-dark-750 transition-colors group"
        >
          <div class="relative w-full aspect-video">
            <iframe
              :src="video.embedUrl"
              :title="video.title"
              class="absolute inset-0 w-full h-full"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
              loading="lazy"
            ></iframe>
          </div>

          <div class="p-3">
            <h3 class="text-white text-sm font-semibold line-clamp-2 group-hover:text-primary-400 transition-colors">
              {{ video.title }}
            </h3>
            <p class="mt-1 text-dark-400 text-xs">{{ video.publishedFormatted }}</p>
          </div>
        </article>
      </div>

      <!-- Empty state -->
      <div v-else class="text-center py-16 text-dark-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
        </svg>
        <p>Chưa có video nào.</p>
      </div>

      <!-- Pagination -->
      <AppPagination
        mode="token"
        :has-prev="hasPrev"
        :has-next="hasNext"
        :disabled="loading"
        @prev="goToPrev"
        @next="goToNext"
      />

    </div>
  </section>
</template>

<script setup>
import { onMounted } from 'vue';
import { useYoutube } from '../composables/useYoutube.js';
import AppPagination from './AppPagination.vue';

const PER_PAGE = 9;

const {
  videos,
  loading,
  error,
  hasVideos,
  hasNext,
  hasPrev,
  fetchVideos,
  nextPage,
  prevPage,
} = useYoutube();

const perPage = PER_PAGE;

onMounted(() => {
  fetchVideos('', PER_PAGE);
});

function reload() {
  fetchVideos('', PER_PAGE);
}

function goToNext() {
  nextPage(PER_PAGE);
  scrollToTop();
}

function goToPrev() {
  prevPage(PER_PAGE);
  scrollToTop();
}

// perPage exposed for skeleton count (defined as const above)

function scrollToTop() {
  const el = document.querySelector('#vue-video');
  if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>


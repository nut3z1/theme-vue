<template>
  <section class="py-12 bg-dark-900">
    <div class="container mx-auto px-4">
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
      <div
        v-else-if="loading && !hasVideos"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      >
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
      <div
        v-else-if="hasVideos"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <article
          v-for="video in videos"
          :key="getId(video)"
          class="rounded-xl overflow-hidden bg-dark-800 hover:bg-dark-750 transition-colors group"
        >
          <div class="relative w-full aspect-video bg-black">
            <!-- Đã bấm play: hiện iframe -->
            <iframe
              v-if="playingId === getId(video)"
              :src="embedSrc(video)"
              :title="video.title"
              class="absolute inset-0 w-full h-full"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            ></iframe>

            <!-- Chưa bấm: hiện ảnh + icon play -->
            <button
              v-else
              type="button"
              class="absolute inset-0 w-full h-full cursor-pointer"
              :aria-label="`Phát video: ${video.title}`"
              @click="play(video)"
            >
              <img
                :src="hqThumb(video)"
                :alt="video.title"
                class="w-full h-full object-cover"
                loading="lazy"
              />
              <span
                class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"
              ></span>
              <span class="absolute inset-0 flex items-center justify-center">
                <span
                  class="w-16 h-16 rounded-full bg-red-600 group-hover:bg-red-500 group-hover:scale-110 transition-all flex items-center justify-center shadow-lg"
                >
                  <svg
                    viewBox="0 0 24 24"
                    class="w-8 h-8 text-white ml-1"
                    fill="currentColor"
                  >
                    <path d="M8 5v14l11-7z" />
                  </svg>
                </span>
              </span>
            </button>
          </div>

          <div class="p-3">
            <h3
              class="text-black text-sm font-semibold line-clamp-2 group-hover:text-primary-400 transition-colors"
            >
              {{ video.title }}
            </h3>
            <p class="mt-1 text-dark-400 text-xs">
              {{ video.publishedFormatted }}
            </p>
          </div>
        </article>
      </div>

      <!-- Empty state -->
      <div v-else class="text-center py-16 text-dark-400">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="mx-auto mb-4 w-12 h-12 opacity-40"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"
          />
        </svg>
        <p>Chưa có video nào.</p>
      </div>

      <!-- Loading indicator cho Load More -->
      <div v-if="loadingMore" class="text-center py-6 mt-4">
        <svg class="animate-spin h-8 w-8 mx-auto text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>

      <!-- Sentinel element cho Infinite Scroll -->
      <div ref="loadMoreSentinel" class="h-4 w-full"></div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch } from "vue";
import { useYoutube } from "../composables/useYoutube.js";

const PER_PAGE = 9;

const {
  videos,
  loading,
  loadingMore,
  error,
  hasVideos,
  hasNext,
  fetchVideos,
  loadMoreVideos,
} = useYoutube();

const perPage = PER_PAGE;

// ID của video đang phát (chỉ 1 video tại một thời điểm)
const playingId = ref(null);

const loadMoreSentinel = ref(null);
const isIntersecting = ref(false);
let observer = null;

onMounted(() => {
  fetchVideos("", PER_PAGE);

  // Khởi tạo Intersection Observer để làm Load More
  observer = new IntersectionObserver((entries) => {
    isIntersecting.value = entries[0].isIntersecting;
  }, {
    rootMargin: '200px', // Bắt đầu load trước khi cuộn tới sentinel 200px
  });

  if (loadMoreSentinel.value) {
    observer.observe(loadMoreSentinel.value);
  }
});

// Watch sự kết hợp giữa trạng thái hiển thị của sentinel và trạng thái loading
watch([isIntersecting, loading, loadingMore, hasNext], ([intersecting, isLoading, isLoadingMore, hasNextVal]) => {
  if (intersecting && !isLoading && !isLoadingMore && hasNextVal) {
    loadMoreVideos(PER_PAGE);
  }
});

onUnmounted(() => {
  if (observer && loadMoreSentinel.value) {
    observer.unobserve(loadMoreSentinel.value);
  }
});

// videoId trong data đang rỗng -> lấy từ URL thumbnail làm dự phòng
function getId(video) {
  if (video.videoId) return video.videoId;
  const m = video.thumbnail?.match(/\/vi\/([^/]+)\//);
  return m ? m[1] : null;
}

// mqdefault (320x180) hơi mờ, dùng hqdefault (480x360) cho nét hơn
function hqThumb(video) {
  return video.thumbnail?.replace("mqdefault", "hqdefault");
}

function embedSrc(video) {
  return `https://www.youtube.com/embed/${getId(video)}?autoplay=1&rel=0`;
}

function play(video) {
  playingId.value = getId(video);
}

function reload() {
  playingId.value = null;
  fetchVideos("", PER_PAGE);
}
</script>
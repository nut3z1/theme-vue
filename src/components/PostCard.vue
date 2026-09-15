<template>
  <a :href="post.link || '#'" 
     class="group block bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden hover:border-primary-500/30 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
    <!-- Image -->
    <div class="relative aspect-[16/10] overflow-hidden bg-dark-800">
      <img v-if="post.featuredImage"
           :src="post.featuredImage"
           :alt="post.title"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
           loading="lazy">
      <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500/10 to-secondary-500/10">
        <svg class="w-12 h-12 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
        </svg>
      </div>

      <!-- Category Badge -->
      <div v-if="post.categories && post.categories.length" class="absolute top-3 left-3">
        <span class="px-3 py-1 text-xs font-semibold text-primary-300 bg-dark-900/80 backdrop-blur-sm rounded-full border border-primary-500/20">
          {{ post.categories[0].name }}
        </span>
      </div>
    </div>

    <!-- Content -->
    <div class="p-5">
      <!-- Meta -->
      <div class="flex items-center gap-3 mb-3">
        <img v-if="post.author.avatar"
             :src="post.author.avatar"
             :alt="post.author.name"
             class="w-6 h-6 rounded-full object-cover">
        <div v-else class="w-6 h-6 rounded-full bg-primary-500/20 flex items-center justify-center">
          <span class="text-xs font-bold text-primary-400">{{ post.author.name?.charAt(0) }}</span>
        </div>
        <span class="text-xs text-dark-400">{{ post.author.name }}</span>
        <span class="text-dark-600">•</span>
        <time class="text-xs text-dark-400">{{ post.dateFormatted }}</time>
      </div>

      <!-- Title -->
      <h3 class="text-base font-semibold text-dark-100 group-hover:text-primary-400 transition-colors line-clamp-2 mb-2 leading-snug">
        {{ post.title }}
      </h3>

      <!-- Excerpt -->
      <p class="text-sm text-dark-400 line-clamp-2 leading-relaxed">
        {{ post.excerpt }}
      </p>

      <!-- Read More -->
      <div class="mt-4 flex items-center gap-1.5 text-sm font-medium text-primary-400 group-hover:text-primary-300 transition-colors">
        <span>Đọc thêm</span>
        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
      </div>
    </div>
  </a>
</template>

<script setup>
defineProps({
  post: {
    type: Object,
    required: true,
  },
});
</script>

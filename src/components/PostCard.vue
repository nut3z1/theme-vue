<template>
  <div class="shadow-md bg-white rounded-xl px-4 sm:px-5 pt-5 pb-4">
    <a class="rounded-md overflow-hidden block" :href="post.link || '#'">
      <img v-if="post.featuredImage"
           :alt="post.title" 
           loading="lazy" 
           decoding="async" 
           class="rounded-md w-full h-[210px] object-cover hover:scale-105 transition-transform duration-500" 
           :src="post.featuredImage" />
      <div v-else class="rounded-md w-full h-[210px] flex items-center justify-center bg-gray-100">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
        </svg>
      </div>
    </a>
    <div class="mt-5">
      <span class="flex items-center gap-3 mb-2.5">
        <a class="text-sm text-gray-500 ease-out duration-200 hover:text-blue-500" :href="post.link || '#'">{{ post.dateFormatted }}</a>
        <span class="block w-px h-4 bg-gray-300"></span>
        <a class="text-sm text-gray-500 ease-out duration-200 hover:text-blue-500" :href="post.link || '#'">{{ post.author?.name || 'Admin' }}</a>
      </span>
      <h2 class="font-medium text-gray-900 text-lg sm:text-xl ease-out duration-200 mb-4 hover:text-blue-500 line-clamp-2">
        <a :href="post.link || '#'">{{ post.title }}</a>
      </h2>
      <a class="text-sm font-medium text-gray-600 inline-flex items-center gap-2 py-2 ease-out duration-200 hover:text-blue-500" :href="post.link || '#'">
        Đọc thêm
        <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1023 4.10225C10.3219 3.88258 10.6781 3.88258 10.8977 4.10225L15.3977 8.60225C15.6174 8.82192 15.6174 9.17808 15.3977 9.39775L10.8977 13.8977C10.6781 14.1174 10.3219 14.1174 10.1023 13.8977C9.88258 13.6781 9.88258 13.3219 10.1023 13.1023L13.642 9.5625H3C2.68934 9.5625 2.4375 9.31066 2.4375 9C2.4375 8.68934 2.68934 8.4375 3 8.4375H13.642L10.1023 4.89775C9.88258 4.67808 9.88258 4.32192 10.1023 4.10225Z" fill=""></path>
        </svg>
      </a>
    </div>
  </div>
</template>

<script setup>
defineProps({
  post: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="relative w-full">
    <!-- Trigger Input (replaces the one in sidebar) -->
    <div class="relative cursor-pointer" @click="openModal">
      <slot name="trigger">
        <div class="relative">
          <input placeholder="Tìm kiếm sản phẩm, bài viết..." readonly class="w-full rounded-full border border-gray-300 py-3 pl-5 pr-13 outline-none ease-out duration-200 placeholder:text-gray-400 focus:border-transparent focus:shadow-md focus:ring-2 focus:ring-blue-500/20 cursor-pointer bg-white text-left" type="text">
          <button type="button" class="text-gray-500 absolute right-0 top-0 px-4 py-3.5 ease-out duration-200 hover:text-blue-600 pointer-events-none">
            <svg width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.25 2.75C6.14154 2.75 2 6.89029 2 11.998C2 17.1056 6.14154 21.2459 11.25 21.2459C13.5335 21.2459 15.6238 20.4187 17.2373 19.0475L20.7182 22.5287C21.011 22.8216 21.4859 22.8217 21.7788 22.5288C22.0717 22.2359 22.0718 21.761 21.7789 21.4681L18.2983 17.9872C19.6714 16.3736 20.5 14.2826 20.5 11.998C20.5 6.89029 16.3585 2.75 11.25 2.75ZM3.5 11.998C3.5 7.71905 6.96962 4.25 11.25 4.25C15.5304 4.25 19 7.71905 19 11.998C19 16.2769 15.5304 19.7459 11.25 19.7459C6.96962 19.7459 3.5 16.2769 3.5 11.998Z" fill="currentColor"></path></svg>
          </button>
        </div>
      </slot>
    </div>

    <!-- Modal Overlay -->
    <Teleport to="body">
      <div v-if="isOpen" class="fixed inset-0 z-[9999] flex items-start justify-center pt-10 sm:pt-[10vh] px-4 sm:px-6">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 transition-opacity backdrop-blur-sm" @click="closeModal"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-3xl bg-white shadow-2xl h-auto max-h-[calc(100vh-100px)] flex flex-col rounded-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
          
          <!-- Search Box Header -->
          <div class="bg-white p-6 sm:p-8 pb-4 shrink-0 border-b border-gray-100">
            <div class="relative">
              <input ref="searchInput" v-model="searchQuery" @input="handleInput" class="flex h-[60px] w-full items-center rounded-xl border border-gray-300 pl-14 pr-14 outline-none duration-300 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 text-lg" placeholder="Nhập từ khoá để tìm kiếm..." type="text">
              <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
              
              <button v-if="searchQuery" @click="clearSearch" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                <svg viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
            </div>
          </div>

          <!-- Tabs -->
          <div class="flex flex-wrap items-center gap-3.5 bg-white px-6 sm:px-8 py-4 border-b border-gray-100 shrink-0">
            <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-gray-200 bg-white text-gray-700 hover:border-blue-300 hover:bg-blue-50'" class="inline-flex h-10 items-center justify-center rounded-lg border px-5 py-2.5 text-sm font-medium transition-colors">Tất cả</button>
            <button @click="activeTab = 'products'" :class="activeTab === 'products' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-gray-200 bg-white text-gray-700 hover:border-blue-300 hover:bg-blue-50'" class="inline-flex h-10 items-center justify-center rounded-lg border px-5 py-2.5 text-sm font-medium transition-colors">Sản phẩm</button>
            <button @click="activeTab = 'blogs'" :class="activeTab === 'blogs' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-gray-200 bg-white text-gray-700 hover:border-blue-300 hover:bg-blue-50'" class="inline-flex h-10 items-center justify-center rounded-lg border px-5 py-2.5 text-sm font-medium transition-colors">Bài viết</button>
          </div>

          <!-- Results Area -->
          <div class="bg-gray-50 p-6 sm:p-8 flex-1 overflow-y-auto">
            
            <div v-if="loading" class="flex flex-col items-center justify-center py-12">
              <svg class="animate-spin h-8 w-8 text-blue-600 mb-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
              <p class="text-gray-500">Đang tìm kiếm...</p>
            </div>

            <div v-else-if="searchQuery && filteredResults.length === 0" class="text-center py-16">
              <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <p class="text-gray-600 text-lg">Không tìm thấy kết quả nào cho "{{ searchQuery }}".</p>
            </div>

            <div v-else-if="!searchQuery" class="text-center py-16">
              <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
              </div>
              <p class="text-gray-500 text-lg">Bắt đầu gõ để tìm kiếm sản phẩm và bài viết.</p>
            </div>

            <div v-else class="space-y-3">
              <div v-for="item in filteredResults" :key="item.type + item.id" class="w-full bg-white group rounded-xl hover:bg-blue-50/50 border border-transparent hover:border-blue-100 transition-all shadow-sm">
                <a class="flex items-center p-3 sm:p-4" :href="item.url">
                  <div class="relative overflow-hidden flex-shrink-0 items-center justify-center rounded-lg border border-gray-100 bg-gray-50 w-24 h-16 sm:w-28 sm:h-20">
                    <img v-if="item.image" :alt="item.title" loading="lazy" class="object-cover w-full h-full duration-300 group-hover:scale-105" :src="item.image">
                    <div v-else class="w-full h-full flex items-center justify-center text-gray-300">
                      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                  </div>
                  <div class="ml-4 w-full flex flex-col justify-center">
                    <h4 class="text-base font-semibold text-gray-900 duration-300 group-hover:text-blue-600 sm:text-lg line-clamp-1" v-html="highlight(item.title)"></h4>
                    
                    <div v-if="item.type === 'product'" class="flex items-center mt-1.5 gap-3">
                        <span class="text-sm font-bold text-gray-900" v-html="item.price_html"></span>
                        <span class="inline-block text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded bg-green-100 text-green-700">Sản phẩm</span>
                    </div>
                    
                    <div v-else class="flex flex-col mt-1">
                        <span class="text-sm text-gray-500 line-clamp-1" v-html="highlight(item.excerpt)"></span>
                        <div class="mt-1">
                            <span class="inline-block text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-700">Bài viết</span>
                        </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            
          </div>
          
          <!-- Close Button -->
          <button @click="closeModal" class="absolute top-4 right-4 sm:hidden p-2 text-gray-400 hover:text-gray-600 bg-gray-100 rounded-full transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue';
import axios from 'axios';

const isOpen = ref(false);
const searchQuery = ref('');
const activeTab = ref('all'); // 'all', 'products', 'blogs'
const loading = ref(false);
const products = ref([]);
const blogs = ref([]);
const searchInput = ref(null);

let debounceTimer = null;
const restUrl = window.wpVueTheme?.restUrl || '/wp-json/';

const openModal = () => {
  isOpen.value = true;
  nextTick(() => {
    if (searchInput.value) {
      searchInput.value.focus();
    }
  });
  document.body.style.overflow = 'hidden';
};

const closeModal = () => {
  isOpen.value = false;
  document.body.style.overflow = '';
};

const clearSearch = () => {
  searchQuery.value = '';
  products.value = [];
  blogs.value = [];
  if (searchInput.value) {
    searchInput.value.focus();
  }
};

const handleInput = () => {
  clearTimeout(debounceTimer);
  loading.value = true;
  
  if (!searchQuery.value.trim()) {
    products.value = [];
    blogs.value = [];
    loading.value = false;
    return;
  }

  debounceTimer = setTimeout(async () => {
    await performSearch();
  }, 400);
};

const performSearch = async () => {
  try {
    const query = searchQuery.value;
    
    // Fetch Products
    const prodPromise = axios.get(`${restUrl}wc/store/v1/products`, {
      params: { search: query, per_page: 5 }
    });
    
    // Fetch Blogs
    const blogPromise = axios.get(`${restUrl}wp/v2/posts`, {
      params: { search: query, per_page: 5, _embed: 1 }
    });
    
    const [prodRes, blogRes] = await Promise.all([prodPromise, blogPromise]);
    
    // Format Products
    products.value = prodRes.data.map(p => {
        // Strip HTML tags from price (WC returns price_html which might have span/del/ins)
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = p.price_html;
        return {
          id: p.id,
          type: 'product',
          title: p.name,
          url: p.permalink,
          image: p.images && p.images.length > 0 ? p.images[0].src : null,
          price_html: tempDiv.innerHTML || p.price_html,
          excerpt: p.short_description
        }
    });
    
    // Format Blogs
    blogs.value = blogRes.data.map(p => {
      let imageUrl = null;
      if (p._embedded && p._embedded['wp:featuredmedia'] && p._embedded['wp:featuredmedia'][0]) {
        imageUrl = p._embedded['wp:featuredmedia'][0].source_url;
      }
      
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = p.excerpt.rendered;
      const cleanExcerpt = tempDiv.textContent || tempDiv.innerText || '';
      
      // Also unescape title entities
      const titleDiv = document.createElement('div');
      titleDiv.innerHTML = p.title.rendered;
      
      return {
        id: p.id,
        type: 'blog',
        title: titleDiv.textContent || titleDiv.innerText,
        url: p.link,
        image: imageUrl,
        excerpt: cleanExcerpt
      };
    });
    
  } catch (err) {
    console.error('Search error:', err);
  } finally {
    loading.value = false;
  }
};

const filteredResults = computed(() => {
  let all = [];
  if (activeTab.value === 'all' || activeTab.value === 'products') {
    all = [...all, ...products.value];
  }
  if (activeTab.value === 'all' || activeTab.value === 'blogs') {
    all = [...all, ...blogs.value];
  }
  
  // Interleave or just sort loosely if needed, for now just concat
  return all;
});

const highlight = (text) => {
  if (!searchQuery.value) return text;
  if (!text) return '';
  
  // Escape regex specials
  const safeQuery = searchQuery.value.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
  const regex = new RegExp(`(${safeQuery})`, 'gi');
  return text.replace(regex, '<span class="text-blue-600 bg-blue-100/50 px-0.5 rounded">$1</span>');
};
</script>

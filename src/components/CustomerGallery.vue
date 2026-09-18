<template>
  <section class="py-6">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-dark-950 rounded-xl px-4 py-7">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50 uppercase">
              Khách hàng <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">Hoàng Long</span>
            </h2>
            <p class="text-dark-400 mt-1 text-sm">Hình ảnh thực tế từ khách hàng của chúng tôi</p>
          </div>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
          <!-- Large Image (First) -->
          <div 
            v-if="images[0]"
            class="col-span-2 row-span-2 aspect-square lg:aspect-auto lg:h-full bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden hover:border-primary-500/30 transition-all cursor-pointer group relative"
            @click="openImage(images[0])"
          >
            <img 
              :src="images[0]" 
              alt="Khách hàng Hoàng Long lớn" 
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
              <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
              </svg>
            </div>
          </div>

          <!-- Small Images -->
          <div 
            v-for="(image, index) in images.slice(1)" 
            :key="index"
            class="aspect-square bg-dark-800/50 rounded-2xl border border-dark-700 overflow-hidden hover:border-primary-500/30 transition-all cursor-pointer group relative"
            @click="openImage(image)"
          >
            <img 
              :src="image" 
              :alt="'Khách hàng Hoàng Long ' + (index + 2)" 
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
              <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Modal (Lightbox) -->
    <transition name="fade">
      <div 
        v-if="selectedImage" 
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-4"
        @click="closeImage"
      >
        <button 
          class="absolute top-4 right-4 text-white hover:text-gray-300 p-2"
          @click.stop="closeImage"
          aria-label="Đóng"
        >
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <img 
          :src="selectedImage" 
          class="max-w-full max-h-full object-contain rounded"
          @click.stop
          alt="Full screen view"
        />
      </div>
    </transition>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const selectedImage = ref(null);

const openImage = (image) => {
  selectedImage.value = image;
  document.body.style.overflow = 'hidden'; // Prevent scrolling
};

const closeImage = () => {
  selectedImage.value = null;
  document.body.style.overflow = ''; // Restore scrolling
};

const images = [
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/376677240_772107981592054_513140479166681722_n.jpg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/400499586_796300405839478_4655050377962618674_n.jpg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/398577852_798821698920682_8477134062310824106_n.jpg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/383997556_770156161787236_6763913331045155677_n.jpg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/383997543_769542735181912_7346302016076924733_n.jpg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/393183799_781436523992533_4793358026143908604_n.jpg',
  'https://hoanglongamthanhso.com/wp-content/uploads/2023/11/376677240_772107981592054_513140479166681722_n.jpg'
];
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

<template>
  <a
    :href="product.permalink || '#'"
    class="group block bg-white rounded-md border border-dark-700 overflow-hidden hover:border-primary-500/30 hover:shadow-glow transition-all duration-300 hover:-translate-y-1"
  >
    <!-- Image -->
    <div class="relative aspect-square overflow-hidden">
      <img
        v-if="product.images && product.images.length > 0"
        :src="product.images[0].src"
        :alt="product.images[0].alt || product.name"
        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
        loading="lazy"
      />
      <div
        v-else
        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-dark-700 to-dark-800"
      >
        <svg
          class="w-16 h-16 text-dark-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
          />
        </svg>
      </div>

      <!-- Badges -->
      <div class="absolute top-3 left-3 flex flex-col gap-2">
        <span
          v-if="product.onSale"
          class="px-3 py-1 text-xs font-bold text-white bg-secondary-500 rounded-full shadow-lg"
        >
          GIẢM GIÁ
        </span>
        <span
          v-if="!product.isInStock"
          class="px-3 py-1 text-xs font-bold text-white bg-dark-600 rounded-full"
        >
          HẾT HÀNG
        </span>
      </div>

      <!-- Quick Actions -->
      <!-- <div
        class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300"
      >
        <button
          v-if="product.isInStock"
          @click.prevent="handleAddToCart"
          class="p-3 bg-primary-500 text-white rounded-xl shadow-glow hover:bg-primary-600 transition-colors"
          :disabled="adding"
          aria-label="Thêm vào giỏ"
        >
          <svg
            v-if="!adding"
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            />
          </svg>
          <svg
            v-else
            class="w-5 h-5 animate-spin"
            fill="none"
            viewBox="0 0 24 24"
          >
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            ></circle>
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
            ></path>
          </svg>
        </button>
      </div> -->
    </div>

    <!-- Info -->
    <div class="p-4">
      <!-- Name -->
      <h3
        class="text-sm font-semibold text-dark-100 line-clamp-2 lg:line-clamp-1 mb-2 leading-snug"
      >
        {{ product.name }}
      </h3>

      <!-- Rating -->
      <div
        v-if="product.averageRating > 0"
        class="flex items-center gap-1.5 mb-2"
      >
        <div class="flex items-center gap-0.5">
          <svg
            v-for="i in 5"
            :key="i"
            class="w-3.5 h-3.5"
            :class="
              i <= Math.round(product.averageRating)
                ? 'text-accent-400'
                : 'text-dark-600'
            "
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
            />
          </svg>
        </div>
        <span class="text-xs text-dark-500">({{ product.reviewCount }})</span>
      </div>

      <!-- Price -->
      <div class="flex items-center gap-2">
        <template v-if="!product.price || Number(product.price) === 0">
          <span class="text-lg font-bold text-red-500">Liên hệ</span>
        </template>
        <template v-else>
          <span
            class="text-lg font-bold"
            :class="product.onSale ? 'text-secondary-400' : 'text-dark-50'"
          >
            {{
              formatPrice(product.onSale ? product.salePrice : product.price)
            }}
          </span>
          <span
            v-if="product.onSale"
            class="text-sm text-dark-500 line-through"
          >
            {{ formatPrice(product.regularPrice) }}
          </span>
        </template>
      </div>

      <div class="product-loop__contact mt-2">
        <ul class="grid grid-cols-1 gap-1">
          <li class="text-xs flex items-center gap-2">
            <img
              alt="hot-product"
              width="16"
              height="16"
              loading="lazy"
              src="https://cdn.hstatic.net/files/200001089693/file/product-hotline-icon.png"
            />
            <span>Gọi ngay để nhận giá tốt nhất</span>
          </li>
          <li class="text-xs flex items-center gap-2">
            <img
              alt="hot-product"
              width="16"
              height="16"
              loading="lazy"
              src="https://cdn.hstatic.net/files/200001089693/file/product-voucher-icon.png"
            />
            <span>Cam kết sản phẩm chính hãng</span>
          </li>
        </ul>
      </div>
    </div>
  </a>
</template>

<script setup>
import { ref } from "vue";
import { useCart } from "../composables/useCart.js";
import { useProducts } from "../composables/useProducts.js";

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
});

const { addToCart } = useCart();
const { formatPrice } = useProducts();
const adding = ref(false);

async function handleAddToCart() {
  adding.value = true;
  await addToCart(props.product.id, 1);
  adding.value = false;
}
</script>

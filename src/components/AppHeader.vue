<template>
  <div>
    <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm">
      <!-- ===== TOP BAR ===== -->
      <div class="hidden lg:block bg-gray-50 border-b border-gray-200">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center gap-3 justify-between h-9">
            <!-- Left: Open hours -->
            <span class="text-xs text-gray-500">
              Thời gian mở cửa:
              <strong class="text-gray-700 font-medium"
                >Từ 8h – 18h hàng ngày</strong
              >
            </span>
            <!-- Right: Main nav links -->
            <nav class="flex items-center gap-1">
              <a
                v-for="item in menuItems"
                :key="item.slug"
                :href="item.url"
                class="relative px-4 h-9 inline-flex items-center text-xs font-medium border-b-2 transition-colors duration-150"
                :class="
                  isActive(item.slug)
                    ? 'text-blue-600 border-blue-600'
                    : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-400'
                "
              >
                {{ item.title }}
              </a>
            </nav>
          </div>
        </div>
      </div>

      <!-- ===== MOBILE HEADER (< lg) ===== -->
      <div class="lg:hidden border-b border-gray-200 bg-white">
        <div class="flex items-center justify-between h-14 px-4">
          <!-- Left: Hamburger menu -->
          <button
            @click="toggleMobileMenu"
            class="p-2 -ml-2 text-black rounded-md transition-colors"
            aria-label="Menu"
          >
            <svg
              v-if="!mobileMenuOpen"
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
            <svg
              v-else
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>

          <!-- Center: Logo -->
          <a
            :href="homeUrl"
            class="absolute left-1/2 -translate-x-1/2 flex items-center gap-1.5"
          >
            <img
              v-if="logoheader"
              :src="logoheader"
              :alt="siteTitle"
              class="h-9 w-auto object-contain"
            />
            <span v-else class="text-lg font-bold text-gray-800">{{
              siteTitle
            }}</span>
          </a>

          <!-- Right: Search + Cart -->
          <div class="flex items-center gap-1">
            <!-- Search icon -->
            <InstantSearch>
              <template #trigger>
                <button
                  class="p-2 text-gray-600 hover:text-blue-600 rounded-md transition-colors"
                  aria-label="Tìm kiếm"
                >
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                  </svg>
                </button>
              </template>
            </InstantSearch>
            <!-- Cart icon -->
            <button
              v-if="wcActive"
              @click="toggleCart"
              class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors cursor-pointer"
              aria-label="Giỏ hàng"
            >
              <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                />
              </svg>
              <span
                v-if="cartItemCount > 0"
                class="absolute top-0 right-0 min-w-[16px] h-4 flex items-center justify-center text-[10px] font-bold text-white bg-blue-600 rounded-full px-0.5"
              >
                {{ cartItemCount > 99 ? "99+" : cartItemCount }}
              </span>
            </button>
          </div>
        </div>
      </div>

      <!-- ===== DESKTOP HEADER (>= lg) ===== -->
      <div class="hidden lg:block border-b border-gray-200">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center gap-8 h-24">
            <!-- Logo -->
            <a
              :href="homeUrl"
              class="flex-shrink-0 flex items-center gap-2 group"
            >
              <img
                v-if="logoheader"
                :src="logoheader"
                :alt="siteTitle"
                class="h-16 w-auto object-contain"
              />
            </a>

            <!-- Search Bar -->
            <div class="flex-1 max-w-2xl">
              <InstantSearch>
                <template #trigger>
                  <div
                    class="flex items-center border border-gray-300 rounded-md overflow-hidden hover:border-blue-400 transition-colors cursor-pointer bg-white"
                  >
                    <div
                      class="flex items-center px-3 py-2.5 flex-1 gap-2 text-gray-400"
                    >
                      <svg
                        class="w-4 h-4 flex-shrink-0"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                      </svg>
                      <span class="text-sm">Tìm kiếm sản phẩm...</span>
                    </div>
                  </div>
                </template>
              </InstantSearch>
            </div>

            <!-- Right: Hotline + Account + Cart -->
            <div class="flex items-center gap-8 flex-shrink-0">
              <!-- Hotline -->
              <a
                href="tel:0975388726"
                class="flex items-center gap-2 text-gray-600 group transition-colors"
              >
                <div
                  class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center"
                >
                  <svg
                    class="w-4 h-4 text-blue-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                    />
                  </svg>
                </div>
                <div class="leading-tight">
                  <div class="text-xs text-gray-400">Hỗ trợ 24/7</div>
                  <div
                    class="text-sm font-semibold text-gray-700 group-hover:text-blue-600"
                  >
                    0975 388 726
                  </div>
                </div>
              </a>

              <!-- Account -->
              <a
                :href="accountUrl"
                class="flex flex-col items-center gap-0.5 text-gray-600 hover:text-blue-600 transition-colors"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
                <span class="text-xs">Tài khoản</span>
              </a>

              <!-- Cart -->
              <button
                v-if="wcActive"
                @click="toggleCart"
                class="relative flex flex-col items-center gap-0.5 text-gray-600 hover:text-blue-600 transition-colors cursor-pointer"
                aria-label="Giỏ hàng"
              >
                <div class="relative">
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                    />
                  </svg>
                  <span
                    v-if="cartItemCount > 0"
                    class="absolute -top-2 -right-2 min-w-[18px] h-[18px] flex items-center justify-center text-[10px] font-bold text-white bg-blue-600 rounded-full px-1"
                  >
                    {{ cartItemCount > 99 ? "99+" : cartItemCount }}
                  </span>
                </div>
                <span class="text-[10px]">Giỏ hàng</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== CATEGORY NAV BAR ===== -->
      <div class="hidden lg:block border-b border-gray-200 bg-white">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
          <div
            class="flex items-center gap-0 h-10 overflow-x-auto scrollbar-none"
          >
            <template v-if="loadingCats">
              <a
                v-for="i in 6"
                :key="i"
                class="shrink-0 h-4 w-24 bg-gray-100 rounded mx-2 animate-pulse"
              ></a>
            </template>
            <template v-else>
              <a
                v-for="cat in navCategories"
                :key="cat.id"
                :href="cat.permalink"
                class="shrink-0 px-4 h-full flex items-center text-sm font-medium border-b-2 transition-all duration-150 whitespace-nowrap"
                :class="
                  isCategoryActive(cat.slug)
                    ? 'text-blue-600 border-blue-600 bg-blue-50'
                    : 'text-gray-600 border-transparent hover:text-blue-600 hover:bg-blue-50 hover:border-blue-600'
                "
              >
                {{ cat.name }}
              </a>
            </template>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <transition name="slide-down">
        <div
          v-if="mobileMenuOpen"
          class="lg:hidden absolute top-full left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-50"
        >
          <nav class="max-w-8xl mx-auto px-4 py-3 space-y-1 h-[100vh]">
            <a
              v-for="item in menuItems"
              :key="item.slug"
              :href="item.url"
              class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all"
              :class="
                isActive(item.slug)
                  ? 'text-blue-600 bg-blue-50'
                  : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
              "
            >
              {{ item.title }}
            </a>
            <!-- Mobile categories -->
            <div class="pt-2 border-t border-gray-100">
              <p
                class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wide"
              >
                Danh mục
              </p>
              <a
                v-for="cat in navCategories"
                :key="`m-${cat.id}`"
                :href="cat.permalink"
                class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all"
                :class="
                  isCategoryActive(cat.slug)
                    ? 'text-blue-600 bg-blue-50 font-medium'
                    : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50'
                "
              >
                {{ cat.name }}
              </a>
            </div>
          </nav>
        </div>
      </transition>
    </header>

    <!-- Spacer cho fixed header (top bar 36px + main header 80px + cat nav 40px) -->
    <div class="h-[58px] lg:h-[156px]"></div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useCart } from "../composables/useCart.js";
import InstantSearch from "./InstantSearch.vue";

const mobileMenuOpen = ref(false);

// Get data from WordPress
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || "/";
const logoheader = homeUrl + "wp-content/uploads/2026/09/3213.jpg";
const siteTitle = wpData.siteTitle || "VueCommerce";
const siteLogo = wpData.siteLogo || null;
const wcActive = wpData.wcActive || false;
const restUrl = wpData.restUrl || "/wp-json/";
const accountUrl = wpData.accountUrl || homeUrl + "my-account/";

// Categories loaded từ PHP — không cần API call
const navCategories = ref(wpData.productCategories || []);
const loadingCats = ref(false);

const menuItems = wpData.primaryMenu || [
  { title: "Trang chủ", url: homeUrl, slug: "home" },
  { title: "Video", url: homeUrl + "video", slug: "video" },
  { title: "Tin Tức", url: homeUrl + "tin-tuc", slug: "tin-tuc" },
  { title: "Liên hệ", url: homeUrl + "lien-he", slug: "lien-he" },
];

function isActive(slug) {
  const path = window.location.pathname;
  if (slug === "home") return path === "/" || wpData.isHome;
  if (slug === "shop")
    return (
      path.includes("/cua-hang") ||
      path.includes("/product") ||
      wpData.isShop ||
      wpData.isProduct
    );
  return path.includes(`/${slug}`);
}

function isCategoryActive(slug) {
  const path = window.location.pathname;
  if (wpData.currentCategory && wpData.currentCategory.slug === slug)
    return true;
  return (
    path.includes(`/danh-muc-san-pham/${slug}`) ||
    path.includes(`/product-category/${slug}`)
  );
}

function toggleMobileMenu() {
  mobileMenuOpen.value = !mobileMenuOpen.value;
}

function handleScroll() {
  if (mobileMenuOpen.value && window.scrollY > 10) {
    mobileMenuOpen.value = false;
  }
}

onMounted(() => {
  window.addEventListener("scroll", handleScroll, { passive: true });
});

onUnmounted(() => {
  window.removeEventListener("scroll", handleScroll);
});
</script>

<style scoped>
.scrollbar-none::-webkit-scrollbar {
  display: none;
}
.scrollbar-none {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.2s ease;
}
.slide-down-enter-from,
.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>

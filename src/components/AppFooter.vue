<template>
  <div>
    <footer
      class="relative bg-dark-950 border-t border-dark-800 pb-[65px] lg:pb-0"
    >
      <!-- Gradient Divider -->
      <div
        class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary-500/50 to-transparent"
      ></div>

      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer -->
        <div
          class="pt-10 pb-4 md:py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12"
        >
          <!-- Brand Column -->
          <div class="lg:col-span-1">
            <a :href="homeUrl" class="flex items-center gap-3 group mb-6">
              <img
                :src="logoFooter"
                alt="Logo"
                class="h-10 w-auto object-contain"
              />
            </a>
            <p class="text-dark-400 text-sm leading-relaxed mb-6">
              {{
                siteDesc ||
                "tự hào tin rằng, cung cấp cho bạn các dàn âm thanh chuyên nghiệp và đa dạng và không ngừng phấn đấu, nỗ lực cùng niêm đam mê."
              }}
            </p>
            <!-- Social Icons -->
            <div class="flex items-center gap-3">
              <a
                v-for="social in socials"
                :key="social.name"
                :href="social.url"
                target="_blank"
                rel="noopener"
                class="w-10 h-10 flex items-center justify-center rounded-xl bg-dark-800 text-dark-400 hover:bg-primary-500/20 hover:text-primary-400 transition-all border border-dark-700 hover:border-primary-500/30"
                :aria-label="social.name"
              >
                <span v-html="social.icon" class="w-4 h-4"></span>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div>
            <h4
              class="text-sm font-semibold text-dark-50 uppercase tracking-wider mb-6"
            >
              Liên Kết
            </h4>
            <ul class="space-y-3">
              <li v-for="link in quickLinks" :key="link.title">
                <a
                  :href="link.url"
                  class="text-sm text-dark-400 hover:text-primary-400 transition-colors flex items-center gap-2 group"
                >
                  <svg
                    class="w-3.5 h-3.5 text-dark-600 group-hover:text-primary-500 transition-colors"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                  {{ link.title }}
                </a>
              </li>
            </ul>
          </div>

          <!-- Customer Service -->
          <div>
            <h4
              class="text-sm font-semibold text-dark-50 uppercase tracking-wider mb-6"
            >
              Hỗ Trợ
            </h4>
            <ul class="space-y-3">
              <li v-for="link in supportLinks" :key="link.title">
                <a
                  :href="link.url"
                  class="text-sm text-dark-400 hover:text-primary-400 transition-colors flex items-center gap-2 group"
                >
                  <svg
                    class="w-3.5 h-3.5 text-dark-600 group-hover:text-primary-500 transition-colors"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                  {{ link.title }}
                </a>
              </li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div>
            <h4
              class="text-sm font-semibold text-dark-50 uppercase tracking-wider mb-6"
            >
              Liên Hệ
            </h4>
            <ul class="space-y-4">
              <li class="flex items-start gap-3">
                <svg
                  class="w-5 h-5 text-primary-400 mt-0.5 shrink-0"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
                <span class="text-sm text-dark-400"
                  >107 P. Trường Lâm, Kim Quan, Việt Hưng, Hà Nội</span
                >
              </li>
              <li class="flex items-start gap-3">
                <svg
                  class="w-5 h-5 text-primary-400 mt-0.5 shrink-0"
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
                <span class="text-sm text-dark-400">0975 386 726</span>
              </li>
              <li class="flex items-start gap-3">
                <svg
                  class="w-5 h-5 text-primary-400 mt-0.5 shrink-0"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                  />
                </svg>
                <span class="text-sm text-dark-400"
                  >cuahanghoanglongamthanhso@gmail.com</span
                >
              </li>
            </ul>
          </div>
        </div>

        <!-- Bottom Bar -->
        <div
          class="py-6 border-t border-dark-800 flex flex-col sm:flex-row items-center justify-between gap-4"
        >
          <p class="text-sm text-dark-500">
            © {{ currentYear }} {{ siteTitle }}. All rights reserved.
          </p>
          <div class="flex items-center gap-6">
            <a
              href="https://hoanglongamthanhso.com/chinh-sach/chinh-sach-bao-mat/"
              class="text-xs text-dark-500 hover:text-dark-300 transition-colors"
              >Chính sách bảo mật</a
            >
            <a
              href="https://hoanglongamthanhso.com/chinh-sach/dieu-khoan-dich-vu-bao-mat/"
              class="text-xs text-dark-500 hover:text-dark-300 transition-colors"
              >Điều khoản sử dụng</a
            >
            <a
              href="https://online.gov.vn/nen-tang/cc595c4e-211e-4986-a089-f975e9f168b0"
              target="_blank"
              rel="noopener noreferrer"
              class='flex-1'
            >
              <img
                :src="logoSaleNoti"
                alt="Logo"
                class="h-16 w-auto object-contain"
              />
            </a>
          </div>
        </div>
      </div>
    </footer>

    <!-- ===== MOBILE BOTTOM NAV ===== -->
    <div
      class="fixed bottom-0 left-0 z-[9999] h-[65px] w-full bg-white shadow-[0_-3px_25px_0_rgba(31,38,67,0.15)] lg:hidden"
    >
      <div class="flex h-full">
        <!-- Trang chủ -->
        <a
          :href="homeUrl"
          class="flex h-full flex-1 flex-col items-center justify-center gap-1 text-xs transition-colors"
        >
          <svg
            width="22px"
            height="22px"
            viewBox="0 0 16 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g
              id="SVGRepo_tracerCarrier"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></g>
            <g id="SVGRepo_iconCarrier">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M8 0L0 6V8H1V15H4V10H7V15H15V8H16V6L14 4.5V1H11V2.25L8 0ZM9 10H12V13H9V10Z"
                fill="#2196f3"
              ></path>
            </g>
          </svg>
          <span class="hover:text-primary-500">Trang chủ</span>
        </a>

        <!-- Messenger -->
        <a
          href="https://m.me/hoanglongamthanhso"
          target="_blank"
          rel="noopener"
          class="flex h-full flex-1 flex-col items-center justify-center gap-1 text-xs hover:text-primary-500 transition-colors"
        >
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="#2196f3">
            <path
              d="M12 0C5.374 0 0 4.975 0 11.111c0 3.498 1.744 6.614 4.469 8.651V24l4.088-2.242c1.092.3 2.246.464 3.443.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0zm1.191 14.963l-3.055-3.26-5.963 3.26L10.732 8l3.131 3.26L19.752 8l-6.561 6.963z"
            />
          </svg>
          <span>Messenger</span>
        </a>

        <!-- Hotline -->
        <a
          href="tel:0975386726"
          class="flex h-full flex-1 flex-col items-center justify-center gap-1 text-xs transition-colors"
        >
          <div
            class="relative flex h-10 w-10 -mt-5 items-center justify-center rounded-full bg-primary-500 shadow-lg ring-4 ring-white"
          >
            <svg
              class="h-6 w-6 text-white"
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
          <span class="font-medium mt-0.5">Hotline</span>
        </a>

        <!-- Zalo -->
        <a
          href="https://zalo.me/0975386726"
          target="_blank"
          rel="noopener"
          class="flex h-full flex-1 flex-col items-center justify-center gap-1 text-xs hover:text-primary-500 transition-colors"
        >
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="#2196f3">
            <path
              d="M22.066 10.978c0 5.418-4.706 9.816-10.51 9.816-1.306 0-2.556-.216-3.716-.613-2.616 2.18-5.748 1.988-5.748 1.988.407-1.848.096-3.32-.123-4.14-1.253-1.776-1.966-3.9-1.966-6.155 0-5.417 4.706-9.815 10.51-9.815s10.509 4.398 10.509 9.815v.9l-.02-.8zm-4.771 1.947c0-.236-.188-.426-.419-.426H13.62l1.966-2.565c.34-.44.02-.916-.549-.916H11.59c-.234 0-.422.188-.422.426v.426c0 .235.188.426.422.426h3.256l-1.967 2.564c-.339.44-.02.916.549.916h3.447c.231 0 .419-.188.419-.426v-.425zm-6.22 0c0-.236-.188-.426-.418-.426H9.288c-.232 0-.42.188-.42.426v.426c0 .235.188.426.42.426h1.369c.23 0 .418-.188.418-.426v-.425zm0-2.31c0-.44-.356-.798-.795-.798H9.066c-.44 0-.796.357-.796.798 0 .441.356.799.796.799h1.22c.439 0 .795-.358.795-.799zm-4.766 2.736v-3.567c0-.236-.188-.426-.42-.426h-.425c-.23 0-.418.188-.418.426v3.567c0 .235.188.426.418.426h.425c.232 0 .42-.188.42-.426z"
            />
          </svg>
          <span>Zalo</span>
        </a>

        <!-- Map -->
        <a
          href="https://maps.app.goo.gl/R5TUjFjUvAV5sxik8"
          target="_blank"
          rel="noopener"
          class="flex h-full flex-1 flex-col items-center justify-center gap-1 text-xs transition-colors"
        >
          <svg
            class="h-6 w-6"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g
              id="SVGRepo_tracerCarrier"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></g>
            <g id="SVGRepo_iconCarrier">
              <path
                d="M12 22.0003C17.5228 22.0003 22 19.9856 22 17.5003C22 16.2337 20.837 15.0892 18.9654 14.2715C17.8233 16.3673 16.0817 18.1738 13.8695 19.1192C12.6804 19.6274 11.3196 19.6274 10.1305 19.1192C7.91828 18.1738 6.17666 16.3673 5.03458 14.2715C3.16295 15.0892 2 16.2337 2 17.5003C2 19.9856 6.47715 22.0003 12 22.0003Z"
                fill="#2196f3"
              ></path>
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M5 8.51464C5 4.9167 8.13401 2 12 2C15.866 2 19 4.9167 19 8.51464C19 12.0844 16.7658 16.2499 13.2801 17.7396C12.4675 18.0868 11.5325 18.0868 10.7199 17.7396C7.23416 16.2499 5 12.0844 5 8.51464ZM12 11C13.1046 11 14 10.1046 14 9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9C10 10.1046 10.8954 11 12 11Z"
                fill="#2196f3"
              ></path>
            </g>
          </svg>
          <span>Map</span>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || "/";
const logoFooter = homeUrl + "wp-content/uploads/2026/09/logo-footer.png";
const logoSaleNoti = homeUrl + "wp-content/uploads/2026/09/logoSaleNoti.png";

const siteTitle = wpData.siteTitle || "VueCommerce";
const siteDesc = wpData.siteDesc || "";
const currentYear = new Date().getFullYear();
const isHome = wpData.isHome || window.location.pathname === "/";

const quickLinks = [
  { title: "Trang chủ", url: homeUrl },
  { title: "Sản phẩm", url: `${homeUrl}shop` },
  { title: "Bài viết", url: `${homeUrl}tin-tuc` },
  { title: "Liên hệ", url: `${homeUrl}lien-he` },
];

const supportLinks = [
  { title: "Hướng dẫn mua hàng", url: "https://hoanglongamthanhso.com/chinh-sach/huong-dan-mua-hang/" },
  { title: "Chính sách đổi trả", url: "https://hoanglongamthanhso.com/chinh-sach/chinh-sach-doi-tra/" },
  { title: "Chính sách vận chuyển", url: "https://hoanglongamthanhso.com/chinh-sach/chinh-sach-van-chuyen/" },
  { title: "Câu hỏi thường gặp", url: "#" },
];

const socials = [
  {
    name: "Facebook",
    url: "https://www.facebook.com/hoanglongamthanhso/",
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
  },
  {
    name: "YouTube",
    url: "https://www.youtube.com/@HoangLongAmThanhSo",
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
  },
  {
    name: "Zalo",
    url: "https://zalo.me/0975386726",
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.066 10.978c0 5.418-4.706 9.816-10.51 9.816-1.306 0-2.556-.216-3.716-.613-2.616 2.18-5.748 1.988-5.748 1.988.407-1.848.096-3.32-.123-4.14-1.253-1.776-1.966-3.9-1.966-6.155 0-5.417 4.706-9.815 10.51-9.815s10.509 4.398 10.509 9.815v.9l-.02-.8zm-4.771 1.947c0-.236-.188-.426-.419-.426H13.62l1.966-2.565c.34-.44.02-.916-.549-.916H11.59c-.234 0-.422.188-.422.426v.426c0 .235.188.426.422.426h3.256l-1.967 2.564c-.339.44-.02.916.549.916h3.447c.231 0 .419-.188.419-.426v-.425zm-6.22 0c0-.236-.188-.426-.418-.426H9.288c-.232 0-.42.188-.42.426v.426c0 .235.188.426.42.426h1.369c.23 0 .418-.188.418-.426v-.425zm0-2.31c0-.44-.356-.798-.795-.798H9.066c-.44 0-.796.357-.796.798 0 .441.356.799.796.799h1.22c.439 0 .795-.358.795-.799zm-4.766 2.736v-3.567c0-.236-.188-.426-.42-.426h-.425c-.23 0-.418.188-.418.426v3.567c0 .235.188.426.418.426h.425c.232 0 .42-.188.42-.426z"/></svg>',
  },
  {
    name: "TikTok",
    url: "https://www.tiktok.com/@hoanglongamthanhso",
    icon: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v7.2c0 1.96-.5 3.97-1.84 5.42-1.38 1.48-3.35 2.37-5.38 2.4-2.28.02-4.64-.81-6.17-2.58-1.55-1.78-2.07-4.32-1.39-6.6.61-2.06 2.05-3.8 4.02-4.63 2.1-.88 4.54-.7 6.46.46v4.22c-1.04-.6-2.31-.76-3.41-.33-1.1.43-1.9 1.4-2.12 2.56-.25 1.34.42 2.8 1.65 3.39 1.25.6 2.81.4 3.86-.48.91-.77 1.4-1.93 1.4-3.13V.02z"/></svg>',
  },
];
</script>

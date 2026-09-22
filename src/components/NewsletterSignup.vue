<template>
  <section class="overflow-hidden mb-8">
    <div class="max-w-8xl w-full mx-auto px-4 sm:px-6 xl:px-0">
      <div class="px-8 py-7">
        <div class="relative z-1 overflow-hidden rounded-xl shadow-xl">
          <img
            alt="background illustration"
            loading="lazy"
            width="1170"
            height="200"
            decoding="async"
            class="absolute -z-1 w-full h-full left-0 top-0 rounded-xl object-cover"
            :src="imgNewSletter"
          />
          <div
            class="absolute -z-1 max-w-[523px] max-h-[243px] w-full h-full right-0 top-0 bg-gradient-to-bl from-white/20 to-transparent"
          ></div>

          <div
            class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 px-9 sm:px-7.5 xl:pl-12.5 xl:pr-14 py-11"
          >
            <div class="max-w-[491px] w-full">
              <h2
                class="max-w-[399px] text-white font-bold text-lg sm:text-xl xl:text-3xl mb-3"
              >
                Đừng bỏ lỡ những xu hướng & ưu đãi mới nhất
              </h2>
              <p class="text-white/90">
                Đăng ký để nhận tin tức về các ưu đãi & mã giảm giá mới nhất
              </p>
            </div>
            <div class="max-w-[477px] w-full">
              <form @submit.prevent="handleSubscribe">
                <div class="flex flex-col sm:flex-row gap-3">
                  <input
                    id="email"
                    v-model="email"
                    required
                    placeholder="Nhập email của bạn"
                    class="w-full bg-white border border-transparent outline-none rounded-full placeholder:text-dark-400 py-3 px-5 text-dark-50 focus:border-white focus:ring-2 focus:ring-white/30"
                    type="email"
                    name="email"
                  />
                  <button
                    type="submit"
                    :disabled="subscribed || isLoading"
                    class="inline-flex justify-center py-3 px-7 text-white bg-dark-50 font-medium rounded-full ease-out duration-200 hover:bg-dark-100 disabled:opacity-80 disabled:cursor-not-allowed whitespace-nowrap"
                  >
                    {{
                      subscribed
                        ? "Subscribed ✓"
                        : isLoading
                        ? "Đang gửi..."
                        : "Đăng ký"
                    }}
                  </button>
                </div>
              </form>
              <p v-if="errorMessage" class="text-sm text-red-10 mt-2">
                {{ errorMessage }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";

const email = ref("");
const subscribed = ref(false);
const isLoading = ref(false);
const errorMessage = ref("");
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || "/";
const imgNewSletter = homeUrl + "wp-content/uploads/2026/09/newsletter-bg.jpg";

async function handleSubscribe() {
  if (!email.value.trim()) return;

  isLoading.value = true;
  errorMessage.value = "";

  try {
    const restUrl = wpData.restUrl || '/wp-json/';
    const response = await fetch(`${restUrl}vuecommerce/v1/subscribe`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email: email.value }),
    });

    const data = await response.json();

    if (response.ok && data.success) {
      subscribed.value = true;
      setTimeout(() => {
        email.value = "";
        subscribed.value = false;
      }, 3000);
    } else {
      errorMessage.value = data.message || "Đã có lỗi xảy ra. Vui lòng thử lại sau.";
    }
  } catch (error) {
    console.error("Lỗi khi gửi form:", error);
    errorMessage.value = "Không thể kết nối đến máy chủ.";
  } finally {
    isLoading.value = false;
  }
}
</script>

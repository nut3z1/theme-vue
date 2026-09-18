<template>
  <section class="min-h-screen py-12">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-14">
        <h1 class="text-3xl sm:text-4xl font-display font-bold text-dark-50 mb-4">
          Liên Hệ <span class="bg-gradient-to-r from-primary-400 to-secondary-400 bg-clip-text text-transparent">Với Chúng Tôi</span>
        </h1>
        <p class="text-dark-400 max-w-2xl mx-auto text-lg">
          Hãy để lại thông tin, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất
        </p>
      </div>

      <div class="grid lg:grid-cols-5 gap-12 max-w-6xl mx-auto">
        <!-- Contact Info -->
        <div class="lg:col-span-2 space-y-4">
          <!-- Info Cards -->
          <div v-for="info in contactInfo" :key="info.title"
               class="flex items-start gap-4 p-5 bg-dark-800/50 rounded-2xl border border-dark-700 hover:border-primary-500/20 transition-all group">
            <div class="w-12 h-12 shrink-0 rounded-xl bg-primary-500/10 flex items-center justify-center group-hover:bg-primary-500/20 transition-colors">
              <span v-html="info.icon" class="w-5 h-5 text-primary-400"></span>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-dark-200 mb-1">{{ info.title }}</h3>
              <p class="text-sm text-dark-400">{{ info.value }}</p>
              <p v-if="info.note" class="text-xs text-dark-500 mt-1">{{ info.note }}</p>
            </div>
          </div>

          <!-- Working Hours -->
          <div class="p-5 bg-dark-800/50 rounded-2xl border border-dark-700">
            <h3 class="text-sm font-semibold text-dark-200 mb-4 flex items-center gap-2">
              <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Giờ làm việc
            </h3>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-dark-400">Thứ 2 - Thứ 6</span>
                <span class="text-dark-200">08:00 - 17:30</span>
              </div>
              <div class="flex justify-between">
                <span class="text-dark-400">Thứ 7</span>
                <span class="text-dark-200">08:00 - 17:30</span>
              </div>
              <div class="flex justify-between">
                <span class="text-dark-400">Chủ nhật</span>
                <span class="text-dark-200">08:00 - 17:30</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-3">
          <form @submit.prevent="handleSubmit" 
                class="p-6 sm:p-8 bg-dark-800/50 rounded-2xl border border-dark-700 space-y-6">
            
            <!-- Success Message -->
            <div v-if="submitSuccess" 
                 class="p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center gap-3 animate-slide-up">
              <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span>{{ successMessage }}</span>
            </div>

            <!-- Error Message -->
            <div v-if="submitError" 
                 class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center gap-3 animate-slide-up">
              <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
              <span>{{ submitError }}</span>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
              <!-- Name -->
              <div>
                <label for="contact-name" class="block text-sm font-medium text-dark-200 mb-2">
                  Họ và tên <span class="text-secondary-400">*</span>
                </label>
                <input v-model="form.name"
                       id="contact-name"
                       type="text"
                       required
                       placeholder="Nguyễn Văn A"
                       class="w-full px-4 py-3 bg-dark-900 border rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 transition-all text-sm"
                       :class="errors.name ? 'border-red-500' : 'border-dark-600 focus:border-primary-500'">
                <p v-if="errors.name" class="mt-1 text-xs text-red-400">{{ errors.name }}</p>
              </div>

              <!-- Email -->
              <div>
                <label for="contact-email" class="block text-sm font-medium text-dark-200 mb-2">
                  Email <span class="text-secondary-400">*</span>
                </label>
                <input v-model="form.email"
                       id="contact-email"
                       type="email"
                       required
                       placeholder="email@gmail.com"
                       class="w-full px-4 py-3 bg-dark-900 border rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 transition-all text-sm"
                       :class="errors.email ? 'border-red-500' : 'border-dark-600 focus:border-primary-500'">
                <p v-if="errors.email" class="mt-1 text-xs text-red-400">{{ errors.email }}</p>
              </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
              <!-- Phone -->
              <div>
                <label for="contact-phone" class="block text-sm font-medium text-dark-200 mb-2">Số điện thoại</label>
                <input v-model="form.phone"
                       id="contact-phone"
                       type="tel"
                       placeholder="0123 456 789"
                       class="w-full px-4 py-3 bg-dark-900 border border-dark-600 rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30 transition-all text-sm">
              </div>

              <!-- Subject -->
              <div>
                <label for="contact-subject" class="block text-sm font-medium text-dark-200 mb-2">Chủ đề</label>
                <select v-model="form.subject"
                        id="contact-subject"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-600 rounded-xl text-dark-100 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30 transition-all text-sm appearance-none cursor-pointer">
                  <option value="">Chọn chủ đề</option>
                  <option value="Hỗ trợ sản phẩm">Hỗ trợ sản phẩm</option>
                  <option value="Đơn hàng">Đơn hàng</option>
                  <option value="Hợp tác kinh doanh">Hợp tác kinh doanh</option>
                  <option value="Góp ý / Khiếu nại">Góp ý / Khiếu nại</option>
                  <option value="Khác">Khác</option>
                </select>
              </div>
            </div>

            <!-- Message -->
            <div>
              <label for="contact-message" class="block text-sm font-medium text-dark-200 mb-2">
                Nội dung <span class="text-secondary-400">*</span>
              </label>
              <textarea v-model="form.message"
                        id="contact-message"
                        rows="5"
                        required
                        placeholder="Mô tả chi tiết yêu cầu của bạn..."
                        class="w-full px-4 py-3 bg-dark-900 border rounded-xl text-dark-100 placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 transition-all text-sm resize-none"
                        :class="errors.message ? 'border-red-500' : 'border-dark-600 focus:border-primary-500'">
              </textarea>
              <p v-if="errors.message" class="mt-1 text-xs text-red-400">{{ errors.message }}</p>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    :disabled="submitting"
                    class="w-full flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
              <svg v-if="!submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <svg v-else class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              <span>{{ submitting ? 'Đang gửi...' : 'Gửi tin nhắn' }}</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';

const wpData = window.wpVueTheme || {};
const restUrl = wpData.restUrl || '/wp-json/';

const form = reactive({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
});

const errors = reactive({
  name: '',
  email: '',
  message: '',
});

const submitting = ref(false);
const submitSuccess = ref(false);
const submitError = ref('');
const successMessage = ref('');

const contactInfo = [
  {
    title: 'Địa chỉ',
    value: '107 P. Trường Lâm, Kim Quan, Việt Hưng, Hà Nội',
    note: null,
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>',
  },
  {
    title: 'Điện thoại',
    value: '0975 386 726',
    note: 'Thứ 2 - Chủ nhật, 8:00 - 17:30',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>',
  },
  {
    title: 'Email',
    value: 'cuahanghoanglongamthanhso@gmail.com',
    note: 'Phản hồi trong 24h',
    icon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
  },
];

function validate() {
  let valid = true;
  errors.name = '';
  errors.email = '';
  errors.message = '';

  if (!form.name.trim()) {
    errors.name = 'Vui lòng nhập họ tên';
    valid = false;
  }

  if (!form.email.trim()) {
    errors.email = 'Vui lòng nhập email';
    valid = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'Email không hợp lệ';
    valid = false;
  }

  if (!form.message.trim()) {
    errors.message = 'Vui lòng nhập nội dung';
    valid = false;
  }

  return valid;
}

async function handleSubmit() {
  if (!validate()) return;

  submitting.value = true;
  submitSuccess.value = false;
  submitError.value = '';

  try {
    const response = await axios.post(`${restUrl}vuecommerce/v1/contact`, {
      name: form.name,
      email: form.email,
      phone: form.phone,
      subject: form.subject,
      message: form.message,
    });

    submitSuccess.value = true;
    successMessage.value = response.data.message || 'Tin nhắn đã được gửi thành công!';

    // Reset form
    form.name = '';
    form.email = '';
    form.phone = '';
    form.subject = '';
    form.message = '';
  } catch (err) {
    submitError.value = err.response?.data?.message || 'Gửi tin nhắn thất bại. Vui lòng thử lại.';
  } finally {
    submitting.value = false;
  }
}
</script>

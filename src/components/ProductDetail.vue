<template>
  <section class="py-12">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Breadcrumb -->
      <nav class="flex mb-7" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-sm">
          <li class="inline-flex items-center">
            <a
              class="inline-flex items-center gap-1 text-gray-500 hover:text-gray-900 transition-colors"
              :href="homeUrl"
              >Home</a
            >
          </li>
          <li>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              viewBox="0 0 16 16"
              fill="none"
            >
              <path
                d="M5.83333 12.6667L10 8.50008L5.83333 4.33341"
                stroke="#6B7280"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></path>
            </svg>
          </li>
          <li>
            <a
              class="text-gray-500 hover:text-gray-900 transition-colors"
              :href="shopUrl"
              >Shop</a
            >
          </li>
          <li>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              viewBox="0 0 16 16"
              fill="none"
            >
              <path
                d="M5.83333 12.6667L10 8.50008L5.83333 4.33341"
                stroke="#6B7280"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></path>
            </svg>
          </li>
          <li class="inline-flex items-center">
            <span
              class="inline-flex items-center gap-1 font-medium text-gray-900"
              >{{ productData.name }}</span
            >
          </li>
        </ol>
      </nav>

      <div class="flex flex-col lg:flex-row gap-12">
        <div class="w-full lg:w-[60%] flex flex-col sm:flex-row gap-4">
          <!-- Thumbnails: cột dọc bên trái, scroll dọc nếu nhiều ảnh -->
          <div
            v-if="images.length > 1"
            class="flex flex-row sm:flex-col gap-3 overflow-x-auto sm:overflow-x-visible sm:overflow-y-auto sm:max-h-[520px] sm:w-[90px] shrink-0 pb-1 sm:pb-0"
          >
            <div
              v-for="(img, index) in images"
              :key="img.id || index"
              class="w-[80px] sm:w-full shrink-0 cursor-pointer"
              @click="activeImageIndex = index"
            >
              <div
                class="bg-gray-50 rounded-xl overflow-hidden transition-all duration-300 border-2"
                :class="
                  activeImageIndex === index
                    ? 'border-violet-500'
                    : 'border-gray-200 hover:border-violet-300'
                "
              >
                <img
                  :alt="img.alt"
                  class="w-full h-auto aspect-square object-cover"
                  :src="img.thumbnail || img.src"
                />
              </div>
            </div>
          </div>

          <!-- Ảnh chính -->
          <div class="flex-1 bg-gray-50 rounded-3xl overflow-hidden relative">
            <span
              v-if="productData.on_sale"
              class="absolute top-4 left-4 z-10 px-3 py-1 text-xs font-bold text-white bg-red-500 rounded-full shadow-sm"
            >
              SALE
            </span>
            <div class="w-full">
              <img
                v-if="activeImage"
                :alt="activeImage.alt || productData.name"
                class="w-full h-auto object-cover transition-transform duration-500"
                :class="zoomed ? 'scale-150 cursor-zoom-out' : 'cursor-zoom-in'"
                @click="zoomed = !zoomed"
                :src="activeImage.src"
              />
              <div
                v-else
                class="w-full aspect-square flex items-center justify-center"
              >
                <svg
                  class="w-24 h-24 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
              </div>
            </div>
          </div>
        </div>


        <div class="w-full lg:w-[40%]">
          <div class="space-y-6">
            <div>
              <h3
                class="mb-2.5 font-semibold text-gray-800 text-3xl sm:text-4xl sm:leading-10"
              >
                {{ productData.name }}
              </h3>
              <div class="flex">
                <div
                  class="flex items-center gap-1"
                  v-if="productData.average_rating > 0"
                >
                  <svg
                    v-for="i in 5"
                    :key="i"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      v-if="
                        i <= Math.round(parseFloat(productData.average_rating))
                      "
                      d="M10 14.7176L15.8779 17.9337L14.6376 11.4552L19.447 6.94132L12.9011 6.1118L10 0.166687L7.09886 6.1118L0.552988 6.94132L5.36244 11.4552L4.12215 17.9337L10 14.7176Z"
                      fill="#FBBF24"
                    ></path>
                    <path
                      v-else
                      d="M10 14.7176L4.12215 17.9337L5.36244 11.4552L0.552988 6.94132L7.09886 6.1118L10 0.166687"
                      fill="#E5E7EB"
                    ></path>
                  </svg>
                  <p class="ml-2 text-gray-500">
                    {{ productData.average_rating }} ({{
                      productData.review_count
                    }}
                    reviews)
                  </p>
                </div>
              </div>

              <div class="flex gap-3 my-2 items-center">
                <!-- Không có giá → hiển thị "Liên hệ" -->
                <span
                  v-if="
                    (!productData.price && !productData.sale_price) ||
                    (Number(productData.price) === 0 &&
                      Number(productData.sale_price) === 0)
                  "
                  class="text-2xl font-bold text-red-500"
                >
                  Liên hệ
                </span>
                <!-- Có giá → hiển thị bình thường -->
                <template v-else>
                  <div class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-gray-800">{{
                      formatDisplayPrice(
                        productData.sale_price || productData.price,
                      )
                    }}</span>
                    <span
                      v-if="productData.on_sale"
                      class="line-through -tracking-wide text-base text-gray-500 font-normal"
                      >{{ formatDisplayPrice(productData.regular_price) }}</span
                    >
                  </div>
                  <span
                    v-if="productData.on_sale && discountPercent > 0"
                    class="px-2 py-0.5 text-xs inline-block leading-4 font-medium rounded-full text-violet-700 bg-violet-50"
                    >{{ discountPercent }}% OFF</span
                  >
                </template>
              </div>
              <div
                v-if="productData.short_description"
                class="text-gray-500 text-base leading-6 prose prose-sm"
                v-html="productData.short_description"
              ></div>
            </div>

            <div
              class="space-y-6"
              v-if="productData.attributes && productData.attributes.length"
            >
              <div v-for="attr in productData.attributes" :key="attr.name">
                <h4 class="font-medium text-gray-800 text-base mb-4">
                  {{ attr.name }}:
                </h4>
                <div class="flex gap-2 flex-wrap">
                  <button
                    v-for="opt in Array.isArray(attr.options)
                      ? attr.options
                      : [attr.options]"
                    :key="opt"
                    class="px-3.5 py-2 h-9 text-sm leading-5 inline-flex items-center justify-center font-medium border rounded-lg cursor-pointer transition bg-white text-gray-700 border-gray-200 hover:bg-gray-100"
                  >
                    {{ opt }}
                  </button>
                </div>
              </div>
            </div>

            <div>
              <div
                class="flex gap-4"
                v-if="
                  isInStock &&
                  (Number(productData.price) > 0 ||
                    Number(productData.sale_price) > 0)
                "
              >
                <div
                  class="flex w-[146px] divide-gray-200 divide-x h-11 rounded-lg border border-gray-200 overflow-hidden"
                >
                  <button
                    @click="decreaseQty"
                    :disabled="quantity <= 1"
                    class="w-11 h-11 flex items-center justify-center hover:bg-gray-100 transition disabled:opacity-50"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                    >
                      <path
                        d="M5 9.25C4.59 9.25 4.25 9.59 4.25 10C4.25 10.41 4.59 10.75 5 10.75H15C15.41 10.75 15.75 10.41 15.75 10C15.75 9.59 15.41 9.25 15 9.25H5Z"
                        fill="#6B7280"
                      ></path>
                    </svg>
                  </button>
                  <input
                    type="number"
                    v-model.number="quantity"
                    min="1"
                    class="flex-1 flex items-center justify-center text-center w-full focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                  />
                  <button
                    @click="increaseQty"
                    class="w-11 h-11 flex items-center justify-center hover:bg-gray-100 transition"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                    >
                      <path
                        d="M10 4.25C10.41 4.25 10.75 4.59 10.75 5V9.25H15C15.41 9.25 15.75 9.59 15.75 10C15.75 10.41 15.41 10.75 15 10.75H10.75V15C10.75 15.41 10.41 15.75 10 15.75C9.59 15.75 9.25 15.41 9.25 15V10.75H5C4.59 10.75 4.25 10.41 4.25 10C4.25 9.59 4.59 9.25 5 9.25H9.25V5C9.25 4.59 9.59 4.25 10 4.25Z"
                        fill="#6B7280"
                      ></path>
                    </svg>
                  </button>
                </div>
                <button
                  @click="handleAddToCart"
                  :disabled="adding"
                  class="inline-flex grow justify-center text-base leading-5 cursor-pointer focus:ring-3 focus:ring-violet-500/20 items-center bg-violet-500 transition hover:bg-violet-600 py-2.5 px-3.5 rounded-lg text-white font-medium disabled:opacity-50"
                >
                  <svg
                    v-if="adding"
                    class="w-5 h-5 mr-2 animate-spin"
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
                  {{
                    adding
                      ? "Đang thêm..."
                      : addedSuccess
                        ? "Đã thêm ✓"
                        : "Add to Cart"
                  }}
                </button>
                <button
                  class="inline-flex text-sm justify-center leading-5 w-11 h-11 cursor-pointer focus:ring-3 items-center transition rounded-lg border font-medium bg-violet-50 border-violet-300 text-primary-500 focus:ring-violet-500/20"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      d="M3.51311 4.41851C1.88463 6.04699 1.88463 8.68728 3.51311 10.3158L9.11618 15.9189C9.60433 16.4071 10.3958 16.4071 10.884 15.9189L16.487 10.3158C18.1155 8.68737 18.1155 6.04707 16.487 4.41859C14.8586 2.79011 12.2183 2.79011 10.5898 4.41859L10.0001 5.00826L9.41037 4.4185C7.78188 2.79002 5.14159 2.79002 3.51311 4.41851Z"
                      stroke="currentColor"
                      stroke-width="1.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>

            <div>
              <div class="thong-tin-warpper">
                <ul
                  class="grid grid-cols-3  shadow-[0_2px_8px_rgba(0,0,0,0.05)] border border-solid border-[#eee] gap-3 rounded-lg bg-[#f5f5f5] p-2.5 text-center text-sm list-none m-0"
                >
                  <li class="border-r border-[#dbdbdb] pr-2.5">
                    <h5 class=".5 text-xs font-bold">Đơn vị tính</h5>
                    <p class='text-[#2196f3]'>Sản phẩm</p>
                  </li>

                  <li class="border-r border-[#dbdbdb] pr-2.5">
                    <h5 class=".5 text-xs font-bold">Bảo hành</h5>
                    <p class='text-[#2196f3]'>12 tháng</p>
                  </li>

                  <li>
                    <h5 class=".5 text-xs font-bold">
                      Nguồn gốc/ Xuất xứ
                    </h5>
                    <p class='text-[#2196f3]'>Chính hãng</p>
                  </li>
                </ul>
              </div>
            </div>

    
            <div
              class="mb-2.5 rounded-lg border border-[#e0e0e0]"
            >
              <div
                class="border-b border-[#e0e0e0] bg-[#f6f6f6] px-2.5 py-2 font-bold"
              >
                Ưu Đãi Khi Mua Hàng:
              </div>

              <div class="px-2.5 pb-2.5 pt-[15px]">
                <ul class="text-sm text-[#696767] space-y-3">
                  <li class="flex items-start gap-2">
                    <img
                      src="https://hoanglongamthanhso.com/wp-content/uploads/2023/08/icon-so.png"
                      alt="icon-thong-tin"
                      class="w-4 h-4 shrink-0 mt-0.5"
                    />
                    <span>Tặng đầy đủ <strong class='text-red-500'>dây rắc</strong></span>
                  </li>

                  <li class="flex items-start gap-2">
                    <img
                      src="https://hoanglongamthanhso.com/wp-content/uploads/2023/08/icon-so.png"
                      alt="icon-thong-tin"
                      class="w-4 h-4 shrink-0 mt-0.5"
                    />
                    <span>
                      <strong class='text-red-500'>Miễn phí</strong> set up, lắp đặt với đội ngũ kỹ
                      thuật chuyên sâu trong bán kính 5km
                    </span>
                  </li>

                  <li class="flex items-start gap-2">
                    <img
                      src="https://hoanglongamthanhso.com/wp-content/uploads/2023/08/icon-so.png"
                      alt="icon-thong-tin"
                      class="w-4 h-4 shrink-0 mt-0.5"
                    />
                    <span
                      >Giao hàng <strong class='text-red-500'>toàn quốc</strong>, thanh toán
                      COD</span
                    >
                  </li>

                  <li class="flex items-start gap-2">
                    <img
                      src="https://hoanglongamthanhso.com/wp-content/uploads/2023/08/icon-so.png"
                      alt="icon-thong-tin"
                      class="w-4 h-4 shrink-0 mt-0.5"
                    />
                    <span
                      >Cam kết sản phẩm <strong class='text-red-500'>CHÍNH HÃNG 100%</strong></span
                    >
                  </li>

                  <li class="flex items-start gap-2">
                    <img
                      src="https://hoanglongamthanhso.com/wp-content/uploads/2023/08/icon-so.png"
                      alt="icon-thong-tin"
                      class="w-4 h-4 shrink-0 mt-0.5"
                    />
                    <span>
                      <strong class='text-red-500'>
                        Ở đâu bán rẻ chúng tôi bán rẻ hơn - Gọi có giá Rẻ nhất
                        Việt Nam
                      </strong>
                    </span>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Nút liên hệ -->
            <div class="flex flex-col gap-2.5">
              <!-- Gọi ngay - full width đỏ -->
              <a
                href="tel:0963889192"
                class="flex flex-col items-center justify-center w-full py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white transition-colors duration-200 cursor-pointer"
              >
                <span class="font-bold text-base leading-tight flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                  </svg>
                  Gọi ngay
                </span>
                <span class="text-xs text-red-100 mt-0.5">Liên hệ mua hàng</span>
              </a>

              <!-- 2 nút chia đôi -->
              <div class="grid grid-cols-2 gap-2.5">
                <!-- Chat Zalo -->
                <a
                  href="https://zalo.me/0963889192"
                  target="_blank"
                  class="flex flex-col items-center justify-center py-3 rounded-xl bg-[#3bb1e1] hover:bg-[#0057d9] text-white transition-colors duration-200 cursor-pointer"
                >
                  <span class="font-bold text-sm leading-tight flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12 2C6.48 2 2 6.03 2 11c0 2.77 1.32 5.25 3.4 6.93l-.88 3.07 3.18-1.6A10.5 10.5 0 0012 20c5.52 0 10-4.03 10-9S17.52 2 12 2z"/>
                    </svg>
                    CHAT ZALO
                  </span>
                  <span class="text-xs text-blue-100 mt-0.5 text-center leading-tight px-1">Giải đáp hỗ trợ tức thì</span>
                </a>

                <!-- Review sản phẩm -->
                <a
                  href="#review"
                  @click="activeTab = 'review'"
                  class="flex flex-col items-center justify-center py-3 rounded-xl bg-green-500 hover:bg-green-600 text-white transition-colors duration-200 cursor-pointer"
                >
                  <span class="font-bold text-sm leading-tight flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Review sản phẩm
                  </span>
                  <span class="text-xs text-green-100 mt-0.5 text-center leading-tight px-1">Trải nghiệm thực tế sản phẩm</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-11">
        <div class="flex border-b border-gray-200">
          <button
            @click="activeTab = 'information'"
            class="px-6 py-3 text-base font-medium cursor-pointer transition-colors relative"
            :class="
              activeTab === 'information'
                ? 'text-primary-500'
                : 'text-gray-500 hover:text-gray-800'
            "
          >
            Mô tả
            <span
              v-if="activeTab === 'information'"
              class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-500 rounded-t"
            ></span>
          </button>
          <button
            @click="activeTab = 'specification'"
            class="px-6 py-3 text-base font-medium cursor-pointer transition-colors relative"
            :class="
              activeTab === 'specification'
                ? 'text-primary-500'
                : 'text-gray-500 hover:text-gray-800'
            "
          >
            Thông số kỹ thuật
            <span
              v-if="activeTab === 'specification'"
              class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-500 rounded-t"
            ></span>
          </button>
          <button
            @click="activeTab = 'review'"
            class="px-6 py-3 text-base font-medium cursor-pointer transition-colors relative"
            :class="
              activeTab === 'review'
                ? 'text-primary-500'
                : 'text-gray-500 hover:text-gray-800'
            "
          >
            Đánh giá
            <span
              v-if="activeTab === 'review'"
              class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-500 rounded-t"
            ></span>
          </button>
          <button
            @click="activeTab = 'delivery'"
            class="px-6 py-3 text-base font-medium cursor-pointer transition-colors relative"
            :class="
              activeTab === 'delivery'
                ? 'text-primary-500'
                : 'text-gray-500 hover:text-gray-800'
            "
          >
            Vận chuyển
            <span
              v-if="activeTab === 'delivery'"
              class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-500 rounded-t"
            ></span>
          </button>
        </div>

        <div class="py-8">
          <div v-show="activeTab === 'specification'" class="overflow-x-auto">
            <table
              class="w-full text-left text-sm"
              v-if="productData.attributes && productData.attributes.length > 0"
            >
              <tbody class="divide-y divide-gray-100">
                <tr v-for="attr in productData.attributes" :key="attr.name">
                  <td
                    class="py-3 pr-8 font-medium text-gray-800 whitespace-nowrap w-1/3"
                  >
                    {{ attr.name }}
                  </td>
                  <td class="py-3 text-gray-500">
                    {{
                      Array.isArray(attr.options)
                        ? attr.options.join(", ")
                        : attr.options
                    }}
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-else class="text-gray-500 italic">
              Đang cập nhật thông số.
            </div>
          </div>

          <div v-show="activeTab === 'information'">
            <div
              v-if="productData.description"
              class="prose max-w-none text-gray-600"
              v-html="productData.description"
            ></div>
            <div v-else class="text-gray-500 italic">
              Chưa có mô tả chi tiết.
            </div>
          </div>

          <div v-show="activeTab === 'review'">
            <div class="text-gray-500">Reviews feature coming soon.</div>
          </div>

          <div
            v-show="activeTab === 'delivery'"
            class="prose max-w-none text-gray-600"
          >
            <h2>
              <span class="text-md mb-2"
                ><span
                  ><strong>1. Quy định về chi phí giao hàng</strong></span
                ></span
              >
            </h2>
            <p>
              <span class="text-md mb-2"
                ><span
                  >Thời gian xử lý đơn hàng có thể từ 1-2 ngày làm việc. Vui
                  lòng gọi đến hotline&nbsp;0963 88 9192&nbsp; (trong giờ hành
                  chính) nếu bạn muốn thay đổi thông tin đơn hàng trước khi đơn
                  hàng của bạn được CHUYỂN QUA GIAO NHẬN.</span
                ></span
              >
            </p>
            <p>
              <span class="text-md mb-2"
                ><span
                  >Thời gian giao hàng tuỳ thuộc vào địa điểm và phương thức
                  giao hàng bạn đã chọn. Hãy tin rắng chúng tôi luôn cố gắng để
                  hàng đến tay bạn sớm nhất!</span
                ></span
              >
            </p>

            <h2>
              <span class="text-md mb-2"
                ><span><strong>2. Chính sách giao hàng</strong></span></span
              >
            </h2>
            <p>
              <span class="text-md mb-2"
                ><span
                  >Thời gian xử lý đơn hàng có thể từ 1-2 ngày làm việc. Vui
                  lòng gọi đến hotline&nbsp;0963 88 91926 (trong giờ hành chính)
                  nếu bạn muốn thay đổi thông tin đơn hàng trước khi đơn hàng
                  của bạn được CHUYỂN QUA GIAO NHẬN.</span
                ></span
              >
            </p>
            <p>
              <span class="text-md mb-2"
                ><span
                  >Thời gian giao hàng tuỳ thuộc vào địa điểm và phương thức
                  giao hàng bạn đã chọn. Hãy tin rắng chúng tôi luôn cố gắng để
                  hàng đến tay bạn sớm nhất!</span
                ></span
              >
            </p>

            <h2>
              <span class="text-md mb-2"
                ><span><strong>3. Chính sách lắp đặt</strong></span></span
              >
            </h2>
            <p>
              <span class="text-md mb-2"
                ><span>Miễn phí lắp đặt trong 100km&nbsp;</span></span
              >
            </p>
          </div>
        </div>
      </div>

      <!-- Related Products -->
      <div
        v-if="relatedProducts && relatedProducts.length > 0"
        class="mt-20 pt-12 border-t border-dark-700"
      >
        <div class="flex items-center justify-between mb-8">
          <div>
            <h2
              class="text-2xl sm:text-3xl font-display font-bold text-dark-50"
            >
              Sản Phẩm
              <span
                class="bg-gradient-to-r from-accent-400 to-primary-400 bg-clip-text text-transparent"
                >Tương Tự</span
              >
            </h2>
          </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <ProductCard
            v-for="rel in relatedProducts"
            :key="rel.id"
            :product="rel"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from "vue";
import { useCart } from "../composables/useCart.js";
import ProductCard from "./ProductCard.vue";

const { addToCart } = useCart();

// Get product data from server-rendered page
const productData = window.__PRODUCT_DATA__ || {};
const wpData = window.wpVueTheme || {};
const homeUrl = wpData.homeUrl || "/";
const shopUrl = homeUrl + "shop";
const currency = wpData.currency || "₫";

// Images
const images = computed(() => productData.images || []);
const activeImageIndex = ref(0);
const activeImage = computed(
  () => images.value[activeImageIndex.value] || null,
);
const zoomed = ref(false);

// Tabs
const activeTab = ref("information"); // 'specification', 'information', 'review'

// Stock
const isInStock = computed(() => productData.stock_status === "instock");

// Quantity
const quantity = ref(1);
const adding = ref(false);
const addedSuccess = ref(false);

// Discount
const discountPercent = computed(() => {
  if (
    !productData.on_sale ||
    !productData.regular_price ||
    !productData.sale_price
  )
    return 0;
  return Math.round(
    (1 -
      parseFloat(productData.sale_price) /
        parseFloat(productData.regular_price)) *
      100,
  );
});

// Related Products
const relatedProducts = computed(() => productData.related_products || []);

function formatDisplayPrice(price) {
  if (!price && price !== 0) return "";
  return new Intl.NumberFormat("vi-VN").format(parseFloat(price)) + currency;
}

function decreaseQty() {
  if (quantity.value > 1) quantity.value--;
}

function increaseQty() {
  quantity.value++;
}

async function handleAddToCart() {
  adding.value = true;
  const result = await addToCart(productData.id, quantity.value);
  adding.value = false;

  if (result.success) {
    addedSuccess.value = true;
    setTimeout(() => {
      addedSuccess.value = false;
    }, 2000);
  }
}
</script>

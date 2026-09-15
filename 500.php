<?php
/**
 * Template: Lỗi máy chủ (500 Internal Server Error)
 *
 * @package VueCommerce
 */

// Force 500 header if this template is loaded directly
if (!headers_sent()) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
}

get_header();
?>

<main class="min-h-[80vh] flex items-center justify-center py-20 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-to-b from-dark-900 to-dark-800"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 text-center max-w-2xl mx-auto px-4 sm:px-6">
        <!-- 500 Display -->
        <h1 class="text-[120px] sm:text-[180px] font-display font-black leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-red-400 to-red-600 opacity-90 drop-shadow-lg mb-4">
            500
        </h1>
        
        <!-- Text -->
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50 mb-4">
            Lỗi máy chủ nội bộ
        </h2>
        <p class="text-dark-300 text-lg mb-10">
            Xin lỗi, hệ thống của chúng tôi đang gặp chút sự cố kỹ thuật. Vui lòng tải lại trang hoặc quay lại sau ít phút.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button onclick="window.location.reload()" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Tải lại trang
            </button>
            
            <a href="<?php echo esc_url(home_url('/')); ?>" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-dark-800 text-dark-50 font-semibold rounded-xl border border-dark-600 hover:border-red-500/50 hover:bg-dark-700 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Về trang chủ
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>

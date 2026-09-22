<?php
/**
 * Template: Trang không tồn tại (404 Error)
 *
 * @package VueCommerce
 */

get_header();
?>

<main class="min-h-[80vh] flex items-center justify-center py-20 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-to-b from-dark-900 to-dark-800"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-primary-500/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 text-center max-w-2xl mx-auto px-4 sm:px-6">
        <!-- 404 Display -->
        <h1 class="text-[120px] sm:text-[180px] font-display font-black leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-primary-400 to-secondary-500 opacity-90 drop-shadow-lg mb-4">
            404
        </h1>
        
        <!-- Text -->
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark-50 mb-4">
            Oops! Lạc đường rồi...
        </h2>
        <p class="text-dark-300 text-lg mb-10">
            Trang bạn đang tìm kiếm không tồn tại, đã bị xóa hoặc tạm thời không thể truy cập.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/')); ?>" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl shadow-glow hover:shadow-glow-lg transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Về trang chủ
            </a>
            
            <a href="<?php echo esc_url(home_url('/shop')); ?>" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-dark-800 text-dark-50 font-semibold rounded-xl border border-dark-600 hover:border-primary-500/50 hover:bg-dark-700 transition-all duration-300">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>

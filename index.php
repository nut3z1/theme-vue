<?php
/**
 * The main template file (fallback)
 *
 * @package VueCommerce
 */

get_header();
?>

<main id="vue-main" class="min-h-screen">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
    ?>
        <article class="max-w-4xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <header class="mb-8">
                <h1 class="text-4xl font-display font-bold text-dark-50 mb-4">
                    <?php the_title(); ?>
                </h1>
                <?php if (is_singular('post')) : ?>
                <div class="flex items-center gap-4 text-dark-400 text-sm">
                    <time datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date(); ?>
                    </time>
                    <span>•</span>
                    <span><?php the_author(); ?></span>
                </div>
                <?php endif; ?>
            </header>

            <div class="prose prose-invert prose-lg max-w-none">
                <?php the_content(); ?>
            </div>
        </article>
    <?php
        endwhile;
    else :
    ?>
        <div class="flex items-center justify-center min-h-[60vh]">
            <div class="text-center">
                <h2 class="text-2xl font-display font-bold text-dark-50 mb-4">
                    Không tìm thấy nội dung
                </h2>
                <p class="text-dark-400">
                    Trang bạn tìm kiếm không tồn tại.
                </p>
                <a href="<?php echo home_url('/'); ?>" 
                   class="inline-block mt-6 px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition-colors">
                    Về trang chủ
                </a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>

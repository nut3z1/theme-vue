<?php
/**
 * Template: Bài viết chi tiết (Single Post)
 *
 * @package VueCommerce
 */

get_header();
?>
<style>
    /* Anti-FOUC: Ẩn nội dung cho đến khi Tailwind CSS load xong */
    #single-content {
        visibility: hidden;
        opacity: 0;
    }
    #single-content.css-loaded {
        visibility: visible;
        opacity: 1;
        transition: opacity 0.2s ease-in;
    }
</style>
<script>
    (function() {
        // Kiểm tra khi DOM sẵn sàng thì reveal nội dung
        function revealContent() {
            var el = document.getElementById('single-content');
            if (el) {
                el.classList.add('css-loaded');
            }
        }

        // Chờ stylesheet vuecommerce-app (Tailwind) load xong
        var found = false;
        var links = document.querySelectorAll('link[rel="stylesheet"]');
        links.forEach(function(link) {
            if (link.href && link.href.indexOf('main.css') !== -1) {
                found = true;
                if (link.sheet) {
                    // CSS đã load sẵn
                    revealContent();
                } else {
                    link.addEventListener('load', revealContent);
                    link.addEventListener('error', revealContent); // fallback
                }
            }
        });

        // Fallback: nếu không tìm thấy stylesheet, reveal sau 300ms
        if (!found) {
            setTimeout(revealContent, 300);
        }

        // Failsafe: luôn reveal sau 1s để tránh trang bị ẩn hoàn toàn
        setTimeout(revealContent, 1000);
    })();
</script>

<div id="single-content">
<main id="vue-main" class="min-h-screen py-10">
    <?php while (have_posts()) : the_post(); ?>

    <div class="w-full px-4 mx-auto max-w-7xl sm:px-6 xl:px-0">
        <div class="flex flex-col gap-5 lg:gap-8 lg:flex-row">
            
            <!-- Main Content Area -->
            <div class="w-full lg:w-2/3">
                <!-- Thumbnail -->
                <?php if (has_post_thumbnail()) : ?>
                <div class="rounded-[10px] overflow-hidden mb-7.5">
                    <img alt="<?php the_title_attribute(); ?>" 
                         class="rounded-[10px] h-[477px] w-full object-cover" 
                         src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>">
                </div>
                <?php endif; ?>
                
                <div>
                    <!-- Meta -->
                    <span class="flex items-center gap-3 mb-4 text-sm text-gray-500">
                        <a class="duration-200 ease-out hover:text-blue-600" href="#">
                            <?php echo get_the_date(); ?>
                        </a>
                        <span class="block w-px h-4 bg-gray-400"></span>
                        <a class="duration-200 ease-out hover:text-blue-600" href="#">
                            <?php echo get_the_author(); ?>
                        </a>
                    </span>
                    
                    <!-- Title -->
                    <h1 class="mb-4 text-2xl font-medium text-gray-900 lg:text-3xl xl:text-4xl">
                        <?php the_title(); ?>
                    </h1>
                    
                    <!-- Content -->
                    <div class="blog-details prose prose-lg max-w-none prose-img:rounded-[10px]">
                        <?php the_content(); ?>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-between gap-10 mt-10 border-t border-gray-200 pt-8">
                        <!-- Post Tags -->
                        <div class="flex flex-wrap items-center gap-5">
                            <p class="font-medium text-gray-800">Tags :</p>
                            <ul class="flex flex-wrap items-center gap-3.5">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                    foreach ($tags as $tag) :
                                ?>
                                <li>
                                    <a class="inline-flex px-4 py-2 capitalize duration-200 ease-out bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-600 hover:border-blue-600 text-sm text-gray-600" 
                                       href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                </li>
                                <?php 
                                    endforeach;
                                endif; 
                                ?>
                            </ul>
                        </div>
                        
                        <!-- Share -->
                        <div class="flex gap-3">
                            <button aria-label="facebook" style="background-color: transparent; border: none; padding: 0px; cursor: pointer; outline: none;">
                                <svg viewBox="0 0 64 64" width="35" height="35"><circle cx="32" cy="32" r="31" fill="#3b5998"></circle><path d="M34.1,47V33.3h4.6l0.7-5.3h-5.3v-3.4c0-1.5,0.4-2.6,2.6-2.6l2.8,0v-4.8c-0.5-0.1-2.2-0.2-4.1-0.2 c-4.1,0-6.9,2.5-6.9,7V28H24v5.3h4.6V47H34.1z" fill="white"></path></svg>
                            </button>
                            <button aria-label="twitter" style="background-color: transparent; border: none; padding: 0px; cursor: pointer; outline: none;">
                                <svg viewBox="0 0 64 64" width="35" height="35"><circle cx="32" cy="32" r="31" fill="#000000"></circle><path d="M 41.116 18.375 h 4.962 l -10.8405 12.39 l 12.753 16.86 H 38.005 l -7.821 -10.2255 L 21.235 47.625 H 16.27 l 11.595 -13.2525 L 15.631 18.375 H 25.87 l 7.0695 9.3465 z m -1.7415 26.28 h 2.7495 L 24.376 21.189 H 21.4255 z" fill="white"></path></svg>
                            </button>
                            <button aria-label="linkedin" style="background-color: transparent; border: none; padding: 0px; cursor: pointer; outline: none;">
                                <svg viewBox="0 0 64 64" width="35" height="35"><circle cx="32" cy="32" r="31" fill="#007fb1"></circle><path d="M20.4,44h5.4V26.6h-5.4V44z M23.1,18c-1.7,0-3.1,1.4-3.1,3.1c0,1.7,1.4,3.1,3.1,3.1 c1.7,0,3.1-1.4,3.1-3.1C26.2,19.4,24.8,18,23.1,18z M39.5,26.2c-2.6,0-4.4,1.4-5.1,2.8h-0.1v-2.4h-5.2V44h5.4v-8.6 c0-2.3,0.4-4.5,3.2-4.5c2.8,0,2.8,2.6,2.8,4.6V44H46v-9.5C46,29.8,45,26.2,39.5,26.2z" fill="white"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Area -->
            <div class="w-full lg:w-1/3 space-y-7.5">
                
                <!-- Search Widget -->
                <div class="shadow-sm bg-white rounded-xl border border-gray-100">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium text-lg text-gray-900">Tìm kiếm</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div id="vue-instant-search"></div>
                    </div>
                </div>
                
                <!-- Recent Posts Widget -->
                <div class="shadow-sm bg-white rounded-xl border border-gray-100 mt-8">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium text-lg text-gray-900">Bài viết mới</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col gap-6">
                            <?php
                            $recent_posts = new WP_Query(array(
                                'posts_per_page' => 3,
                                'post_status' => 'publish',
                                'post__not_in' => array(get_the_ID())
                            ));
                            if ($recent_posts->have_posts()) :
                                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                            ?>
                            <div class="flex items-center gap-4">
                                <a class="max-w-[110px] w-full rounded-[10px] overflow-hidden shrink-0" href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img alt="<?php the_title_attribute(); ?>" class="rounded-[10px] w-full h-20 object-cover" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>">
                                    <?php else: ?>
                                        <div class="w-full h-20 bg-gray-200 rounded-[10px]"></div>
                                    <?php endif; ?>
                                </a>
                                <div>
                                    <a href="<?php the_permalink(); ?>">
                                        <h3 class="text-gray-900 text-sm font-medium leading-[22px] ease-out duration-200 mb-1.5 hover:text-blue-600 line-clamp-2">
                                            <?php the_title(); ?>
                                        </h3>
                                    </a>
                                    <div class="flex items-center gap-3">
                                        <div class="text-xs text-gray-500 ease-out duration-200"><?php echo get_the_date(); ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Latest Products Widget -->
                <div class="shadow-sm bg-white rounded-xl border border-gray-100 mt-8">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium text-lg text-gray-900">Sản phẩm nổi bật</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col gap-6">
                            <?php
                            $recent_products = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => 3,
                                'post_status' => 'publish'
                            ));
                            if ($recent_products->have_posts()) :
                                while ($recent_products->have_posts()) : $recent_products->the_post();
                                $product = wc_get_product(get_the_ID());
                            ?>
                            <div class="flex items-center gap-4">
                                <a class="flex items-center justify-center rounded-[10px] bg-gray-100 max-w-[90px] w-full h-20 shrink-0 overflow-hidden" href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gray-200"></div>
                                    <?php endif; ?>
                                </a>
                                <div>
                                    <h3 class="font-medium text-sm text-gray-900 mb-1 ease-out duration-200 hover:text-blue-600 line-clamp-2">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <p class="text-sm font-bold text-gray-800"><?php echo wp_strip_all_tags($product->get_price_html()); ?></p>
                                </div>
                            </div>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Popular Categories Widget -->
                <div class="shadow-sm bg-white rounded-xl border border-gray-100 mt-8">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium text-lg text-gray-900">Danh mục</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col gap-3">
                            <?php
                            $categories = get_categories(array('orderby' => 'count', 'order' => 'DESC', 'number' => 5));
                            if ($categories):
                                foreach ($categories as $category) :
                            ?>
                            <a class="group flex items-center justify-between ease-out duration-200 text-gray-700 hover:text-blue-600 capitalize text-sm" href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?>
                                <span class="inline-flex rounded-full bg-gray-100 text-xs w-7 h-7 justify-center items-center ease-out duration-200 group-hover:text-white group-hover:bg-blue-600">
                                    <?php echo sprintf('%02d', $category->count); ?>
                                </span>
                            </a>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Tags Widget -->
                <div class="shadow-sm bg-white rounded-xl border border-gray-100 mt-8">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                        <h2 class="font-medium text-lg text-gray-900">Tags phổ biến</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-wrap gap-3.5">
                            <?php
                            $all_tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 15));
                            if ($all_tags) :
                                foreach ($all_tags as $tag) :
                            ?>
                            <a class="inline-flex hover:text-white border border-gray-300 py-1.5 h-auto text-xs items-center justify-center px-4 rounded-full ease-out duration-200 hover:bg-blue-600 hover:border-blue-600 capitalize text-gray-600" href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <?php endwhile; ?>
</main>
</div><!-- /#single-content -->

<?php get_footer(); ?>

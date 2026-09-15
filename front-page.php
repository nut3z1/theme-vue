<?php
/**
 * Template: Trang chủ (Front Page)
 *
 * @package VueCommerce
 */

get_header();
?>

<main id="vue-main">
    <!-- Hero Section (1 banner to + 2 banner nhỏ) -->
    <div id="vue-hero"></div>

    <!-- Danh sách sản phẩm mới -->
    <div id="vue-new-products"></div>

    <!-- 4 Sản phẩm theo danh mục -->
    <div id="vue-category-products"></div>

    <!-- 5 Sản phẩm hiển thị swiperjs -->
    <div id="vue-product-swiper"></div>

    <!-- 5 Bài viết mới nhất -->
    <div id="vue-latest-posts"></div>

    <!-- Newsletter Signup -->
    <div id="vue-newsletter"></div>
</main>

<?php get_footer(); ?>

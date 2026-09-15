<?php
/**
 * WooCommerce Template: Danh sách sản phẩm (Shop Page)
 *
 * Override: woocommerce/archive-product.php
 *
 * @package VueCommerce
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="vue-main">
    <!-- Product Grid + Filters (Vue handles rendering) -->
    <div id="vue-product-grid" class="min-h-screen"></div>
</main>

<?php get_footer(); ?>

<?php
/**
 * WooCommerce Template: Chi tiết sản phẩm (Single Product)
 *
 * Override: woocommerce/single-product.php
 *
 * @package VueCommerce
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get current product data for Vue
global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
    $product = wc_get_product( get_the_ID() );
}

$product_data = array();

if ( $product ) {
    $product_data = array(
        'id'               => $product->get_id(),
        'name'             => $product->get_name(),
        'slug'             => $product->get_slug(),
        'price'            => $product->get_price(),
        'regular_price'    => $product->get_regular_price(),
        'sale_price'       => $product->get_sale_price(),
        'price_html'       => $product->get_price_html(),
        'description'      => $product->get_description(),
        'short_description'=> $product->get_short_description(),
        'sku'              => $product->get_sku(),
        'stock_status'     => $product->get_stock_status(),
        'stock_quantity'   => $product->get_stock_quantity(),
        'categories'       => wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'names')),
        'tags'             => wp_get_post_terms($product->get_id(), 'product_tag', array('fields' => 'names')),
        'on_sale'          => $product->is_on_sale(),
        'featured'         => $product->is_featured(),
        'average_rating'   => $product->get_average_rating(),
        'review_count'     => $product->get_review_count(),
    );

    // Get product images
    $image_id = $product->get_image_id();
    $gallery_ids = $product->get_gallery_image_ids();
    $images = array();

    if ($image_id) {
        $images[] = array(
            'id'        => $image_id,
            'src'       => wp_get_attachment_image_url($image_id, 'full'),
            'thumbnail' => wp_get_attachment_image_url($image_id, 'product-thumb'),
            'alt'       => get_post_meta($image_id, '_wp_attachment_image_alt', true),
        );
    }

    foreach ($gallery_ids as $gid) {
        $images[] = array(
            'id'        => $gid,
            'src'       => wp_get_attachment_image_url($gid, 'full'),
            'thumbnail' => wp_get_attachment_image_url($gid, 'product-thumb'),
            'alt'       => get_post_meta($gid, '_wp_attachment_image_alt', true),
        );
    }

    $product_data['images'] = $images;

    // Get product attributes
    $attributes = $product->get_attributes();
    $attr_data = array();
    foreach ($attributes as $attr) {
        $attr_data[] = array(
            'name'    => wc_attribute_label($attr->get_name()),
            'options' => $attr->get_options(),
        );
    }
    $product_data['attributes'] = $attr_data;

    // Get related products
    $related_product_ids = wc_get_related_products($product->get_id(), 4);
    $related_products = array();
    foreach ($related_product_ids as $rel_id) {
        $rel_product = wc_get_product($rel_id);
        if ($rel_product) {
            $rel_image_id = $rel_product->get_image_id();
            $rel_categories = wp_get_post_terms($rel_product->get_id(), 'product_cat', array('fields' => 'all'));
            $rel_cats_formatted = array();
            foreach ($rel_categories as $cat) {
                $rel_cats_formatted[] = array('id' => $cat->term_id, 'name' => $cat->name, 'slug' => $cat->slug);
            }

            $related_products[] = array(
                'id' => $rel_product->get_id(),
                'name' => $rel_product->get_name(),
                'permalink' => $rel_product->get_permalink(),
                'price' => $rel_product->get_price(),
                'regularPrice' => $rel_product->get_regular_price(),
                'salePrice' => $rel_product->get_sale_price(),
                'onSale' => $rel_product->is_on_sale(),
                'averageRating' => $rel_product->get_average_rating(),
                'reviewCount' => $rel_product->get_review_count(),
                'images' => $rel_image_id ? array(array('src' => wp_get_attachment_image_url($rel_image_id, 'product-large'))) : array(),
                'categories' => $rel_cats_formatted
            );
        }
    }
    $product_data['related_products'] = $related_products;
}
?>

<main id="vue-main">
    <!-- Product Detail (Vue handles rendering) -->
    <div id="vue-product-detail" 
         class="min-h-screen"
         data-product='<?php echo esc_attr(wp_json_encode($product_data)); ?>'>
    </div>
</main>

<script>
    // Make product data available globally for Vue
    window.__PRODUCT_DATA__ = <?php echo wp_json_encode($product_data); ?>;
</script>

<?php get_footer(); ?>

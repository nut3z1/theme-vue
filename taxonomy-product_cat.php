<?php
/**
 * Template: Trang danh mục sản phẩm WooCommerce
 * Kích hoạt khi truy cập /danh-muc-san-pham/{slug}/
 *
 * @package VueCommerce
 */

get_header();

// Lấy thông tin danh mục hiện tại
$queried_object = get_queried_object();
$cat_slug  = isset($queried_object->slug)  ? $queried_object->slug  : '';
$cat_name  = isset($queried_object->name)  ? $queried_object->name  : 'Danh mục';
$cat_id    = isset($queried_object->term_id) ? $queried_object->term_id : 0;
$cat_desc  = isset($queried_object->description) ? $queried_object->description : '';
$cat_count = isset($queried_object->count) ? $queried_object->count : 0;

// Lấy thumbnail của danh mục (nếu có)
$thumbnail_id  = get_term_meta($cat_id, 'thumbnail_id', true);
$cat_thumbnail = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
?>

<main id="vue-main" class="min-h-screen">
    <!-- Mount point cho Vue ProductGrid với danh mục được pre-select -->
    <div id="vue-product-grid"
         data-category-id="<?php echo esc_attr($cat_id); ?>"
         data-category-slug="<?php echo esc_attr($cat_slug); ?>"
         data-category-name="<?php echo esc_attr($cat_name); ?>"
         data-category-count="<?php echo esc_attr($cat_count); ?>">
    </div>
</main>

<?php
// Truyền thêm thông tin danh mục vào wpVueTheme qua inline script
?>
<script>
if (typeof window.wpVueTheme !== 'undefined') {
    window.wpVueTheme.isProductCategory = true;
    window.wpVueTheme.currentCategory = {
        id: <?php echo (int)$cat_id; ?>,
        slug: '<?php echo esc_js($cat_slug); ?>',
        name: '<?php echo esc_js($cat_name); ?>',
        description: '<?php echo esc_js($cat_desc); ?>',
        count: <?php echo (int)$cat_count; ?>,
        thumbnail: '<?php echo esc_js($cat_thumbnail); ?>'
    };
}
</script>

<?php get_footer(); ?>

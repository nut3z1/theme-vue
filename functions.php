<?php
/**
 * VueCommerce Theme Functions
 *
 * @package VueCommerce
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('VUECOMMERCE_VERSION', '1.0.0');
define('VUECOMMERCE_DIR', get_template_directory());
define('VUECOMMERCE_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function vuecommerce_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    add_image_size('product-thumb', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('post-thumb', 600, 400, true);
    add_image_size('hero-banner', 1920, 800, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => __('Menu Chính', 'vuecommerce'),
        'footer'    => __('Menu Footer', 'vuecommerce'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Responsive embeds
    add_theme_support('responsive-embeds');

    // Wide alignment
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'vuecommerce_setup');

/**
 * Enqueue Scripts and Styles
 */
function vuecommerce_scripts() {
    // Google Fonts - Inter & Outfit
    wp_enqueue_style(
        'vuecommerce-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Main theme stylesheet (WordPress metadata only)
    wp_enqueue_style('vuecommerce-style', get_stylesheet_uri(), array(), VUECOMMERCE_VERSION);

    // Define VUECOMMERCE_DEV in wp-config.php to enable Vite Dev Server HMR directly in WordPress
    $is_dev = defined('VUECOMMERCE_DEV') && VUECOMMERCE_DEV;

    if ($is_dev) {
        // Load Vite Dev Server Client
        wp_enqueue_script('vite-client', 'http://localhost:3000/@vite/client', array(), null, false);
        // Load Vue Entry from Vite Dev Server
        wp_enqueue_script('vuecommerce-app', 'http://localhost:3000/src/main.js', array(), null, true);
    } else {
        // Vite compiled CSS
        $css_file = VUECOMMERCE_DIR . '/assets/css/main.css';
        if (file_exists($css_file)) {
            wp_enqueue_style(
                'vuecommerce-app',
                VUECOMMERCE_URI . '/assets/css/main.css',
                array('vuecommerce-google-fonts'),
                VUECOMMERCE_VERSION
            );
        }

        // Vite compiled JS
        $js_file = VUECOMMERCE_DIR . '/assets/js/main.js';
        if (file_exists($js_file)) {
            wp_enqueue_script(
                'vuecommerce-app',
                VUECOMMERCE_URI . '/assets/js/main.js',
                array(),
                VUECOMMERCE_VERSION,
                true
            );
        }
    }

    // Pass WordPress data to Vue (runs for both Dev and Prod)
    wp_localize_script('vuecommerce-app', 'wpVueTheme', array(
        'restUrl'      => esc_url_raw(rest_url()),
        'nonce'        => wp_create_nonce('wp_rest'),
        'themeUrl'     => VUECOMMERCE_URI,
        'homeUrl'      => home_url('/'),
        'siteTitle'    => get_bloginfo('name'),
        'siteDesc'     => get_bloginfo('description'),
        'isHome'       => is_front_page(),
        'isShop'       => function_exists('is_shop') ? is_shop() : false,
        'isProduct'    => function_exists('is_product') ? is_product() : false,
        'isBlog'       => is_home() || is_archive(),
        'isContact'    => is_page('contact') || is_page('lien-he'),
        'isSingle'     => is_singular('post'),
        'currentPage'  => get_query_var('paged') ? get_query_var('paged') : 1,
        'postId'       => get_the_ID(),
        'wcActive'     => class_exists('WooCommerce'),
        'cartUrl'      => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '',
        'checkoutUrl'  => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '',
        'currency'     => function_exists('get_woocommerce_currency_symbol') ? get_woocommerce_currency_symbol() : '₫',
        'primaryMenu'  => vuecommerce_get_menu_items('primary'),
    ));
}
add_action('wp_enqueue_scripts', 'vuecommerce_scripts');

/**
 * Get menu items as array for Vue
 */
function vuecommerce_get_menu_items($location) {
    $locations = get_nav_menu_locations();
    if (!isset($locations[$location])) {
        // Default menu items if no menu is set
        return array(
            array('title' => 'Trang chủ', 'url' => home_url('/'), 'slug' => 'home'),
            array('title' => 'Sản phẩm', 'url' => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop'), 'slug' => 'shop'),
            array('title' => 'Bài viết', 'url' => get_permalink(get_option('page_for_posts')), 'slug' => 'blog'),
            array('title' => 'Liên hệ', 'url' => home_url('/lien-he'), 'slug' => 'contact'),
        );
    }

    $menu = wp_get_nav_menu_object($locations[$location]);
    $items = wp_get_nav_menu_items($menu->term_id);
    $menu_array = array();

    if ($items) {
        foreach ($items as $item) {
            $menu_array[] = array(
                'title'  => $item->title,
                'url'    => $item->url,
                'slug'   => sanitize_title($item->title),
                'target' => $item->target,
                'classes' => implode(' ', $item->classes),
            );
        }
    }

    return $menu_array;
}

/**
 * Register REST API endpoint for Contact Form
 */
function vuecommerce_register_contact_endpoint() {
    register_rest_route('vuecommerce/v1', '/contact', array(
        'methods'             => 'POST',
        'callback'            => 'vuecommerce_handle_contact',
        'permission_callback' => '__return_true',
        'args'                => array(
            'name'    => array('required' => true, 'sanitize_callback' => 'sanitize_text_field'),
            'email'   => array('required' => true, 'sanitize_callback' => 'sanitize_email'),
            'phone'   => array('required' => false, 'sanitize_callback' => 'sanitize_text_field'),
            'subject' => array('required' => false, 'sanitize_callback' => 'sanitize_text_field'),
            'message' => array('required' => true, 'sanitize_callback' => 'sanitize_textarea_field'),
        ),
    ));
}
add_action('rest_api_init', 'vuecommerce_register_contact_endpoint');

/**
 * Handle Contact Form Submission
 */
function vuecommerce_handle_contact($request) {
    $name    = $request->get_param('name');
    $email   = $request->get_param('email');
    $phone   = $request->get_param('phone');
    $subject = $request->get_param('subject') ?: 'Liên hệ từ website';
    $message = $request->get_param('message');

    // Validate email
    if (!is_email($email)) {
        return new WP_Error('invalid_email', 'Email không hợp lệ', array('status' => 400));
    }

    // Send email to admin
    $to = get_option('admin_email');
    $email_subject = '[VueCommerce] ' . $subject;
    $email_body = sprintf(
        "Tên: %s\nEmail: %s\nSố điện thoại: %s\n\nNội dung:\n%s",
        $name, $email, $phone ?: 'Không có', $message
    );
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    $sent = wp_mail($to, $email_subject, $email_body, $headers);

    if ($sent) {
        return array(
            'success' => true,
            'message' => 'Cảm ơn bạn! Tin nhắn đã được gửi thành công.',
        );
    }

    return new WP_Error('send_failed', 'Gửi tin nhắn thất bại. Vui lòng thử lại.', array('status' => 500));
}

/**
 * Add Module type to script tag for Vite
 */
function vuecommerce_script_module_type($tag, $handle, $src) {
    if ($handle === 'vuecommerce-app') {
        $tag = '<script type="module" src="' . esc_url($src) . '" id="vuecommerce-app-js"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'vuecommerce_script_module_type', 10, 3);

/**
 * Add custom body classes
 */
function vuecommerce_body_classes($classes) {
    $classes[] = 'dark';
    $classes[] = 'bg-dark-900';
    $classes[] = 'text-dark-50';
    $classes[] = 'antialiased';

    if (is_front_page()) {
        $classes[] = 'is-home';
    }
    if (function_exists('is_shop') && is_shop()) {
        $classes[] = 'is-shop';
    }
    if (function_exists('is_product') && is_product()) {
        $classes[] = 'is-product';
    }

    return $classes;
}
add_filter('body_class', 'vuecommerce_body_classes');

/**
 * Register widget areas
 */
function vuecommerce_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'vuecommerce'),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'vuecommerce'),
        'id'            => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'vuecommerce_widgets_init');

/**
 * Disable WooCommerce default styles (we use Tailwind)
 */
function vuecommerce_dequeue_wc_styles($enqueue_styles) {
    unset($enqueue_styles['woocommerce-general']);
    unset($enqueue_styles['woocommerce-layout']);
    unset($enqueue_styles['woocommerce-smallscreen']);
    return $enqueue_styles;
}
add_filter('woocommerce_enqueue_styles', 'vuecommerce_dequeue_wc_styles');

/**
 * Disable WooCommerce default scripts on product pages (Vue handles it)
 */
function vuecommerce_dequeue_wc_scripts() {
    if (function_exists('is_product') && (is_shop() || is_product())) {
        wp_dequeue_script('wc-add-to-cart');
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'vuecommerce_dequeue_wc_scripts', 20);

/**
 * Extend REST API - Add featured image URL to posts
 */
function vuecommerce_rest_featured_image($data, $post, $context) {
    $featured_img_url = get_the_post_thumbnail_url($post->ID, 'post-thumb');
    $data->data['featured_image_url'] = $featured_img_url ?: '';
    return $data;
}
add_filter('rest_prepare_post', 'vuecommerce_rest_featured_image', 10, 3);

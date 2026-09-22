<!DOCTYPE html>
<html <?php language_attributes(); ?> class="dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="vue-app" class="min-h-screen bg-dark-900 text-dark-50">
    <!-- Vue AppHeader mounts here -->
    <?php if ( ! ( is_account_page() && ! is_user_logged_in() ) ) : ?>
        <div id="vue-header"></div>
    <?php endif; ?>

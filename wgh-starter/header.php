<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Header Start -->
<header id="header">
    <div class="container">

        <div class="logo-block">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png"
                     alt="<?php bloginfo( 'name' ); ?>">
            </a>
        </div>

        <nav id="navigation">
            <?php
            wp_nav_menu( [
                'theme_location' => 'main-menu',
                'menu_class'     => 'sf-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ] );
            ?>
        </nav>

        <div class="clearfix"></div>
    </div>
</header>
<!-- Header End -->

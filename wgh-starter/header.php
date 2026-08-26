<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wgh-starter' ); ?></a>

<!-- Header Start -->
<header id="header">
    <div class="container">

        <div class="logo-block">
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                printf(
                    '<a href="%1$s" class="site-title">%2$s</a>',
                    esc_url( home_url( '/' ) ),
                    esc_html( get_bloginfo( 'name' ) )
                );
            }
            ?>
        </div>

        <button class="menu-toggle" aria-controls="navigation" aria-expanded="false">
            <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'wgh-starter' ); ?></span>
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <nav id="navigation" aria-label="<?php esc_attr_e( 'Primary', 'wgh-starter' ); ?>">
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

<main id="content">

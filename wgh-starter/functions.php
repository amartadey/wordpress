<?php
/**
 * WGH Starter — functions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// ── THEME SETUP ───────────────────────────────────────────────────────────────

function wgh_setup() {
	load_theme_textdomain( 'wgh-starter', get_template_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );

	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	register_nav_menus( [
		'main-menu' => __( 'Header Menu', 'wgh-starter' ),
		'footer'    => __( 'Footer Menu', 'wgh-starter' ),
	] );
}
add_action( 'after_setup_theme', 'wgh_setup' );


// ── NAV ACTIVE CLASS ──────────────────────────────────────────────────────────

function wgh_nav_active_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes, true ) ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'wgh_nav_active_class', 10, 2 );


// ── ENQUEUE ASSETS ────────────────────────────────────────────────────────────

function wgh_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	$ver = function ( $path ) use ( $dir ) {
		$f = $dir . $path;
		return file_exists( $f ) ? filemtime( $f ) : null;
	};

	wp_enqueue_style( 'wgh-bootstrap',        $uri . '/assets/css/bootstrap.min.css',                 [], $ver( '/assets/css/bootstrap.min.css' ) );
	wp_enqueue_style( 'wgh-fontawesome',      $uri . '/assets/font-awesome/css/font-awesome.min.css', [], $ver( '/assets/font-awesome/css/font-awesome.min.css' ) );
	wp_enqueue_style( 'wgh-superfish',        $uri . '/assets/css/superfish.css',                     [], $ver( '/assets/css/superfish.css' ) );
	wp_enqueue_style( 'wgh-owl-carousel',     $uri . '/assets/css/owl.carousel.css',                  [], $ver( '/assets/css/owl.carousel.css' ) );
	wp_enqueue_style( 'wgh-responsive-slides', $uri . '/assets/css/responsiveslides.css',             [], $ver( '/assets/css/responsiveslides.css' ) );

	// Theme stylesheet (style.css at the theme root) — load last so it can override.
	wp_enqueue_style( 'wgh-style', get_stylesheet_uri(), [ 'wgh-bootstrap' ], $ver( '/style.css' ) );

	$js_deps = [ 'jquery' ];

	wp_enqueue_script( 'wgh-bootstrap-js',        $uri . '/assets/js/bootstrap.min.js',        $js_deps, $ver( '/assets/js/bootstrap.min.js' ),        true );
	wp_enqueue_script( 'wgh-superfish-js',        $uri . '/assets/js/superfish.js',            $js_deps, $ver( '/assets/js/superfish.js' ),            true );
	wp_enqueue_script( 'wgh-owl-carousel-js',     $uri . '/assets/js/owl.carousel.min.js',     $js_deps, $ver( '/assets/js/owl.carousel.min.js' ),     true );
	wp_enqueue_script( 'wgh-responsive-slides-js', $uri . '/assets/js/responsiveslides.min.js', $js_deps, $ver( '/assets/js/responsiveslides.min.js' ), true );

	wp_enqueue_script(
		'wgh-main',
		$uri . '/assets/js/main.js',
		[ 'jquery', 'wgh-superfish-js', 'wgh-owl-carousel-js', 'wgh-responsive-slides-js' ],
		$ver( '/assets/js/main.js' ),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wgh_enqueue_assets' );


// ── ADMIN LOGIN SCREEN ────────────────────────────────────────────────────────

function wgh_login_logo() {
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( ! $logo_id ) {
		return;
	}
	$src = wp_get_attachment_image_url( $logo_id, 'full' );
	if ( ! $src ) {
		return;
	}
	printf(
		'<style>.login h1 a{background-image:url(%s);background-size:contain;background-repeat:no-repeat;width:100%%;height:80px}</style>',
		esc_url( $src )
	);
}
add_action( 'login_enqueue_scripts', 'wgh_login_logo' );

add_filter( 'login_headerurl', function () {
	return home_url( '/' );
} );
add_filter( 'login_headertext', function () {
	return get_bloginfo( 'name' );
} );


// ── CUSTOMIZER — FOOTER LOGO ──────────────────────────────────────────────────
// Header logo uses the native custom-logo (Customize → Site Identity).

function wgh_customize_register( $wp_customize ) {
	$wp_customize->add_setting( 'wgh_footer_logo', [
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'wgh_footer_logo',
		[
			'label'       => __( 'Footer Logo', 'wgh-starter' ),
			'description' => __( 'Optional. Falls back to the site logo when empty.', 'wgh-starter' ),
			'section'     => 'title_tagline',
			'settings'    => 'wgh_footer_logo',
			'priority'    => 9,
		]
	) );
}
add_action( 'customize_register', 'wgh_customize_register' );


/**
 * Footer logo URL, with fallback to the header custom-logo.
 */
function wgh_footer_logo_url() {
	$url = get_theme_mod( 'wgh_footer_logo' );
	if ( $url ) {
		return $url;
	}
	$logo_id = get_theme_mod( 'custom_logo' );
	return $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : '';
}


// ── HEAD CLEANUP ──────────────────────────────────────────────────────────────

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

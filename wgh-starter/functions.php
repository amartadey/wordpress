<?php
/**
 * WGH Starter — functions.php
 */


// ── THEME SETUP ───────────────────────────────────────────────────────────────

function wgh_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
	add_theme_support( 'custom-logo' );

	register_nav_menus( [
		'main-menu'    => __( 'Header Menu',       'wgh-starter' ),
		'footer'       => __( 'Footer Menu',       'wgh-starter' ),
		'footer-other' => __( 'Footer Other Menu', 'wgh-starter' ),
	] );
}
add_action( 'after_setup_theme', 'wgh_setup' );


// ── NAV ACTIVE CLASS ──────────────────────────────────────────────────────────

function wgh_nav_active_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'wgh_nav_active_class', 10, 2 );


// ── ENQUEUE ASSETS ────────────────────────────────────────────────────────────

function wgh_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	$ver = function( $path ) use ( $dir ) {
		$f = $dir . $path;
		return file_exists( $f ) ? filemtime( $f ) : null;
	};

	wp_enqueue_style( 'wgh-bootstrap',        $uri . '/css/bootstrap.min.css',                 [], $ver( '/css/bootstrap.min.css' ) );
	wp_enqueue_style( 'wgh-fontawesome',       $uri . '/font-awesome/css/font-awesome.min.css', [], $ver( '/font-awesome/css/font-awesome.min.css' ) );
	wp_enqueue_style( 'wgh-superfish',         $uri . '/css/superfish.css',                     [], $ver( '/css/superfish.css' ) );
	wp_enqueue_style( 'wgh-owl-carousel',      $uri . '/css/owl.carousel.css',                  [], $ver( '/css/owl.carousel.css' ) );
	wp_enqueue_style( 'wgh-responsive-slides', $uri . '/css/responsiveslides.css',               [], $ver( '/css/responsiveslides.css' ) );
	wp_enqueue_style( 'wgh-style',             $uri . '/css/style.css',                          [], $ver( '/css/style.css' ) );

	wp_enqueue_script( 'wgh-bootstrap-js',        $uri . '/js/bootstrap.min.js',        [ 'jquery' ], $ver( '/js/bootstrap.min.js' ),        true );
	wp_enqueue_script( 'wgh-superfish-js',         $uri . '/js/superfish.js',            [ 'jquery' ], $ver( '/js/superfish.js' ),            true );
	wp_enqueue_script( 'wgh-owl-carousel-js',      $uri . '/js/owl.carousel.min.js',     [ 'jquery' ], $ver( '/js/owl.carousel.min.js' ),     true );
	wp_enqueue_script( 'wgh-responsive-slides-js', $uri . '/js/responsiveslides.min.js', [ 'jquery' ], $ver( '/js/responsiveslides.min.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'wgh_enqueue_assets' );


// ── ADMIN LOGIN LOGO ──────────────────────────────────────────────────────────

function wgh_login_logo() {
	$logo = get_template_directory_uri() . '/images/logo.png';
	echo '<style>
		.login h1 a {
			background-image: url(' . esc_url( $logo ) . ');
			background-size: contain;
			background-repeat: no-repeat;
			width: 320px;
			height: 80px;
		}
	</style>';
}
add_action( 'login_enqueue_scripts', 'wgh_login_logo' );


// ── CUSTOMIZER — LOGOS ────────────────────────────────────────────────────────

function wgh_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'wgh_logo_section', [
		'title'    => __( 'Theme Logos', 'wgh-starter' ),
		'priority' => 30,
	] );

	for ( $i = 1; $i <= 2; $i++ ) {
		$wp_customize->add_setting( "wgh_logo_$i" );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			"wgh_logo_{$i}_control",
			[
				'label'    => __( "Logo $i", 'wgh-starter' ),
				'section'  => 'wgh_logo_section',
				'settings' => "wgh_logo_$i",
			]
		) );
	}
}
add_action( 'customize_register', 'wgh_customize_register' );

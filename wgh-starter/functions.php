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
		'main-menu'    => __( 'Header Menu',      'wgh-starter' ),
		'footer'       => __( 'Footer Menu',      'wgh-starter' ),
		'footer-other' => __( 'Footer Other Menu','wgh-starter' ),
	] );
}
add_action( 'after_setup_theme', 'wgh_setup' );


// ── SIDEBAR ───────────────────────────────────────────────────────────────────

function wgh_widgets_init() {
	register_sidebar( [
		'name'          => __( 'Primary Sidebar', 'wgh-starter' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
}
add_action( 'widgets_init', 'wgh_widgets_init' );


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

	// CSS
	wp_enqueue_style( 'wgh-bootstrap',          $uri . '/css/bootstrap.min.css',                    [], $ver( '/css/bootstrap.min.css' ) );
	wp_enqueue_style( 'wgh-fontawesome',         $uri . '/font-awesome/css/font-awesome.min.css',    [], $ver( '/font-awesome/css/font-awesome.min.css' ) );
	wp_enqueue_style( 'wgh-superfish',           $uri . '/css/superfish.css',                        [], $ver( '/css/superfish.css' ) );
	wp_enqueue_style( 'wgh-owl-carousel',        $uri . '/css/owl.carousel.css',                     [], $ver( '/css/owl.carousel.css' ) );
	wp_enqueue_style( 'wgh-responsive-slides',   $uri . '/css/responsiveslides.css',                 [], $ver( '/css/responsiveslides.css' ) );
	wp_enqueue_style( 'wgh-style',               $uri . '/css/style.css',                            [], $ver( '/css/style.css' ) );

	// JS
	wp_enqueue_script( 'wgh-bootstrap-js',           $uri . '/js/bootstrap.min.js',        [ 'jquery' ], $ver( '/js/bootstrap.min.js' ),        true );
	wp_enqueue_script( 'wgh-superfish-js',            $uri . '/js/superfish.js',            [ 'jquery' ], $ver( '/js/superfish.js' ),            true );
	wp_enqueue_script( 'wgh-owl-carousel-js',         $uri . '/js/owl.carousel.min.js',     [ 'jquery' ], $ver( '/js/owl.carousel.min.js' ),     true );
	wp_enqueue_script( 'wgh-responsive-slides-js',    $uri . '/js/responsiveslides.min.js', [ 'jquery' ], $ver( '/js/responsiveslides.min.js' ), true );
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


// ── ACF OPTIONS PAGES ─────────────────────────────────────────────────────────

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( [
		'page_title' => __( 'Theme General Settings', 'wgh-starter' ),
		'menu_title' => __( 'Theme Settings',         'wgh-starter' ),
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'manage_options',
		'icon_url'   => 'dashicons-superhero',
		'position'   => 3,
		'post_id'    => 'options',
		'redirect'   => false,
	] );

	acf_add_options_page( [
		'page_title' => __( 'Includes', 'wgh-starter' ),
		'menu_title' => __( 'Includes', 'wgh-starter' ),
		'menu_slug'  => 'includes-settings',
		'capability' => 'manage_options',
		'icon_url'   => 'dashicons-screenoptions',
		'position'   => 3.1,
		'post_id'    => 'includes',
		'redirect'   => false,
	] );
}


// ── LINK VALIDATION HELPER ────────────────────────────────────────────────────

function wgh_link( $url ) {
	$url = trim( (string) $url );

	if ( $url === '' || $url === '#' ) return '';

	if ( stripos( $url, 'mailto:' ) === 0 ) {
		$email = substr( $url, 7 );
		if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			return 'href="mailto:' . esc_attr( $email ) . '"';
		}
	}

	if ( stripos( $url, 'tel:' ) === 0 ) {
		$tel = preg_replace( '/[^\d\+]/', '', substr( $url, 4 ) );
		if ( preg_match( '/^\+?\d{5,}$/', $tel ) ) {
			return 'href="tel:' . esc_attr( $tel ) . '"';
		}
	}

	$no_scheme = preg_replace( '#^https?://#i', '', $url );
	$first     = explode( '/', $no_scheme, 2 )[0];

	if ( strpos( $first, '@' ) !== false && filter_var( $first, FILTER_VALIDATE_EMAIL ) ) {
		return 'href="mailto:' . esc_attr( $first ) . '"';
	}

	$clean = preg_replace( '/[^\d\+]/', '', $no_scheme );
	if ( preg_match( '/^\+?\d{5,}$/', $clean ) ) {
		return 'href="tel:' . esc_attr( $clean ) . '"';
	}

	return 'href="' . esc_url( $url ) . '"';
}


// ── BREADCRUMB ────────────────────────────────────────────────────────────────

function wgh_breadcrumb() {
	echo '<ul>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'wgh-starter' ) . '</a></li>';

	if ( is_page() ) {
		global $post;
		foreach ( array_reverse( get_post_ancestors( $post->ID ) ) as $parent_id ) {
			echo '<li class="separator">/</li>';
			echo '<li><a href="' . esc_url( get_permalink( $parent_id ) ) . '">' . esc_html( get_the_title( $parent_id ) ) . '</a></li>';
		}
		echo '<li class="separator">/</li>';
		echo '<li><span aria-current="page">' . esc_html( get_the_title() ) . '</span></li>';
	} elseif ( is_single() ) {
		$cat = get_the_category();
		if ( $cat ) {
			echo '<li class="separator">/</li>';
			echo '<li><a href="' . esc_url( get_category_link( $cat[0]->term_id ) ) . '">' . esc_html( $cat[0]->name ) . '</a></li>';
		}
		echo '<li class="separator">/</li>';
		echo '<li><span aria-current="page">' . esc_html( get_the_title() ) . '</span></li>';
	}

	echo '</ul>';
}


// ── HEAD CLEANUP ──────────────────────────────────────────────────────────────

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

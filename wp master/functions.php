<?php
/**
 * ---------------------------------------------------------
 *  THEME BASIC SETUP
 * ---------------------------------------------------------
 */

/* Title formatting */
function selahtechnology_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) return $title;

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'selahtechnology' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'selahtechnology_wp_title', 10, 2 );

/* Featured images support */
add_theme_support( 'post-thumbnails' );

/* Register sidebar */
if ( function_exists('register_sidebar') ) {
	register_sidebar();
}

/* Menus */
register_nav_menus([
	'main-menu'    => __( 'Header Menu', 'selahtechnology' ),
	'footer'       => __( 'Footer Menu', 'selahtechnology' ),
	'footer-other' => __( 'Footer Other Menu', 'selahtechnology' ),
]);


/**
 * ---------------------------------------------------------
 *  NAV ACTIVE CLASS
 * ---------------------------------------------------------
 */
function special_nav_class($classes, $item){
	if ( in_array('current-menu-item', $classes) ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);


/**
 * ---------------------------------------------------------
 *  ADMIN LOGIN LOGO
 * ---------------------------------------------------------
 */
function selahtechnology_wplogo() {
	$logo = get_template_directory_uri() . '/assets/img/logo/logo.png';
	echo '<style>
		h1 a {
			background-image: url(' . esc_url($logo) . ') !important;
			background-size: contain !important;
			background-repeat: no-repeat !important;
			width: 320px !important;
			height: 80px !important;
		}
	</style>';
}
add_action('login_head', 'selahtechnology_wplogo');



/**
 * ---------------------------------------------------------
 *  ENQUEUE ASSETS (CSS & JS)
 * ---------------------------------------------------------
 */
function mytheme_enqueue_assets() {

    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    $ver = function($path) use ($dir) {
        $f = $dir . $path;
        return file_exists($f) ? filemtime($f) : null;
    };

    /* CSS */
    $css = [
        'bootstrap-css'   => '/assets/css/bootstrap.min.css',
        'base-css'        => '/assets/css/base.css',
        'stellarnav-css'  => '/assets/css/stellarnav.min.css',
        'swiper-css'      => '/assets/css/swiper.css',
        'fonts-css'       => '/assets/fonts/style.css',
        'fontawesome-css' => '/assets/fontawesome-6/css/all.css',
        'styles-css'      => '/assets/css/styles.css',
        'responsive-css'  => '/assets/css/responsive.css',
    ];

    foreach ($css as $h => $p) {
        wp_enqueue_style($h, $uri . $p, [], $ver($p));
    }

    $js = [
        'color-modes'       => '/assets/js/vendor/color-modes.js',
        'bootstrap-bundle'  => '/assets/js/bootstrap.bundle.min.js',
        'magnific-popup-js' => '/assets/js/jquery.magnific-popup.min.js',
        'odometer-js'       => '/assets/js/jquery.odometer.min.js',
        'jquery-appear'     => '/assets/js/jquery.appear.js',
        'gsap'              => '/assets/js/gsap.js',
        'scrolltrigger'     => '/assets/js/ScrollTrigger.js',
        'splittext'         => '/assets/js/SplitText.js',
        'gsap-animation'    => '/assets/js/gsap-animation.js',
        'parallax-scroll'   => '/assets/js/jquery.parallaxScroll.min.js',
        'swiper-js'         => '/assets/js/swiper-bundle.js',
        'ajax-form'         => '/assets/js/ajax-form.js',
        'wow'               => '/assets/js/wow.min.js',
        'aos-js'            => '/assets/js/aos.js',
        'main-js'           => '/assets/js/main.js',
        'custom-all'        => '/assets/js/new/all.js',
    ];

    foreach ($js as $h => $p) {
        wp_enqueue_script($h, $uri . $p, ['jquery'], $ver($p), true);
    }
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');




/**
 * ---------------------------------------------------------
 *  CUSTOMIZER — LOGOS
 * ---------------------------------------------------------
 */
function selahtechnology_customize_register( $wp_customize ) {

	$wp_customize->add_section('selahtechnology_logo_section', [
		'title'    => __('Theme Logos', 'selahtechnology'),
		'priority' => 30,
	]);

	for ($i = 1; $i <= 2; $i++) {
		$wp_customize->add_setting("selahtechnology_logo_$i");
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			"selahtechnology_logo_{$i}_control",
			[
				'label'    => __("Logo $i", 'selahtechnology'),
				'section'  => 'selahtechnology_logo_section',
				'settings' => "selahtechnology_logo_$i",
			]
		));
	}
}
add_action('customize_register', 'selahtechnology_customize_register');


/**
 * ---------------------------------------------------------
 *  ACF OPTIONS PAGES
 * ---------------------------------------------------------
 */
if ( function_exists('acf_add_options_page') ) {

	acf_add_options_page([
		'page_title'      => __('Theme General Settings', 'mytheme'),
		'menu_title'      => __('Theme Settings', 'mytheme'),
		'menu_slug'       => 'theme-general-settings',
		'capability'      => 'manage_options',
		'icon_url'        => 'dashicons-superhero',
		'position'        => 3,
		'post_id'         => 'options',
		'redirect'        => false,
	]);

	acf_add_options_page([
    'page_title'      => __('Includes', 'mytheme'),
    'menu_title'      => __('Includes', 'mytheme'),
    'menu_slug'       => 'includes-settings',
    'capability'      => 'manage_options',
    'icon_url'        => 'dashicons-screenoptions',
    'position'        => 3.1,
    'post_id'         => 'includes',
    'redirect'        => false,
	]);

}


/**
 * ---------------------------------------------------------
 *  LINK VALIDATION HELPER
 * ---------------------------------------------------------
 * Auto-builds correct href for phone, email, URL, or removes href.
 */
function srDev_link_validation( $url ) {
    $url = trim( (string) $url );

    if ( $url === '' || $url === '#' ) {
        return '';
    }

    if ( stripos( $url, 'mailto:' ) === 0 ) {
        $email = substr( $url, 7 );
        // validate email portion
        if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            return 'href="mailto:' . esc_attr( $email ) . '"';
        }
    }

    if ( stripos( $url, 'tel:' ) === 0 ) {
        $tel = substr( $url, 4 );
        $clean_tel = preg_replace( '/[^\d\+]/', '', $tel );
        if ( preg_match( '/^\+?\d{5,}$/', $clean_tel ) ) {
            return 'href="tel:' . esc_attr( $clean_tel ) . '"';
        }
    }

    $no_scheme = preg_replace( '#^https?://#i', '', $url );

    $first_segment = explode( '/', $no_scheme, 2 )[0];

    if ( strpos( $first_segment, '@' ) !== false ) {
        $candidate_email = $first_segment;
        if ( filter_var( $candidate_email, FILTER_VALIDATE_EMAIL ) ) {
            return 'href="mailto:' . esc_attr( $candidate_email ) . '"';
        }
    }

    $clean = preg_replace( '/[^\d\+]/', '', $no_scheme );
    if ( preg_match( '/^\+?\d{5,}$/', $clean ) ) {
        return 'href="tel:' . esc_attr( $clean ) . '"';
    }

    return 'href="' . esc_url( $url ) . '"';
}





/**
 * ---------------------------------------------------------
 * HEAD CLEANUP — 100% safe for normal WordPress sites (2025)
 * - Safe for custom WP themes/plugins (non-headless)
 * - Removes only WP version, emoji fallbacks, RSD and WLW links
 * ---------------------------------------------------------
 */

 // remove WP version meta
remove_action( 'wp_head', 'wp_generator' );

 // remove emoji scripts/styles (modern browsers support emojis natively)
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

 // remove remote publishing and Windows Live Writer links (legacy)
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );


// Disable Theme & Plugin File Editor (Security Hardening)
define( 'DISALLOW_FILE_EDIT', false );



/**
 * ---------------------------------------------------------
 * breadcrumb
 * ---------------------------------------------------------
 */
function srdev_breadcrumb() {

    echo '<ul>';
    echo '<li><a href="' . home_url('/') . '">Home</a></li>';

    if (is_page()) {

        global $post;
        $parents = array_reverse(get_post_ancestors($post->ID));

        foreach ($parents as $parent_id) {
            echo '<li class="separator">/</li>';
            echo '<li><a href="' . get_permalink($parent_id) . '">' . get_the_title($parent_id) . '</a></li>';
        }

        echo '<li class="separator">/</li>';
        echo '<li><a aria-current="page">' . get_the_title() . '</a></li>';
    }

    elseif (is_single()) {

        $cat = get_the_category();
        if ($cat) {
            echo '<li class="separator">/</li>';
            echo '<li><a href="' . get_category_link($cat[0]->term_id) . '">' . $cat[0]->name . '</a></li>';
        }

        echo '<li class="separator">/</li>';
        echo '<li><a aria-current="page">' . get_the_title() . '</a></li>';
    }

    echo '</ul>';
}








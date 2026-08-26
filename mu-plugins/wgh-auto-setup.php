<?php
/**
 * Plugin Name: WGH Auto Setup
 * Description: First-run setup: activates the wgh-starter theme and bundled plugins (running their activation hooks), removes the default Hello World post and Sample Page, closes comments site-wide, and generates a per-site theme screenshot. Self-removes after completion.
 * Version: 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'wgh_auto_setup', 1 );

function wgh_auto_setup() {
	// Skip non-standard request types to avoid side effects.
	if ( wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		return;
	}

	// Already ran.
	if ( get_option( 'wgh_auto_setup_done' ) ) {
		return;
	}

	// WordPress not fully installed yet.
	if ( ! get_option( 'siteurl' ) ) {
		return;
	}

	// ── 1. Activate theme ────────────────────────────────────────────────────
	if ( wp_get_theme( 'wgh-starter' )->exists() && get_stylesheet() !== 'wgh-starter' ) {
		switch_theme( 'wgh-starter' );
	}

	// ── 2. Activate bundled plugins (runs their activation hooks) ────────────
	if ( ! function_exists( 'activate_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$slugs = [ 'classic-editor', 'secure-custom-fields', 'aam-wp-migration' ];
	$to_activate = [];

	foreach ( $slugs as $slug ) {
		$dir = WP_PLUGIN_DIR . '/' . $slug;
		if ( ! is_dir( $dir ) ) {
			continue;
		}
		foreach ( (array) glob( $dir . '/*.php' ) as $file ) {
			$headers = get_file_data( $file, [ 'Plugin Name' => 'Plugin Name' ] );
			if ( empty( $headers['Plugin Name'] ) ) {
				continue;
			}
			$rel = $slug . '/' . basename( $file );
			if ( ! is_plugin_active( $rel ) ) {
				$to_activate[] = $rel;
			}
			break; // main file for this slug found
		}
	}

	if ( $to_activate ) {
		activate_plugins( $to_activate ); // fires activation hooks
	}

	// ── 3. Remove default content ───────────────────────────────────────────
	// Hello World is always post ID 1 on a fresh install; fall back to a title match.
	$default_post = get_post( 1 );
	if ( $default_post && 'post' === $default_post->post_type && 'post' === get_post_status( 1 ) ) {
		wp_delete_post( 1, true );
	} else {
		$hello = get_posts( [
			'post_type'      => 'post',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			's'              => 'Hello world',
		] );
		if ( $hello ) {
			wp_delete_post( $hello[0], true );
		}
	}

	// Sample Page is always page ID 2 on a fresh install.
	$sample = get_post( 2 );
	if ( $sample && 'page' === $sample->post_type && get_page_by_path( 'sample-page' ) ) {
		wp_delete_post( 2, true );
	}

	// ── 4. Close comments site-wide by default ──────────────────────────────
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );

	// Close on any content that already exists (e.g. Privacy Policy draft).
	global $wpdb;
	$wpdb->query(
		"UPDATE {$wpdb->posts} SET comment_status = 'closed', ping_status = 'closed'
		 WHERE post_status IN ( 'publish', 'draft', 'pending', 'private' )"
	);
	// Re-enable per site later via Settings → Discussion.

	// ── 5. Per-site theme screenshot ───────────────────────────────────────
	wgh_generate_screenshot();

	// ── 6. Mark done, then self-delete ─────────────────────────────────────
	update_option( 'wgh_auto_setup_done', '1' );

	if ( is_writable( __FILE__ ) ) {
		@unlink( __FILE__ );
	}
}


/**
 * Draw a simple screenshot.png (site title on a dark card) into the theme folder.
 * Silently no-ops if GD is missing or the theme folder is not writable.
 */
function wgh_generate_screenshot() {
	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return;
	}

	$theme_dir = get_theme_root( 'wgh-starter' ) . '/wgh-starter';
	$target    = $theme_dir . '/screenshot.png';
	if ( ! is_dir( $theme_dir ) || ! is_writable( $theme_dir ) ) {
		return;
	}

	$w = 1200;
	$h = 900;
	$img = imagecreatetruecolor( $w, $h );

	$bg     = imagecolorallocate( $img, 22, 22, 30 );
	$accent = imagecolorallocate( $img, 99, 102, 241 );
	$fg     = imagecolorallocate( $img, 255, 255, 255 );
	$muted  = imagecolorallocate( $img, 150, 150, 165 );

	imagefilledrectangle( $img, 0, 0, $w, $h, $bg );
	imagefilledrectangle( $img, 0, $h - 12, $w, $h, $accent );

	$title    = wp_strip_all_tags( get_bloginfo( 'name' ) ) ?: 'WordPress Site';
	$subtitle = 'Web Graphics Hub — WGH Starter';

	$font = function_exists( 'imagettftext' ) ? wgh_find_ttf() : '';

	if ( $font ) {
		$size = 60;
		do {
			$box = imagettfbbox( $size, 0, $font, $title );
			$tw  = abs( $box[2] - $box[0] );
			$size -= 4;
		} while ( $tw > $w - 160 && $size > 16 );

		imagettftext( $img, $size, 0, (int) ( ( $w - $tw ) / 2 ), (int) ( $h / 2 ), $fg, $font, $title );

		$sb = imagettfbbox( 22, 0, $font, $subtitle );
		$sw = abs( $sb[2] - $sb[0] );
		imagettftext( $img, 22, 0, (int) ( ( $w - $sw ) / 2 ), $h - 60, $muted, $font, $subtitle );
	} else {
		// GD bitmap fallback: render small, scale up.
		$tmp = imagecreatetruecolor( 600, 80 );
		imagefilledrectangle( $tmp, 0, 0, 600, 80, $bg );
		imagestring( $tmp, 5, 10, 30, $title, $fg );
		$scaled = imagescale( $tmp, $w - 200 );
		imagecopy( $img, $scaled, 100, (int) ( $h / 2 - imagesy( $scaled ) / 2 ), 0, 0, imagesx( $scaled ), imagesy( $scaled ) );
		imagestring( $img, 3, (int) ( $w / 2 - 110 ), $h - 60, $subtitle, $muted );
		imagedestroy( $tmp );
		imagedestroy( $scaled );
	}

	imagepng( $img, $target );
	imagedestroy( $img );
}

function wgh_find_ttf() {
	$candidates = [
		'/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
		'/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
		'/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
		'/usr/share/fonts/dejavu/DejaVuSans.ttf',
		'/Library/Fonts/Arial.ttf',
		'C:/Windows/Fonts/arial.ttf',
	];
	foreach ( $candidates as $f ) {
		if ( is_readable( $f ) ) {
			return $f;
		}
	}
	return '';
}

<?php
/**
 * Plugin Name: WGH Auto Setup
 * Description: First-run setup: activates wgh-starter theme and bundled plugins, deletes the default Hello World post, disables comments site-wide. Self-removes after completion.
 */

add_action( 'init', 'wgh_auto_setup', 1 );

function wgh_auto_setup() {
	// Skip non-standard request types to avoid side effects
	if ( wp_doing_ajax() || wp_doing_cron() ) return;
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) return;
	if ( defined( 'WP_CLI' ) && WP_CLI ) return;

	// Already ran — nothing to do
	if ( get_option( 'wgh_auto_setup_done' ) ) return;

	// WordPress not fully installed yet (installer in progress)
	if ( ! get_option( 'siteurl' ) ) return;

	// ── 1. Activate theme ─────────────────────────────────────────────────────
	if ( wp_get_theme( 'wgh-starter' )->exists() && get_stylesheet() !== 'wgh-starter' ) {
		switch_theme( 'wgh-starter' );
	}

	// ── 2. Discover and activate plugins ─────────────────────────────────────
	$slugs = [ 'classic-editor', 'secure-custom-fields', 'aam-wp-migration' ];

	$active  = (array) get_option( 'active_plugins', [] );
	$changed = false;

	foreach ( $slugs as $slug ) {
		$dir = WP_PLUGIN_DIR . '/' . $slug;
		if ( ! is_dir( $dir ) ) continue;

		foreach ( (array) glob( $dir . '/*.php' ) as $file ) {
			$headers = get_file_data( $file, [ 'Plugin Name' => 'Plugin Name' ] );
			if ( empty( $headers['Plugin Name'] ) ) continue;

			$rel = $slug . '/' . basename( $file );
			if ( ! in_array( $rel, $active, true ) ) {
				$active[] = $rel;
				$changed  = true;
			}
			break; // found main file for this slug
		}
	}

	if ( $changed ) {
		update_option( 'active_plugins', array_values( $active ) );
	}

	// ── 3. Delete default "Hello World" post and its comment ─────────────────
	$hello = get_posts( [
		'title'          => 'Hello world!',
		'post_type'      => 'post',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	] );
	if ( ! empty( $hello ) ) {
		wp_delete_post( $hello[0], true );
	}

	// ── 4. Disable comments site-wide by default ──────────────────────────────
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status',    'closed' );

	// ── 5. Mark done, then self-delete ────────────────────────────────────────
	update_option( 'wgh_auto_setup_done', '1' );

	if ( is_writable( __FILE__ ) ) {
		@unlink( __FILE__ );
	}
}

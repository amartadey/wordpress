<?php
/**
 * Comments template.
 *
 * Comments are closed by default (see the WGH Auto Setup mu-plugin and
 * Settings → Discussion). Turn them on per site there when a project needs them.
 * page.php calls comments_template() already; add the same block to single.php
 * if a project needs comments on posts.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$count = get_comments_number();
			printf(
				esc_html( _n( '%s comment', '%s comments', $count, 'wgh-starter' ) ),
				number_format_i18n( $count )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( [
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 48,
			] );
			?>
		</ol>

		<?php
		the_comments_pagination( [
			'prev_text' => esc_html__( 'Previous', 'wgh-starter' ),
			'next_text' => esc_html__( 'Next', 'wgh-starter' ),
		] );
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wgh-starter' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div>

<?php
/**
 * Template for displaying 404 (Not Found) pages.
 */
get_header();
?>

<div class="innerPage">
    <div class="container">
        <div class="heading">
            <h1 class="text-center"><?php _e( 'Page Not Found', 'wgh-starter' ); ?></h1>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h4><?php _e( 'Sorry, the page you are looking for could not be found.', 'wgh-starter' ); ?></h4>
                <p>
                    <?php _e( 'You may have mistyped the address, or the page may have moved.', 'wgh-starter' ); ?>
                </p>
                <p>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                        <?php _e( 'Go to Homepage', 'wgh-starter' ); ?>
                    </a>
                </p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

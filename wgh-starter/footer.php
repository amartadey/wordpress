</main><!-- #content -->

<!-- Footer Start -->
<footer id="footer">
    <div class="container">

        <?php $wgh_footer_logo = wgh_footer_logo_url(); ?>
        <?php if ( $wgh_footer_logo ) : ?>
            <div class="footer-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( $wgh_footer_logo ); ?>"
                         alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                         width="320" height="80">
                </a>
            </div>
        <?php endif; ?>

        <div class="footer-bottom">
            <?php
            if ( has_nav_menu( 'footer' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => 'nav',
                    'container_class' => 'footer-nav',
                    'fallback_cb'    => false,
                ] );
            }
            ?>
            <div class="copy-right">
                <p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All Rights Reserved.', 'wgh-starter' ); ?></p>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</footer>
<!-- Footer End -->

<?php wp_footer(); ?>
</body>
</html>

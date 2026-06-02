<!-- Footer Start -->
<footer id="footer">
    <div class="container">

        <div class="footer-top">
            <div class="clearfix"></div>
        </div>

        <div class="footer-bottom">
            <nav class="footer-nav">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ] );
                ?>
                <div class="clearfix"></div>
            </nav>
            <div class="copy-right">
                <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</p>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</footer>
<!-- Footer End -->

<?php wp_footer(); ?>
</body>
</html>

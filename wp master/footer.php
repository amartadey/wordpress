

    
<footer id="footer">
    <div class="container">
        <div class="footer-top">
            <div class="contact-block box">
                <h3>CONTACT US</h3>
            </div>
            <div class="address-block box">
                <a href="http://harmonyair.net/contact-us.html"><p>Harmony Air, LLC <span>7230 Centennial Place</span>Nashville TN, 37209</p></a>
            </div>
            <div class="ph-block box">

                <a href="tel:6153508550"><p>615 350 8550</p></a>
                <p class="fax">615 350 8551</p>
                <div class="clearfix"></div>
            </div>
            <div class="social-media box">
              <h4>Social Share</h4>
                <a href="https://www.facebook.com/profile.php?id=100009851168739" target="_blank" title="Facebook">
                    <img src="<?php bloginfo('template_directory'); ?>/images/facebook_circle_color-24.png" alt="" />
                </a>
                <a href="https://plus.google.com/113445132588876149101" title="Google+">
                    <img src="<?php bloginfo('template_directory'); ?>/images/google_circle_color-32.png" alt="" />
                </a>
                <a href="https://twitter.com/Harmony_Air" title="Twitter">
                    <img src="<?php bloginfo('template_directory'); ?>/images/twitter_circle_color-24.png" alt="" />
                </a>
            </div>
            <div class="footer-logo-block box">
                <a href="index.html"><img src="<?php bloginfo('template_directory'); ?>/images/footer-logo-2.png" alt="" /></a>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="footer-bottom">
            <nav class="footer-nav">
            <ul>
                <li><a href="#">Air Taxi</a></li>
                <li><a href="#">Flight Training</a></li>
                <li><a href="http://harmonyair.net/aircraft-mgmt.html">Aircraft Management</a></li>
                <li><a href="http://harmonyair.net/fleet.html">Fleet</a></li>
                <li><a href="http://harmonyair.net/about-us.html">About Us</a></li>
                
            </ul>
               <div class="clearfix"></div> 
        </nav>
            <div class="copy-right">
                <p>© Harmony Air. All Rights Reserved</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</footer>


<!-- JQuery Start --> 
	<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/classie.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/cbpAnimatedHeader.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/style.js"></script>

<!-- superfish js -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/superfish.js" type="text/javascript"></script>
    <script type="text/javascript">
        // initialise plugins
        jQuery(document).ready(function($){
                jQuery('ul.sf-menu').superfish();
        
                /* prepend menu icon */
                jQuery('#nav-wrap').prepend('<div id="menu-icon"></div>');
                //alert ('test');
                /* toggle nav */
                $("#menu-icon").on("click", function(){
                        jQuery(".sf-menu").slideToggle();
                        jQuery(this).toggleClass("active");
                });
        });
    
    </script> 
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>



<?php wp_footer(); ?>
</body>
</html>
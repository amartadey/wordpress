<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 *
 *
 */

get_header(); ?>


<?php 
/*
*Template Name: 404 Pages
*/
?>
 <?php $admin_email = get_option( 'admin_email' ); ?> 
<?php get_header(); ?>
<div class="inner-banner" style="text-align: center;">
	<img src="<?php echo get_template_directory_uri(); ?>/images/not-found-banner.gif" alt="not-found-banner" /> 
</div>
<div class="innerPage">
	<div class="container">
        <div class="heading">
				<h1 class="text-center"><?php _e( 'Not Found' ); ?></h1>
		 </div>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h4 class="text-center"><?php _e( 'Sorry, the page you tried cannot be found.' ); ?></h4>
                     <p>You may have typed address incorrectly. If you found a broken link from another site or from our site, please. <a href="mailto:<? echo $admin_email; ?>">email us</a></p>
                    <p><a href="<?php echo get_home_url(); ?>" class="page-not-found-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
 Go to our Homepage</a></p>
    
                    <?php //get_search_form(); ?>
                </aside><!-- .page-content -->
    
    
            </div><!-- #content -->
        </div>
	</div><!-- #primary -->
</div>

<?php get_footer(); ?>
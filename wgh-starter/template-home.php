<?php
/**
 * Template Name: Home Page
 */
get_header();
?>

<!-- Banner Start -->
<div class="banner">
    <div class="desc">
        <div class="container">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</div>
<!-- Banner End -->

<?php get_footer(); ?>

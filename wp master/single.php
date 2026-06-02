<?php get_header(); ?>

<div class="innerPage">
	<div class="container">
        <div class="heading">
            <h1><?php the_title(); ?></h1>
        </div>
        <div class="clear"></div>
        <div class="text">
		<?php 
            while(have_posts()) : the_post();
                the_content(); 
            endwhile;
        ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>

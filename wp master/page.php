<?php get_header(); ?>
<?php if (has_post_thumbnail( $post->ID ) ): ?>
<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
<div class="inner-banner">
	<img src="<?php echo $image[0]; ?>" alt="" /> 
</div>
<?php endif; ?>
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

<?php get_header(); ?>

<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
    <div class="inner-banner">
        <img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title_attribute(); ?>">
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
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

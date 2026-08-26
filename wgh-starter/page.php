<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="inner-banner">
            <?php the_post_thumbnail( 'full', [ 'alt' => the_title_attribute( [ 'echo' => false ] ) ] ); ?>
        </div>
    <?php endif; ?>

    <div class="innerPage">
        <div class="container">
            <div class="heading">
                <h1><?php the_title(); ?></h1>
            </div>
            <div class="clear"></div>
            <div class="text">
                <?php the_content(); ?>
                <?php wp_link_pages( [ 'before' => '<div class="page-links">', 'after' => '</div>' ] ); ?>
            </div>
            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>
        </div>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>

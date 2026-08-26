<?php get_header(); ?>

<div class="innerPage">
    <div class="container">

        <?php if ( have_posts() ) : ?>

            <?php if ( is_home() && ! is_front_page() ) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php elseif ( is_archive() ) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php the_archive_title(); ?></h1>
                    <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
                </header>
            <?php elseif ( is_search() ) : ?>
                <header class="page-header">
                    <h1 class="page-title">
                        <?php
                        /* translators: %s: search query. */
                        printf( esc_html__( 'Search results for: %s', 'wgh-starter' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
                        ?>
                    </h1>
                </header>
            <?php endif; ?>

            <div class="post-list">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <?php if ( 'post' === get_post_type() ) : ?>
                            <p class="entry-meta">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                            </p>
                        <?php endif; ?>
                        <div class="entry-summary"><?php the_excerpt(); ?></div>
                        <a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'wgh-starter' ); ?></a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination( [
                'mid_size'  => 1,
                'prev_text' => esc_html__( 'Previous', 'wgh-starter' ),
                'next_text' => esc_html__( 'Next', 'wgh-starter' ),
            ] );
            ?>

        <?php else : ?>

            <div class="no-results">
                <h1><?php esc_html_e( 'Nothing found', 'wgh-starter' ); ?></h1>
                <p><?php esc_html_e( 'No content matched your request. Try a search.', 'wgh-starter' ); ?></p>
                <?php get_search_form(); ?>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>

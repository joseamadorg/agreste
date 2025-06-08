<?php get_header(); ?>
    <div id="primary" class="content-area atreves-page-containerr atreves-services-details">
        <main id="main" class="site-main">
            <div class="single-details-area">
                <div class="container">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                    <?php endif; ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <h3 class="entry-title"><?php the_title(); ?></h3>
                            </header>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </main><!-- #main -->
    </div>
<?php get_footer(); ?>

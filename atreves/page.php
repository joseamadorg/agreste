<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package atreves
 */
$blog_column = is_active_sidebar( 'right-sidebar' ) ? 8 : 12 ;
get_header();
?>
	<div id="primary" class="content-area atreves-page-containerr"> 
		<main id="main" class="site-main">
		 <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-<?php print esc_attr($blog_column); ?>">
					<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', 'page' );

							//If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
					?>
			    </div>
				<?php if ( is_active_sidebar( 'right-sidebar' ) ) { ?>
			        <div class="col-lg-4 sidebar-blog right-side">
						<?php get_sidebar(); ?>
		            </div>
				<?php } ?>
               </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer();
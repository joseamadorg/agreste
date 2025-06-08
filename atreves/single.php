<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package atreves
 */
$blog_column = is_active_sidebar( 'right-sidebar' ) ? 8 : 12 ;
get_header();
?>
	<div id="primary" class="content-area atreves-page-containerr atreves-blog-details">
		<main id="main" class="site-main">
		 	<div class="blog-details-area">
		 		<div class="container">
            		<div class="row custom-gutter">
						<div class="col-lg-<?php print esc_attr($blog_column); ?>">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', get_post_format() );

								?>

								<?php 
								if( get_previous_post_link() AND get_next_post_link() ) : ?>

								<?php 
								endif; ?>


								<?php get_template_part( 'template-parts/biography'); ?>	


								<div class="blog-details-comment">
									<?php
									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template(); 
									endif;
									?>
								</div>
							<?php 	
							endwhile; ?>
						</div>
					 	<?php if ( is_active_sidebar( 'right-sidebar' ) ) { ?>
					        <div class="col-lg-4 sidebar-blog right-side">
								<?php get_sidebar(); ?>
				            </div>
						<?php } ?>
		  			</div>
               </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php 
get_footer();
<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package atreves
 */
$blog_column = is_active_sidebar( 'right-sidebar' ) ? 8 : 12 ;
get_header();
?>
	<div id="primary" class="content-area atreves-page-containerr atreves-blog-page">
        <main id="main" class="site-main">
			<div class="blog-area">
				<div class="container">
					<div class="row custom-gutter">
						<div class="col-lg-<?php print esc_attr($blog_column); ?>">
							<div class="blog-inner">
					
								<?php
								if ( have_posts() ) :

									/* Start the Loop */
									while ( have_posts() ) :
										the_post();

										/*
										 * Include the Post-Type-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
										 */
										get_template_part( 'template-parts/content', get_post_format() );


									endwhile;
								?>
								
								<div class="atreves-pagination text-center">
									<?php 
									the_posts_pagination(array(
										'next_text' => '<i class="fas fa-arrow-right"></i>',
										'prev_text' => '<i class="fas fa-arrow-left"></i>',
										'screen_reader_text' => ' ',
										'type' => 'list'
									));
									?>
								</div>
								<?php	
									
								else :

									get_template_part( 'template-parts/content', 'none' );

								endif;
								?>
							</div>
							<?php get_template_part( 'template-parts/biography'); ?>	


								<div class="blog-details-comment">
									<?php
									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template(); 
									endif;
									?>
								</div>
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
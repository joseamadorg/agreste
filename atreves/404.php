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
$atreves_error_404_text = get_theme_mod('atreves_error_404_text','404'); 
$atreves_error_title = get_theme_mod('atreves_error_title','Page not found '); 
$atreves_error_link_text = get_theme_mod('atreves_error_link_text','Back To Home '); 
$atreves_error_desc = get_theme_mod('atreves_error_desc','Oops! The page you are looking for does not exist. It might have been moved or deleted. '); 
get_header();
?>

    <div id="primary" class="content-area atreves-404-page atreves-page-containerr">
        <main id="main" class="site-main">
			<div class="blog-area-">
				<div class="container">
					<div class="row custom-gutter">
						<div class="col-lg-8 offset-lg-2">
							<div class="blog-inner">
								<section class="error-404 not-found">
									<header class="page-header">
										<h1 class="error-heading">
											<?php echo esc_html( $atreves_error_404_text ); ?>
										</h1>
										<h2 class="error-sub-title">
											<?php echo esc_html( $atreves_error_title ); ?>
										</h2>
										<p><?php echo esc_html( $atreves_error_desc ); ?></p>
									</header><!-- .page-header -->

									<div class="page-content error-page-inner">
										<a href="<?php echo esc_url(home_url('/')); ?>" class="go-back-btnn">
											<?php echo esc_html( $atreves_error_link_text ); ?>
										</a>
									</div>
								</section>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
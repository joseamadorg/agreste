<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package atreves
 */
if (!defined('ABSPATH')){
    exit(); //exit if access directly
}

if (!class_exists('Atreves_Tags')){
    class Atreves_Tags{
		
		
		private static $instance;

	    /**
	     * get instance
	     * @since 1.0.0
	     * */
	    public static function getInstance(){
		    if (null ==  self::$instance){
			    self::$instance = new self();
		    }
		    return self::$instance;
	    }

	    /**
	     * Prints HTML with meta information for the current post-date/time.
	     */
	    public static function posted_on() {
		    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		    }

		    $time_string = sprintf( $time_string,
			    esc_attr( get_the_date( DATE_W3C ) ),
			    esc_html( get_the_date() ),
			    esc_attr( get_the_modified_date( DATE_W3C ) ),
			    esc_html( get_the_modified_date() )
		    );

		    $posted_on = sprintf(
		    /* translators: %s: post date. */
			    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		    );

		    echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	    }

	    public static function posted_by() {
		    $byline = sprintf(
		    /* translators: %s: post author. */
			    esc_html_x( 'By %s', 'post author', 'atreves' ),
			    '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		    );

		    echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	    }

	    /**
	     * Displays an optional post thumbnail.
	     *
	     * Wraps the post thumbnail in an anchor element on index views, or a div
	     * element when on single views.
	     */
	    public static function post_thumbnail() {
		    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			    return;
		    }

		    if ( is_singular() ) :
			    ?>

                <div class="post-thumbnail">
				    <?php the_post_thumbnail(); ?>
                </div><!-- .post-thumbnail -->

		    <?php else : ?>

                <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				    <?php
				    the_post_thumbnail( 'post-thumbnail', array(
					    'alt' => the_title_attribute( array(
						    'echo' => false,
					    ) ),
				    ) );
				    ?>
                </a>

		    <?php
		    endif; // End is_singular().
	    }
		
		 public static function tags() {
	     ?>
		    <?php if ( has_tag() ): ?>
                <div class="tag-list-wrapper">
                    <ul class="navs navs-tag">
	                    <li class="navs__item">
	                        <h4 class="navs__item-tag mr-2"><?php esc_html_e( 'Tags : ', 'atreves' ); ?></h4>
	                    </li>
	                    <?php
	                     if ( get_the_tag_list()) {
	                            echo get_the_tag_list('<li>',
	                                ' </li><li>','</li>');
	                         }
	                   ?>
	                </ul>
                </div>
           <?php endif; ?>

	  <?php  }
		
		public static function categories() { 
			if( has_category() ):
			?>

				<div class="tag-list-wrapper">
					<ul class="navs navs-tag">
						<li class="navs__item">
	                        <h4 class="navs__item-tag"><?php esc_html_e( 'Categories : ', 'atreves' ); ?></h4>
	                    </li>
						<?php
						$categories = get_the_category( get_the_ID() );
						
						foreach ($categories as $category){
							
							print '<li><a class="news-tag" href="' . get_category_link($category->term_id) . '">'  . $category->cat_name . '</a></li>';

						} ?>
					</ul>
				</div>

			<?php
			endif; 
	   }

    }//end class


}

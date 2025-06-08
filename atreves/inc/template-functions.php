<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package atreves
 * @param array $classes Classes for the body element.
 * @return array
*/

if(!class_exists('Atreves_Functions')){
	class Atreves_Functions{
		private static $instance;

		public function __construct() {
			add_filter( 'body_class', array($this,'body_classes') );
			add_action( 'wp_head', array($this,'pingback_header') );
		}

		public static function getInstance(){
			if (null ==  self::$instance){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function body_classes($classes){
			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			// Adds a class of no-sidebar when there is no sidebar present.
			if ( ! is_active_sidebar( 'right-sidebar' ) ) {
				$classes[] = 'no-sidebar';
			}

			return $classes;
		}

		public function pingback_header(){
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}
		

        public function link_pages(){
            $defaults = array(
                'before' => '<div class="wp-link-pages"><span>'.esc_html__('Pages:' ,'atreves').'</span>',
                'after' => '</div>',
                'link_before' => '',
                'link_after' => '',
                'next_or_number' => 'number',
                'separator' => ' ',
                'pagelink' => '%',
                'echo' => 1
            );
            wp_link_pages($defaults);
        }	
	
	}//end class
}



/**
 * [ocdi_import_files description]
 * @return [type] [description]
 */
function ocdi_import_files() {
    return array(
        array(
            'import_file_name' => 'Atreves',
            'categories' => array() ,
            'local_import_file'          => trailingslashit(get_template_directory()).'/demo/atreves-demo-content.xml',
            'local_import_widget_file'   => trailingslashit(get_template_directory()).'/demo/site-settings.json',
            'local_import_customizer_file' => trailingslashit(get_template_directory()).'/demo/atrevescustomizer.dat',        
            'import_preview_image_url'   => get_template_directory_uri().'/demo/screenshot.png',
        ),                
    );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );

/**
 * [ocdi_after_import_setup description]
 * @return [type] [description]
 */
function ocdi_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'main-menu' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php'))
    {
        do_action('akd_elementor_global');
    }

}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );
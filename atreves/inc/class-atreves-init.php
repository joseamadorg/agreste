<?php
/**
 * theme init class
 * */
if (!defined('ABSPATH')){
	exit(); //exit if access directly
}

if (!class_exists('Atreves_Init')){

	class Atreves_Init{

		private static $instance;

		public function __construct() {
			//theme setup
			add_action( 'after_setup_theme', array($this,'theme_setup') );
			//widget init
			add_action( 'widgets_init', array($this,'widgets_init' ));
			//theme assets
			add_action('wp_enqueue_scripts',array($this,'theme_assets'));
		}

		public static function getInstance(){
			if (null == self::$instance){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function theme_setup(){
		 /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on atreves, use a find and replace
		 * to change 'atreves' to the name of your theme in all the template files.
		 */
			load_theme_textdomain( 'atreves', get_template_directory() . '/languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );
			
			/**
			 * Registers an editor stylesheet for the theme.
			 */
			function atreves_theme_add_editor_styles() {
				add_editor_style( 'custom-style.css' );
			}
			add_action( 'admin_init', 'atreves_theme_add_editor_styles' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support( 'post-thumbnails' );
			
			//Custom image size
			add_image_size('atreves-main-blog', 780, 450, true);
			add_image_size('atreves-blog', 336, 207, true);

			// This theme uses wp_nav_menu() in one location.
			register_nav_menus( array(
				'main-menu' => esc_html__( 'Primary Menu', 'atreves' ),
			) );
			
			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );

			// Set up the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'atreves_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
			) ) );

			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for core custom logo.
			 *
			 * @link https://codex.wordpress.org/Theme_Logo
			 */
			add_theme_support( 'custom-logo', array(
				'height'      => 180,
				'width'       => 42,
				'flex-width'  => true,
				'flex-height' => true,
			) );
			
			add_theme_support( 'custom-header' );
			
			// This variable is intended to be overruled from themes.
			// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
			$GLOBALS['content_width'] = apply_filters( 'atreves_content_width', 640 );

			//post formats
			add_theme_support('post-formats', array('image', 'audio', 'video', 'quote', 'link', 'gallery', 'chat', 'aside', 'status'));

			//load theme dependency files
			self::include_files();
		}

		/**
		 * widgets_init
		 * @since 1.0.0
		 * */
		public function widgets_init(){

			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar', 'atreves' ),
				'id'            => 'right-sidebar',
				'description'   => esc_html__( 'Add widgets here.', 'atreves' ),
				'before_widget' => '<div id="%1$s" class="widget blog-sidebar widget-2 %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title widgettitle">',
				'after_title'   => '</h5>',
			) );

			$enable_footer_widgets = get_theme_mod('atreves_enable_footer_widgets', true);
			if($enable_footer_widgets == true){
				register_sidebar( array(
					'name'          => esc_html__( 'Footer Widget Area One', 'atreves' ),
					'id'            => 'footer-widget-1',
					'description'   => esc_html__( 'Add Footer  widgets here.', 'atreves' ),
					'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				) );			

				register_sidebar( array(
					'name'          => esc_html__( 'Footer Widget Area Two', 'atreves' ),
					'id'            => 'footer-widget-2',
					'description'   => esc_html__( 'Add Footer widgets here.', 'atreves' ),
					'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				) );			

				register_sidebar( array(
					'name'          => esc_html__( 'Footer Widget Area Three', 'atreves' ),
					'id'            => 'footer-widget-3',
					'description'   => esc_html__( 'Add Footer widgets here.', 'atreves' ),
					'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				) );			

				register_sidebar( array(
					'name'          => esc_html__( 'Footer Widget Area Four', 'atreves' ),
					'id'            => 'footer-widget-4',
					'description'   => esc_html__( 'Add Footer widgets here.', 'atreves' ),
					'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				) );
			}

			register_sidebar( array(
				'name'          => esc_html__( 'Footer Menu Widget', 'atreves' ),
				'id'            => 'footer-menu',
				'description'   => esc_html__( 'Add Footer widgets here.', 'atreves' ),
				'before_widget' => '<div id="%1$s" class="footer-menu widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );
		}
		

		public function include_files(){

			$includes_files = array(
				
				
				array(
					'file-name' => 'comments-modification',
					'file-path' => ATREVES_INC
				),
			
				array(
					'file-name' => 'theme-inline-styles',
					'file-path' => ATREVES_THEME_STYLESHEETS
				),
			);

			if (is_array($includes_files) && !empty($includes_files)){
				foreach ($includes_files as  $file){
					if (file_exists( $file['file-path'].'/'. $file['file-name'].'.php')){
						require_once $file['file-path'].'/'. $file['file-name'].'.php';
					}
				}
			}
		}

		public function theme_assets(){
			self::theme_css();
			self::theme_js();
		}
	
		/*
		*atreves load font
		*/
	   	public static function  atreves_fonts_url() {
	        $font_url = '';
	        if ( 'off' !== esc_html_x( 'on', 'Google font: on or off', 'atreves' ) ) :
	            $font_url = add_query_arg(
	                array(
	                    'family' => urlencode( 'Raleway:300,400,500,600|Raleway:600,700&display=swap' ),
	                ), "//fonts.googleapis.com/css" );
	        endif;
	        return apply_filters( 'atreves_google_font_url', esc_url( $font_url ) );
	    }
		
		public function theme_css(){
			
			$ver = ATREVES_VERSION;
			$includes_css = array(

				array(
					'handle' => 'atreves-font',
					'src' => self::atreves_fonts_url(),
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				array(
					'handle' => 'animate',
					'src' => ATREVES_CSS .'/animate.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				array(
					'handle' => 'bootstrap',
					'src' => ATREVES_CSS .'/bootstrap.min.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				
				array(
					'handle' => 'font-awesome',
					'src' => ATREVES_CSS .'/font-awesome.min.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				array(
					'handle' => 'jquery-ui',
					'src' => ATREVES_CSS .'/jquery-ui.min.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				array(
					'handle' => 'magnific-popup',
					'src' => ATREVES_CSS .'/magnific-popup.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				array(
					'handle' => 'nice-select',
					'src' => ATREVES_CSS .'/nice-select.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				),
				array(
					'handle' => 'slick',
					'src' => ATREVES_CSS .'/slick.css',
					'deps' => array(),
					'ver' => $ver,
					'media' => 'all'
				)
			);

			if (is_array($includes_css) && !empty($includes_css)){
				foreach ($includes_css as  $css){
					call_user_func_array('wp_enqueue_style',$css);
				}
			}

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			wp_enqueue_style( 'atreves-style', get_stylesheet_uri());
		}
		
		public function theme_js(){
			// all js files
			wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '1.5.9', true );
			wp_enqueue_script( 'wow-js', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), '1.1.3', true );
			wp_enqueue_script( 'waypoint-js', get_template_directory_uri() . '/assets/js/waypoints.min.js', array('jquery'), '4.0.1', true );
			wp_enqueue_script( 'magnific-js', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '1.6.2', true );
			wp_enqueue_script( 'imgloaded-js', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array('jquery'), '4.1.4', true );
			wp_enqueue_script( 'slick-animation', get_template_directory_uri() . '/assets/js/slick-animation.js', array('jquery'), '1.6.2', true );
			wp_enqueue_script( 'vendor', get_template_directory_uri() . '/assets/js/vendor.js', array('jquery'), '1.6.2', true );
			wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), time(), true );
		}
	}//end class

	if (class_exists('Atreves_Init')){
		Atreves_Init::getInstance();
	}
}
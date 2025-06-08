<?php
/**
 * atreves functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package atreves
 */
 
/**
 * Define Const for theme Dir
 * @since 1.0.0
 * */
define('ATREVES_ROOT_PATH',get_template_directory());
define('ATREVES_ROOT_URL',get_template_directory_uri());
define('ATREVES_CSS',ATREVES_ROOT_URL .'/assets/css');
define('ATREVES_JS',ATREVES_ROOT_URL .'/assets/js');
define('ATREVES_IMG',ATREVES_ROOT_URL .'/assets/img');
define('ATREVES_INC',ATREVES_ROOT_PATH .'/inc');
define('ATREVES_THEME_STYLESHEETS',ATREVES_INC .'/theme-stylesheets');

require_once(__DIR__ . '/welcome.php');

/**
 * define theme info
 * @since 1.0.0
 * */
if (is_child_theme()){
	$theme = wp_get_theme();
	$parent_theme = $theme->Template;
	$theme_info = wp_get_theme($parent_theme);
}else{
	$theme_info = wp_get_theme();
}
define('ATREVES_DEV_MODE',true);
$gazania_version = ATREVES_DEV_MODE ? time() : $theme_info->get('Version');
define('ATREVES_NAME',$theme_info->get('Name'));
define('ATREVES_VERSION',$gazania_version);
define('ATREVES_AUTHOR',$theme_info->get('Author'));
define('ATREVES_AUTHOR_URI',$theme_info->get('AuthorURI'));

/*
 * include template helper function
 * @since 1.0.0
 * */
if (file_exists(ATREVES_INC.'/template-functions.php') && ATREVES_INC.'/template-tags.php'){
	require_once  ATREVES_INC.'/template-functions.php';
	require_once  ATREVES_INC.'/template-tags.php';

	function Atreves_Function($instance){
		$new_instance = false;
		switch ($instance){
			case ("Functions"):
				$new_instance = class_exists('Atreves_Functions') ? Atreves_Functions::getInstance() : false;
				break;
			case ("Tags"):
				$new_instance = class_exists('Atreves_Tags') ? Atreves_Tags::getInstance() : false;
				break;
			default:
				 $new_instance = false;
			break;
		}

		return $new_instance;
	}
}



/*
* Include theme init file
* @since 1.0.0
*/
if ( file_exists(ATREVES_INC.'/class-atreves-init.php' ) ) {
	require_once  ATREVES_INC.'/class-atreves-init.php';
}

if ( file_exists(ATREVES_INC.'/plugins/tgma/activate.php') ) {
	require_once  ATREVES_INC.'/plugins/tgma/activate.php';
}		

/**
 * Custom template helper function for this theme.
 */
require_once ATREVES_INC . '/template-helper.php';
require_once ATREVES_INC . '/atreves_customizer.php';
require_once ATREVES_INC . '/atreves_customizer_data.php';



// Move comments textarea to bottom
function gazania_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'gazania_move_comment_field_to_bottom' );


/**
 * Nav menu fallback function
 * @since 1.0.0
 */
 function atreves_primary_menu_fallback()
{
    get_template_part('template-parts/default', 'menu');
}


function atreves_block_editor_styles() {
	wp_enqueue_style( 'block-editor-bootstrap', get_theme_file_uri( 'assets/css/block-editor.bootstrap.css' ), array(), null );
	wp_enqueue_style( 'block-editor-theme', get_theme_file_uri( 'assets/css/block-editor.theme.css' ), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'atreves_block_editor_styles', 1, 1 );

/**
* admin js
**/
add_action('admin_enqueue_scripts', 'atreves_admin_custom_scripts');
function atreves_admin_custom_scripts(){
	wp_enqueue_media();
	wp_register_script('atreves-admin-custom', get_template_directory_uri().'/inc/js/admin_custom.js', array('jquery'), '', true);
	wp_enqueue_script('atreves-admin-custom');
}


/**
* shortcode supports for removing extra p, spance etc
*
*/
add_filter( 'the_content', 'atreves_shortcode_extra_content_remove' );
/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 */
function atreves_shortcode_extra_content_remove( $content ) {

    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr( $content, $array );

}


/**
 * Nav menu fallback function
 * @since 1.0.0
 */
 function atreves_theme_fallback_menu()
{
    get_template_part('template-parts/default', 'menu');
}


/**
 * Atreves CSS Include
 */
function enqueue_our_required_stylesheet(){
	wp_enqueue_style('load-fa-pro', get_template_directory_uri(). '/assets/fonts/fontawesome-pro-v5.css');
	wp_enqueue_style('load-fa', get_template_directory_uri(). '/assets/fonts/fontawesome-v6.css');
	wp_enqueue_style('plusjakarta-font', get_template_directory_uri() . '/assets/fonts/plusjakarta-font.css' );
	wp_enqueue_style('inter-font', get_template_directory_uri() . '/assets/fonts/inter-font.css' );
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style('atreves-owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css' );
	wp_enqueue_style('popups', get_template_directory_uri() . '/assets/css/magnific-popup.css' );
	wp_enqueue_style('atreves-style-css', get_template_directory_uri() . '/assets/css/atreves.css' );
	wp_enqueue_style('atreves-responsive-css', get_template_directory_uri() . '/assets/css/atreves-responsive.css' );
	
}
add_action( 'wp_enqueue_scripts', 'enqueue_our_required_stylesheet' );


/**
 * Atreves CSS Include In Footer
 */
function add_css_in_footer() {
	?>
	<link rel='stylesheet' href='<?php echo esc_url( get_template_directory_uri() . '/assets/css/style.css' ); ?>' type='text/css'>
    <link rel='stylesheet' href='<?php echo esc_url( get_template_directory_uri() . '/assets/css/responsive.css' ); ?>' type='text/css'>
	<?php
}
add_action( 'wp_footer', 'add_css_in_footer', 100 );

function enqueue_theme_styles() { 
	wp_register_style( 'header-style', ATREVES_CSS . '/style.css', array(), time(), 'all' ); 
	wp_register_style( 'responsive', ATREVES_CSS . '/responsive.css', array(), time(), 'all' ); 
	
	wp_enqueue_style( 'header-style' ); 
	wp_enqueue_style( 'responsive' ); 
	} 
	add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );

	/**
	 * Framwork redux
	*/
	require_once (get_template_directory() . '/inc/options/function.options.php');


/**
 * Atreves JS Include
 */
function enqueue_load_js() {
	wp_enqueue_script( 'jquery.slicknav', get_template_directory_uri() . '/assets/js/jquery.slicknav.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'slider', get_template_directory_uri() . '/assets/js/slider.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'owl_crousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'owl_crousel_min', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'video-popup-js', get_template_directory_uri() . '/assets/js/video-popup.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'video-section-js', get_template_directory_uri() . '/assets/js/video-section.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'bootstrap.min', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'custom-js', 'RepayAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'HOME_URL'=> home_url() ));  
}
add_action( 'wp_enqueue_scripts', 'enqueue_load_js' );


  
	  
/**
 * Function For Elementor Global Colors after import.
 */
add_action('atreves_elementor_global', 'atreves_elementor_global_setup');
function atreves_elementor_global_setup()
{
    $atreves_elementor_kit = apply_filters('atreves_elementor_global', false);
    if ($atreves_elementor_kit)
    {
        esc_attr($atreves_elementor_kit);
    }
}

/**
 * Get Elementor Template list
 */
function atreves_get_elementor_templates()
{
    $args = array(
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
		'posts_per_page' => -1,

    );
    $atreves_the_query = new WP_Query($args);
    $atreves_elementor_posts = array();
    if ($atreves_the_query->have_posts()):
        foreach ($atreves_the_query->posts as $atreves_post):
            $atreves_elementor_posts[$atreves_post->ID] = apply_filters('the_title', get_the_title($atreves_post));
        endforeach;
    endif;
    return $atreves_elementor_posts;
}

// Add support for featured image
add_theme_support( 'post-thumbnails' );

// Add product title in Woocoomerce single product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
function woocommerce_template_single_title_custom()
{
    the_title( '<h3 class="product_title entry-title">',' </h3>' );
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title_custom', 5);


/**
 * Get Elementor Template list
 */


function atreves_get_elementor_header_templates()
{	
	$args = array(
		'post_type' => 'elementor_library',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'elementor_library_category',
				'field' => 'slug',
				'terms' => 'header',
			),
		),
	);
	
	$query = new WP_Query( $args );
	$atreves_header_templates = array();
	if ( $query->have_posts() ) {
		foreach ($query->posts as $atreves_post):
            $atreves_header_templates[$atreves_post->ID] = apply_filters('the_title', get_the_title($atreves_post));
        endforeach;
	}
	return $atreves_header_templates;	
}

// Preloader Customizer Section
function add_preloader_customizer_section( $wp_customize ) {
    $wp_customize->add_section( 'preloader_section', array(
        'title' => __( 'Preloader', 'atreves' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'show_preloader', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    $wp_customize->add_control( 'show_preloader', array(
        'type' => 'checkbox',
        'label' => __( 'Show Preloader', 'atreves' ),
        'section' => 'preloader_section',
    ) );
}
add_action( 'customize_register', 'add_preloader_customizer_section' );


//Banner Hide/Show Option
add_action( 'elementor/element/wp-page/document_settings/after_section_end', function( $element, $args ) {
	$element->start_controls_section(
		'section_page_settings',
		[
			'label' => __( 'Banner Settings', 'atreves' ),
			'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
		]
	);
	$element->add_control(
		'banner_display',
		[
			'label' => __( 'Hide Banner', 'atreves' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'Show',
			'label_on' => __( 'Show', 'atreves' ),
			'label_off' => __( 'Hide', 'atreves' ),
		]
	);
	$element->end_controls_section();
}, 10, 2 );


// Function to get options for the Elementor templates dropdown
function get_elementor_template_options() {
    $templates = get_posts([
        'post_type'      => 'elementor_library',
        'posts_per_page' => -1,
    ]);
    $options = [];
    foreach ($templates as $template) {
        $options[$template->ID] = $template->post_title;
    }
    return $options;
}

add_action('elementor/element/wp-page/document_settings/after_section_end', 'add_elementor_template_dropdown', 10, 2);

function add_elementor_template_dropdown($element, $args) {
    // Footer settings
    $atreves_footer_e = get_theme_mod('choose_elementor_footer');
    $element->start_controls_section(
        'page_footer_settings',
        [
            'label' => __('Footer Settings', 'atreves'),
            'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
        ]
    );
    $element->add_control(
        'page_footer_display',
        [
            'label' => __('Show Footer', 'atreves'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __('Show', 'atreves'),
            'label_off' => __('Hide', 'atreves'),
        ]
    );
    $element->add_control(
        'choose_elementor_page_footer',
        [
            'label' => __('Show Templates', 'atreves'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => get_elementor_template_options(),
            'transport' => 'refresh',
            'default' => $atreves_footer_e,
            'condition' => [
                'page_footer_display' => 'yes',
            ]
        ]
    );
    $element->end_controls_section();

    // Header settings
    $atreves_header_e = get_theme_mod('choose_elementor_header');
    $element->start_controls_section(
        'page_header_settings',
        [
            'label' => __('Header Settings', 'atreves'),
            'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
        ]
    );
    $element->add_control(
        'page_header_display',
        [
            'label' => __('Show Header', 'atreves'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __('Show', 'atreves'),
            'label_off' => __('Hide', 'atreves'),
        ]
    );
    $element->add_control(
        'choose_elementor_page_header',
        [
            'label' => __('Show Templates', 'atreves'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => get_elementor_template_options(),
            'transport' => 'refresh',
            'default' => $atreves_header_e,
            'condition' => [
                'page_header_display' => 'yes',
            ]
        ]
    );
    $element->end_controls_section();
}

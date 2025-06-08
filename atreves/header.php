<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
$style = '';
$is_preloader = get_theme_mod('show_preloader');

if($is_preloader){
    if(isset($_GET['elementor-preview'])){
        ?>
        <div id='preloader' class='preloader' style="display:none;">
        <?php
    }
    else{
        ?>
        <div id='preloader' class='preloader' >
        <?php
    }
?>

    <div class="preloader-inner">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
</div>
<?php
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Function to check if the page is being viewed in the Elementor editor
        function isElementorEditor() {
            return (
                window.location.href.indexOf("elementor") !== -1 &&
                document.querySelector(".elementor-editor-active") !== null
            );
        }
  
        // Hide the preloader if the page is viewed in the Elementor editor
        if (isElementorEditor()) {
            document.getElementById("preloader").style.display = "none";
        }
    });
</script>
<a id="backtotop"></a>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'atreves'); ?></a>
    <?php
    $current_page_id = get_queried_object_id();
    $elementor_document=null;
    // Get Elementor settings for the current page
    if (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))) :
    $elementor_document = \Elementor\Plugin::$instance->documents->get($current_page_id);
    endif;
    if ($elementor_document) {
        $page_settings = $elementor_document->get_settings();
        $show_page_header = !empty($page_settings['page_header_display']);
        $chosen_elementor_page_header = $page_settings['choose_elementor_page_header'] ?? '';
    } else {
        $show_page_header = false;
        $chosen_elementor_page_header = '';
    }

    // Get global header settings from the customizer
    $default_header = get_theme_mod('choose_default_header', 'default-header');
    $global_elementor_header = get_theme_mod('choose_elementor_header', '');
    ?>
    <div class="body-overlay" id="body-overlay"></div>
    <div class="search-popup" id="search-popup">
        <?php get_search_form(); ?>  
    </div>
    <?php
    // Determine which header to display
    if ($show_page_header && !empty($chosen_elementor_page_header)) {
        // Display the Elementor page-specific header
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($chosen_elementor_page_header);
    } elseif ($default_header === 'elementor-header' && !empty($global_elementor_header)) {
        // Display the global Elementor header set in the customizer
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($global_elementor_header);
    } else {
        // Fallback to the default header
        ?>
        <header id="masthead" class="site-header">
            <!-- Your default header HTML here -->
            <nav class="navbar navbar-area navbar-expand-lg nav-transparent">
                <div class="container nav-container nav-white">
                    <div class="responsive-mobile-menu">
                        <div class="logo">
                            <?php echo atreves_header_logo(); ?>
                        </div>
                        <button class="s7t-header-menu toggle-btn d-block d-lg-none" data-toggle="collapse" data-val="0" data-target="#atreves_main_menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation','atreves'); ?>">
                            <span class="icon-left"></span>
                            <span class="icon-right"></span>
                        </button>
                    </div>
                    <?php wp_nav_menu(array(
                        'menu' => 'primary-menu',
                        'theme_location' => 'main-menu',
                        'menu_class' => 'navbar-nav',
                        'container' => 'div',
                        'container_class' => 'collapse navbar-collapse',
                        'container_id' => 'atreves_main_menu',
                        'fallback_cb' => 'atreves_theme_fallback_menu',
                    )); ?>
                    <a class='nav-link talk_btn' href='<?php echo esc_url( home_url( '/contact' ) ); ?>'>Contact <i class='fa-solid fa-arrow-right'></i></a>
                </div>
            </nav>
        </header>
        <?php
    }
    ?>
    <div id="content" class="site-content">
        <?php do_action('atreves_before_main_content'); ?>

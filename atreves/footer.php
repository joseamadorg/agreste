<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package atreves
 */
?>  

<?php
$current_page_id = null; // Initialize the variable

if (have_posts()) {
    while (have_posts()) {
        the_post(); // Ensure proper context
    }

    // Get the current page ID
    $current_page_id = get_the_ID();
}

$atreves_footer_e = get_theme_mod('choose_elementor_footer'); // Retrieve the default footer setting
$use_elementor_footer = false; // Flag to determine if Elementor footer is used

if (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if ($current_page_id) {
        // Get Elementor settings for the current page
        $elementor_document = \Elementor\Plugin::$instance->documents->get($current_page_id);

        // Default footer
        $page_footer = $atreves_footer_e;

        // Check if it's a valid Elementor document and if there's a footer set via Elementor settings
        if ($elementor_document instanceof \Elementor\Core\DocumentTypes\Page) {
            $page_settings = $elementor_document->get_settings();
            
            $show_page_footer = $page_settings['page_footer_display'] ?? false;
            $chosen_elementor_page_footer = $page_settings['choose_elementor_page_footer'] ?? null;
            
            if ($show_page_footer && !empty($chosen_elementor_page_footer)) {
                $page_footer = $chosen_elementor_page_footer;
            }

            // Display the correct footer content based on Elementor settings
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($page_footer);
            $use_elementor_footer = true; // Elementor footer is being used
        } else {
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($atreves_footer_e);
            $use_elementor_footer = true; // Elementor footer is being used
        }
    } else {
        // Display the default footer content if no valid post ID is found
        echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($atreves_footer_e);
        $use_elementor_footer = true; // Elementor footer is being used
    }
}

// Only call atreves_footer_style action if Elementor footer is not used
if (!$use_elementor_footer) {
    do_action('atreves_footer_style');
}
?>

</div><!-- #page -->

<?php 
wp_footer(); 
?>
</body>
</html>

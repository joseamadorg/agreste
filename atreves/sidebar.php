<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Atreves
 */
if ( ! is_active_sidebar( 'right-sidebar' ) ) {
	return;
}
?>
<aside class="sidebar-area sidebar-right">
	<?php dynamic_sidebar( 'right-sidebar' ); ?>
</aside><!-- #secondary -->

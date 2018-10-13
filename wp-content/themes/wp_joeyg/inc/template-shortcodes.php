<?php
/**
 * Shortcodes that modify the editor bar to wrap CMS content
 */





/**
 * Adds a horizontal slideshow scroller wrapper around content
 */
function wpjg_scroller_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'bg-color' => 'grey',
		'class' => 'contain'
	), $atts, 'scroller' );
	$scrollArrows = '';
	return '<div class="wpsc scroller '.$atts['class'].'" style="background-color: '.$atts['bg-color'].'">' . $scrollArrows . '<div class="deck">'.$content.'</div></div>';
}
add_shortcode( 'scroller', 'wpjg_scroller_shortcode' );





/**
 * Adds image block wrappers around the content
 */
function wpjg_image_block_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'contain'
	), $atts, 'image_block' );
	return '<div class="wpsc image-block '.$atts['class'].'"><div class="inner">'.do_shortcode($content).'</div></div>';
}
add_shortcode('image_block', 'wpjg_image_block_shortcode');





/**
 * Adds columns wrap to post content
 * @atts => count
 */
function wpjg_column_wrap_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'count' => '2',
		'class' => 'contain'
	), $atts, 'column_wrap');
	return '<div class="wpsc sc-column-wrap count-'.$atts['count'].' '.$atts['class'].'">' . do_shortcode($content) . '</div>';
}
add_shortcode('column_wrap', 'wpjg_column_wrap_shortcode');





/**
 * Wraps individual columns
 */
function wpjg_column_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'default',
		'span' => '1'
	), $atts, 'column');
	return '<div class="wpsc sc-column '.$atts['class'].' span-'.$atts['span'].'">' . do_shortcode($content) . '</div>';
}
add_shortcode('column', 'wpjg_column_shortcode');





/**
 * makes a window block at a defined height
 */
function wpjg_viewport_block_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'full',
	), $atts, 'viewport');
	return '<div class="wpsc viewport-window '.$atts['class'].'">' . do_shortcode($content) . '</div>';
}
add_shortcode('viewport', 'wpjg_viewport_block_shortcode');





/**
 * wraps a nav element around content
 */
function wpjg_nav_wrap_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'nav-default',
	), $atts, 'image_block');
	return '<nav class="wpsc '.$atts['class'].'">'.$content.'</nav>';
}
add_shortcode('nav', 'wpjg_nav_wrap_shortcode');





/**
 * Adds view fullscreen image link
 */
function wpjg_view_fullscreen_image_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'bg-color' => '#ffffff',
		'view' => '0',
		'class' => '',
	), $atts, 'fullscreen');
	return '<div class="wpsc btn-fullscreen-wrap ' . $atts['class'] . '"><button class="btn btn-fullscreen"
				data-view="' . $atts['view'] . '"
				data-bg-color="' . $atts['bg-color'] . '">'.$content.'</button></div>';
}
add_shortcode('fullscreen', 'wpjg_view_fullscreen_image_shortcode');





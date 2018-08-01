<?php
/**
 * Shortcodes that modify the editor bar to wrap CMS content
 */





/**
 * Adds a horizontal slideshow scroller wrapper around content
 */
function wp_gridinator_scroller_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'bg-color' => 'grey'
	), $atts, 'scroller' );
	$scrollArrows = '<div class="scroller-arrows"><i class="fa fa-angle-double-left"></i><span></span><i class="fa fa-angle-double-right"></i></div>';
	return '<div style="background-color: '.$atts['bg-color'].'" class="scroller">' . $scrollArrows . '<div class="deck">'.$content.'</div></div>';
}
add_shortcode( 'scroller', 'wp_gridinator_scroller_shortcode' );





/**
 * Adds image block wrappers around the content
 */
function wp_gridinator_image_block_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'image-block',
		'type' => 'full'
	), $atts, 'image_block' );
	return '<div class="'.$atts['class'].' '.$atts['type'].'"><div class="inner">'.do_shortcode($content).'</div></div>';
}
add_shortcode('image_block', 'wp_gridinator_image_block_shortcode');





/**
 * wraps a nav element around content
 */
function wp_gridinator_nav_wrap_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'nav-default',
	), $atts, 'image_block');
	return '<nav class="'.$atts['class'].' '.$atts['type'].'">'.$content.'</nav>';
}
add_shortcode('nav', 'wp_gridinator_nav_wrap_shortcode');





/**
 * Adds view fullscreen image link
 */
function wp_gridinator_view_fullscreen_image_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'view' => '0'
	), $atts, 'fullscreen');
	return '<button class="btn btn-fullscreen"
				data-bind="click"
				data-event="fullscreen"
				data-view="' . $atts['view'] . '">'.$content.'</button>';
}
add_shortcode('fullscreen', 'wp_gridinator_view_fullscreen_image_shortcode');





/**
 * Adds columns wrap to post content
 * @atts => count
 */
function wp_gridinator_column_wrap_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'count' => '2',
		'class' => '',
	), $atts, 'column_wrap');
	return '<div class="sc-column-wrap count-'.$atts['count'].' '.$atts['class'].'">' . do_shortcode($content) . '</div>';
}
add_shortcode('column_wrap', 'wp_gridinator_column_wrap_shortcode');





/**
 * Wraps individual columns
 */
function wp_gridinator_column_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
		'class' => 'default',
		'span' => '1'
	), $atts, 'column');
	return '<div class="sc-column '.$atts['class'].' span-'.$atts['span'].'">' . do_shortcode($content) . '</div>';
}
add_shortcode('column', 'wp_gridinator_column_shortcode');





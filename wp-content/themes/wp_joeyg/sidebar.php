<?php
/**
 * sidebar widget area
 */

if ( ! is_active_sidebar( 'sidebar-widgets' ) ) {
	return;
}
?>

<aside id="site-widgets" class="sidebar-widgets">
	<div class="widget-inner">
		<?php dynamic_sidebar( 'sidebar-widgets' ); ?>
	</div>
</aside>

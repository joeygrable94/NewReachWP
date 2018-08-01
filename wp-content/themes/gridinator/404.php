<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header();
?>

	<header class="page-header header-404">
		<h1 class="page-title">ERROR: <?php esc_html_e( 'page not found', 'wp_gridinator' ); ?></h1>
	</header><!-- .page-header -->

	<div class="grid-404-content">
		<h2 class="text-404">404</h2>
		<p>It looks like nothing was found at this location.</br>Try one of the links below or searching again?</p>
	</div><!-- .page-content -->

<?php
get_sidebar();
get_footer();

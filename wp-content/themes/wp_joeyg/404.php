<?php
/**
 * 404 NOT FOUND
 */

get_header();
?>

	<header id="page-header" class="page-404">
		<h1 class="page-title">ERROR:<br><?php esc_html_e( 'page not found', 'wp_gridinator' ); ?></h1>
	</header>

	<section id="page-404">
		<h2 class="text-404">404</h2>
		<p>It looks like nothing was found.</br>Try searching again or click one of the links below.</p>
	</section>

<?php
get_sidebar();

get_footer();

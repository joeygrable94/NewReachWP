<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WP_Gridinator
 */

get_header();

if ( have_posts() ) : ?>

	<header class="page-header header-search">
		<h1 class="page-title search terms"><?php /* translators: %s: search query. */
			printf( esc_html__( 'SEARCHED: %s', 'wp_gridinator' ), '<span>' . get_search_query() . '</span>' ); ?>
		</h1>
	</header><!-- .page-header -->

<?php

	/* Start the Loop */
	while ( have_posts() ) :

		the_post();

		/**
		 * Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called content-search.php and that will be used instead.
		 */
		get_template_part( 'template-parts/content', 'search' );

	endwhile;

else :

	get_template_part( 'template-parts/content', 'none' );

endif;
		
get_sidebar();
get_footer();

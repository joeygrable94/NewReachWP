<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

	<header class="page-header header-page-single">
		<?php echo the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

<?php
/* Start the Loop */
while ( have_posts() ) :
	
	the_post();

	get_template_part( 'template-parts/content', 'page' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
	
		comments_template();
	
	endif;

endwhile; // End of the loop.

get_sidebar();
get_footer();

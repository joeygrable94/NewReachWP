<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

	<header class="page-header header-posts-multp header-posts-category">
		<?php $page_name = get_queried_object()->name;
		if ($page_name) { echo "<h1>Category: ".$page_name."</h1>"; } ?>
	</header><!-- .page-header -->

<?php
# POSTS
if (have_posts()):

	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		# modular grid
		echo '<div class="post-category">';
		get_template_part( 'template-parts/content', 'featured' );
		echo '</div>';

	endwhile;

# NO POSTS
else:

	get_template_part( 'template-parts/content', 'none' );

endif;

get_sidebar();
get_footer();

<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

	<header class="page-header header-posts-multp">
		<?php single_post_title('<h1 class="entry-title">', '</h1>'); ?>
	</header><!-- .page-header -->

<?php
# POSTS
if (have_posts()):

	# SINGLE
	if (is_singular()): the_post();
		get_template_part('template-parts/content', 'post');

	# MULTIPLE
	else:

		# FEATURED
		$featured_query = new WP_Query(array( 'meta_key' => 'meta-checkbox-featured-post', 'meta_value' => '1' ));
		if ($featured_query->have_posts()) :

			# split layout
			echo '<div class="post-featured">';
			while ($featured_query->have_posts()):
				$featured_query->the_post();
				$do_not_duplicate[] = $post->ID;
				get_template_part('template-parts/content', 'featured');
			endwhile;
			echo '</div>';

		endif;
		
		# OTHER
		query_posts(array( 'post__not_in' => $do_not_duplicate ));
		if (have_posts()):

			# modular grid
			echo '<div class="post-modular">';
			while (have_posts()) : the_post();
				get_template_part('template-parts/content', 'modular');
			endwhile;
			echo '</div>';

		endif;

	endif;

# NO POSTS
else:

	get_template_part( 'template-parts/content', 'none' );

endif;

get_sidebar();
get_footer();

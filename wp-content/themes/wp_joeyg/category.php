<?php
/**
 * all categories (post template: default)
 * 
 * visual-design, brand-identity, web-development, books-and-calligraphy
 */

get_header();
?>

	<header id="page-header">
		<?php # $page_name = get_queried_object()->name; if ($page_name) { echo '<h1 class="page-title">'.$page_name.'</h1>'; } ?>
		<h1 class="page-title">Category</h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>

<?php
# POSTS

	// get categories
	$categories = get_the_category();
	$category_slug = $categories[0]->slug;
	
	// get featured posts
	$featured_query = new WP_Query(array(
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $category_slug,
		'meta_key' => 'meta-checkbox-featured-post',
		'meta_value' => '1'
	));
	if ($featured_query->have_posts()) {
		echo '<h2 class="content-section-title">My Finest Work:</h2>';
		echo '<div id="content-post-featured" class="content-block">';
		while ($featured_query->have_posts()) {
			$featured_query->the_post();
			get_template_part('template-parts/content', 'featured');
		}
		echo '</div>';
	}

	// reset the WP_Query
	wp_reset_postdata();

	// get other posts
	$modular_query = new WP_Query(array(
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $category_slug,
		'meta_key' => 'meta-checkbox-featured-post',
		'meta_value' => '0'
	));
	if ($modular_query->have_posts()) {
		if ($featured_query->have_posts()) {
			echo '<h2 class="content-section-title">More Exceptional Projects:</h2>';
		} else {
			echo '<h2 class="content-section-title">My finest work:</h2>';
		}
		echo '<div id="content-post-modular" class="content-block">';
		while ($modular_query->have_posts()) {
			$modular_query->the_post();
			get_template_part('template-parts/content', 'modular');
		}
		echo '</div>';
	}

get_sidebar();
get_footer();

<?php
/**
 * RESOURCES page
 */

get_header();
?>

	<header id="page-header">
		<h1 class="page-title"><?php echo the_title(); ?></h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>

	<div id="content-resource-search" class="content-block">
		<h2 class="content-section-title">Search for a Resource</h2>
		<?php get_template_part('template-parts/content', 'resource-search-form'); ?>
	</div>

<?php
while ( have_posts() ) :

	the_post();

	wpjg_search_resources_query();

endwhile;

get_sidebar();

get_footer();

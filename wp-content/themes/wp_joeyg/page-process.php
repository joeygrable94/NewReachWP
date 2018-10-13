<?php
/**
 * PROCESS page
 */

get_header();
?>

	<header id="blog-header">
		<h1 class="page-title"><?php echo the_title(); ?></h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>

<?php
while ( have_posts() ) :
	the_post();
	// get blog posts
	$process_query = new WP_Query(array(
		'orderby' => 'date',
		'order' => 'ASC',
		'category_name' => 'process',
		'category__not_in' => array('48')
	));
	if ($process_query->have_posts()) {
		echo '<div id="content-process-articles" class="content-block">';
		while ($process_query->have_posts()) {
			$process_query->the_post();
			get_template_part( 'template-parts/content', 'process' );
		}
		echo "</div>";
	}

endwhile;

get_sidebar();

get_footer();

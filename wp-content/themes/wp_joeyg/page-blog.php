<?php
/**
 * BLOG page
 */

get_header();
?>

	<header id="blog-header">
		<h1 class="page-title"><?php echo the_title(); ?></h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>

<?php
echo '<section id="content-blog-articles" class="content-block">';

while (have_posts()):
	the_post();
	// get blog posts
	$blog_query = new WP_Query(array(
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'blog'
	));
	if ($blog_query->have_posts()) {
		echo '<h2 class="content-section-title">Explore the experimental side to my work <i class="fa fa-hand-o-down" aria-hidden="true"></i></h2>';
		while ($blog_query->have_posts()) {
			$blog_query->the_post();
			get_template_part( 'template-parts/content', 'blog' );
		}
	}
endwhile;

echo '</section>';

get_sidebar();

get_footer();

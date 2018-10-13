<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

	<header id="page-header">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>

<?php

# POSTS
if (have_posts()):

	# SINGLE
	if (is_singular()):

		the_post();
		get_template_part('template-parts/content', 'post');

	# MULTIPLE
	else: ?>

		<!-- categories -->
		<section id="content-post-categories" class="content-block">
			<?php $cats = wpjg_gather_portfolio_categories();
			foreach (array_reverse($cats) as $index => $cat) { ?>
				<div class="category-block category-block-image bcat-<?php echo $cat->slug; ?>">
					<img class="cover" data-bind="click" data-event="linkTo" data-link="<?php echo get_category_link($cat->term_id); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $cat->slug; ?>.jpg">
				</div>
				<div class="category-block category-block-content">
					<h3 class="category-block-title">
						<?php echo $cat->name; ?>
					</h3>
					<p class=""><?php echo $cat->description; ?></p>
					<p><a href="<?php echo get_category_link($cat->term_id); ?>">view <?php echo strtolower($cat->name); ?> projects</a></p>
				</div>
			<?php } ?>
		</section>
		
		<!-- modular table -->
		<section id="content-post-modular" class="content-block">
			<h2 class="content-section-title">All Work:</h2>
			<?php echo wpjg_get_filtered_posts(); ?>
		</section>

	<?php endif;

# NO POSTS
else:

	get_template_part( 'template-parts/content', 'none' );

endif;

get_sidebar();
get_footer();

<?php
/**
 * Template part for displaying a SINGLE post
 *
 * @package WP_Gridinator
 */
?>

<article id="post-<?php the_ID(); ?>" class="post-single post-block">

	<!-- featured image -->
	<?php echo wp_gridinator_display_post_featured_image(); ?>

	<header class="entry-header">

		<!-- entry-title -->
		<?php if (is_singular()) { the_title('<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>'); } ?>

		<!-- entry-date -->
		<?php the_date('F Y', '<h3 class="entry-date">', '</h3>'); ?>
		
	</header>

	<!-- entry-content -->
	<main role="main" class="entry-content">

		<!-- entry-headline -->
		<?php if ( 'post' === get_post_type() && get_post_meta(get_the_ID(), 'headline', true) ) {
			echo '<h2 class="entry-headline">' . get_post_meta(get_the_ID(), 'headline', true) . '</h2>';
		} ?>
		
		<!-- entry-content -->
		<?php the_content(); ?>

	</main>

</article><!-- #post-<?php the_ID(); ?> -->
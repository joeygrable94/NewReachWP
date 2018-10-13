<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Gridinator
 */

?>
	
<?php if (is_singular()) : ?>
<!-- SINGLE POST -->

	<article id="post-<?php the_ID(); ?>" <?php post_class( array('grid-block', 'grid-post-single') ); ?>>

		<!-- featured image -->
		<?php echo wp_gridinator_display_post_featured_image(); ?>

		<header class="entry-header">

			<!-- entry-title -->
			<?php if (is_singular()) {
				the_title('<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>');
			} else {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} ?>

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

<?php else: ?>
<!-- MULTIPLE POSTS -->

	<div id="post-<?php the_ID(); ?>" class="grid-block grid-post-multp">
		<img class="gb-item entry-thumbnail"
			 src="<?php the_post_thumbnail_url(); ?>"
			 alt="<?php the_title_attribute(); ?>"
			 data-bind="click"
			 data-event="linkTo"
			 data-link="<?php the_permalink(); ?>"
		/>
		<div class="gb-item entry-content">
			<div class="inner-wrap">
				<!-- entry-title -->
				<?php if (is_singular()) {
					the_title('<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>');
				} else {
					the_title( '<h1 class="entry-title">', '</h1>' );
				} ?>
				<!-- entry-headline -->
				<?php if ( 'post' === get_post_type() ) { echo '<h2 class="entry-headline">' . get_post_meta(get_the_ID(), 'headline', true) . '</h2>'; } ?>
				<!-- entry-date -->
				<?php the_date('M Y', '<h3 class="entry-date">', '</h3>'); ?>
				<!-- entry-content -->
				<?php the_excerpt(); ?>
				<!-- read more -->
				<?php echo wp_gridinator_read_more_link(); ?>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php
/**
 * Template part for displaying page content in page.php
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array('grid-block', 'grid-page') ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
	<img class="entry-thumbnail" src="<?php the_post_thumbnail_url(); ?>"/>
	<?php endif; ?>

	<!-- entry-content -->
	<main role="main" class="entry-content <?php echo wp_gridinator_get_page_slug(); ?>">

		<!-- entry-headline -->
		<?php $postHeadline = get_post_meta(get_the_ID(), 'headline', true);
		if ( 'page' === get_post_type() && isset($postHeadline) ) {
			echo '<h2 class="entry-headline">' . $postHeadline . '</h2>';
		} ?>

		<?php the_content(); ?>
		
		<!-- page links -->
		<?php wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp_gridinator' ),
			'after'  => '</div>',
		)); ?>

	</main><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
	<footer class="entry-footer">
		<?php edit_post_link( sprintf( wp_kses(
		__( 'Edit <span class="screen-reader-text">%s</span>', 'wp_gridinator' ), array(
			'span' => array('class' => array(), ),
		)), get_the_title() ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
	<?php endif; ?>

</article>

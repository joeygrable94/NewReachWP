<?php
/**
 * SINGLE page
 */
?>

<article id="content-page-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-page') ); ?>>

	<header class="content-page-header">

		<?php if ( has_post_thumbnail() ) : ?>
		<img src="<?php the_post_thumbnail_url(); ?>"/>
		<?php endif; ?>

	</header>

	<main class="content-page-main" role="main">

		<!--<div class="content-page-main-meta">
			<?php #the_date('F Y', '<h4 class="content-page-date">', '</h4>'); ?>
			<?php #echo wpjg_post_categories(); ?>
		</div>-->

		<?php echo wpjg_post_headline(3); ?>

		<?php the_content(); ?>

	</main>

	<div class="content-page-links">
		<?php /* wp_link_pages(array(
			'before' => '<h3 class="content-links-title">' . esc_html__( 'Pages:', 'wp_gridinator' ),
			'after'  => '</h3>',
		)); */ ?>
	</div>

	<footer class="content-page-footer"></footer>

</article>

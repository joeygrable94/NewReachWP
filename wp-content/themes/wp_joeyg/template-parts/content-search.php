<?php
/**
 * SEARCH page results
 */
?>

<article id="content-post-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-search') ); ?>>

	<header class="content-post-header">
		<?php if ( has_post_thumbnail() ) : ?>
		<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>"
			 data-bind="click"
			 data-event="linkTo"
			 data-link="<?php the_permalink(); ?>" />
		<?php endif; ?>
	</header>

	<main class="content-post-main" role="main">

		<?php the_title( sprintf( '<h2 class="content-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php echo wpjg_post_headline(3); ?>

		<?php the_excerpt(); ?>
		
		<?php echo wpjg_read_more_link(); ?>

		<?php the_date('F Y', '<h4 class="content-post-date">', '</h4>'); ?>
	
		<?php echo wpjg_post_categories(); ?>

	</main>

	<footer class="content-post-footer"></footer>

</article>

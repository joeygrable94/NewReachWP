<?php
/**
 * MULTIPLE featured posts on the same page
 */
?>

<article id="content-post-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-featured') ); ?>>
	
	<header class="content-post-header"></header>

	<main class="content-post-main" role="main">

		<div class="content-post-main-image">
			<?php if ( has_post_thumbnail() ) : ?>
			<img class="content-post-thumbnail data-click" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>"
				 data-bind="click"
				 data-event="linkTo"
				 data-link="<?php the_permalink(); ?>" />
			<?php endif; ?>
		</div>

		<div class="content-post-main-meta">
			<?php echo wpjg_post_categories(); ?>
			<?php the_date('F Y', '<h4 class="content-post-date">', '</h4>'); ?>
		</div>

		<div class="content-post-main-excerpt">
			<?php the_title( sprintf( '<h2 class="content-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php echo wpjg_post_headline(3); ?>
			<?php echo the_excerpt(); ?>
			<?php echo wpjg_read_more_link(); ?>
		</div>

	</main>

	<footer class="content-post-footer"></footer>

</article>

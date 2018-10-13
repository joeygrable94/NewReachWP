<?php
/**
 * Template part for displaying MULTIPLE posts
 *
 * @package WP_Gridinator
 */
?>
	
<?php #wp_gridinator_display_featured_posts(); ?>

<div id="post-<?php the_ID(); ?>" class="post-block">
	<img class="gb-item entry-thumbnail" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>"
		 data-bind="click"
		 data-event="linkTo"
		 data-link="<?php the_permalink(); ?>" />
	<div class="gb-item entry-summary">
		<div class="inner-wrap">
			<!-- entry-title -->
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<!-- entry-headline -->
			<?php echo wp_gridinator_post_headline(); ?>
			
			<!-- entry-date -->
			<?php the_date('M Y', '<h3 class="entry-date">', '</h3>'); ?>
			
			<!-- entry-content -->
			<?php the_excerpt(); ?>
			
			<!-- read more -->
			<?php echo wp_gridinator_read_more_link(); ?>
		</div>
	</div>
</div>
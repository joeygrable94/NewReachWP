<?php
/**
 * Template part for displaying MULTIPLE posts
 */
?>
	
<?php #wp_gridinator_display_featured_posts(); ?>

<div id="post-<?php the_ID(); ?>" class="post-block">
	<img class="gb-item entry-thumbnail" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>"
		 data-bind="click"
		 data-event="linkTo"
		 data-link="<?php the_permalink(); ?>" />
	<div class="gb-item entry-summary">
		<!-- entry-title -->
		<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
		<!-- entry-headline -->
		<?php echo wp_gridinator_post_headline(4); ?>
		<!-- entry-date -->
		<?php the_date('M Y', '<h5 class="entry-date">', '</h5>'); ?>
		<!-- entry-content -->
		<?php the_excerpt(); ?>
		<!-- read more -->
		<?php echo wp_gridinator_read_more_link(); ?>
	</div>
</div>
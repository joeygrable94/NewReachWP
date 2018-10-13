<?php
/**
 * BLOG page
 */
?>

<a href="<?php the_permalink(); ?>">
<article id="content-post-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-blog') ); ?>>

	<main class="content-blog-main" role="main">

		<h2 class="content-blog-main-title"><?php echo get_the_title(); ?></h2>

		<?php echo wpjg_post_headline(3); ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<img class="content-blog-thumbnail" src="<?php the_post_thumbnail_url(); ?>" />
		<?php endif; ?>

		<div class="content-blog-main-meta">
			<?php the_date('F Y', '<h4 class="content-blog-date">', '</h4>'); ?>
		</div>

	</main>

</article>
</a>
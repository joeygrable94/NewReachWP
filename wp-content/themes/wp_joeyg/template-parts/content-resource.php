<?php
/**
 * RESOURCE page
 */
?>

<a href="<?php the_permalink(); ?>">
	<article id="content-process-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-resource') ); ?>>

		<header class="content-resource-header"></header>

		<main class="content-resource-main" role="main">
			<h2 class="content-resource-main-title"><?php the_title(); ?></h2>
			<?php echo wpjg_post_headline(5); ?>
		</main>

		<footer class="content-resource-footer">resource type</footer>

	</article>
</a>
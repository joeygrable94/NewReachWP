<?php
/**
 * PROCESS page
 */
?>

<a href="<?php the_permalink(); ?>">
<article id="content-process-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-process') ); ?>>

	<header class="content-process-header"></header>

	<main class="content-process-main" role="main">
		<h2 class="content-process-main-title"><?php the_title(); ?></h2>
		<?php echo wpjg_post_headline(5); ?>
	</main>

	<footer class="content-process-footer"></footer>

</article>
</a>
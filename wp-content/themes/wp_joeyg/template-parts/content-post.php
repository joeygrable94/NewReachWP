<?php
/**
 * SINGLE post
 */
?>

<article id="content-post-<?php the_ID(); ?>" <?php post_class( array('content-block', 'content-post') ); ?>>

	<header class="content-post-header">
		<?php echo wpjg_display_post_featured_image(); ?>
	</header>

	<main class="content-post-main" role="main">

		<!--<div class="content-post-main-meta">
			<?php #the_date('F Y', '<h4 class="content-post-date">', '</h4>'); ?>
			<?php #echo wpjg_post_categories(); ?>
		</div>-->
	
		<?php if (is_singular()) { the_title('<h1 class="content-post-title">', '</h2>'); } ?>

		<?php echo wpjg_post_headline(2); ?>

		<?php the_content(); ?>

	</main>
	
	<footer class="content-post-footer"></footer>

</article>
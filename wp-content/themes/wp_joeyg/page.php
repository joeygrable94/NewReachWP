<?php
/**
 * ALL pages
 */

get_header();
?>

	<header id="page-header">
		<h1 class="page-title"><?php echo the_title(); ?></h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>

<?php
while ( have_posts() ) :
	
	the_post();

	get_template_part( 'template-parts/content', 'page' );

endwhile;

get_sidebar();

get_footer();

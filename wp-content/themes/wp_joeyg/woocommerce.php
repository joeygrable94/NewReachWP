<?php
/**
 * STOREFRONT
 */

get_header();
?>

	<header id="page-header">
		<h1 class="page-title">Products</h1>
		<?php echo wpjg_get_secondary_navigation(); ?>
	</header>
	
	<main class="page-main-woocommerce">
		<?php woocommerce_content(); ?>
	</main>

<?

get_sidebar();

get_footer();

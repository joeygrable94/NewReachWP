<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<!-- font-awesome -->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body <?php body_class(); ?>>

<!-- Site Header -->
<header id="site-header" class="<?php echo get_current_page_class(); ?>">
	<div class="inner-wrap">

	<!-- custom logo & description -->
	<div id="site-header-branding">
		<?php echo wpjg_custom_header_content(); ?>
	</div>

	<!-- Navigation -->
	<?php echo wpjg_get_site_navigation(); ?>

</div>
</header>

<!-- Site Content -->
<div id="page" class="<?php echo get_current_page_class(); ?> <?php echo get_current_category_class(); ?>">
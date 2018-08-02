<?php
/**
 * The theme header
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	
	<!-- Google reCAPTCHA -->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<!-- ANALYTICS -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-122319281-1"></script>
	<script>window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-122319281-1');</script>
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5LGBFVS');</script>
	<!-- End Google Tag Manager -->

</head>
<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5LGBFVS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- header -->
<header id="site-header" class="<?php echo get_current_page_class(); ?>">
	<!-- custom logo & description -->
	<div class="header-branding">
		<?php echo wp_gridinator_custom_header_content(); ?>
	</div>
	<?php echo wp_gridinator_header_navigation_dropdown(); ?>
</header>

<!-- #navigation-site -->
<nav id="navigation-site" class="menu">
	<div class="nav-vertical">
		<?php echo wp_gridinator_site_navigation(); ?>
		<div class="nav-horizontal">
			<a class="fa fa-linkedin" href="https://www.linkedin.com/in/joeygrable94/" target="_blank"></a>
			<a class="fa fa-facebook-f" href="https://www.facebook.com/joeygrable94/" target="_blank"></a>
			<a class="fa fa-instagram" href="https://www.instagram.com/joeygrable94/" target="_blank"></a>
			<a class="fa fa-git" href="https://github.com/joeygrable94" target="_blank"></a>
		</div>
	</div>
</nav><!-- #navigation-site -->

<!-- #page -->
<div id="page" class="grid-default <?php echo get_current_page_class() . ' '; ?>">

	<!-- nav-toggle -->
	<div id="site-nav-toggle" data-bind="click" data-event="toggler" data-toggle="#navigation-site">
		<a class="fa fa-plus"></a>
	</div>

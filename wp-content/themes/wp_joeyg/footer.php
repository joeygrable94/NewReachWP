
	<!-- Site Footer -->
	<footer id="site-footer">
		<div class="inner-wrap">
			<?php if ( is_active_sidebar( 'sidebar-footer' ) ) {
				dynamic_sidebar( 'sidebar-footer' );
			} ?>
		</div>
	</footer>

</div>
<!-- END Site Content -->



<?php wp_footer(); ?>

<!-- ANALYTICS -->
<?php get_template_part('template-parts/google', 'analytics'); ?>

<!-- reCAPTCHA -->
<?php get_template_part('template-parts/google', 'recaptcha'); ?>

<!-- TAG MANAGER -->
<?php get_template_part('template-parts/google', 'tagmanager'); ?>

<style type="text/css">
#wpadminbar { display: none !important; margin: 0 !important; }
html { margin: 0 !important; }
</style>

</body>
</html>

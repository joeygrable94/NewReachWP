<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Gridinator
 */

?>

<section class="grid-search-not-found no-results not-found">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Looking for: '.get_search_query() , 'wp_gridinator' ); ?></h1>
	</header><!-- .page-header -->

	<main role="main" class="page-content">
		<h2>Nothing found.</h2>
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) :
			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'wp_gridinator' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
			esc_url( admin_url( 'post-new.php' ) )); ?>
		<?php elseif ( is_search() ) : ?>
			<p>
				<?php esc_html_e( 'Hmmm, It looks like I don\'t have anything under ', 'wp_gridinator' ); ?> 
				<span class="search-terms"><?php esc_html_e(get_search_query()); ?></span>
			</p>
		<?php else : ?>
			<p><?php esc_html_e( 'Hmmm, It looks like I don\'t have anything under ', 'wp_gridinator' ); ?></p>
		<?php endif; ?>
	</main><!-- .page-content -->

</section><!-- .no-results -->

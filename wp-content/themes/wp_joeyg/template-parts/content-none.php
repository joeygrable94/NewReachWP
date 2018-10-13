<?php
/**
 * NO content
 */
?>

<section id="" class="content-block no-post-results">

	<header class="content-post-header">
	</header>

	<main class="content-post-main" role="main">
		<h2 class="content-post-title"><?php esc_html_e( 'Searching for: '.get_search_query() , 'wp_gridinator' ); ?></h2>
		<h3>Nothing found.</h3>
	</main>

	<?php if ( get_edit_post_link() ) : ?>
	<footer class="content-post-footer">
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
	</footer>
	<?php endif; ?>

</section>

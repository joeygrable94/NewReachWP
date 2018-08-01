<?php
/**
 * The template for displaying comments
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="grid-block">

	<div class="comments-area">

	<?php if ( have_comments() ) : ?>
		
		<h3 class="comments-title">
			<?php $wp_gridinator_comment_count = get_comments_number();
			if ( '1' === $wp_gridinator_comment_count ) {
				printf( /* translators: 1: title. */
					esc_html__( 'Comments', 'wp_gridinator' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( /* WPCS: XSS OK. translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', $wp_gridinator_comment_count, 'comments title', 'wp_gridinator' ) ),
					number_format_i18n( $wp_gridinator_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			} ?>
		</h3><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ul class="comment-list">
			<?php wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			)); ?>
		</ul><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

		<? if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wp_gridinator' ); ?></p>
		<?php endif; ?>

	<?php endif; // Check for have_comments(). ?>

	<?php comment_form(); ?>

	</div>

</div><!-- #comments -->

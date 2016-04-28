<?php
/**
 * The template for displaying Comments
 * The area of the page that contains comments and the comment form.
 *
 * @package The Landscaper
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

 <div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf(
					_nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'the-landscaper-wp' ),
					number_format_i18n( get_comments_number() )
				);
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'the-landscaper-wp' ); ?></span>
				<?php paginate_comments_links(); ?>
			</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'thelandscaper_comment' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'the-landscaper-wp' ); ?></span>
				<?php paginate_comments_links(); ?>
			</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments">
			<?php esc_html_e( 'Comments are closed.', 'the-landscaper-wp' ); ?>
		</p>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>
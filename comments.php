<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bulmascores
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/*
Change "Reply" string with a FontAwesome Icon
Source: http://www.wpbeginner.com/wp-themes/how-to-change-the-reply-text-in-wordpress-comments/
*/
function bulmascores_reply_text( $link ) {
	$link = str_replace( esc_html__( 'Reply', 'bulmascores' ), '<i class="fas fa-reply"></i>', $link );
	return $link;
}
add_filter( 'comment_reply_link', 'bulmascores_reply_text' );

// Change "Edit" string with a FontAwesome Icon
function bulmascores_edit_text( $text ) {
	$text = str_replace( esc_html__( 'Edit', 'bulmascores' ), '<i class="fas fa-pencil-alt"></i>', $text );
	return $text;
}
add_filter( 'edit_comment_link', 'bulmascores_edit_text' );

// Add class to submit button in comments
function bulmascores_comment_form_defaults( $defaults ) {
	$defaults['class_submit'] = esc_attr( 'button is-light' );
	return $defaults;
}
add_filter( 'comment_form_defaults', 'bulmascores_comment_form_defaults' );
?>

<div id="comments" class="comments-area content">

	<?php
	if ( have_comments() ) : ?>
		<h2 class="comments-title"><i class="far fa-comment"></i>
			<?php comments_number(
				esc_html__( 'no comments', 'bulmascores' ),
				esc_html__( 'one comment', 'bulmascores' ),
				esc_html__( '% comments', 'bulmascores' )
			); ?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'bulmascores' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->

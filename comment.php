<?php global $comment; ?>

<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

	<?php echo hybrid_avatar(); ?>

	<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-author] [comment-published] [comment-permalink before="| "] [comment-edit-link before="| "] [comment-reply-link before="| "]</div>' ); ?>

	<div class="comment-content comment-text">
		<?php if ( '0' == $comment->comment_approved ) : ?>
			<?php echo apply_atomic_shortcode( 'comment_moderation', '<p class="alert moderation">' . __( 'Your comment is awaiting moderation.', 'unique' ) . '</p>' ); ?>
		<?php endif; ?>

		<?php comment_text( $comment->comment_ID ); ?>
	</div><!-- .comment-content .comment-text -->

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
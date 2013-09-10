<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

	<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-author] [comment-published] [comment-permalink before="| "] [comment-edit-link before="| "] [comment-reply-link before="| "]</div>' ); ?>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
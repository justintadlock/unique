<?php
/**
 * Status Content Template
 *
 * Template used to show posts with the 'status' post format.
 *
 * @package Unique
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/unique
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

do_atomic( 'before_entry' ); // unique_before_entry ?>

<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php do_atomic( 'open_entry' ); // unique_open_entry ?>

	<?php if ( is_singular() && is_main_query() ) { ?>

		<header class="entry-header">
			<?php echo get_avatar( get_the_author_meta( 'email' ) ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php echo do_shortcode( '[entry-mood before="<p class=\'mood\'><span class=\'mood-before\'>Current mood:</span> " after="</p>"]' ); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'unique' ), 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[post-format-link] updated on [entry-published] [entry-views before=" | "] [entry-edit-link before="| "]<br />[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'unique' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php } else { ?>

		<header class="entry-header">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_avatar( get_the_author_meta( 'email' ) ); ?></a>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( __( 'Read more &rarr;', 'unique' ) ); ?>
			<?php echo do_shortcode( '[entry-mood before="<p class=\'mood\'><span class=\'mood-before\'>Current mood:</span> " after="</p>"]' ); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'unique' ), 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[post-format-link] updated on [entry-published] [entry-permalink before="| "] [entry-comments-link before="| " one="%s reply" more="%s replies" zero="Reply"] [entry-edit-link before="| "]', 'unique' ) . '</div>' ); ?>
		</footer>

	<?php } ?>

	<?php do_atomic( 'close_entry' ); // unique_close_entry ?>

</article><!-- .hentry -->

<?php do_atomic( 'after_entry' ); // unique_after_entry ?>
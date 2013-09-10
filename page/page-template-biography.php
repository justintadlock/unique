<?php
/**
 * Template Name: Biography
 *
 * @package Unique
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/unique
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // unique_before_content ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // unique_open_content ?>

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php do_atomic( 'before_entry' ); // unique_before_entry ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php do_atomic( 'open_entry' ); // unique_open_entry ?>

						<header class="entry-header">
							<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
						</header><!-- .entry-header -->

						<div class="entry-content">

							<div id="hcard-<?php the_author_meta( 'user_nicename' ); ?>" class="author-profile vcard">

								<h2 class="author-name fn n">
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
								</h2>

								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_author_meta( 'display_name' ); ?>">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), '100', '', get_the_author_meta( 'display_name' ) ); ?>
								</a>

								<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>

								<p class="social">
									<?php if ( $twitter = get_the_author_meta( 'twitter' ) ) { ?>
										<a class="twitter" href="<?php echo esc_url( "http://twitter.com/{$twitter}" ); ?>" title="<?php printf( esc_attr__( '%s on Twitter', 'unique' ), get_the_author_meta( 'display_name' ) ); ?>"><?php _e( 'Twitter', 'unique' ); ?></a>
									<?php } ?>

									<?php if ( $facebook = get_the_author_meta( 'facebook' ) ) { ?>
										<a class="facebook" href="<?php echo esc_url( $facebook ); ?>" title="<?php printf( esc_attr__( '%s on Facebook', 'unique' ), get_the_author_meta( 'display_name' ) ); ?>"><?php _e( 'Facebook', 'unique' ); ?></a>
									<?php } ?>

									<?php if ( $google_plus = get_the_author_meta( 'google_plus' ) ) { ?>
										<a class="google-plus" href="<?php echo esc_url( $google_plus ); ?>" title="<?php printf( esc_attr__( '%s on Google+', 'unique' ), get_the_author_meta( 'display_name' ) ); ?>"><?php _e( 'Google+', 'unique' ); ?></a>
									<?php } ?>

									<a class="feed" href="<?php echo esc_url( get_author_feed_link( $id ) ); ?>" title="<?php printf( esc_attr__( 'Subscribe to the feed for %s', 'unique' ), get_the_author_meta( 'display_name' ) ); ?>"><?php _e( 'Subscribe', 'unique' ); ?></a>
								</p>

							</div><!-- .author-profile .vcard -->

							<?php the_content(); ?>

							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'unique' ), 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

						<footer class="entry-footer">
							<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-edit-link]</div>' ); ?>
						</footer><!-- .entry-footer -->

						<?php do_atomic( 'close_entry' ); // unique_close_entry ?>

					</article><!-- .hentry -->

					<?php do_atomic( 'after_entry' ); // unique_after_entry ?>

					<?php do_atomic( 'after_singular' ); // unique_after_singular ?>

					<?php comments_template( '/comments.php', true ); // Loads the comments.php template. ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // unique_close_content ?>

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // unique_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
<?php
/**
 * Template Name: Avatars (Administrator)
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
							<?php the_content(); ?>

							<?php
							/* Set up some default variables to use in the gallery. */
							$gallery_columns = 5;
							$gallery_iterator = 0;

							$layout = get_post_layout( get_the_ID() );

							if ( in_array( $layout, array( '3c-l', '3c-r', '3c-c' ) ) )
								$gallery_columns = 4;
							elseif ( '1c' == $layout )
								$gallery_columns = 8;

							$users = get_users( array( 'role' => 'administrator' ) ); ?>

							<?php if ( !empty( $users ) ) { ?>

								<div class="gallery">

									<?php foreach ( $users as $user ) { ?>

										<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">'; ?>

										<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
											<div class="gallery-icon">
												<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>" title="<?php echo esc_attr( get_the_author_meta( 'display_name', $user->ID ) ); ?>">
													<?php echo get_avatar( $user->ID ); ?>
												</a>
											</div>
											<div class="gallery-caption">
												<?php the_author_meta( 'display_name', $user->ID ); ?>
											</div>
										</div>

										<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>'; ?>

									<?php } // End foreach. ?>

									<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>'; ?>

								</div><!-- .gallery -->

							<?php } // End if. ?>

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
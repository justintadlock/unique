<?php
/**
 * Template Name: Post Thumbnail Gallery
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

			<?php $loop = new WP_Query(
				array(
					'posts_per_page' => ( 'layout-1c' == theme_layouts_get_layout() ? 15 : 12 ),
					'ignore_sticky_posts' => true,
				)
			);

			/* Set up some default variables to use in the gallery. */
			$gallery_columns = ( 'layout-1c' == theme_layouts_get_layout() ? 5 : 3 );
			$gallery_iterator = 0; ?>

			<?php if ( $loop->have_posts() ) : ?>

				<div class="gallery">

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">'; ?>

						<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
							<div class="gallery-icon">
								<?php get_the_image( array( 'size' => 'thumbnail', 'meta_key' => false, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/thumbnail-default.png' ) ); ?>
							</div>
							<div class="gallery-caption">
								<?php the_title(); ?>
							</div>
						</div>

						<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>'; ?>

					<?php endwhile; ?>

					<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>'; ?>

				</div><!-- .gallery -->

			<?php endif; wp_reset_query(); ?>

			<?php do_atomic( 'after_singular' ); // unique_after_singular ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // unique_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // unique_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
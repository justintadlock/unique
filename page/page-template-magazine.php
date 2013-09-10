<?php
/**
 * Template Name: Magazine
 *
 * @package Unique
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/unique
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

$do_not_duplicate = array();

get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // unique_before_content ?>

	<?php
	$sticky = get_option( 'sticky_posts' );
	rsort( $sticky );

	$loop = new WP_Query( 
		array(
			'post__in' => array_slice( $sticky, 0, 5 ),
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array(
						'post-format-aside',
						'post-format-audio',
						'post-format-chat',
						'post-format-link', 
						'post-format-quote',
						'post-format-status',
						'post-format-video'
					),
					'operator' => 'NOT IN'
				)
			)
		)
	); ?>

	<?php if ( $loop->have_posts() ) : ?>

		<div class="flexslider">
			<ul class="slides">

				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID(); ?>

					<li class="slide">
					<?php get_the_image( array( 'meta_key' => false, 'size' => 'unique-slider' ) ); ?>
					<div class="slide-caption">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>
					</div><!-- .slide-caption -->
					</li>
				<?php endwhile; ?>
			</ul>
		</div>

	<?php endif; ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // unique_open_content ?>

		<div class="hfeed">

			<?php $loop = new WP_Query(
				array(
					'post_type' => 'post',
					'posts_per_page' => 4,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array(
								'post-format-aside',
								'post-format-audio',
								'post-format-chat',
								'post-format-gallery',
								'post-format-image', 
								'post-format-link', 
								'post-format-quote',
								'post-format-status',
								'post-format-video'
							),
							'operator' => 'NOT IN'
						)
					),
					'post__not_in' => $do_not_duplicate
				)
			); ?>

			<?php if ( $loop->have_posts() ) : ?>

				<div class="content-secondary">

				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID();  ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

							<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail' ) ); ?>

							<header class="entry-header">
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __( 'Published on [entry-published] [entry-edit-link before=" | "]', 'unique' ) . '</div>' ); ?>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

					</article><!-- .hentry -->

				<?php endwhile; ?>
				</div>
			<?php endif; ?>

			<?php $loop = new WP_Query(
				array(
					'posts_per_page' => 3,
					'post__not_in' => $do_not_duplicate,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array( 'post-format-image' )
						)
					)
				)
			);

			/* Set up some default variables to use in the gallery. */
			$gallery_columns = 3;
			$gallery_iterator = 0; ?>

			<?php if ( $loop->have_posts() ) : ?>

				<div class="gallery">

					<h2 class="gallery-title">
						<?php _e( 'Latest Images', 'unique' ); ?>
						<a class="post-format-link" href="<?php echo get_post_format_link( 'image' ); ?>"><?php _e( 'View Archive &rarr;', 'unique' ); ?></a>
					</h2>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">'; ?>

						<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
							<div class="gallery-icon">
								<?php get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail', 'image_scan' => true ) ); ?>
							</div>
							<div class="gallery-caption">
								<?php the_title(); ?>
							</div>
						</div>

						<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>'; ?>

					<?php endwhile; ?>

					<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>'; ?>

				</div><!-- .gallery -->

			<?php endif; ?>

			<?php $loop = new WP_Query(
				array(
					'posts_per_page' => 3,
					'posts__not_in' => $do_not_duplicate,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array( 'post-format-gallery' )
						)
					)
				)
			);

			/* Set up some default variables to use in the gallery. */
			$gallery_columns = 3;
			$gallery_iterator = 0; ?>

			<?php if ( $loop->have_posts() ) : ?>

				<div class="gallery">

					<h2 class="gallery-title">
						<?php _e( 'Latest Galleries', 'unique' ); ?>
						<a class="post-format-link" href="<?php echo get_post_format_link( 'gallery' ); ?>"><?php _e( 'View Archive &rarr;', 'unique' ); ?></a>
					</h2>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">'; ?>

						<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
							<div class="gallery-icon">
								<?php get_the_image( array( 'size' => 'thumbnail', 'meta_key' => false ) ); ?>
							</div>
							<div class="gallery-caption">
								<?php the_title(); ?>
							</div>
						</div>

						<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>'; ?>

					<?php endwhile; ?>

					<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>'; ?>

				</div><!-- .gallery -->

			<?php endif; ?>

			<?php wp_reset_query(); ?>

			<?php do_atomic( 'after_singular' ); // unique_after_singular ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // unique_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // unique_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
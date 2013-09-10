<?php
/**
 * Template Name: Magazine
 */

$do_not_duplicate = array();

get_header(); // Loads the header.php template. ?>

	<!-- Begin featured area. --->
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

			<div class="slides">

				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID(); ?>

					<figure class="slide">

						<?php get_the_image( array( 'meta_key' => false, 'size' => 'unique-slider' ) ); ?>

						<figcaption class="slide-caption">

							<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

						</figcaption><!-- .slide-caption -->

					</figure><!-- .slide -->
				<?php endwhile; ?>

			</div><!-- .slides -->

		</div><!-- .flexslider -->

	<?php endif; ?>
	<!-- End featured area. -->

	<div id="content" class="hfeed">

		<!-- Begin excerpts area. -->
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
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title tag="h2"]' ); ?>
								<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( 'Published on [entry-published] [entry-edit-link before=" | "]', 'unique' ) . '</div>' ); ?>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

					</article><!-- .hentry -->

				<?php endwhile; ?>

			</div><!-- .content-secondary -->

		<?php endif; ?>
		<!-- End excerpts area. --->

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

					<figure class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">

						<div class="gallery-icon">
							<?php get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail', 'image_scan' => true ) ); ?>
						</div><!-- .gallery-icon -->

						<figcaption class="gallery-caption">
							<?php the_title(); ?>
						</figcaption><!-- .gallery-caption -->

					</figure><!-- .gallery-item -->

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

					<figure class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">

						<div class="gallery-icon">
							<?php get_the_image( array( 'size' => 'thumbnail', 'meta_key' => false ) ); ?>
						</div><!-- .gallery-icon -->

						<figcaption class="gallery-caption">
							<?php the_title(); ?>
						</figcaption><!-- .gallery-caption -->

					</figure><!-- .gallery-item -->

					<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>'; ?>

				<?php endwhile; ?>

				<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>'; ?>

			</div><!-- .gallery -->

		<?php endif; ?>

		<?php wp_reset_query(); ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
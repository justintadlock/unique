<?php
/* Set up some default variables to use in the gallery. */
$gallery_columns = apply_atomic( 'post_format_archive_gallery_columns', 3 );
$gallery_iterator = 0;

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed">

		<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

		<?php if ( have_posts() ) : ?>

			<div class="gallery">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row">'; ?>

					<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">

						<div class="gallery-icon">
							<?php get_the_image( array( 'size' => 'thumbnail', 'meta_key' => false ) ); ?>
						</div><!-- .gallery-icon -->

						<figcaption class="gallery-caption">
							<?php the_title(); ?>
						</figcaption><!-- .gallery-caption -->

					</div><!-- .gallery-item -->

					<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>'; ?>

				<?php endwhile; ?>

				<?php if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>'; ?>

			</div><!-- .gallery -->

		<?php else : ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
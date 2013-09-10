<?php get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed">

		<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

		<?php if ( have_posts() ) { ?>

			<?php while ( have_posts() ) { ?>

				<?php the_post(); // Loads the post data. ?>

				<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>

				<?php if ( is_singular() ) { ?>

					<?php if ( '' == get_post_format() && is_multi_author() && is_singular( 'post' ) ) locate_template( array( 'misc/author-box.php' ), true ); ?>

					<?php comments_template(); // Loads the comments.php template. ?>

				<?php } ?>

			<?php } ?>

		<?php } else { ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php } ?>

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
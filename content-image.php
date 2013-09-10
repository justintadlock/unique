<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php if ( is_singular( get_post_type() ) ) { ?>

		<header class="entry-header">
			<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
			<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( '[post-format-link] published on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'unique' ) . '</div>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php if ( post_format_tools_post_has_content() ) { ?>
				<?php the_content(); ?>
			<?php } else { ?>
				<?php get_the_image( array( 'image_class' => 'aligncenter', 'size' => 'full', 'meta_key' => false, 'link_to_post' => false ) ); ?>
			<?php } ?>

			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'unique' ), 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'unique' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php } else { ?>

		<header class="entry-header">
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php if ( post_format_tools_post_has_content() ) { ?>
				<?php the_content( __( 'Read more &rarr;', 'unique' ) ); ?>
			<?php } else { ?>
				<?php get_the_image( array( 'image_class' => 'aligncenter', 'size' => 'full', 'meta_key' => false ) ); ?>
			<?php } ?>

			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'unique' ), 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[post-format-link] published on [entry-published] [entry-permalink before="| "] [entry-comments-link before="| "] [entry-edit-link before="| "]', 'unique' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php } ?>

</article><!-- .hentry -->
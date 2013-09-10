<?php get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed">

		<article id="post-0" class="<?php hybrid_entry_class(); ?>">

			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Whoah! You broke something!', 'unique' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">

				<p>
					<?php printf( __( "Just kidding! You tried going to %s, which doesn't exist, so that means I probably broke something.", 'unique' ), '<code>' . home_url( esc_url( $_SERVER['REQUEST_URI'] ) ) . '</code>' ); ?>
				</p>
				<p>
					<?php _e( "The following is a list of the latest posts from the blog. Maybe it will help you find what you're looking for.", 'unique' ); ?>
				</p>

				<ul>
					<?php wp_get_archives( array( 'limit' => 20, 'type' => 'postbypost' ) ); ?>
				</ul>

			</div><!-- .entry-content -->

		</article><!-- .hentry -->

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
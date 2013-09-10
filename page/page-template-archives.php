<?php
/**
 * Template Name: Archives
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

					<header class="entry-header">
						<h1 class="entry-title"><?php single_post_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>

						<?php if ( function_exists( 'smartArchives' ) ) : smartArchives( 'both', '' ); ?>

						<?php elseif ( function_exists( 'wp_smart_archives' ) ) : wp_smart_archives(); ?>

						<?php elseif ( function_exists( 'srg_clean_archives' ) ) : srg_clean_archives(); ?>

						<?php else : ?>

							<h2><?php _e( 'Archives by category', 'unique' ); ?></h2>

							<ul class="xoxo category-archives">
								<?php wp_list_categories( array( 'feed' => __( 'RSS', 'unique' ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
							</ul><!-- .xoxo .category-archives -->

							<h2><?php _e( 'Archives by month', 'unique' ); ?></h2>

							<ul class="xoxo monthly-archives">
								<?php wp_get_archives( array( 'show_post_count' => true, 'type' => 'monthly' ) ); ?>
							</ul><!-- .xoxo .monthly-archives -->

						<?php endif; ?>

						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'unique' ), 'after' => '</p>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-edit-link]</div>' ); ?>
					</footer><!-- .entry-footer -->

				</article><!-- .hentry -->

				<?php comments_template(); // Loads the comments.php template. ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>
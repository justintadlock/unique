<div class="author-profile vcard">

	<h4 class="author-name fn n">
		<?php printf( __( 'Article written by %s', 'unique' ), '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a>' ); ?>
	</h4>

	<?php echo get_avatar( get_the_author_meta( 'user_email' ), '96' ); ?>

	<div class="author-description author-bio">
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

			<a class="feed" href="<?php echo esc_url( get_author_feed_link( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php printf( esc_attr__( 'Subscribe to the feed for %s', 'unique' ), get_the_author_meta( 'display_name' ) ); ?>"><?php _e( 'Subscribe', 'unique' ); ?></a>
		</p>
	</div>
</div>
<?php
/**
 * User profile widget.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * User Profile widget class.
 *
 * @since 0.1.0
 */
class Unique_Widget_User_Profile extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'user-profile',
			'description' => __( "Display a user's profile.", 'widget-user-profile' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 525,
			'height' => 350,
			'id_base' => 'user-profile'
		);

		/* Create the widget. */
		$this->WP_Widget( 'user-profile', esc_attr__( 'User Profile', 'widget-user-profile' ), $widget_options, $control_options );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Get the user ID. */
		$user_id = absint( $instance['user'] );

		/* Get the avatar size. */
		$avatar_size = absint( $instance['avatar_size'] );

		/* Get the link to the user's "more info" page. */
		if ( !empty( $instance['custom_user_page'] ) )
			$more_url = get_permalink( absint( $instance['custom_user_page'] ) );
		else
			$more_url = get_author_posts_url( $user_id );

		$more = '<a class="user-profile-more" href="' . $more_url . '" title="' . esc_attr( get_the_author_meta( 'display_name', $user_id ) ) . '">' . __( 'Read more &rarr;', 'widget-user-profile' ) . '</a>';

		/* Get the user profile text. */
		if ( empty( $instance['custom_user_text'] ) )
			$user_text = get_the_author_meta( 'description', $user_id );
		else
			$user_text = $instance['custom_user_text'];

		$user_text = wpautop( do_shortcode( $user_text ) );
		$user_text = apply_filters( 'widget_user_profile_text', $user_text );
		$user_text = preg_replace( "/<\/p>(?![^<\/p>]+<\/p>)$/", " {$more}</p>", $user_text );

		/* Open the before widget HTML. */
		echo $before_widget;

		/* Output the widget title. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Output the user's gravatar. */
		$avatar = get_avatar( get_the_author_meta( 'user_email', $user_id ), $avatar_size, '', get_the_author_meta( 'display_name', $user_id ) );
		echo str_replace( "class='", "class='{$instance['avatar_align']} ", $avatar );

		/* Output the user text. */
		echo $user_text;

		/* Close the after widget HTML. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Set the instance to the new instance. */
		$instance = $new_instance;

		/* Strip tags from elements that don't need them. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['avatar_size'] = strip_tags( $new_instance['avatar_size'] );

		if ( current_user_can( 'unfiltered_html' ) )
			$instance['custom_user_text'] =  $new_instance['custom_user_text'];
		else
			$instance['custom_user_text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['custom_user_text'] ) ) );

		$instance['custom_user_page'] = ( isset( $new_instance['custom_user_page'] ) ? absint( $new_instance['custom_user_page'] ) : 0 );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		/* Set up the defaults. */
		$defaults = array(
			'title' => __( 'Profile', 'user-profile' ),
			'user' => '',
			'avatar_size' => '40',
			'avatar_align' => 'alignleft',
			'custom_user_text' => '',
			'custom_user_page' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$pages = array();
		$posts = array();
		$posts = get_posts( array( 'post_type' => 'page', 'post_status' => 'any', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1 ) );

		foreach ( $posts as $post )
			$pages[$post->ID] = esc_attr( $post->post_title );
		?>

		<div style="width:48%;float:left;">

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'widget-user-profile' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e( 'User:', 'widget-user-profile' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>">
				<?php foreach ( get_users_of_blog() as $author ) { ?>
					<option value="<?php echo $author->ID; ?>" <?php selected( $instance['user'], $author->ID ); ?>><?php echo $author->display_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'avatar_size' ); ?>"><?php _e( 'Avatar Size:', 'widget-user-profile' ); ?></label>
			<input style="float:right;width:66px;" type="text" class="widefat" id="<?php echo $this->get_field_id( 'avatar_size' ); ?>" name="<?php echo $this->get_field_name( 'avatar_size' ); ?>" value="<?php echo $instance['avatar_size']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'avatar_align' ); ?>"><?php _e( 'Avatar Alignment:', 'widget-user-profile' ); ?></label> 
			<select style="float:right;max-width:66px;" class="widefat" id="<?php echo $this->get_field_id( 'avatar_align' ); ?>" name="<?php echo $this->get_field_name( 'avatar_align' ); ?>">
				<?php foreach ( array( 'alignnone' => __( 'None', 'widget-user-profile'), 'alignleft' => __( 'Left', 'widget-user-profile' ), 'alignright' => __( 'Right', 'widget-user-profile' ), 'aligncenter' => __( 'Center', 'widget-user-profile' ) ) as $option_value => $option_label ) { ?>
					<option value="<?php echo $option_value; ?>" <?php selected( $instance['avatar_align'], $option_value ); ?>><?php echo $option_label; ?></option>
				<?php } ?>
			</select>
		</p>

		</div>

		<div style="width:48%;float:right;">

		<p>
			<label for="<?php echo $this->get_field_id( 'custom_user_text' ); ?>"><?php _e( 'Custom Text:', 'widget-user-profile' ); ?></label>
			<textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id( 'custom_user_text' ); ?>" name="<?php echo $this->get_field_name( 'custom_user_text' ); ?>"><?php echo esc_textarea( $instance['custom_user_text'] ); ?></textarea>
			<?php _e( 'User bio will be used if left empty.', 'widget-user-profile' ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'custom_user_page' ); ?>"><?php _e( '"Read More" should link to:', 'widget-user-profile' ); ?></label> 

			<?php $select = wp_dropdown_pages(
				array(
					'selected' => ( !empty( $instance['custom_user_page'] ) ? absint( $instance['custom_user_page'] ) : 0 ),
					'name' => $this->get_field_name( 'custom_user_page' ),
					'id' => $this->get_field_id( 'custom_user_page' ),
					'show_option_none' => __( 'Author Archive Page', 'widget-user-profile' ),
					'echo' => false
				)
			);
			echo str_replace( '<select', '<select class="widefat"', $select ); ?>
		</p>

		</div>

		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>
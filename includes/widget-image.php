<?php
/**
 * Image widget.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Image widget class.
 *
 * @since 0.1.0
 */
class Unique_Widget_Image extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array( 
			'classname' => 'image', 
			'description' => __( 'Display an image in any sidebar.', 'unique' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 250,
			'height' => 350,
			'id_base' => 'image'
		);

		/* Create the widget. */
		$this->WP_Widget( 'image', __( 'Image', 'unique' ), $widget_options, $control_options );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$image_width = $image_height = $image_class = $image_title = '';

		if ( !$instance['image_width'] && $instance['image_caption'] )
			$image_width = ' width="300"';

		elseif ( $instance['image_width'] )
			$image_width = ' width="' . absint( $instance['image_width'] ) . '"';

		if ( !$instance['image_caption'] )
			$image_class = ' class="' . $instance['image_align'] . '"';
		else
			$cap_align = ' align="' . $instance['image_align'] . '"';

		if ( $instance['image_height'] )
			$image_height = ' height="' . absint( $instance['image_height'] ) . '"';

		if ( $instance['image_title'] )
			$image_title = ' title="' . esc_attr( $instance['image_title'] ) . '"';

		echo $before_widget;

		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		$img = '<img src="' . esc_url( $instance['image_url'] ) . '" alt="' . $instance['image_alt'] . '"' . $image_title . $image_width . $image_height . $image_class . ' />';

		if ( $instance['link_url'] )
			$img = '<a href="' . esc_url( $instance['link_url'] ) . '">' . $img . '</a>';

		if ( $instance['image_caption'] ) {
			$caption = '[caption ' . $cap_align . $image_width . ' caption="' . esc_attr( $instance['image_caption'] ) . '"]' . $img . '[/caption]';
			echo do_shortcode( $caption );
		} else {
			echo '<p>' . $img . '</p>';
		}

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
		$instance['image_title'] = strip_tags( $new_instance['image_title'] );
		$instance['image_alt'] = strip_tags( $new_instance['image_alt'] );
		$instance['image_caption'] = strip_tags( $new_instance['image_caption'] );
		$instance['image_width'] = strip_tags( $new_instance['image_width'] );
		$instance['image_height'] = strip_tags( $new_instance['image_height'] );

		$instance['image_url'] = esc_url( $new_instance['image_url'] );
		$instance['link_url'] = esc_url( $new_instance['link_url'] );

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
			'title' => __( 'Image', 'unique' ),
			'image_align' => 'aligncenter',
			'image_url' => '',
			'image_title' => '',
			'image_alt' => '',
			'image_caption' => '',
			'image_width' => '',
			'image_height' => '',
			'link_url' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'Image <acronym title="Uniform Resource Locator">URL</acronym>:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" value="<?php echo $instance['image_url']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'alt_text' ); ?>"><?php _e( 'Alternate Text:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'alt_text' ); ?>" name="<?php echo $this->get_field_name( 'alt_text' ); ?>" value="<?php echo $instance['alt_text']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_title' ); ?>"><?php _e( 'Image Title:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'image_title' ); ?>" name="<?php echo $this->get_field_name( 'image_title' ); ?>" value="<?php echo $instance['image_title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_caption' ); ?>"><?php _e( 'Caption:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'image_caption' ); ?>" name="<?php echo $this->get_field_name( 'image_caption' ); ?>" value="<?php echo $instance['image_caption']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_align' ); ?>"><?php _e( 'Alignment:', 'unique' ); ?></label> 
			<select style="float:right;max-width:66px;" class="widefat" id="<?php echo $this->get_field_id( 'image_align' ); ?>" name="<?php echo $this->get_field_name( 'image_align' ); ?>">
				<?php foreach ( array( 'alignnone' => __( 'None', 'unique'), 'aligncenter' => __( 'Center', 'unique' ), 'alignleft' => __( 'Left', 'unique' ), 'alignright' => __( 'Right', 'unique' ) ) as $option_value => $option_label ) { ?>
					<option value="<?php echo $option_value; ?>" <?php selected( $instance['image_align'], $option_value ); ?>><?php echo $option_label; ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_width' ); ?>"><?php _e( 'Width:', 'unique' ); ?></label>
			<input style="float:right;width:66px;" type="text" class="widefat" id="<?php echo $this->get_field_id( 'image_width' ); ?>" name="<?php echo $this->get_field_name( 'image_width' ); ?>" value="<?php echo $instance['image_width']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_height' ); ?>"><?php _e( 'Height:', 'unique' ); ?></label>
			<input style="float:right;width:66px;" type="text" class="widefat" id="<?php echo $this->get_field_id( 'image_height' ); ?>" name="<?php echo $this->get_field_name( 'image_height' ); ?>" value="<?php echo $instance['image_height']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_url' ); ?>"><?php _e( 'Link <acronym title="Uniform Resource Locator">URL</acronym>:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" value="<?php echo $instance['link_url']; ?>" />
		</p>
		</div>

		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>
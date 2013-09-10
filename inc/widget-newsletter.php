<?php
/**
 * Newsletter widget.  Provies a subscribe form for integration with Google/Feedburner.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012 - 2013, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Newsletter widget class.
 *
 * @since 0.1.0
 */
class Unique_Widget_Newsletter extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array( 
			'classname' => 'newsletter', 
			'description' => __( 'Displays a subscription form for your Google/Feedburner account.', 'unique' ) 
		);

		/* Set up the widget control options. */
		$control_options = array( 
			'width' => 200, 
			'height' => 350, 
			'id_base' => 'newsletter'
		);

		/* Create the widget. */
		$this->WP_Widget( 'newsletter', __( 'Newsletter', 'unique' ), $widget_options, $control_options );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		echo $before_widget;

		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title; ?>

		<div class="newsletter-wrap">
		<form action="http://feedburner.google.com/fb/a/mailverify" method="post">
		<p>
			<input class="newsletter-text" type="text" name="email" value="<?php echo esc_attr( $instance['input_text'] ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
			<input class="newsletter-submit" type="submit" value="<?php echo esc_attr( $instance['submit_text'] ); ?>" />
			<input type="hidden" value="<?php echo esc_attr( $instance['id'] ); ?>" name="uri" />
			<input type="hidden" name="loc" value="en_US" />
		</p>
		</form>
		</div><?php

		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['id'] = strip_tags( $new_instance['id'] );
		$instance['input_text'] = strip_tags( $new_instance['input_text'] );
		$instance['submit_text'] = strip_tags( $new_instance['submit_text'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		//Defaults
		$defaults = array(
			'title' => __( 'Newsletter', 'unique' ),
			'input_text' => __( 'you@site.com', 'unique' ),
			'submit_text' => __( 'Subscribe', 'unique' ),
			'id' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="hybrid-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Google/Feedburner ID:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'input_text' ); ?>"><?php _e( 'Input Text:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'input_text' ); ?>" name="<?php echo $this->get_field_name( 'input_text' ); ?>" value="<?php echo esc_attr( $instance['input_text'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'submit_text' ); ?>"><?php _e( 'Submit Text:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'submit_text' ); ?>" name="<?php echo $this->get_field_name( 'submit_text' ); ?>" value="<?php echo esc_attr( $instance['submit_text'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>
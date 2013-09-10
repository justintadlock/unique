<?php
/**
 * List sub-pages widget.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012 - 2013, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * List sub-pages widget class.
 *
 * @since 0.1.0
 */
class Unique_Widget_List_Sub_Pages extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array( 
			'classname' => 'list-sub-pages', 
			'description' => __( 'Displays the sub-pages of the current page. Widget only appears if there are sub-pages of the current page.', 'unique' ) 
		);

		/* Set up the widget control options. */
		$control_options = array( 
			'width' => 250, 
			'height' => 350, 
			'id_base' => 'list-sub-pages' 
		);

		/* Create the widget. */
		$this->WP_Widget( 'list-sub-pages', __( 'List Sub-Pages', 'unique' ), 	$widget_options, $control_options 
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $sidebar, $instance ) {

		extract( $sidebar );

		/* Only display widget if viewing a page. */
		if ( !is_page() )
			return;

		/* Get the queried post object. */
		$post = get_queried_object();

		/* If the post does not have a parent, get the list based off the current post. */
		if ( 0 >= $post->post_parent ) {
			$children = wp_list_pages( array( 'child_of' => get_queried_object_id(), 'echo' => false, 'title_li' => false ) );
		}

		/* Else, check for post ancestors and get the top-level post. */
		elseif ( $post->ancestors ) {
			$ancestors = $post->ancestors;
			$ancestors = end( $ancestors );
			$children = wp_list_pages( array( 'child_of' => $ancestors, 'title_li' => false, 'echo' => false ) );
		}

		/* If no children posts were found, return. */
		if ( empty( $children ) )
			return;

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Display the sub-pages list. */
		echo '<ul class="xoxo">' . $children . '</ul>';

		/* Output the theme's $after_widget wrapper. */
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
			'title' => __( 'Sub Pages', 'unique' )
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		</div>

		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>
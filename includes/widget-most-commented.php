<?php
/**
 * Most commented posts widget.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Most commented posts widget class.
 *
 * @since 0.1.0
 */
class Unique_Widget_Most_Commented extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'most-commented',
			'description' => __( 'Display top commented posts.', 'unique' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 250,
			'height' => 350,
			'id_base' => 'most-commented'
		);

		/* Create the widget. */
		$this->WP_Widget( 'most-commented', __( 'Most Commented', 'unique' ), $widget_options, $control_options );
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Arguments for the query. */
		$args = array(
			'orderby' => 'comment_count',
			'order' => 'DESC',
			'post_type' => ( isset( $instance['post_type'] ) ? $instance['post_type'] : 'post' ),
			'posts_per_page' => ( isset( $instance['posts_per_page'] ) ? intval( $instance['posts_per_page'] ) : 10 ),
			'post_status' => array( 'publish', 'inherit' ),
			'ignore_sticky_posts' => true
		);

		/* Only add arguments if they're set. */
		if ( !empty( $instance['day'] ) )
			$args['day'] = absint( $instance['day'] );
		if ( !empty( $instance['monthnum'] ) )
			$args['monthnum'] = absint( $instance['monthnum'] );
		if ( !empty( $instance['year'] ) )
			$args['year'] = absint( $instance['year'] );

		/* Open the before widget HTML. */
		echo $before_widget;

		/* Output the widget title. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Query the popular posts. */
		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) {

			echo '<ul class="xoxo most-commented">';

			while ( $loop->have_posts() ) {
				$loop->the_post();

				/* Create a list item, add the post title (w/link) and comment count (w/link). */
				echo '<li>';
				the_title( '<a class="post-link" href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a> ' );
				echo '<span class="comments-number">';
				comments_number( __( '(0)', 'unique' ), __( '(1)', 'unique' ), __( '(%)', 'unique' ), 'comments-link', '' );
				echo '<span>';
				echo '</li>';
			}

			echo '</ul>';
		}

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

		/* Sanitize input elements. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['year'] = strip_tags( $new_instance['year'] );
		$instance['posts_per_page'] = intval( $new_instance['posts_per_page'] );

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
			'title' => __( 'Most Commented', 'unique' ),
			'post_type' => 'post',
			'posts_per_page' => 10,
			'year' => '',
			'monthnum' => '',
			'day' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$months = array( '', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
		$days = array( '', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31 );
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:', 'unique' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php foreach ( $post_types as $type ) {
					if ( post_type_supports( $type->name, 'comments' ) || post_type_supports( $type->name, 'trackbacks' ) ) { ?>
						<option value="<?php echo esc_attr( $type->name ); ?>" <?php selected( $instance['post_type'], $type->name ); ?>><?php echo esc_html( $type->labels->singular_name ); ?></option>
					<?php }
				} ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'unique' ); ?></label>
			<input style="float:right;width:66px;" type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'year' ); ?>"><?php _e( 'Year:', 'unique' ); ?></label>
			<input style="float:right;width:66px;" type="text" class="widefat" id="<?php echo $this->get_field_id( 'year' ); ?>" name="<?php echo $this->get_field_name( 'year' ); ?>" value="<?php echo $instance['year']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'monthnum' ); ?>"><?php _e( 'Month:', 'unique' ); ?></label> 
			<select style="float:right;max-width:66px;" class="widefat" id="<?php echo $this->get_field_id( 'monthnum' ); ?>" name="<?php echo $this->get_field_name( 'monthnum' ); ?>">
				<?php foreach ( $months as $month ) { ?>
					<option value="<?php echo esc_attr( $month ); ?>" <?php selected( $instance['monthnum'], $month ); ?>><?php echo $month; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'day' ); ?>"><?php _e( 'Day:', 'unique' ); ?></label> 
			<select style="float:right;max-width:66px;" class="widefat" id="<?php echo $this->get_field_id( 'day' ); ?>" name="<?php echo $this->get_field_name( 'day' ); ?>">
				<?php foreach ( $days as $day ) { ?>
					<option value="<?php echo esc_attr( $day ); ?>" <?php selected( $instance['day'], $day ); ?>><?php echo $day; ?></option>
				<?php } ?>
			</select>
		</p>

		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>
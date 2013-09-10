<?php
/**
 * Gallery posts widget.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012 - 2013, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Gallery post format widget class.
 *
 * @since 0.1.0
 */
class Unique_Widget_Gallery_Posts extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'unique-gallery-posts',
			'description' => esc_html__( 'Displays posts from the "gallery" post format.', 'unique' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'unique-gallery-posts',		// $this->id_base
			__( 'Galleries', 'unique' ),		// $this->name
			$widget_options,			// $this->widget_options
			$control_options			// $this->control_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		$loop = new WP_Query(
			array(
				'posts_per_page' => $instance['posts_per_page'],
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( 'post-format-gallery' )
					)
				)
			)
		);

		if ( $loop->have_posts() ) {

			/* Set up some default variables to use in the gallery. */
			$gallery_columns = 3;
			$gallery_iterator = 0; 

			echo '<div class="gallery">';

			while ( $loop->have_posts() ) {
				$loop->the_post();

				if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">';  ?>

						<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
							<div class="gallery-icon">
								<?php get_the_image( array( 'image_scan' => true, 'size' => 'thumbnail', 'meta_key' => false, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/thumbnail-default.png' ) ); ?>
							</div>
						</div>

			<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>';

			}

			if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>';

			echo '</div>';
		}

		wp_reset_query();

		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => esc_attr__( 'Galleries', 'unique' ),
			'posts_per_page' => 9,
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<div class="hybrid-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'unique' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'unique' ); ?></label>
			<input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>
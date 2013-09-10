<?php
/**
 * Functions for handling the theme's settings on WordPress' theme customizer screen.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/unique
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Add layout option in Customize. */
add_action( 'customize_register', 'unique_customize_register' );

/**
 * Registers custom sections, settings, and controls for the $wp_customize instance.
 *
 * @since 0.1.0
 * @access public
 * @param object $wp_customize
 */
function unique_customize_register( $wp_customize ) {

	/* Get the theme prefix. */
	$prefix = hybrid_get_prefix();

	/* Get the default theme settings. */
	$default_settings = hybrid_get_default_theme_settings();

	/* Get supported theme layouts. */
	$supports = get_theme_support( 'theme-layouts' );

	/* Only display the layout section and settings if the theme supports custom layouts. */
	if ( is_array( $supports[0] ) ) {

		/* Add the layout section. */
		$wp_customize->add_section(
			"{$prefix}-layout",
			array(
				'title' => 		esc_html__( 'Layout', 'unique' ),
				'priority' => 	190,
				'capability' => 	'edit_theme_options'
			)
		);

		/* Add the 'layout' setting. */
		$wp_customize->add_setting(
			"{$prefix}_theme_settings[layout]",
			array(
				'default' =>		$default_settings['layout'],
				'type' =>			'option',
				'capability' =>		'edit_theme_options',
				'sanitize_callback' =>	'sanitize_key',
				'transport' =>		'postMessage'
			)
		);

		/* Set up an array for the layout choices and add in the 'default' layout. */
		$layout_choices = array( 'default' => theme_layouts_get_string( 'default' ) );

		/* Loop through each of the layouts and add it to the choices array with proper key/value pairs. */
		foreach ( $supports[0] as $layout )
			$layout_choices[$layout] = theme_layouts_get_string( $layout );

		/* Add the layout control. */
		$wp_customize->add_control(
			"{$prefix}_theme_settings[layout]",
			array(
				'label' => 		esc_html__( 'Default Layout', 'unique' ),
				'section' => 	"{$prefix}-layout",
				'settings' => 	"{$prefix}_theme_settings[layout]",
				'type' =>		'radio',
				'choices' =>	$layout_choices
			)
		);

		/* If viewing the customize preview screen, add a script to show a live preview. */
		if ( $wp_customize->is_preview() && !is_admin() )
			add_action( 'wp_footer', 'unique_customize_preview_script', 21 );
	}
}

/**
 * Handles the live preview of changing the layouts.
 *
 * @since 0.1.0
 * @access public
 * @return void
 */
function unique_customize_preview_script() { ?>

	<script type="text/javascript">
	wp.customize(
		'<?php echo hybrid_get_prefix(); ?>_theme_settings[layout]',
		function( value ) {
			value.bind( 
				function( to ) {
					var classes = jQuery( 'body' ).attr( 'class' ).replace( /layout-[a-zA-Z0-9_-]*/g, '' );
					jQuery( 'body' ).attr( 'class', classes ).addClass( 'layout-' + to );
				} 
			);
		}
	);
	</script>
	<?php
}

?>
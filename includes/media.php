<?php
/**
 * Functions for handling media, scripts, and styles in the theme.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Filter the style.css to allow for a style.min.css stylesheet. */
add_filter( 'stylesheet_uri', 'unique_min_stylesheet_uri', 10, 2 );

/* Register and load scripts. */
add_action( 'wp_enqueue_scripts', 'unique_enqueue_scripts' );

/* Add custom image sizes. */
add_action( 'init', 'unique_add_image_sizes' );

/**
 * Filters the active theme's 'style.css' file and replaces it with a 'style.min.css' file if it 
 * exists.  The purpose of the 'style.min.css' file is to offer a compressed version of the theme 
 * stylesheet for faster load times.
 *
 * @since 0.1.0
 * @access public
 * @param string $stylesheet_uri The active theme's stylesheet URI.
 * @param string $stylesheet_directory_uri The active theme's directory URI.
 * @return string
 */
function unique_min_stylesheet_uri( $stylesheet_uri, $stylesheet_dir_uri ) {

	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
		return $stylesheet_uri;

	$stylesheet = str_replace( trailingslashit( $stylesheet_dir_uri ), '', $stylesheet_uri );

	$stylesheet = str_replace( '.css', '.dev.css', $stylesheet );

	if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'style.min.css' ) )
		$stylesheet_uri = trailingslashit( $stylesheet_dir_uri ) . 'style.min.css';

	return $stylesheet_uri;
}

/**
 * Registers and loads the theme's scripts.
 *
 * @since 0.1.0
 * @access public
 * @return void
 */
function unique_enqueue_scripts() {

	/* Enqueue the 'flexslider' script. */
	wp_enqueue_script( 'flexslider', trailingslashit( THEME_URI ) . 'js/flexslider/flexslider.js', array( 'jquery' ), '20120713', true );

	/* Enqueue the Unique theme script. */
	wp_enqueue_script( 'unique-theme', trailingslashit( THEME_URI ) . 'js/unique.js', array( 'flexslider' ), '20120725', true );
}

/**
 * Adds custom image sizes for featured images.  The 'feature' image size is used for sticky posts.
 *
 * @since 0.1.0
 * @access public
 * @return void
 */
function unique_add_image_sizes() {
	add_image_size( 'unique-slider', 960, 400, true );
}

/**
 * Returns a set of image attachment links based on size.
 *
 * @since 0.1.0
 * @access public
 * @return void
 * @return string Links to various image sizes for the image attachment.
 */
function unique_get_image_size_links() {

	/* If not viewing an image attachment page, return. */
	if ( !wp_attachment_is_image( get_the_ID() ) )
		return;

	/* Set up an empty array for the links. */
	$links = array();

	/* Get the intermediate image sizes and add the full size to the array. */
	$sizes = get_intermediate_image_sizes();
	$sizes[] = 'full';

	/* Loop through each of the image sizes. */
	foreach ( $sizes as $size ) {

		/* Get the image source, width, height, and whether it's intermediate. */
		$image = wp_get_attachment_image_src( get_the_ID(), $size );

		/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
		if ( !empty( $image ) && ( true === $image[3] || 'full' == $size ) )
			$links[] = "<a class='image-size-link' href='" . esc_url( $image[0] ) . "'>{$image[1]} &times; {$image[2]}</a>";
	}

	/* Join the links in a string and return. */
	return join( ' <span class="sep">/</span> ', $links );
}

/**
 * Displays an attachment image's metadata and exif data while viewing a singular attachment page.
 *
 * Note: This function will most likely be restructured completely in the future.  The eventual plan is to 
 * separate each of the elements into an attachment API that can be used across multiple themes.  Keep 
 * this in mind if you plan on using the current filter hooks in this function.
 *
 * @since 0.1.0
 * @access public
 * @return void
 */
function unique_image_info() {

	/* Set up some default variables and get the image metadata. */
	$meta = wp_get_attachment_metadata( get_the_ID() );
	$items = array();
	$list = '';

	/* Add the width/height to the $items array. */
	$items['dimensions'] = sprintf( __( '<span class="prep">Dimensions:</span> %s', 'unique' ), '<span class="image-data"><a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &#215; %2$s pixels', 'unique' ), $meta['width'], $meta['height'] ) . '</a></span>' );

	/* If a timestamp exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['created_timestamp'] ) )
		$items['created_timestamp'] = sprintf( __( '<span class="prep">Date:</span> %s', 'unique' ), '<span class="image-data">' . date( get_option( 'date_format' ), $meta['image_meta']['created_timestamp'] ) . '</span>' );

	/* If a camera exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['camera'] ) )
		$items['camera'] = sprintf( __( '<span class="prep">Camera:</span> %s', 'unique' ), '<span class="image-data">' . $meta['image_meta']['camera'] . '</span>' );

	/* If an aperture exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['aperture'] ) )
		$items['aperture'] = sprintf( __( '<span class="prep">Aperture:</span> %s', 'unique' ), '<span class="image-data">' . sprintf( __( 'f/%s', 'unique' ), $meta['image_meta']['aperture'] ) . '</span>' );

	/* If a focal length is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['focal_length'] ) )
		$items['focal_length'] = sprintf( __( '<span class="prep">Focal Length:</span> %s', 'unique' ), '<span class="image-data">' . sprintf( __( '%s mm', 'unique' ), $meta['image_meta']['focal_length'] ) . '</span>' );

	/* If an ISO is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['iso'] ) )
		$items['iso'] = sprintf( __( '<span class="prep">ISO:</span> %s', 'unique' ), '<span class="image-data">' . $meta['image_meta']['iso'] . '</span>' );

	/* If a shutter speed is given, format the float into a fraction and add it to the $items array. */
	if ( !empty( $meta['image_meta']['shutter_speed'] ) ) {

		if ( ( 1 / $meta['image_meta']['shutter_speed'] ) > 1 ) {
			$shutter_speed = '1/';

			if ( number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0 ) )
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0, '.', '' );
			else
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1, '.', '' );
		} else {
			$shutter_speed = $meta['image_meta']['shutter_speed'];
		}

		$items['shutter_speed'] = sprintf( __( '<span class="prep">Shutter Speed:</span> %s', 'unique' ), '<span class="image-data">' . sprintf( __( '%s sec', 'unique' ), $shutter_speed ) . '</span>' );
	}

	/* Allow devs to overwrite the array of items. */
	$items = apply_atomic( 'image_info_items', $items );

	/* Loop through the items, wrapping each in an <li> element. */
	foreach ( $items as $item )
		$list .= "<li>{$item}</li>";

	/* Format the HTML output of the function. */
	$output = '<div class="image-info"><h3>' . __( 'Image Info', 'unique' ) . '</h3><ul>' . $list . '</ul></div>';

	/* Display the image info and allow devs to overwrite the final output. */
	echo apply_atomic( 'image_info', $output );
}

?>
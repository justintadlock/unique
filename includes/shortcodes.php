<?php
/**
 * Shortcodes bundled for use with themes.  These shortcodes are not meant to be used with the post content 
 * editor.  Their purpose is to make it easier for users to filter hooks without having to know too much PHP code
 * and to provide access to specific functionality in other (non-post content) shortcode-aware areas.
 *
 * @package Unique
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/unique
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Register shortcodes. */
add_action( 'init', 'unique_register_shortcodes' );

/**
 * Registers shortcodes for the Unique theme.
 *
 * @since 0.1.0
 */
function unique_register_shortcodes() {

	/* Adds the [entry-mood] shortcode. */
	add_shortcode( 'entry-mood', 'unique_entry_mood_shortcode' );

	/* Adds the [entry-views] shortcode. */
	add_shortcode( 'entry-views', 'unique_entry_views_shortcode' );
}

/**
 * Returns the mood for the current post.  The mood is set by the 'mood' custom field.
 *
 * @since 0.1.0
 * @access public
 * @param array $attr The shortcode arguments.
 * @return string
 */
function unique_entry_mood_shortcode( $attr ) {

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );

	$mood = get_post_meta( get_the_ID(), 'mood', true );

	if ( !empty( $mood ) )
		$mood = $attr['before'] . convert_smilies( $mood ) . $attr['after'];

	return $mood;
}

/**
 * Displays the entry views count for the current post in the loop.
 *
 * @since 0.1.0
 * @access public
 * @param array $attr The shortcode arguments.
 * @return string
 */
function unique_entry_views_shortcode( $attr ) {

	$attr = shortcode_atts( array( 'before' => '', 'after' => '' ), $attr );

	if ( current_theme_supports( 'entry-views' ) ) {
		$views = entry_views_get();

		return $attr['before'] . sprintf( _n( '%s View', '%s Views', $views, 'unique' ), $views ) . $attr['after'];
	}

	return '';
}

?>
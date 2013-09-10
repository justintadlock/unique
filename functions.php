<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Unique
 * @subpackage Functions
 * @version    0.2.0
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2012 - 2013, Justin Tadlock
 * @link       http://themehybrid.com/themes/unique
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'unique_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function unique_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Load unique theme includes. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/media.php' );

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'footer' ) );
	add_theme_support( 'hybrid-core-scripts', array( 'comment-reply' ) );
	add_theme_support( 'hybrid-core-styles', array( '25px', 'gallery', 'parent', 'style' ) );
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Add theme support for framework extensions. */
	add_theme_support( 
		'theme-layouts', 
		array( '1c', '2c-l', '2c-r', '3c-l', '3c-r', '3c-c' ),
		array( 'default' => '2c-l', 'customizer' => true )
	);

	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'cleaner-caption' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) );

	/* Add support for a custom header image (logo). */
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1080,
			'height'      => 200,
			'flex-height' => true,
			'flex-width'  => false,
			'header-text' => false
		)
	);

	/* Add support for a custom background. */
	add_theme_support( 
		'custom-background',
		array(
			'default-color'    => 'f1f1f1',
			'default-image'    => trailingslashit( get_template_directory_uri() ) . 'images/bg.png',
			'wp-head-callback' => 'unique_custom_background_callback'
		)
	);

	/* Register shortcodes. */
	add_action( 'init', 'unique_register_shortcodes' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'unique_embed_defaults' );

	/* Set content width. */
	hybrid_set_content_width( 620 );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'unique_disable_sidebars' );
	add_action( 'template_redirect', 'unique_theme_layout' );

	/* Add classes to the comments pagination. */
	add_filter( 'previous_comments_link_attributes', 'unique_previous_comments_link_attributes' );
	add_filter( 'next_comments_link_attributes', 'unique_next_comments_link_attributes' );

	/* Filters the image/gallery post format archive galleries. */
	add_filter( "{$prefix}_post_format_archive_gallery_columns", 'unique_archive_gallery_columns' );

	/* Register additional widgets. */
	add_action( 'widgets_init', 'unique_register_widgets' );

	/* Add additional contact methods. */
	add_filter( 'user_contactmethods', 'unique_contact_methods' );

	/* Custom search form template. */
	add_filter( 'get_search_form', 'unique_search_form' );

	/** Hybrid Core 1.6 changes **/
	add_filter( "{$prefix}_sidebar_defaults", 'unique_sidebar_defaults'  );
	add_filter( 'cleaner_gallery_defaults',   'unique_gallery_defaults'  );
	add_filter( 'the_content',                'unique_aside_infinity', 9 );
	/****************************/
}

/**
 * Loads extra widget files and registers the widgets.
 * 
 * @since  0.1.0
 * @access public
 * @return void
 */
function unique_register_widgets() {

	/* Load and register the image stream widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-image-stream.php' );
	register_widget( 'Unique_Widget_Image_Stream' );

	/* Load and register the newsletter widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-newsletter.php' );
	register_widget( 'Unique_Widget_Newsletter' );

	/* Load and register the list sub-pages widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-list-sub-pages.php' );
	register_widget( 'Unique_Widget_List_Sub_Pages' );

	/* Load and register the user profile widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-user-profile.php' );
	register_widget( 'Unique_Widget_User_Profile' );

	/* Load and register the most-commented posts widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-most-commented.php' );
	register_widget( 'Unique_Widget_Most_Commented' );

	/* Load and register the image widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-image.php' );
	register_widget( 'Unique_Widget_Image' );

	/* Load and register the gallery posts widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-gallery-posts.php' );
	register_widget( 'Unique_Widget_Gallery_Posts' );

	/* Load and register the image posts widget. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/widget-image-posts.php' );
	register_widget( 'Unique_Widget_Image_Posts' );
}

/**
 * Sets the number of columns to show on image and gallery post format archives pages based on the 
 * layout that is currently being used.
 *
 * @since 0.1.0
 * @access public
 * @param int $columns Number of gallery columns to display.
 * @return int $columns
 */
function unique_archive_gallery_columns( $columns ) {

	/* Only run the code if the theme supports the 'theme-layouts' feature. */
	if ( current_theme_supports( 'theme-layouts' ) ) {

		/* Get the current theme layout. */
		$layout = theme_layouts_get_layout();

		if ( 'layout-1c' == $layout )
			$columns = 4;

		elseif ( in_array( $layout, array( 'layout-3c-l', 'layout-3c-r', 'layout-3c-c' ) ) )
			$columns = 2;
	}

	return $columns;
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 0.1.0
 * @access public
 * @return void
 */
function unique_theme_layout() {

	if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
		add_filter( 'theme_mod_theme_layout', 'unique_theme_layout_one_column' );

	elseif ( is_attachment() && wp_attachment_is_image() && 'default' == get_post_layout( get_queried_object_id() ) )
		add_filter( 'theme_mod_theme_layout', 'unique_theme_layout_one_column' );

	elseif ( is_page_template( 'page/page-template-magazine.php' ) )
		add_filter( 'theme_mod_theme_layout', 'unique_theme_layout_one_column' );
}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since 0.1.0
 * @access public
 * @param string $layout The layout of the current page.
 * @return string
 */
function unique_theme_layout_one_column( $layout ) {
	return '1c';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 0.1.0
 * @access public
 * @param array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function unique_disable_sidebars( $sidebars_widgets ) {

	if ( current_theme_supports( 'theme-layouts' ) && !is_admin() ) {

		if ( 'layout-1c' == theme_layouts_get_layout() ) {
			$sidebars_widgets['primary'] = false;
			$sidebars_widgets['secondary'] = false;
		}
	}

	return $sidebars_widgets;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 * @access public
 * @param array $args Default embed arguments.
 * @return array
 */
function unique_embed_defaults( $args ) {

	$args['width'] = 620;

	if ( current_theme_supports( 'theme-layouts' ) ) {

		$layout = theme_layouts_get_layout();

		if ( 'layout-3c-l' == $layout || 'layout-3c-r' == $layout || 'layout-3c-c' == $layout )
			$args['width'] = 500;
		elseif ( 'layout-1c' == $layout )
			$args['width'] = 980;
	}

	return $args;
}

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since 0.1.0
 * @access public
 * @param string $attributes The previous comments link attributes.
 * @return string
 */
function unique_previous_comments_link_attributes( $attributes ) {
	return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since 0.1.0
 * @access public
 * @param string $attributes The next comments link attributes.
 * @return string
 */
function unique_next_comments_link_attributes( $attributes ) {
	return $attributes . ' class="next"';
}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What 
 * happens is the theme's background image hides the user-selected background color.  If a user selects a 
 * background image, we'll just use the WordPress custom background callback.
 *
 * @since 0.1.0
 * @access public
 * @link http://core.trac.wordpress.org/ticket/16919
 * @return void
 */
function unique_custom_background_callback() {

	// $background is the saved custom image or the default image.
	$background = get_background_image();

	// $color is the saved custom color or the default image.
	$color = get_background_color();

	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', 'left' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', 'scroll' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}

?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}

/**
 * Adds new contact methods to the user profile screen for more modern social media sites.
 *
 * @since 0.1.0
 * @access public
 * @param array $meta Array of contact methods.
 * @return array $meta
 */
function unique_contact_methods( $meta ) {

	/* Twitter contact method. */
	$meta['twitter'] = __( 'Twitter Username', 'unique' );

	/* Google+ contact method. */
	$meta['google_plus'] = __( 'Google+ URL', 'unique' );

	/* Facebook contact method. */
	$meta['facebook'] = __( 'Facebook URL', 'unique' );

	/* Return the array of contact methods. */
	return $meta;
}

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
 * Creates a custom search form by filtering the 'get_search_form' hook.
 *
 * @since  0.2.0
 * @access public
 * @param  string  $form
 * @return string
 */
function unique_search_form( $form ) {

	$value       = get_search_query() ? esc_attr( get_search_query() ) : '';
	$placeholder = esc_attr__( 'Enter search terms...', 'unique' );

	$form  = "\n\t\t" . '<form method="get" class="search-form" action="' . trailingslashit( home_url() ) . '">';
	$form .= "\n\t\t\t" . '<div class="search-wrap">';
	$form .= "\n\t\t\t\t" . '<input class="search-text" type="text" name="s" value="' . $value . '" placeholder="' . $placeholder . '" />';
	$form .= "\n\t\t\t\t" . '<input class="search-submit" name="submit" type="submit" value="' . esc_attr__( 'Search', 'unique' ) . '" />';
	$form .= "\n\t\t\t" . '</div>';
	$form .= "\n\t\t" . '</form><!-- .search-form -->';

	return $form;
}

/* === HYBRID CORE 1.6 CHANGES. === 
 *
 * The following changes are slated for Hybrid Core version 1.6 to make it easier for 
 * theme developers to build awesome HTML5 themes. The code will be removed once 1.6 
 * is released.
 */

	/**
	 * Sidebar parameter defaults.
	 *
	 * @since  0.2.0
	 * @access public
	 * @param  array  $defaults
	 * @return array
	 */
	function unique_sidebar_defaults( $defaults ) {

		$defaults = array(
			'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		);

		return $defaults;
	}

	/**
	 * Gallery defaults for the Cleaner Gallery extension.
	 *
	 * @since  0.2.0
	 * @access public
	 * @param  array  $defaults
	 * @return array
	 */
	function unique_gallery_defaults( $defaults ) {

		$defaults['itemtag']    = 'figure';
		$defaults['icontag']    = 'div';
		$defaults['captiontag'] = 'figcaption';

		return $defaults;
	}

	/**
	 * Adds an infinity character "&#8734;" to the end of the post content on 'aside' posts.  This 
	 * is from version 0.1.1 of the Post Format Tools extension.
	 *
	 * @since  0.2.0
	 * @access public
	 * @param  string $content The post content.
	 * @return string $content
	 */
	function unique_aside_infinity( $content ) {

		if ( has_post_format( 'aside' ) && !is_singular() )
			$content .= ' <a class="permalink" href="' . get_permalink() . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '">&#8734;</a>';

		return $content;
	}

/* End Hybrid Core 1.6 section. */

?>
/**
 * @version 20130326
 */

var $j = jQuery.noConflict();

$j( document ).ready(

	function() {

		/* Mobile menu. */
		$j( '.menu-toggle' ).click(
			function() {
				$j( this ).parent().children( '.wrap, .menu-items' ).fadeToggle();
				$j( this ).toggleClass( 'active' );
			}
		);

		/* Responsive videos. */
		$j( '.format-video object, .format-video embed, .format-video iframe' ).removeAttr( 'width height' ).wrap( '<div class="embed-wrap" />' );

		/* Flexslider. */
		if ( $j.isFunction( $j.fn.flexslider ) ) {

			/* Flexslider */
			$j( '.flexslider' ).flexslider(
				{
					animation: "slide",
					selector: ".slides > .slide"
				}
			);
		}
	}
);
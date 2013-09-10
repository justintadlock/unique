var $j = jQuery.noConflict();

$j( document ).ready(

	function() {

		/* Responsive videos. */
		$j( '.format-video object, .format-video embed, .format-video iframe' ).removeAttr( 'width height' ).wrap( '<div class="embed-wrap" />' );

		/* Flexslider */
		$j( '.flexslider' ).flexslider(
			{
				animation: "slide"
			}
		);

		/* Slider captions. */
		$j( '.flexslider .slide-caption' ).css( 'opacity', 0.85 );

		/* WordPress captions. */
		$j( '.wp-caption-text' ).css( 'opacity', 0.85 );

		/* Search form in a menu on focus. */
		$j( '.menu-container .search-text' ).focus(
			function() { 
				$j( this ).animate(
					{
						width: '140px'
					}, 
					300, 
					function() {
						// Animation complete.
					}
				);
			}
		);

		/* Close search form. */
		$j( '.menu-container .search-text' ).blur(
			function() { 
				$j( this ).animate(
					{
						width: '0px'
					}, 
					300, 
					function() {
						// Animation complete.
					}
				);
			}
		);

	}
);
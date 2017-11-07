'use strict';

function _hogan_embed_load_responsive_iframes( event ) {

	$( '.hogan-module-embed iframe:not([data-ratio])' ).each( function() {
		$(this).attr( 'data-ratio', parseFloat( $(this).attr( 'width' ) / $(this).attr( 'height' ) ) );
	} );

	_hogan_embed_adjust_responsive_iframes( event ); // Initial adjust
}

function _hogan_embed_adjust_responsive_iframes( event ) {

	$( '.hogan-module-embed iframe[data-ratio]' ).each( function() {
		$(this).height( parseInt( $(this).width() / $(this).data( 'ratio' ) ) );
	} );
}

( function( $ ) {

	// Make embedded iframes responsive (Reset height based on original ratio on window resize)
	$( document ).ready( _hogan_embed_load_responsive_iframes );
	$( window ).resize( _hogan_embed_adjust_responsive_iframes );

} )( jQuery );

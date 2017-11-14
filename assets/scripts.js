'use strict';

function _hogan_embed_load_responsive_iframes( event ) {

	jQuery( '.hogan-module-embed iframe:not([data-ratio])' ).each( function() {
		jQuery(this).attr( 'data-ratio', parseFloat( jQuery( this ).attr( 'width' ) / jQuery( this ).attr( 'height' ) ) );
	} );

	_hogan_embed_adjust_responsive_iframes( event ); // Initial adjust
}

function _hogan_embed_adjust_responsive_iframes( event ) {

	jQuery( '.hogan-module-embed iframe[data-ratio]' ).each( function() {
		jQuery( this ).height( parseInt( jQuery( this ).width() / jQuery( this ).data( 'ratio' ) ) );
	} );
}

( function( $ ) {

	// Make embedded iframes responsive (Reset height based on original ratio on window resize)
	jQuery( document ).ready( _hogan_embed_load_responsive_iframes );
	jQuery( window ).resize( _hogan_embed_adjust_responsive_iframes );

} )( jQuery );

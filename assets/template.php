<?php
/**
 * Embed Module template
 *
 * $this is an instace of the Embed object.
 *
 * Available properties:
 * $this->content (string) Embed HTML code.
 * $this->content_allowed_html (array) Allowed HTML.
 * $this->caption (string) Caption HTML code.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Embed ) ) {
	return; // Exit if accessed directly.
}

echo wp_kses( $this->content, $this->content_allowed_html );

if ( ! empty( $this->caption ) ) {
	hogan_component( 'caption', [
		'content' => $this->caption,
	] );
}

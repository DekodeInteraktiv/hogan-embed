<?php
/**
 * Embed Module template
 *
 * $this is an instace of the Embed object.
 *
 * Available properties:
 * $this->content (string) Embed HTML code.
 * $this->caption (string) Caption HTML code.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Embed ) ) {
	return; // Exit if accessed directly.
}

echo $this->content; // WPCS: XSS OK.

if ( ! empty( $this->caption ) ) {
	hogan_component( 'caption', [
		'content' => $this->caption,
	] );
}

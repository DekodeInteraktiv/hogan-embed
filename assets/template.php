<?php
/**
 * Embed Module template
 *
 * $this is an instace of the Embed object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
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

?>

<?php if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php endif; ?>

<?php echo wp_kses( $this->content, $this->content_allowed_html ); ?>

<?php if ( ! empty( $this->caption ) ) : ?>
	<figcaption><?php echo wp_kses( $this->caption, hogan_caption_allowed_html() ); ?></figcaption>
<?php endif; ?>

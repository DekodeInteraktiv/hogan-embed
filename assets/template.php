<?php
/**
 * Template for embed module
 *
 * $this is an instace of the Embed object. Ex. use: $this->content to output content value.
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Embed ) ) {
	return; // Exit if accessed directly.
}

$embed_allowed_html = apply_filters( 'hogan/module/embed/content/allowed_html', [
	'a' => [
		'href' => true,
	],
	'blockquote' => [],
	'iframe' => [
		'src' => true,
		'width' => true,
		'height' => true,
		'frameborder' => true,
		'marginwidth' => true,
		'marginheight' => true,
		'scrolling' => true,
		'title' => true,
	],
] );

// CSS classes for inner wrapper <figure>.
$classes = apply_filters( 'hogan/module/embed/inner_wrapper_classes', [], $this );
$classes = trim( implode( ' ', array_filter( $classes ) ) );

?>

<figure class="<?php echo esc_attr( $classes ); ?>">

	<?php if ( ! empty( $this->heading ) ) : ?>
		<h1 class="heading"><?php echo esc_html( $this->heading ); ?></h1>
	<?php endif; ?>

	<?php echo wp_kses( $this->content, $embed_allowed_html ); ?>

	<?php if ( ! empty( $this->caption ) ) : ?>
		<figcaption><?php echo wp_kses_post( $this->caption ); ?></figcaption>
	<?php endif; ?>

</figure>

<?php
/**
 * Embed module class
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Embed' ) ) {

	/**
	 * Embed module class (WYSIWYG).
	 *
	 * @extends Modules base class.
	 */
	class Embed extends Module {

		/**
		 * Embed heading
		 *
		 * @var string $heading
		 */
		public $heading;

		/**
		 * Embed content
		 *
		 * @var string $content
		 */
		public $content;

		/**
		 * Allowed HTML for embed content
		 *
		 * @var string $content_allowed_html
		 */
		public $content_allowed_html;

		/**
		 * WYSIWYG caption
		 *
		 * @var string $caption ;
		 */
		public $caption;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Embed', 'hogan-embed' );
			$this->template = __DIR__ . '/assets/template.php';

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
			add_filter( 'oembed_dataparse', [ $this, 'manipulate_oembed_html' ], 99, 2 );

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 */
		public function get_fields() {

			$fields = [];

			// Heading field can be disabled using filter hogan/module/embed/heading/enabled (true/false).
			hogan_append_heading_field( $fields, $this );

			$fields[] = [
				'type'   => 'oembed',
				'key'    => $this->field_key . '_content',
				'name'   => 'content',
				'width'  => 815,
				'height' => 458,
			];

			if ( true === apply_filters( 'hogan/module/embed/caption/enabled', true ) ) {

				$fields[] = [
					'type'         => 'wysiwyg',
					'key'          => $this->field_key . '_caption',
					'name'         => 'caption',
					'label'        => __( 'Caption below the embedded object.', 'hogan-embed' ),
					'delay'        => true,
					'tabs'         => apply_filters( 'hogan/module/embed/caption/tabs', 'visual' ),
					'media_upload' => apply_filters( 'hogan/module/embed/caption/allow_media_upload', 0 ),
					'toolbar'      => apply_filters( 'hogan/module/embed/caption/toolbar', 'hogan_caption' ),
					'wrapper'      => [
						'class' => apply_filters( 'hogan/module/embed/caption/wrapper_class', 'small-height-editor' ),
					],
				];

			}

			return $fields;
		}

		/**
		 * Enqueue module assets
		 */
		public function enqueue_assets() {

			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : false;

			wp_enqueue_style( 'hogan-embed', plugins_url( '/assets/styles.css', __FILE__ ), [], $_version );
		}

		/**
		 * Wrap iframe code in responsive wrapper
		 *
		 * @param string $html The returned oEmbed HTML.
		 * @param object $data A data object result from an oEmbed provider.
		 *
		 * @return string Video iframe code with responsive wrapper
		 */
		public function manipulate_oembed_html( $html, $data ) {

			// Verify oembed data (as done in the oEmbed data2html code).
			if ( ! is_object( $data ) || empty( $data->type ) ) {
				return $html;
			}

			// Verify that it is a video.
			if ( 'video' !== $data->type ) {
				return $html;
			}

			// Calculate padding bottom percentage.
			$ar = ( $data->height / $data->width ) * 100;

			// Strip width and height from html.
			$html = preg_replace( '/(width|height)="\d*"\s/', '', $html );

			// Return code.
			return '<div class="embed-responsive" style="padding-bottom: ' . $ar . '%;">' . $html . '</div>';
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {

			$this->heading = $content['heading'] ?? null;
			$this->content = $content['content'];
			$this->caption = $content['caption'] ?? null;

			$this->content_allowed_html = apply_filters( 'hogan/module/embed/content/allowed_html', [
				'a' => [
					'href' => true,
				],
				'blockquote' => [],
				'div' => [
					'class' => true,
					'style' => true,
				],
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

			parent::load_args_from_layout_content( $content );

			add_filter( 'hogan/module/embed/inner_wrapper_tag', function () {
				return 'figure';
			} );

		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() {
			return ! empty( $this->content );
		}
	}
}

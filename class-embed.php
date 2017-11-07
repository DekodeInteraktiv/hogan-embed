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
		 * Embed content
		 *
		 * @var string $content
		 */
		public $content;

		/**
		 * WYSIWYG caption
		 *
		 * @var string $caption;
		 */
		public $caption;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label = __( 'Embed', 'hogan-embed' );
			$this->template = __DIR__ . '/assets/template.php';

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 */
		public function get_fields() {

			$fields = [
				[
					'type' => 'oembed',
					'key' => $this->field_key . '_content',
					'name' => 'content',
					'width' => 815,
					'height' => 458,
				],
			];

			if ( true === apply_filters( 'hogan/module/embed/include_caption', true ) ) {
				$fields[] = [
					'type' => 'wysiwyg',
					'key' => $this->field_key . '_caption',
					'name' => 'caption',
					'label' => __( 'Caption below the embedded object.', 'hogan-embed' ),
					'delay' => true,
					'tabs' => apply_filters( 'hogan/module/embed/caption/tabs', 'all' ),
					'media_upload' => apply_filters( 'hogan/module/embed/caption/allow_media_upload', 0 ),
					'toolbar' => apply_filters( 'hogan/module/embed/caption/toolbar', 'hogan' ),
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
			wp_enqueue_script( 'hogan-embed', plugins_url( '/assets/scripts.js', __FILE__ ), [ 'jquery' ], $_version, true );
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {

			$this->content = $content['content'];
			$this->caption = $content['caption'] ?? null;

			parent::load_args_from_layout_content( $content );
		}
	}
}

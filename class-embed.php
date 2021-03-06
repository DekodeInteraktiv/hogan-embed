<?php
/**
 * Embed module class.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Embed' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Embed module class.
	 *
	 * @extends Modules base class.
	 */
	class Embed extends Module {

		/**
		 * Embed HTML content.
		 *
		 * @var string $content
		 */
		public $content;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Embed', 'hogan-embed' );
			$this->template = __DIR__ . '/assets/template.php';

			add_filter( 'oembed_dataparse', [ $this, 'manipulate_oembed_html' ], 99, 2 );
			add_filter( 'pre_kses', [ $this, 'allow_facebook_url_in_kses' ], 10, 1 );

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [
				[
					'type'         => 'oembed',
					'key'          => $this->field_key . '_content',
					'name'         => 'content',
					'label'        => '',
					// Translators: %s: url to codex.
					'instructions' => sprintf( __( 'You can find a list of possible embeds <a href="%s">here</a>.', 'hogan-embed' ), 'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
					'width'        => 815,
					'height'       => 458,
				],
			];

			hogan_append_caption_field( $fields, $this );

			return $fields;
		}

		/**
		 * Enqueue module assets
		 */
		public function enqueue_assets() {

			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : HOGAN_EMBED_VERSION;

			wp_enqueue_style( 'hogan-embed', plugins_url( '/assets/hogan-embed.css', __FILE__ ), [], $_version );
		}

		/**
		 * Wrap iframe code in responsive wrapper
		 *
		 * @param string $html The returned oEmbed HTML.
		 * @param object $data A data object result from an oEmbed provider.
		 *
		 * @return string The returned oEmbed HTML with responsive wrapper
		 */
		public function manipulate_oembed_html( string $html, $data ) : string {

			// Verify oembed data (as done in the oEmbed data2html code).
			if ( ! is_object( $data ) || empty( $data->type ) || is_admin() ) {
				return $html;
			}

			// Don't manipulate the embed if fetched from the rest api.
			if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
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
			return apply_filters(
				'hogan/module/embed/manipulate_oembed_html',
				'<div class="embed-responsive" style="padding-bottom: ' . $ar . '%;">' . $html . '</div>',
				$html,
				$data
			);
		}

		/**
		 * Override pre_kses to allow Facebook to async load the Connect API.
		 *
		 * @param string $string Content to run through kses.
		 * @return string Content to run through kses.
		 */
		public function allow_facebook_url_in_kses( string $string ) : string {

			/**
			 * The wp_kses_normalize_entities() function used by wp_kses() will replace & with &amp; - this will result in Facebook embeds failing to load.
			 * This ugly hack will reinsert the original &.
			 */
			if ( false !== strpos( $string, 'sdk.js#xfbml=1&amp;version=' ) ) {
				$string = str_replace( 'sdk.js#xfbml=1&amp;version=', 'sdk.js#xfbml=1&version=', $string );
			}

			return $string;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->content = $raw_content['content'] ?? '';

			// Remove unwanted Instagram inline CSS. (safecss_filter_attr will disard any inline css containing \ ( & } = or comments).
			$this->content = str_replace( [ 'rgba(0,0,0,0.5)', 'rgba(0,0,0,0.15)' ], 'transparent', $this->content );
			$this->content = str_replace( 'width:-webkit-calc(100% - 2px);', '', $this->content );
			$this->content = str_replace( 'calc(100% - 2px);', '100%', $this->content );

			parent::load_args_from_layout_content( $raw_content, $counter );
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return ! empty( $this->content );
		}
	}
}

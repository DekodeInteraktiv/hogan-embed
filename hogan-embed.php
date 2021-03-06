<?php
/**
 * Plugin Name: Hogan Module: Embed
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-embed
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/hogan-embed
 * Description: oEmbed Module for Hogan
 * Version: 1.2.1
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: hogan-embed
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types = 1 );
namespace Dekode\Hogan\Embed;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HOGAN_EMBED_VERSION', '1.2.1' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_embed_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_embed_register_module', 10, 1 );

/**
 * Register module text domain
 *
 * @return void
 */
function hogan_embed_load_textdomain() {
	\load_plugin_textdomain( 'hogan-embed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 *
 * @param \Dekode\Hogan\Core $core Hogan Core instance.
 * @return void
 */
function hogan_embed_register_module( \Dekode\Hogan\Core $core ) {
	require_once 'class-embed.php';
	$core->register_module( new \Dekode\Hogan\Embed() );
}

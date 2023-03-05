<?php
/**
 * The main plugin file for WooCommerce Custom Add To Cart Button. Included during the bootstrap process if the plugin is active.
 *
 * @package   Barn2\woo-custom-add-to-cart-button
 * @author    Barn2 Plugins <support@barn2.co.uk>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 *
 * @wordpress-plugin
 * Plugin Name:     WooCommerce Custom Add To Cart Button
 * Plugin URI:      https://barn2.co.uk/wordpress-plugins/woo-custom-add-to-cart-button/
 * Description:     Customize the Add to Cart buttons in WooCommerce by changing the text or adding a cart icon.
 * Version:         1.1.5
 * Author:          Barn2 Plugins
 * Author URI:      https://barn2.co.uk
 * Text Domain:     woo-custom-add-to-cart-button
 * Domain Path:     /languages
 *
 * WC requires at least: 3.7
 * WC tested up to: 7.4.1
 *
 * Copyright:       Barn2 Media Ltd
 * License:         GNU General Public License v3.0
 * License URI:     https://www.gnu.org/licenses/gpl.html
 */
namespace Barn2\Plugin\WC_Custom_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const PLUGIN_VERSION = '1.1.5';
const PLUGIN_FILE    = __FILE__;

// Autoloader.
require_once __DIR__ . '/vendor/autoload.php';

// Helper function to access the shared plugin instance.
function wc_custom_cart_button() {
    return Plugin_Factory::create( PLUGIN_FILE, PLUGIN_VERSION );
}

// Load the plugin
wc_custom_cart_button()->register();

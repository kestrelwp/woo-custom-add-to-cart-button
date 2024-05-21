<?php
/**
 * The main plugin file for WooCommerce Custom Add To Cart Button. Included during the bootstrap process if the plugin is active.
 *
 * @package   Barn2\woo-custom-add-to-cart-button
 * @author    Kestrel <support@kestrelwp.com>
 * @license   GPL-3.0
 * @copyright Kestrel
 *
 * @wordpress-plugin
 * Plugin Name:     WooCommerce Custom Add To Cart Button
 * Plugin URI:      https://kestrelwp.com/product/custom-add-to-cart-button-for-woocommerce/
 * Description:     Customize the Add to Cart buttons in WooCommerce by changing the text or adding a cart icon.
 * Version:         1.2.5
 * Author:          Kestrel
 * Author URI:      https://kestrelwp.com
 * Text Domain:     woo-custom-add-to-cart-button
 * Domain Path:     /languages
 * Requires at least: 6.0
 * Tested up to: 6.5
 * Requires PHP: 7.4
 *
 * Requires Plugins: woocommerce
 * WC requires at least: 6.5
 * WC tested up to: 8.7
 *
 * Copyright:       Kestrel
 * License:         GNU General Public License v3.0
 * License URI:     https://www.gnu.org/licenses/gpl.html
 */
namespace Barn2\Plugin\WC_Custom_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const PLUGIN_VERSION = '1.2.5';
const PLUGIN_FILE    = __FILE__;

// Autoloader.
require_once __DIR__ . '/vendor/autoload.php';

// Helper function to access the shared plugin instance.
function wc_custom_cart_button() {
    return Plugin_Factory::create( PLUGIN_FILE, PLUGIN_VERSION );
}

// Load the plugin
wc_custom_cart_button()->register();

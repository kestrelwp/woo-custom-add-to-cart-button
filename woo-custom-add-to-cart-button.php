<?php

/**
 * The main plugin file for WooCommerce Custom Add To Cart Button.
 *
 * This file is included during the WordPress bootstrap process if the plugin is active.
 *
 * @wordpress-plugin
 * Plugin Name:     WooCommerce Custom Add To Cart Button
 * Plugin URI:      https://barn2.co.uk/wordpress-plugins/woo-custom-add-to-cart-button/
 * Description:     Customize the Add to Cart buttons in WooCommerce by changing the text or adding a cart icon.
 * Version:         1.1
 * Author:          Barn2 Media
 * Author URI:      https://barn2.co.uk
 * Text Domain:     woo-custom-add-to-cart-button
 * Domain Path:     /languages
 *
 * WC requires at least: 3.0
 * WC tested up to: 3.8
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

const PLUGIN_VERSION = '1.1';
const PLUGIN_FILE    = __FILE__;

// Autoloader.
require_once plugin_dir_path( __FILE__ ) . 'autoloader.php';

// Helper function to access the shared plugin instance.
function wc_custom_cart_button() {
    return Plugin_Factory::create( PLUGIN_FILE, PLUGIN_VERSION );
}

// Load the plugin
wc_custom_cart_button()->register();

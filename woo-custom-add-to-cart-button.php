<?php
/**
 * The main plugin file for WooCommerce Custom Add To Cart Button.
 *
 * This file is included during the WordPress bootstrap process if the plugin is active.
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Custom Add To Cart Button
 * Plugin URI:		  https://barn2.co.uk/wordpress-plugins/woocommerce-custom-add-to-cart-button/
 * Description:       Change the 'Add to Cart' button text in WooCommerce, and optionally add a cart icon.
 * Version:           1.0
 * Author:            Barn2 Media
 * Author URI:        https://barn2.co.uk
 * Text Domain:       woo-custom-add-to-cart-button
 * Domain Path:       /languages
 *
 * WC requires at least: 3.0
 * WC tested up to: 3.3.2
 *
 * Copyright:		  2016-2018 Barn2 Media Ltd
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Barn2\Plugins\WC_Custom_Add_To_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The main plugin class.
 *
 * @package   Barn2\WooCommerce_Custom_Add_To_Cart_Button
 * @version   1.0
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @link      https://barn2.co.uk
 * @copyright 2016-2018 Barn2 Media Ltd
 */
class WC_Custom_Add_To_Cart_Button {

	const NAME		 = 'WooCommerce Custom Add To Cart';
	const VERSION		 = '1.0';
	const PLUGIN_FILE	 = __FILE__;

	private $plugin_basename;
	private $includes_dir;
	private $plugin_classes;

	public function __construct() {
		$this->plugin_basename	 = plugin_basename( self::PLUGIN_FILE );
		$this->includes_dir		 = plugin_dir_path( self::PLUGIN_FILE ) . 'includes/';
		$this->includes();
	}

	public static function bootstrap() {
		$self = new self();
		$self->load();
	}

	public function load() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		// Don't load anything if WooCommerce isn't installed or active
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$this->load_textdomain();
		$plugin_classes = array();

		// Add settings to the Customizer
		$plugin_classes['customizer'] = new Add_To_Cart_Customizer();

		// Initialise front-end classes
		if ( $this->is_front_end() ) {
			$plugin_classes = array_merge( $plugin_classes, array(
				'replacer'	 => new Add_To_Cart_Replacer(),
				'styles'	 => new Add_To_Cart_Styles( self::PLUGIN_FILE, self::VERSION )
				) );
		}

		$this->plugin_classes = $plugin_classes;
	}

	private function includes() {
		// Core
		require_once $this->includes_dir . 'class-util.php';

		// Front end
		require_once $this->includes_dir . 'class-add-to-cart-replacer.php';
		require_once $this->includes_dir . 'class-add-to-cart-styles.php';

		// Admin
		require_once $this->includes_dir . 'admin/class-add-to-cart-customizer.php';
	}

	private function is_front_end() {
		return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
	}

	private function load_textdomain() {
		load_plugin_textdomain( 'woo-custom-add-to-cart-button', false, dirname( $this->plugin_basename ) . '/languages' );
	}

}
// plugin class

/* Load the plugin */
WC_Custom_Add_To_Cart_Button::bootstrap();

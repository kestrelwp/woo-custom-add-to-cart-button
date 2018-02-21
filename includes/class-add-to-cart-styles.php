<?php

namespace Barn2\Plugins\WC_Custom_Add_To_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers our stylesheet and adds any CSS classes to the body and cart buttons.
 *
 * @package   WooCommerce_Custom_Add_To_Cart_Button
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @link      https://barn2.co.uk
 * @copyright 2016-2018 Barn2 Media Ltd
 */
class Add_To_Cart_Styles {

	private $assets_url;
	private $plugin_version;

	public function __construct( $path, $version ) {
		$this->assets_url		 = trailingslashit( plugins_url( 'assets', $path ) );
		$this->plugin_version	 = $version;

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
		add_filter( 'woocommerce_loop_add_to_cart_args', array( $this, 'add_loop_button_class' ), 10, 2 );
	}

	public function enqueue_styles() {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'wc-custom-add-to-cart', $this->assets_url . "css/wc-custom-add-to-cart{$min}.css", array(), $this->plugin_version );
	}

	public function add_body_class( $classes ) {
		return array_merge( $classes, $this->get_body_class() );
	}

	public function add_loop_button_class( $args, $product = null ) {
		if ( ! $product ) {
			return $args;
		}

		if ( Util::is_text_replaceable( $product ) ) {
			if ( empty( $args['class'] ) ) {
				$args['class'] = '';
			}
			$args['class'] = trim( $args['class'] . ' text_replaceable' );
		}
		return $args;
	}

	private function get_body_class() {
		$body_class = array();

		if ( 'yes' === get_option( Util::OPTION_ADD_TO_CART_ICON, 'no' ) ) {
			$body_class[] = 'wc-add-to-cart-icon';
		}
		if ( 'yes' === get_option( Util::OPTION_ADD_TO_CART_ICON_ONLY, 'no' ) ) {
			$body_class[] = 'wc-add-to-cart-no-text';
		}

		return $body_class;
	}

}
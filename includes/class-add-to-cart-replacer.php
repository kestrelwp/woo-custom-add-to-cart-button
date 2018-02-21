<?php

namespace Barn2\Plugins\WC_Custom_Add_To_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Replaces the Add to Cart button text in WooCommerce.
 *
 * @package   WooCommerce_Custom_Add_To_Cart_Button
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @link      https://barn2.co.uk
 * @copyright 2016-2018 Barn2 Media Ltd
 */
class Add_To_Cart_Replacer {

	public function __construct() {
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'replace_single_text' ), 10, 2 );
		add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'replace_loop_text' ), 10, 2 );
	}

	public function replace_single_text( $text, $product = null ) {
		if ( apply_filters( 'wcatc_replace_text_single_product', true, $product ) ) {
			$text = $this->get_add_to_cart_text();
		}
		return $text;
	}

	public function replace_loop_text( $text, $product = null ) {
		if ( apply_filters( 'wcatc_replace_text_in_loop', Util::is_text_replaceable( $product ), $product ) ) {
			$text = $this->get_add_to_cart_text();
		}
		return $text;
	}

	public function get_add_to_cart_text() {
		$text = get_option( Util::OPTION_ADD_TO_CART_TEXT, __( 'Add to cart', 'woocommerce' ) );
		return $text;
	}

}
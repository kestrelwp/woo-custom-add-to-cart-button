<?php

namespace Barn2\Plugins\WC_Custom_Add_To_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Utility functions & constants.
 *
 * @package   Barn2\WooCommerce_Custom_Add_To_Cart_Button
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @link      https://barn2.co.uk
 * @copyright 2016-2018 Barn2 Media Ltd
 */
class Util {

	const OPTION_ADD_TO_CART_TEXT		 = 'woocommerce_add_to_cart_text';
	const OPTION_ADD_TO_CART_ICON		 = 'woocommerce_add_to_cart_icon';
	const OPTION_ADD_TO_CART_ICON_ONLY = 'woocommerce_add_to_cart_icon_only';

	public static function is_text_replaceable( $product ) {
		return apply_filters( 'wcatc_is_text_replaceable', ( 'simple' === $product->get_type() && $product->is_in_stock() && $product->is_purchasable() ), $product );
	}

}
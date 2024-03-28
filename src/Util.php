<?php
namespace Barn2\Plugin\WC_Custom_Cart_Button;

/**
 * Utility functions & constants.
 *
 * @package   Barn2\woo-custom-add-to-cart-button
 * @author    Kestrel <support@kestrelwp.com>
 * @license   GPL-3.0
 * @copyright Kestrel
 */
class Util {

    const OPTION_ADD_TO_CART_TEXT                = 'woocommerce_add_to_cart_text';
    const OPTION_ADD_TO_CART_ICON                = 'woocommerce_add_to_cart_icon';
    const OPTION_ADD_TO_CART_ICON_ONLY           = 'woocommerce_add_to_cart_icon_only';
    const OPTION_ADD_TO_CART_BACKGROUND_COLOR    = 'woocommerce_add_to_cart_background_color';
    const OPTION_ADD_TO_CART_COLOR               = 'woocommerce_add_to_cart_color';

    public static function is_text_replaceable( $product ) {
        return apply_filters( 'wcatc_is_text_replaceable', ( 'simple' === $product->get_type() && $product->is_in_stock() && $product->is_purchasable() ), $product );
    }

}

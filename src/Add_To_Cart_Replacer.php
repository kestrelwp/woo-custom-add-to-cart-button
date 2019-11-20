<?php

namespace Barn2\Plugin\WC_Custom_Cart_Button;

use Barn2\Lib\Registerable;

/**
 * Replaces the Add to Cart button text in WooCommerce.
 *
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Add_To_Cart_Replacer implements Registerable {

    public function register() {
        \add_filter( 'woocommerce_product_single_add_to_cart_text', [ $this, 'replace_single_text' ], 10, 2 );
        \add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'replace_loop_text' ], 10, 2 );
    }

    public function replace_single_text( $text, $product = null ) {
        if ( \apply_filters( 'wcatc_replace_text_single_product', true, $product ) ) {
            $text = $this->get_add_to_cart_text();
        }
        return $text;
    }

    public function replace_loop_text( $text, $product = null ) {
        if ( \apply_filters( 'wcatc_replace_text_in_loop', Util::is_text_replaceable( $product ), $product ) ) {
            $text = $this->get_add_to_cart_text();
        }
        return $text;
    }

    public function get_add_to_cart_text() {
        $text = \get_option( Util::OPTION_ADD_TO_CART_TEXT, __( 'Add to cart', 'woocommerce' ) ); // pick up WooCommerce translation for this
        return $text;
    }

}

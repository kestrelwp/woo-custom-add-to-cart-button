<?php

namespace Barn2\Plugin\WC_Custom_Cart_Button;

use Barn2\Lib\Registerable;

/**
 * Registers our stylesheet and adds any CSS classes to the body and cart buttons.
 *
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Add_To_Cart_Styles implements Registerable {

    private $assets_url;
    private $plugin_version;

    public function __construct( $root_path, $version ) {
        $this->assets_url     = \trailingslashit( \plugins_url( 'assets', $root_path ) );
        $this->plugin_version = $version;
    }

    public function register() {
        \add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        \add_filter( 'body_class', [ $this, 'add_body_class' ] );
        \add_filter( 'woocommerce_loop_add_to_cart_args', [ $this, 'add_loop_button_class' ], 10, 2 );
    }

    public function enqueue_styles() {
        $min = \defined( 'SCRIPT_DEBUG' ) && \SCRIPT_DEBUG ? '' : '.min';
        \wp_enqueue_style( 'wc-custom-add-to-cart', $this->assets_url . "css/wc-custom-add-to-cart{$min}.css", [], $this->plugin_version );
    }

    public function add_body_class( $classes ) {
        return \array_merge( $classes, $this->get_body_class() );
    }

    public function add_loop_button_class( $args, $product = null ) {
        if ( ! $product ) {
            return $args;
        }

        if ( Util::is_text_replaceable( $product ) ) {
            if ( empty( $args['class'] ) ) {
                $args['class'] = '';
            }
            $args['class'] = \trim( $args['class'] . ' text_replaceable' );
        }
        return $args;
    }

    private function get_body_class() {
        $body_class = [];

        if ( 'yes' === \get_option( Util::OPTION_ADD_TO_CART_ICON, 'no' ) ) {
            $body_class[] = 'wc-add-to-cart-icon';
        }
        if ( 'yes' === \get_option( Util::OPTION_ADD_TO_CART_ICON_ONLY, 'no' ) ) {
            $body_class[] = 'wc-add-to-cart-no-text';
        }

        return $body_class;
    }

}

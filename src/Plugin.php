<?php

namespace Barn2\Plugin\WC_Custom_Cart_Button;

use Barn2\Lib\Registerable,
    Barn2\Lib\Service_Provider,
    Barn2\Lib\Plugin\Simple_Plugin;

/**
 * The main plugin class.
 *
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Plugin extends Simple_Plugin implements Registerable, Service_Provider {

    const NAME = 'WooCommerce Custom Add To Cart';

    private $services = [];

    public function __construct( $file, $version = '1.0' ) {
        parent::__construct( [
            'name'    => self::NAME,
            'file'    => $file,
            'version' => $version
        ] );
    }

    public function register() {
        // Load the text domain
        add_action( 'init', [ $this, 'load_textdomain' ], 5 );
        add_action( 'init', [ $this, 'maybe_load_plugin' ] );
    }

    public function maybe_load_plugin() {
        // Bail early if WooCommerce isn't installed.
        if ( ! \Barn2\Lib\Util::is_woocommerce_active() ) {
            return;
        }

        // Add settings to the Customizer
        $this->services['customizer'] = new Admin\Add_To_Cart_Customizer( $this->get_basename() );

        // Initialise the front-end classes
        if ( \Barn2\Lib\Util::is_front_end() ) {
            $this->services['replacer'] = new Add_To_Cart_Replacer();
            $this->services['styles']   = new Add_To_Cart_Styles( $this->get_file(), $this->get_version() );
        }

        array_map( function( $service ) {
            if ( $service instanceof Registerable ) {
                $service->register();
            }
        }, $this->services );
    }

    public function load_textdomain() {
        \load_plugin_textdomain( 'woo-custom-add-to-cart-button', false, \dirname( $this->get_basename() ) . '/languages' );
    }

    public function get_service( $id ) {
        return ! empty( $this->services[$id] ) ? $this->services[$id] : null;
    }

}

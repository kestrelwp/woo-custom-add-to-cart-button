<?php
namespace Barn2\Plugin\WC_Custom_Cart_Button;

/**
 * Factory to create/return the shared plugin instance.
 *
 * @package   Barn2\woo-custom-add-to-cart-button
 * @author    Kestrel <support@kestrelwp.com>
 * @license   GPL-3.0
 * @copyright Kestrel
 */
class Plugin_Factory {

    private static $plugin = null;

    public static function create( $file, $version ) {
        if ( null === self::$plugin ) {
            self::$plugin = new Plugin( $file, $version );
        }
        return self::$plugin;
    }

}

<?php
namespace Barn2\Plugin\WC_Custom_Cart_Button;

use Barn2\Plugin\WC_Custom_Cart_Button\Admin\Add_To_Cart_Customizer,
    Barn2\WCB_Lib\Registerable,
    Barn2\WCB_Lib\Translatable,
    Barn2\WCB_Lib\Service_Provider,
    Barn2\WCB_Lib\Service_Container,
    Barn2\WCB_Lib\Plugin\Simple_Plugin,
    Barn2\WCB_Lib\Plugin\Admin\Admin_Links,
    Barn2\WCB_Lib\Util as Lib_Util;

/**
 * The main plugin class.
 *
 * @package   Barn2\woo-custom-add-to-cart-button
 * @author    Kestrel <support@kestrelwp.com>
 * @license   GPL-3.0
 * @copyright Kestrel
 */
class Plugin extends Simple_Plugin implements Registerable, Translatable, Service_Provider {

    const NAME = 'WooCommerce Custom Add To Cart Button';

    use Service_Container;

    public function __construct( $file, $version = '1.0' ) {
        parent::__construct( [
            'name'               => self::NAME,
            'file'               => $file,
            'version'            => $version,
            'is_woocommerce'     => true,
            'documentation_path' => 'kb-categories/custom-add-to-cart-kb/',
            'settings_path'      => 'customize.php?autofocus[section]=' . Add_To_Cart_Customizer::ADD_TO_CART_SECTION,
        ] );
    }

    public function register() {
        // Load the text domain
        add_action( 'init', [ $this, 'load_textdomain' ], 5 );
        add_action( 'init', [ $this, 'maybe_load_plugin' ] );
        $this->declare_hpos_compatibility( PLUGIN_FILE );
    }

    public function maybe_load_plugin() {
        // Bail early if WooCommerce isn't installed.
        if ( ! Lib_Util::is_woocommerce_active() ) {
            return;
        }

        $this->register_services();
    }

    public function create_services() {
        return [
            'admin_links' => new Admin_Links( $this ),
            'customizer'  => new Add_To_Cart_Customizer( $this->get_basename() ),
            'replacer'    => new Add_To_Cart_Replacer(),
            'styles'      => new Add_To_Cart_Styles( $this->get_file(), $this->get_version() )
        ];
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'woo-custom-add-to-cart-button', false, $this->get_slug() . '/languages' );
    }

    public function declare_hpos_compatibility( $plugin_entry_file, $compatible = true ) {
		add_action( 'before_woocommerce_init', function() use( $plugin_entry_file, $compatible ) {
			if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', $plugin_entry_file, $compatible );
			}
		} );
	}

}

<?php
namespace Barn2\Plugin\WC_Custom_Cart_Button\Admin;

use Barn2\WCB_Lib\Registerable,
    Barn2\Plugin\WC_Custom_Cart_Button\Util;

/**
 * Registers the Customizer settings.
 *
 * @package   Barn2\woo-custom-add-to-cart-button
 * @author    Kestrel <support@kestrelwp.com>
 * @license   GPL-3.0
 * @copyright Kestrel
 */
class Add_To_Cart_Customizer implements Registerable {

    const ADD_TO_CART_SECTION = 'woocommerce_add_to_cart_button';

    private $basename;

    public function __construct( $basename ) {
        $this->basename = $basename;
    }

    public function register() {
        add_action( 'customize_register', [ $this, 'add_sections' ], 20 ); // after WooCommerce
        add_action( 'customize_controls_print_scripts', [ $this, 'add_scripts' ], 40 );
    }

    /**
     * Add the 'Add to Cart' settings to the customizer.
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
    public function add_sections( $wp_customize ) {

        // Add WooCommerce panel if not already added (WC < 3.3).
        if ( ! $wp_customize->get_panel( 'woocommerce' ) ) {
            $wp_customize->add_panel( 'woocommerce', [
                'priority'       => 200,
                'capability'     => 'manage_woocommerce',
                'theme_supports' => '',
                'title'          => __( 'WooCommerce', 'woocommerce' ), // pick up WooCommerce translation for this
            ] );
        }

        $this->add_add_to_cart_section( $wp_customize );
    }

    private function add_add_to_cart_section( $wp_customize ) {

        $wp_customize->add_section( self::ADD_TO_CART_SECTION, [
            'title'    => __( 'Add To Cart Buttons', 'woo-custom-add-to-cart-button' ),
            'priority' => 50,
            'panel'    => 'woocommerce',
            ]
        );

        $wp_customize->add_setting( Util::OPTION_ADD_TO_CART_TEXT, [
            'default'           => __( 'Add to cart', 'woocommerce' ), // pick up WooCommerce translation for this
            'type'              => 'option',
            'capability'        => 'manage_woocommerce',
            'sanitize_callback' => 'sanitize_text_field',
            ]
        );

        $wp_customize->add_control( Util::OPTION_ADD_TO_CART_TEXT, [
            'label'       => __( 'Add to cart text', 'woo-custom-add-to-cart-button' ),
            'description' => __( 'The text for the add to cart buttons.', 'woo-custom-add-to-cart-button' ),
            'section'     => self::ADD_TO_CART_SECTION,
            'settings'    => Util::OPTION_ADD_TO_CART_TEXT,
            'type'        => 'text',
            ]
        );

        $wp_customize->add_setting( Util::OPTION_ADD_TO_CART_ICON, [
            'default'              => 'no',
            'type'                 => 'option',
            'capability'           => 'manage_woocommerce',
            'sanitize_callback'    => 'wc_bool_to_string',
            'sanitize_js_callback' => 'wc_string_to_bool',
            ]
        );

        $wp_customize->add_control( Util::OPTION_ADD_TO_CART_ICON, [
            'label'    => __( 'Show add to cart icon', 'woo-custom-add-to-cart-button' ),
            'section'  => self::ADD_TO_CART_SECTION,
            'settings' => Util::OPTION_ADD_TO_CART_ICON,
            'type'     => 'checkbox',
            ]
        );

        $wp_customize->add_setting( Util::OPTION_ADD_TO_CART_ICON_ONLY, [
            'default'              => 'no',
            'type'                 => 'option',
            'capability'           => 'manage_woocommerce',
            'sanitize_callback'    => 'wc_bool_to_string',
            'sanitize_js_callback' => 'wc_string_to_bool',
            ]
        );

        $wp_customize->add_control( Util::OPTION_ADD_TO_CART_ICON_ONLY, [
            'label'    => __( 'Hide the add to cart text', 'woo-custom-add-to-cart-button' ),
            'section'  => self::ADD_TO_CART_SECTION,
            'settings' => Util::OPTION_ADD_TO_CART_ICON_ONLY,
            'type'     => 'checkbox',
            ]
        );

        $wp_customize->add_setting( Util::OPTION_ADD_TO_CART_BACKGROUND_COLOR, [
            'default'              => '',
            'type'                 => 'option',
            'capability'           => 'manage_woocommerce',
            ]
        );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, Util::OPTION_ADD_TO_CART_BACKGROUND_COLOR, [
            'label'    => __( 'Button background', 'woo-custom-add-to-cart-button' ),
            'section'  => self::ADD_TO_CART_SECTION,
            'settings' => Util::OPTION_ADD_TO_CART_BACKGROUND_COLOR
            ]
        ) );

        $wp_customize->add_setting( Util::OPTION_ADD_TO_CART_COLOR, [
            'default'              => '',
            'type'                 => 'option',
            'capability'           => 'manage_woocommerce',
            ]
        );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, Util::OPTION_ADD_TO_CART_COLOR, [
            'label'    => __( 'Button text color', 'woo-custom-add-to-cart-button' ),
            'section'  => self::ADD_TO_CART_SECTION,
            'settings' => Util::OPTION_ADD_TO_CART_COLOR
            ]
        ) );
    }

    /**
     * Scripts to improve our form.
     */
    public function add_scripts() {
        ?>
        <script type="text/javascript">
            jQuery( document ).ready( function( $ ) {
                wp.customize.section( '<?php echo esc_js( self:: ADD_TO_CART_SECTION ); ?>', function( section ) {
                    section.expanded.bind( function( isExpanded ) {
                        if ( isExpanded ) {
                            wp.customize.previewer.previewUrl.set( '<?php echo esc_js( wc_get_page_permalink( 'shop' ) ); ?>' );
                        }
                    } );
                } );
            } );
        </script>
        <?php
    }

}

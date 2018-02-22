<?php

namespace Barn2\Plugins\WC_Custom_Add_To_Cart_Button;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers our Customizer settings.
 *
 * @package   WooCommerce_Custom_Add_To_Cart_Button
 * @author    Barn2 Media <info@barn2.co.uk>
 * @license   GPL-3.0
 * @link      https://barn2.co.uk
 * @copyright 2016-2018 Barn2 Media Ltd
 */
class Add_To_Cart_Customizer {

	const ADD_TO_CART_SECTION = 'woocommerce_add_to_cart_button';

	public function __construct() {
		add_action( 'customize_register', array( $this, 'add_sections' ), 20 ); // after WooCommerce
		add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 40 );
	}

	/**
	 * Add the 'Add to Cart' settings to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function add_sections( $wp_customize ) {

		// Add WooCommerce panel if not already added (WC < 3.3).
		if ( ! $wp_customize->get_panel( 'woocommerce' ) ) {
			$wp_customize->add_panel( 'woocommerce', array(
				'priority'		 => 200,
				'capability'	 => 'manage_woocommerce',
				'theme_supports' => '',
				'title'			 => __( 'WooCommerce', 'woocommerce' ),
			) );
		}

		$this->add_add_to_cart_section( $wp_customize );
	}

	private function add_add_to_cart_section( $wp_customize ) {

		$wp_customize->add_section( self::ADD_TO_CART_SECTION, array(
			'title'		 => __( 'Add To Cart Buttons', 'woo-custom-add-to-cart-button' ),
			'priority'	 => 50,
			'panel'		 => 'woocommerce',
			)
		);

		$wp_customize->add_setting( Util::OPTION_ADD_TO_CART_TEXT, array(
			'default'			 => __( 'Add to cart', 'woocommerce' ), // pick up WooCommerce translation for this
			'type'				 => 'option',
			'capability'		 => 'manage_woocommerce',
			'sanitize_callback'	 => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control( Util::OPTION_ADD_TO_CART_TEXT, array(
			'label'			 => __( 'Add to cart text', 'woo-custom-add-to-cart-button' ),
			'description'	 => __( 'The text for the add to cart buttons.', 'woo-custom-add-to-cart-button' ),
			'section'		 => self::ADD_TO_CART_SECTION,
			'settings'		 => Util::OPTION_ADD_TO_CART_TEXT,
			'type'			 => 'text',
			)
		);

		$wp_customize->add_setting( Util::OPTION_ADD_TO_CART_ICON, array(
			'default'				 => 'no',
			'type'					 => 'option',
			'capability'			 => 'manage_woocommerce',
			'sanitize_callback'		 => 'wc_bool_to_string',
			'sanitize_js_callback'	 => 'wc_string_to_bool',
			)
		);

		$wp_customize->add_control( Util::OPTION_ADD_TO_CART_ICON, array(
			'label'		 => __( 'Show add to cart icon', 'woo-custom-add-to-cart-button' ),
			'section'	 => self::ADD_TO_CART_SECTION,
			'settings'	 => Util::OPTION_ADD_TO_CART_ICON,
			'type'		 => 'checkbox',
			)
		);

		$wp_customize->add_setting( Util::OPTION_ADD_TO_CART_ICON_ONLY, array(
			'default'				 => 'no',
			'type'					 => 'option',
			'capability'			 => 'manage_woocommerce',
			'sanitize_callback'		 => 'wc_bool_to_string',
			'sanitize_js_callback'	 => 'wc_string_to_bool',
			)
		);

		$wp_customize->add_control( Util::OPTION_ADD_TO_CART_ICON_ONLY, array(
			'label'		 => __( 'Hide the add to cart text', 'woo-custom-add-to-cart-button' ),
			'section'	 => self::ADD_TO_CART_SECTION,
			'settings'	 => Util::OPTION_ADD_TO_CART_ICON_ONLY,
			'type'		 => 'checkbox',
			)
		);
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
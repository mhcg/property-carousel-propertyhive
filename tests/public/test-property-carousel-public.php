<?php
/**
 * Property_Carousel_Public tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel_Public
 * @package Tests
 * @subpackage Tests/Public
 */

/**
 * Property_Carousel_Public tests.
 */
class Tests_Public_Property_Carousel_Public extends WP_UnitTestCase {

	/**
	 * Tests the constructor.
	 *
	 * @covers Property_Carousel_Public::__construct
	 */
	public function test_constructor() {
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);
		$this->assertInstanceOf( 'Property_Carousel_Public', $obj );
	}

	/**
	 * Test some shortcodes got registered.
	 *
	 * @covers Property_Carousel_Public::register_shortcodes
	 */
	public function test_register_shortcodes() {
		remove_all_shortcodes();
		$this->assertFalse( shortcode_exists( Property_Carousel_Shortcode::SHORTCODE ) );
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);
		$obj->register_shortcodes();
		$this->assertTrue( shortcode_exists( Property_Carousel_Shortcode::SHORTCODE ) );
	}

	/**
	 * Tests the default Property Hive hooks get registered.
	 *
	 * @covers Property_Carousel_Public::register_default_template_hooks
	 */
	public function test_register_default_template_hooks() {
		remove_all_actions( 'property_carousel_loop_after_title' );
		$this->assertFalse( has_action( 'property_carousel_loop_after_title' ) );
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);

		// call register_default_template_hooks with override for is_propertyhive_available.
		add_filter( 'property_carousel_is_propertyhive_available', '__return_true' );
		$obj->register_default_template_hooks();
		$this->assertTrue( has_action( 'property_carousel_loop_after_title' ) );
		remove_all_filters( 'property_carousel_is_propertyhive_available' );
	}

	/**
	 * Tests scripts get registered.
	 *
	 * @covers Property_Carousel_Public::enqueue_scripts
	 */
	public function test_enqueue_scripts() {
		$handle = 'propertyhive_property_carousel';
		if ( array_key_exists( $handle, wp_scripts()->registered ) ) {
			wp_deregister_script( $handle );
		}
		$this->assertArrayNotHasKey( 'propertyhive_property_carousel', wp_scripts()->registered );

		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);
		$obj->enqueue_scripts();
		$this->assertArrayHasKey( 'propertyhive_property_carousel', wp_scripts()->registered );
	}

	/**
	 * Tests styles get registered.
	 *
	 * @covers Property_Carousel_Public::enqueue_styles
	 */
	public function test_enqueue_styles() {
		$handle = 'propertyhive_property_carousel';
		if ( array_key_exists( $handle, wp_styles()->registered ) ) {
			wp_deregister_style( $handle );
		}
		$this->assertArrayNotHasKey( 'propertyhive_property_carousel', wp_styles()->registered );

		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);
		$obj->enqueue_styles();
		$this->assertArrayHasKey( 'propertyhive_property_carousel', wp_styles()->registered );
	}

	/**
	 * Tests that the shortcode method just returns nothing if Property Hive not installed.
	 *
	 * @covers Property_Carousel_Public::property_carousel_shortcode
	 */
	public function test_property_carousel_shortcode_propertyhive_not_installed() {
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);
		$this->assertSame( '', $obj->property_carousel_shortcode( array() ) );
	}

	/**
	 * Tests that the shortcode includes the flexslider CSS and JS when installed.
	 *
	 * @covers Property_Carousel_Public::property_carousel_shortcode
	 */
	public function test_property_carousel_shortcode_propertyhive_installed() {
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);

		$attributes = array();
		// de-register anything with flexslider in the CSS or JS registered stuff.
		foreach ( $this->find_registered_flexslider_css() as $handle ) {
			wp_deregister_style( $handle );
		}
		foreach ( $this->find_registered_flexslider_js() as $handle ) {
			wp_deregister_script( $handle );
		}
		$this->assertCount( 0, $this->find_registered_flexslider_css() );
		$this->assertCount( 0, $this->find_registered_flexslider_js() );

		// call property_carousel_shortcode with override for is_propertyhive_available which should register them.
		add_filter( 'property_carousel_is_propertyhive_available', '__return_true' );
		$obj->property_carousel_shortcode( $attributes, true );
		remove_all_filters( 'property_carousel_is_propertyhive_available' );

		// check they were registered.
		$this->assertCount( 1, $this->find_registered_flexslider_css() );
		$this->assertCount( 1, $this->find_registered_flexslider_js() );
	}

	// <editor-fold desc="Helper Methods">
	/**
	 * Helper function to find any registered scripts containing 'flexslider' in their handle.
	 *
	 * @return array List of handles found containing 'flexslider'
	 */
	private function find_registered_flexslider_js() {
		$registered = array_keys( wp_scripts()->registered );
		$found      = array();
		foreach ( $registered as $item ) {
			if ( false !== strpos( $item, 'flexslider' ) ) {
				$found[] = $item;
			}
		}

		return $found;
	}

	/**
	 * Helper function to find any registered styles containing 'flexslider' in their handle.
	 *
	 * @return array List of handles found containing 'flexslider'
	 */
	private function find_registered_flexslider_css() {
		$registered = array_keys( wp_styles()->registered );
		$found      = array();
		foreach ( $registered as $item ) {
			if ( false !== strpos( $item, 'flexslider' ) ) {
				$found[] = $item;
			}
		}

		return $found;
	}
	// </editor-fold>
}

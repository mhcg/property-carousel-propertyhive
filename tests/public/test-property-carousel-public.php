<?php
/**
 * @since 1.0.0
 * @covers Property_Carousel_Public
 */

class Tests_Public_Property_Carousel_Public extends WP_UnitTestCase {

	/**
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
	 * @covers Property_Carousel_Public::register_default_template_hooks
	 */
	public function test_register_default_template_hooks() {
		remove_all_actions( 'property_carousel_loop_after_title' );
		$this->assertFalse( has_action( 'property_carousel_loop_after_title' ) );
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);
		$obj->register_default_template_hooks();
		$this->assertTrue( has_action( 'property_carousel_loop_after_title' ) );
	}

	/**
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
	 * Tests that the shortcode method returns something meaningful when Property Hive is installed
	 *
	 * @covers Property_Carousel_Public::property_carousel_shortcode
	 */
	public function test_property_carousel_shortcode_propertyhive_installed() {
		$obj = new Property_Carousel_Public(
			'propertyhive_property_carousel',
			'1.2.3'
		);

		$attributes = array();
		// run test a couple of times as this will test the caching of the js and css handle
		for ( $i = 0; $i < 5; $i ++ ) {
			$content = $obj->property_carousel_shortcode( $attributes, true );
			$this->assertStringStartsWith( '<div', $content );
			$this->assertStringEndsWith( '</div>', $content );
		}
	}
}

<?php
/**
 * Tests the Shortcode helper class.
 */

class PropertyhivePropertyCarouselShortcodeTest extends \WP_UnitTestCase {

	/**
	 * @covers Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available
	 */
	public function test_is_propertyhive_available() {
		$var = Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available();
		$this->assertInternalType( 'bool', $var );
	}

	/**
	 * @covers Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template() {
		$this->assertStringEndsWith(
			'propertyhive-property-carousel.php',
			Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template()
		);
	}

	/**
	 * @covers Propertyhive_Property_Carousel_Shortcode::property_carousel_shortcode
	 */
	public function test_property_carousel_shortcode() {
		$output = Propertyhive_Property_Carousel_Shortcode::property_carousel_shortcode( array() );
		$this->assertStringStartsWith(
			'<div ',
			$output
		);
		$this->assertStringEndsWith(
			'</div>',
			$output
		);
	}

}

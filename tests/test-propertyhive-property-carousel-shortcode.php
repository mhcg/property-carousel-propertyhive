<?php
/**
 * Tests the Shortcode helper class.
 */

class PropertyhivePropertyCarouselShortcodeTest extends \WP_UnitTestCase {

	/**
	 * Tests the is_propertyhive_available method.
	 *
	 * Not much can do really just check it returns a true or false.
	 *
	 * @covers Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available
	 */
	public function test_is_propertyhive_available() {
		$var = Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available();
		$this->assertInternalType( 'bool', $var );
	}

	/**
	 * Tests the shortcode output method.
	 *
	 * Output should start and end with div tags and have some reference to flexslider in the output.
	 *
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

		$contains_flexslider = ( false !== strpos( $output, 'flexslider' ) );
		$this->assertTrue( $contains_flexslider );
	}

	/**
	 * Tests the loop template path returns the right filename.
	 *
	 * @covers Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template() {
		$this->assertStringEndsWith(
			'propertyhive-property-carousel.php',
			Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template()
		);
	}

	/**
	 * Test the loop template path returns the default path.
	 *
	 * @covers Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template_default() {
		$custom_path = get_template_directory() . '/property-carousel/propertyhive-property-carousel.php';
		if ( file_exists( $custom_path ) ) {
			unlink( $custom_path );
		}
		$this->assertStringEndsWith(
			'/public/partials/propertyhive-property-carousel.php',
			Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template()
		);
	}

	/**
	 * Test the loop template path returns the template path.
	 *
	 * @covers Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template_custom() {

		$custom_path = get_template_directory() . '/property-carousel/propertyhive-property-carousel.php';
		if ( file_exists( $custom_path ) ) {
			unlink( $custom_path );
		}
		if ( ! file_exists( get_template_directory() . '/property-carousel' ) ) {
			mkdir( get_template_directory() . '/property-carousel', 0777, true );
		}
		touch( $custom_path );

		$this->assertStringEndsNotWith(
			'/public/partials/propertyhive-property-carousel.php',
			Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template()
		);
		$this->assertStringEndsWith(
			'/property-carousel/propertyhive-property-carousel.php',
			Propertyhive_Property_Carousel_Shortcode::property_carousel_loop_template()
		);
		unlink( $custom_path );
	}

}

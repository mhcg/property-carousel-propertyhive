<?php
/**
 * Tests the Shortcode helper class.
 *
 * @since 1.0.0
 */

class Tests_Public_Property_Carousel_Shortcode extends \WP_UnitTestCase {

	/**
	 * Tests the is_propertyhive_available method.
	 *
	 * Not much can do really just check it returns a true or false.
	 *
	 * @covers Property_Carousel_Shortcode::is_propertyhive_available
	 */
	public function test_is_propertyhive_available() {
		$var = Property_Carousel_Shortcode::is_propertyhive_available();
		$this->assertInternalType( 'bool', $var );
	}

	/**
	 * Tests the shortcode output method.
	 *
	 * Output should start and end with div tags and have some reference to flexslider in the output.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode() {
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output( array() );
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
	 * @covers Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template() {
		$this->assertStringEndsWith(
			'/property-carousel.php',
			Property_Carousel_Shortcode::property_carousel_loop_template()
		);
	}

	/**
	 * Test the loop template path returns the default path.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template_default() {
		$custom_path = get_template_directory() . '/property-carousel/property-carousel.php';
		if ( file_exists( $custom_path ) ) {
			unlink( $custom_path );
		}
		$this->assertStringEndsWith(
			'/public/partials/property-carousel.php',
			Property_Carousel_Shortcode::property_carousel_loop_template()
		);
	}

	/**
	 * Test the loop template path returns the template path.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_loop_template
	 */
	public function test_property_carousel_loop_template_custom() {

		$custom_path = get_template_directory() . '/property-carousel/property-carousel.php';
		if ( file_exists( $custom_path ) ) {
			unlink( $custom_path );
		}
		if ( ! file_exists( get_template_directory() . '/property-carousel' ) ) {
			mkdir( get_template_directory() . '/property-carousel', 0777, true );
		}
		touch( $custom_path );

		$this->assertStringEndsNotWith(
			'/public/partials/property-carousel.php',
			Property_Carousel_Shortcode::property_carousel_loop_template()
		);
		$this->assertStringEndsWith(
			'/property-carousel/property-carousel.php',
			Property_Carousel_Shortcode::property_carousel_loop_template()
		);
		unlink( $custom_path );
	}

}

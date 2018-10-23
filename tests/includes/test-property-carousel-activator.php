<?php
/**
 * Activator tests.
 *
 * @covers Property_Carousel_Activator
 * @since 1.0.0
 */

class Tests_Includes_Property_Carousel_Activator extends WP_UnitTestCase {

	/**
	 * Nothing currently.
	 *
	 * @covers Property_Carousel_Activator::activate
	 */
	public function test_activate() {
		activate_property_carousel();
		// doesn't crash
		$this->assertTrue( true );
	}
}

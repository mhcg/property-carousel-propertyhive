<?php
/**
 * Deactivator tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel_Deactivator
 */

class Tests_Includes_Property_Carousel_Deactivator extends WP_UnitTestCase {

	/**
	 * Nothing currently.
	 *
	 * @covers Property_Carousel_Deactivator::deactivate
	 */
	public function test_deactivate() {
		deactivate_property_carousel();
		// doesn't crash
		$this->assertTrue( true );
	}
}

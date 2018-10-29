<?php
/**
 * Activator tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel_Activator
 * @package Tests
 * @subpackage Tests/Includes
 */

/**
 * Activator tests.
 */
class Tests_Includes_Property_Carousel_Activator extends WP_UnitTestCase {

	/**
	 * Nothing currently.
	 *
	 * @covers Property_Carousel_Activator::activate
	 */
	public function test_activate() {
		property_carousel_propertyhive_activate();
		// shouldn't crash.
		$this->assertTrue( true );
	}
}

<?php
/**
 * Deactivator tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel_Deactivator
 * @package Tests
 * @subpackage Tests/Includes
 */

/**
 * Deactivator tests.
 */
class Tests_Includes_Property_Carousel_Deactivator extends WP_UnitTestCase {

	/**
	 * Nothing currently.
	 *
	 * @covers Property_Carousel_Deactivator::deactivate
	 */
	public function test_deactivate() {
		property_carousel_propertyhive_deactivate();
		// shouldn't crash.
		$this->assertTrue( true );
	}
}

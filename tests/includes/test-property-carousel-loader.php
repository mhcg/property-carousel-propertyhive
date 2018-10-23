<?php
/**
 * @covers Property_Carousel_Loader
 */

class Tests_Includes_Property_Carousel_Loader extends WP_UnitTestCase {

	/**
	 * Test the constructor.
	 *
	 * @covers Property_Carousel_Loader::__construct
	 */
	public function test_constructor() {
		$var = new Property_Carousel_Loader();
		$this->assertInstanceOf( 'Property_Carousel_Loader', $var);
	}

	/**
	 * Test Add Action method.
	 *
	 * @covers Property_Carousel_Loader::add_action
	 */
	public function test_add_action() {

	}

	/**
	 * Test Add Filter method.
	 *
	 * @covers Property_Carousel_Loader::add_filter
	 */
	public function test_add_filter() {

	}

	/**
	 * Test Run method.
	 *
	 * @covers Property_Carousel_Loader::run
	 */
	public function test_run() {

	}

}

<?php
/**
 * @covers Property_Carousel
 *
 * @since 1.0.0
 */

class Tests_Property_Carousel extends WP_UnitTestCase {

	/**
	 * @covers Property_Carousel::__construct
	 */
	public function test_constructor() {
		$var = new Property_Carousel();
		$this->assertInstanceOf( 'Property_Carousel', $var );
	}

	/**
	 * @covers Property_Carousel::get_propertyhive_property_carousel
	 */
	public function test_get_propertyhive_property_carousel() {
		$obj = new Property_Carousel();
		$this->assertSame( 'propertyhive-property-carousel', $obj->get_propertyhive_property_carousel() );
	}

	/**
	 * @covers Property_Carousel::get_version
	 */
	public function test_get_version_default() {
		$obj = new Property_Carousel();
		$this->assertTrue( version_compare( $obj->get_version(), '0.0.0', '>' ) );
	}

	/**
	 * @covers Property_Carousel::get_version
	 */
	public function test_get_version_specifc() {
		$obj = new Property_Carousel( '1.2.3', true );
		$this->assertSame( '1.2.3', $obj->get_version() );
	}

	/**
	 * @covers Property_Carousel::get_loader
	 */
	public function test_get_loader() {
		$obj = new Property_Carousel();
		$this->assertInstanceOf( 'Property_Carousel_Loader', $obj->get_loader() );
	}

	/**
	 * @covers Property_Carousel::run
	 */
	public function test_run() {
		$obj = new Property_Carousel();
		// currently just runs the Loader::run() so just check no errors I guess
		$obj->run();
		$this->assertTrue( true );
	}

}

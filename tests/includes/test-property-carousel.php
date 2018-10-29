<?php
/**
 * Property_Carousel tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel
 * @package Tests
 * @subpackage Tests/Includes
 */

/**
 * Property_Carousel tests.
 */
class Tests_Includes_Property_Carousel extends WP_UnitTestCase {

	/**
	 * Tests the constructor.
	 *
	 * @covers Property_Carousel::__construct
	 * @covers Property_Carousel::load_dependencies
	 * @covers Property_Carousel::set_locale
	 * @covers Property_Carousel::define_admin_hooks
	 * @covers Property_Carousel::define_public_hooks
	 */
	public function test_constructor() {
		$var = new Property_Carousel();
		$this->assertInstanceOf( 'Property_Carousel', $var );
	}

	/**
	 * Tests get_property_carousel_propertyhive().
	 *
	 * @covers Property_Carousel::get_property_carousel_propertyhive
	 */
	public function test_get_property_carousel_propertyhive() {
		$obj = new Property_Carousel();
		$this->assertSame( 'property-carousel-propertyhive', $obj->get_property_carousel_propertyhive() );
	}

	/**
	 * Tests get_version() returns using a default value.
	 *
	 * @covers Property_Carousel::get_version
	 */
	public function test_get_version_default() {
		$obj = new Property_Carousel();
		$this->assertTrue( version_compare( $obj->get_version(), '0.0.0', '>' ) );
	}

	/**
	 * Tests get_version() returns a specifically passed in version number.
	 *
	 * @covers Property_Carousel::get_version
	 */
	public function test_get_version_specific() {
		$obj = new Property_Carousel( '1.2.3' );
		$this->assertSame( '1.2.3', $obj->get_version() );
	}

	/**
	 * Tests get_loader.
	 *
	 * @covers Property_Carousel::get_loader
	 */
	public function test_get_loader() {
		$obj = new Property_Carousel();
		$this->assertInstanceOf( 'Property_Carousel_Loader', $obj->get_loader() );
	}

	/**
	 * Tests the Property_Carousel run() method runs without error.
	 *
	 * @covers Property_Carousel::run
	 * @covers Property_Carousel_Loader::run
	 */
	public function test_run() {
		$obj = new Property_Carousel();
		// currently just runs the Loader::run() so just check no errors I guess.
		$obj->run();
		$this->assertTrue( true );
	}

}

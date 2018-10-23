<?php
/**
 * @covers Property_Carousel_Admin
 *
 * @since 1.0.0
 */

class Tests_Admin_Property_Carousel_Admin extends WP_UnitTestCase {

	/**
	 * @covers Property_Carousel_Admin::__construct
	 */
	public function test_constructor() {
		$var = new Property_Carousel_Admin( 'test_version', '0.0.1' );
		$this->assertInstanceOf( 'Property_Carousel_Admin', $var );
	}

	/**
	 * Test that some admin notices get added.
	 *
	 * Currently only one being added when Property Hive plugin isn't installed therefore have to bodge
	 * that to make sure it would work if installed.
	 *
	 * @covers Property_Carousel_Admin::add_admin_notices
	 */
	public function test_add_admin_notices_no_propertyhive_installed() {
		// pointless going any further if the unit test thinks Property Hive is available
		// properly run unit tests shouldn't have any other plugins installed maybe???
		$this->assertFalse( Property_Carousel_Shortcode::is_propertyhive_available() );

		// remove any other admin_notices (for testing obviously)
		remove_all_actions( 'admin_notices' );
		$this->assertFalse( has_action( 'admin_notices' ) );

		// should get admin_notices as PH not installed
		$var = new Property_Carousel_Admin( 'test_version', '0.0.1' );
		$var->add_admin_notices();
		$this->assertTrue( has_action( 'admin_notices' ) );
	}

	/**
	 * Test that no admin notices for Property Hive missing get added.
	 *
	 * Currently only one being added when Property Hive plugin isn't installed therefore have to bodge
	 * that to make sure it would work if installed.
	 *
	 * @covers Property_Carousel_Admin::add_admin_notices
	 */
	public function test_add_admin_notices_has_propertyhive() {
		// remove any other admin_notices (for testing obviously)
		remove_all_actions( 'admin_notices' );
		$this->assertFalse( has_action( 'admin_notices' ) );

		$var = new Property_Carousel_Admin( 'test_version', '0.0.1' );
		$var->add_admin_notices(true); // with override for testing
		$this->assertFalse( has_action( 'admin_notices' ) );
	}

	public function test_add_admin_notices_has_output() {
		remove_all_actions( 'admin_notices' );
		$this->assertFalse( has_action( 'admin_notices' ) );

		$var = new Property_Carousel_Admin( 'test_version', '0.0.1' );
		$var->add_admin_notices();
		$this->assertTrue( has_action( 'admin_notices' ) );

		ob_start();
		do_action( 'admin_notices' );
		$content = ob_get_contents();
		ob_end_clean();
		$this->assertContains('notice', $content);
	}

}

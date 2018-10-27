<?php
/**
 * Property_Carousel_Shortcode tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel_Shortcode
 * @package Tests
 * @subpackage Tests/Public
 */

/**
 * Property_Carousel_Shortcode tests.
 */
class Tests_Public_Property_Carousel_Shortcode extends \WP_UnitTestCase {

	/**
	 * Array of post_ids for test record posts.
	 *
	 * @var array Array of post_ids for test record posts.
	 */
	protected static $test_property_ids;
	/**
	 * Array of post_ids for the test records marked as featured.
	 *
	 * @var array Array of post_ids for the test records marked as featured.
	 */
	protected static $test_properties_featured_ids;

	/**
	 * Creates some test property data for use in unit tests.
	 *
	 * Note, this could be called by setUp for each test for WordPress < 4.4.0.
	 *
	 * @param WP_UnitTest_Factory $factory An instance of WP_UnitTest_Factory to use.
	 */
	public static function wpSetUpBeforeClass( $factory ) {
		self::create_test_property_posts( $factory );
	}

	/**
	 * Clear template actions as they don't exist when testing
	 */
	public function setUp() {
		parent::setUp();

		// wpSetUpBeforeClass wasn't added until WordPress 4.4.
		include ABSPATH . '/wp-includes/version.php';
		if ( -1 === version_compare( $wp_version, '4.4.0' ) ) {
			$factory = new WP_UnitTest_Factory();
			self::wpSetUpBeforeClass( $factory );
		}

		self::clear_template_hooks();
	}

	/**
	 * Create some test posts (of type property).
	 *
	 * Note, this could be called by setUp for each test for WordPress < 4.4.0.
	 *
	 * @param WP_UnitTest_Factory $factory An instance of WP_UnitTest_Factory to use.
	 */
	protected static function create_test_property_posts( $factory ) {
		// currently there is a limit of (at most) 10 records will be returned by the shortcode output code.
		$num_of_tests    = wp_rand( 5, 10 );
		$num_of_featured = (int) $num_of_tests / 2;
		if ( $num_of_featured < 2 ) {
			$num_of_featured = 2;
		}
		$array_of_post_ids     = array();
		$array_of_featured_ids = array();
		for ( $i = 0; $i < $num_of_tests; $i ++ ) {
			$post_id             = $factory->post->create(
				array(
					'post_type' => 'property',
				)
			);
			$array_of_post_ids[] = $post_id;

			update_post_meta( $post_id, '_on_market', 'yes' );
			$featured = 'no';
			if ( $i < $num_of_featured ) {
				$featured                = 'yes';
				$array_of_featured_ids[] = $post_id;
			}
			update_post_meta( $post_id, '_featured', $featured );
		}

		// set the class properties for use in tests.
		self::$test_property_ids            = $array_of_post_ids;
		self::$test_properties_featured_ids = $array_of_featured_ids;
	}

	/**
	 * Clear template actions hooks.
	 */
	protected static function clear_template_hooks() {
		$actions_to_clear = array(
			'property_carousel_before_loop_item',
			'property_carousel_loop_thumbnail',
			'property_carousel_loop_after_title',
			'property_carousel_loop_after_details',
		);
		foreach ( $actions_to_clear as $tag ) {
			remove_all_actions( $tag );
		}
	}

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

	/**
	 * Tests the shortcode output when no data.
	 *
	 * Shouldn't return anything when there is no data.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_no_data() {
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'office_id' => '-1',
			)
		);
		$this->assertSame( '', $output );
	}

	/**
	 * Tests the shortcode output method - Basic with data.
	 *
	 * Output should be in the following format:
	 * <div class="* flexslider *"><ul *><li *>*</li></ul></div>
	 *
	 * i.e. opening div with a reference to flexslider in the class followed by ul and some li's for
	 * the data.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_basic_with_data() {
		// generate the shortcode output.
		$output       = Property_Carousel_Shortcode::property_carousel_shortcode_output();
		$num_of_tests = count( self::$test_property_ids );
		$this->standard_output_tests( $output, $num_of_tests );
	}

	/**
	 * Tests the shortcode attribute Featured.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_featured_only() {
		$num_featured = count( self::$test_properties_featured_ids );
		$output       = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'featured' => 'yes',
			)
		);
		$this->standard_output_tests( $output, $num_featured );
	}

	/**
	 * Tests the shortcode attribute Featured.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_not_featured() {
		$num_not_featured = count( self::$test_property_ids ) - count( self::$test_properties_featured_ids );
		$output           = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'featured' => 'no',
			)
		);
		$this->standard_output_tests( $output, $num_not_featured );
	}

	/**
	 * Tests the shortcode attribute Department.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_department_residential_sales() {
		$post_id = self::$test_property_ids[0];
		update_post_meta( $post_id, '_department', 'residential-sales' );
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'department' => 'residential-sales',
			)
		);
		$this->standard_output_tests( $output, 1 );
	}

	/**
	 * Tests the shortcode attribute Department.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_department_residential_lettings() {
		$post_id = self::$test_property_ids[0];
		update_post_meta( $post_id, '_department', 'residential-lettings' );
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'department' => 'residential-lettings',
			)
		);
		$this->standard_output_tests( $output, 1 );
	}

	/**
	 * Tests the shortcode attribute Department.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_department_commercial() {
		$post_id = self::$test_property_ids[0];
		update_post_meta( $post_id, '_department', 'commercial' );
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'department' => 'commercial',
			)
		);
		$this->standard_output_tests( $output, 1 );
	}

	/**
	 * Tests the shortcode attribute Department.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_department_invalid() {
		$post_id = self::$test_property_ids[0];
		update_post_meta( $post_id, '_department', 'invalid' );
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'department' => 'invalid',
			)
		);
		$this->standard_output_tests( $output, count( self::$test_property_ids ) );
	}

	/**
	 * Tests the shortcode attribute Office.
	 *
	 * @covers Property_Carousel_Shortcode::property_carousel_shortcode_output
	 */
	public function test_property_carousel_shortcode_office() {
		$post_id = self::$test_property_ids[0];
		update_post_meta( $post_id, '_office_id', '123' );
		$output = Property_Carousel_Shortcode::property_carousel_shortcode_output(
			array(
				'office_id' => '123',
			)
		);
		$this->standard_output_tests( $output, 1 );
	}

	/**
	 * Tests the get_property_post_class() method returns at least property-carousel-property.
	 *
	 * @covers Property_Carousel_Shortcode::get_property_post_class
	 */
	public function test_get_property_post_class() {
		$post_id = self::$test_property_ids[0];
		$classes = Property_Carousel_Shortcode::get_property_post_class( $post_id );
		$this->assertContains( 'property-carousel-property', $classes );

		$post_id = self::$test_properties_featured_ids[0];
		$classes = Property_Carousel_Shortcode::get_property_post_class( $post_id );
		$this->assertContains( 'property-carousel-property', $classes );
	}

	/**
	 * Tests the get_property_post_class() method returns suitable array for a non-featured property.
	 *
	 * @covers Property_Carousel_Shortcode::get_property_post_class
	 */
	public function test_get_property_post_class_non_featured() {
		$non_featured = array_diff_assoc( self::$test_property_ids, self::$test_properties_featured_ids );
		$post_id      = array_values( $non_featured )[0];
		$classes      = Property_Carousel_Shortcode::get_property_post_class( $post_id );
		$this->assertNotContains( 'featured', $classes );
	}

	/**
	 * Tests the get_property_post_class() method returns suitable array for a featured property.
	 *
	 * @covers Property_Carousel_Shortcode::get_property_post_class
	 */
	public function test_get_property_post_class_featured() {
		$post_id = self::$test_properties_featured_ids[0];
		$classes = Property_Carousel_Shortcode::get_property_post_class( $post_id );
		$this->assertContains( 'featured', $classes );
	}


	// <editor-fold desc="Helper Methods">

	/**
	 * Run standard shortcode output tests on the supplied $output.
	 *
	 * @param string $output Shortcode output to check.
	 * @param int    $expected_lis Number of properties that should be in the data, i.e. number of <LI></LI> pairs.
	 */
	protected function standard_output_tests( $output, $expected_lis ) {
		// looking for <div class="* flexslider *"> - only 1.
		$this->assertEquals(
			1,
			preg_match_all( '/\<div\sclass=".*flexslider.*">/m', $output )
		);
		// looking for <ul *> - only 1.
		$this->assertEquals(
			1,
			preg_match_all( '/\<ul\s.*>/m', $output )
		);
		// looking for <li *> - should be same number as random number of records for testing.
		$this->assertEquals(
			$expected_lis,
			preg_match_all( '/\<li\s.*>/m', $output ),
			"Should have been {$expected_lis} LIs but found " . preg_match_all( '/\<li\s.*>/m', $output )
		);
		// looking for </li> - should be same number as random number of records for testing.
		$this->assertEquals(
			$expected_lis,
			preg_match_all( '/\<\/li>/m', $output ),
			"Should have been {$expected_lis} closing LIs but found " . preg_match_all( '/\<\/li>/m', $output )
		);
		// looking for </ul> - only 1.
		$this->assertEquals(
			1,
			preg_match_all( '/\<\/ul>/m', $output )
		);
		// looking for final </div> - only 1.
		$this->assertStringEndsWith( '</div>', $output );
	}

	// </editor-fold>
}

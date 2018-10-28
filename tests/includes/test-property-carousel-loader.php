<?php
/**
 * Loader tests.
 *
 * @since 1.0.0
 * @covers Property_Carousel_Loader
 * @package Tests
 * @subpackage Tests/Includes
 */

/**
 * Loader tests.
 */
class Tests_Includes_Property_Carousel_Loader extends WP_UnitTestCase {

	/**
	 * Used to test actions are running.
	 *
	 * @var int my_test_hook updates this value as needed for testing.
	 * @used-by my_test_hook
	 */
	private $test_counter = 0;

	/**
	 * Test the constructor.
	 *
	 * @covers Property_Carousel_Loader::__construct
	 */
	public function test_constructor() {
		$var = new Property_Carousel_Loader();
		$this->assertInstanceOf( 'Property_Carousel_Loader', $var );
	}

	/**
	 * Test Add Action method - single action.
	 *
	 * Add a new action to a newly created Loader object and it should be the one and only action
	 * in the collection of actions.
	 *
	 * @covers Property_Carousel_Loader::add_action
	 */
	public function test_add_action_one() {
		$obj = new Property_Carousel_Loader();

		$hook     = 'my_test_hook';
		$callback = 'nonsense_callback';

		$result = $obj->add_action( $hook, [ $this, $callback ] );
		$this->assertCount( 1, $result );

		$this->assertSame( $result[0]['hook'], $hook );
	}

	/**
	 * Test Add Action method - multiple actions.
	 *
	 * Adds several actions and checks they are are in the collection of actions.
	 *
	 * @covers Property_Carousel_Loader::add_action
	 */
	public function test_add_action_multiple() {
		$obj = new Property_Carousel_Loader();

		// setup test data - random number of hooks above 1.
		$num_of_hooks = wp_rand( 2, 20 );
		$test_hooks   = array();
		for ( $i = 0; $i < $num_of_hooks; $i ++ ) {
			$hook         = "my_test_hook_{$i}";
			$test_hooks[] = $hook;
		}

		// add the hooks.
		$result = array();
		foreach ( $test_hooks as $this_hook ) {
			$this_callback = $this_hook . '_callback';
			$result        = $obj->add_action( $this_hook, [ $this, $this_callback ] );
		}
		$this->assertCount( $num_of_hooks, $result );

		// build results array.
		// i.e. same format as test data so can check it's the same.
		$actual = array();
		foreach ( $result as $result_hook ) {
			$this_hook = $result_hook['hook'];
			$actual[]  = $this_hook;
		}
		$this->assertSame( $test_hooks, $actual );
	}

	/**
	 * Test Add Filter method.
	 *
	 * @covers Property_Carousel_Loader::add_filter
	 */
	public function test_add_filter_one() {
		$obj = new Property_Carousel_Loader();

		$hook     = 'my_test_hook';
		$callback = 'nonsense_callback';

		$result = $obj->add_filter( $hook, [ $this, $callback ] );
		$this->assertCount( 1, $result );

		$this->assertSame( $result[0]['hook'], $hook );
	}

	/**
	 * Test Add Filter method - multiple actions.
	 *
	 * Adds several filters and checks they are are in the collection of actions.
	 *
	 * @covers Property_Carousel_Loader::add_filter
	 */
	public function test_add_filter_multiple() {
		$obj = new Property_Carousel_Loader();

		// setup test data - random number of hooks above 1.
		$num_of_hooks = wp_rand( 2, 20 );
		$test_hooks   = array();
		for ( $i = 0; $i < $num_of_hooks; $i ++ ) {
			$hook         = "my_test_hook_{$i}";
			$test_hooks[] = $hook;
		}

		// add the hooks.
		$result = array();
		foreach ( $test_hooks as $this_hook ) {
			$this_callback = $this_hook . '_callback';
			$result        = $obj->add_filter( $this_hook, [ $this, $this_callback ] );
		}
		$this->assertCount( $num_of_hooks, $result );

		// build results array.
		// i.e. same format as test data so can check it's the same.
		$actual = array();
		foreach ( $result as $result_hook ) {
			$this_hook = $result_hook['hook'];
			$actual[]  = $this_hook;
		}
		$this->assertSame( $test_hooks, $actual );
	}


	/**
	 * Test Run method - Actions.
	 *
	 * Create a test action then make sure it gets ran with run().
	 *
	 * @covers Property_Carousel_Loader::run
	 */
	public function test_run_actions() {
		$obj = new Property_Carousel_Loader();
		$obj->add_action( 'my_test_hook', [ $this, 'my_test_hook' ] );
		$obj->run();

		$this->test_counter = 0;
		do_action( 'my_test_hook' );
		$this->assertEquals( 10, $this->test_counter );
		$this->test_counter = 0;
	}

	/**
	 * Test Run method - Filters.
	 *
	 * Create a test filter then make sure it gets ran with run().
	 *
	 * @covers Property_Carousel_Loader::run
	 */
	public function test_run_filters() {
		$obj    = new Property_Carousel_Loader();
		$result = $obj->add_filter( 'my_test_hook', [ $this, 'my_test_hook' ] );
		$this->assertCount( 1, $result );
		$obj->run();

		$this->test_counter = 0;
		$new_val            = apply_filters( 'my_test_hook', 999 );
		$this->assertEquals( 10, $this->test_counter );
		$this->assertEquals( 10, $new_val );
		$this->test_counter = 0;
	}

	/**
	 * Test action that sets $test_counter = 10 and also returns 10.
	 *
	 * @return int Returns 0 or 10.
	 * @used-by test_run_actions
	 * @used-by test_run_filters
	 */
	public function my_test_hook() {
		$this->test_counter = 10;

		return $this->test_counter;
	}

}

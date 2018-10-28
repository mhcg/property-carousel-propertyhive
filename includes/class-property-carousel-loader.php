<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/includes
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */
class Property_Carousel_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array $actions The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array $filters The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->actions = array();
		$this->filters = array();
	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 *
	 * @param    string   $hook The name of the WordPress action that is being registered.
	 * @param    callable $callback The name of the function definition on the $component.
	 * @param    int      $priority Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int      $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 *
	 * @return array The collection of actions registered with WordPress.
	 */
	public function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions[] = array(
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $this->actions;
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 *
	 * @param    string   $hook The name of the WordPress filter that is being registered.
	 * @param    callable $callback The name of the function definition on the $component.
	 * @param    int      $priority Optional. The priority at which the function should be fired (default is 10).
	 * @param    int      $accepted_args Optional. The number of arguments that should be passed to the $callback (default is 1).
	 *
	 * @return array The collection of filters registered with WordPress.
	 */
	public function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters[] = array(
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $this->filters;
	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		foreach ( $this->filters as $hook ) {
			add_filter(
				$hook['hook'],
				$hook['callback'],
				$hook['priority'],
				$hook['accepted_args']
			);
		}

		foreach ( $this->actions as $hook ) {
			add_action(
				$hook['hook'],
				$hook['callback'],
				$hook['priority'],
				$hook['accepted_args']
			);
		}
	}

}

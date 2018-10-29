<?php
/**
 * Plugin Name:       Property Carousel for Property Hive
 * Plugin URI:        https://wordpress.org/plugins/property-carousel-for-propertyhive/
 * Description:       Property Hive extension to add a carousel feature.
 * Version:           1.0.0
 * Author:            MHCG LTD
 * Author URI:        https://www.mhcg.co.uk
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       property-carousel-propertyhive
 * Domain Path:       /languages
 *
 * Property Carousel for Property Hive is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Property Carousel for Property Hive is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this plugin. If not,
 * see http://www.gnu.org/licenses/gpl-3.0.txt.
 *
 * @link              https://github.com/mhcg/property-carousel-propertyhive
 * @since             1.0.0
 * @package           Property_Carousel_Propertyhive
 *
 * @wordpress-plugin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'PROPERTY_CAROUSEL_PROPERTYHIVE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function property_carousel_propertyhive_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-property-carousel-activator.php';
	Property_Carousel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function property_carousel_propertyhive_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-property-carousel-deactivator.php';
	Property_Carousel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'property_carousel_propertyhive_activate' );
register_deactivation_hook( __FILE__, 'property_carousel_propertyhive_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-property-carousel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function property_carousel_propertyhive_run() {
	$plugin = new Property_Carousel( PROPERTY_CAROUSEL_PROPERTYHIVE_VERSION );
	$plugin->run();
}

property_carousel_propertyhive_run();

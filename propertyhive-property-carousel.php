<?php

/**
 * Plugin Name:       Property Hive Property Carousel
 * Plugin URI:        https://github.com/mhcg/propertyhive-property-carousel
 * Description:       Property Hive extension to add a carousel feature.
 * Version:           1.0.0
 * Author:            MHCG LTD
 * Author URI:        https://www.mhcg.co.uk
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       propertyhive-property-carousel
 * Domain Path:       /languages
 *
 * Property Hive Property Carousel is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Property Hive Property Carousel is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this plugin. If not,
 * see http://www.gnu.org/licenses/gpl-3.0.txt.
 *
 *
 * @link              https://github.com/mhcg/propertyhive-property-carousel
 * @since             1.0.0
 * @package           Propertyhive_Property_Carousel
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
define( 'PROPERTYHIVE_PROPERTY_CAROUSEL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_propertyhive_property_carousel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-propertyhive-property-carousel-activator.php';
	Propertyhive_Property_Carousel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_propertyhive_property_carousel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-propertyhive-property-carousel-deactivator.php';
	Propertyhive_Property_Carousel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_propertyhive_property_carousel' );
register_deactivation_hook( __FILE__, 'deactivate_propertyhive_property_carousel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-propertyhive-property-carousel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_propertyhive_property_carousel() {

	$plugin = new Propertyhive_Property_Carousel();
	$plugin->run();

}

run_propertyhive_property_carousel();

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/admin
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */
class Propertyhive_Property_Carousel_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $propertyhive_property_carousel The ID of this plugin.
	 */
	private $propertyhive_property_carousel;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $propertyhive_property_carousel The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $propertyhive_property_carousel, $version ) {

		$this->propertyhive_property_carousel = $propertyhive_property_carousel;
		$this->version                        = $version;

	}

	/**
	 * Add any admin notices that are relevant.
	 *
	 * @since 1.0.0
	 *
	 * @uses Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available()
	 */
	public function add_admin_notices() {
		if ( ! Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available() ) {
			add_action( 'admin_notices', function () {
				?>
                <div class="error notice">
                    <p><?php Propertyhive_Property_Carousel_i18n::_e(
							'Property Carousel requires the Property Hive plugin.'
						); ?></p>
                </div>
				<?php
			} );
		}
	}
}

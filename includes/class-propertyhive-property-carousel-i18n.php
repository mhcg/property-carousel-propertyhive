<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/includes
 * @author     MHCG LTD <contact@mhcg.co.uk>
 *
 * @codeCoverageIgnore Boilerplate Code - should have their own unit tests really
 */
class Propertyhive_Property_Carousel_i18n {

	const TEXT_DOMAIN = 'propertyhive-property-carousel';

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			self::TEXT_DOMAIN,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	/**
	 * Display translated text for this text domain.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text Text to translate.
	 */
	public static function _e( $text ) {
		_e( $text, self::TEXT_DOMAIN );
	}

	/**
	 * Retrieve the translation of $text for this text domain.
	 *
	 * If there is no translation, or the text domain isn't loaded, the original text is returned.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text Text to translate.
	 *
	 * @return string Translated text.
	 */
	public static function __( $text ) {
		return __( $text, self::TEXT_DOMAIN );
	}

}

<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/mhcg/property-carousel-propertyhive
 * @since      1.0.0
 *
 * @package    Property_Carousel_Propertyhive
 * @subpackage Property_Carousel_Propertyhive/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Property_Carousel_Propertyhive
 * @subpackage Property_Carousel_Propertyhive/includes
 * @author     MHCG LTD <contact@mhcg.co.uk>
 *
 * @codeCoverageIgnore Boilerplate Code - should have their own unit tests really
 */
class Property_Carousel_I18n {

	const TEXT_DOMAIN = 'property-carousel-for-propertyhive';

	/**
	 * Helper class constructor.
	 */
	private function __construct() {
	}

	/**
	 * Helper class clone.
	 */
	private function __clone() {
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public static function load_plugin_textdomain() {
		load_plugin_textdomain(
			self::TEXT_DOMAIN,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	/**
	 * Display translated text that has been escaped for safe use in HTML output.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text   Text to translate.
	 */
	public static function esc_html_e( $text ) {
		esc_html_e( $text, self::TEXT_DOMAIN );
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

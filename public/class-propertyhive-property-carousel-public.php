<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, scripts, css and shortcodes.
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/public
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */
class Propertyhive_Property_Carousel_Public {

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
	 * @since 1.0.0
	 * @access private
	 * @var string $flexslider_js_handle The handle used when registering and enqueuing the FlexSlider library.
	 */
	private $flexslider_js_handle;

	/**
	 * @since 1.0.0
	 * @access private
	 * @var string $flexslider_css_handle The handle used when registering and enqueuing the FlexSlider CSS.
	 */
	private $flexslider_css_handle;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $propertyhive_property_carousel The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $propertyhive_property_carousel, $version ) {

		$this->propertyhive_property_carousel = $propertyhive_property_carousel;
		$this->version                        = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_register_style(
			$this->propertyhive_property_carousel,
			plugin_dir_url( __FILE__ ) . 'css/propertyhive-property-carousel-public.css',
			$this->get_flexslider_css_handle(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script(
			$this->propertyhive_property_carousel,
			plugin_dir_url( __FILE__ ) . 'js/propertyhive-property-carousel-public.js',
			array( 'jquery', $this->get_flexslider_js_handle() ),
			$this->version,
			false
		);

	}

	/**
	 * Register the shortcodes.
	 *
	 * @since 1.0.0
	 */
	public function register_shortcodes() {

		add_shortcode(
			Propertyhive_Property_Carousel_Shortcode::SHORTCODE,
			array( $this, 'property_carousel_shortcode' )
		);

	}

	/**
	 * Output property carousel.
	 *
	 * Outputs a FlexSlider for the specified attributes.
	 *
	 * @see Propertyhive_Property_Carousel_Shortcode::property_carousel_shortcode()
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes The shortcode attributes
	 *
	 * @return string FlexSlider HTML or empty string if Property Hive plugin isn't active
	 */
	public function property_carousel_shortcode( $attributes ) {

		// Output nothing if Property Hive plugin isn't also active
		if ( ! Propertyhive_Property_Carousel_Shortcode::is_propertyhive_available() ) {
			return '';
		}

		// include the relevant styles and scripts and delegate the output the Shortcode helper
		wp_enqueue_style( $this->get_flexslider_css_handle() );
		wp_enqueue_style( $this->propertyhive_property_carousel );

		wp_enqueue_script( $this->get_flexslider_js_handle() );
		wp_enqueue_script( $this->propertyhive_property_carousel );

		return Propertyhive_Property_Carousel_Shortcode::property_carousel_shortcode( $attributes );

	}

	/**
	 * Returns the JS handler string.
	 *
	 * Works out which JS file to use for the FlexSlider.  Some themes and the Property Hive plugin
	 * come with their own versions so need to use one only.  Will use the Property Hive one if available,
	 * otherwise will include the version supplied with this plugin.
	 *
	 * @return string String to use for the JS handler when registering and enqueuing.
	 */
	protected function get_flexslider_js_handle() {

		if ( ! empty( $this->flexslider_js_handle ) ) {
			return $this->flexslider_js_handle;
		}

		// check the list of registered styles looking for an existing one to use
		foreach ( array( 'flexslider', 'jquery-flexslider' ) as $handle ) {
			if ( wp_style_is( $handle ) ) {
				return $handle;
			}
		}

		// otherwise, use ours
		$this->flexslider_js_handle = 'jquery-flexslider';
		wp_register_script(
			$this->flexslider_js_handle,
			plugin_dir_url( __FILE__ ) . 'js/jquery.flexslider.js',
			array( 'jquery' ),
			'2.2.2',
			false
		);

		return $this->flexslider_js_handle;

	}

	/**
	 * Register default template hooks.
	 *
	 * Default template bits from the Property Hive template.  Override as theme as needed.
	 *
	 * @since 1.0.0
	 */
	public function register_default_template_hooks() {
		/**
		 * Featured Property Carousel Loop Items
		 *
		 * @see propertyhive_template_loop_property_thumbnail()
		 * @see propertyhive_template_loop_summary()
		 * @see propertyhive_template_loop_price()
		 */
		add_action( 'propertyhive_property_carousel_loop_thumbnail', 'propertyhive_template_loop_property_thumbnail', 10 );

		add_action( 'propertyhive_property_carousel_loop_after_title', 'propertyhive_template_loop_summary', 30 );
		add_action( 'propertyhive_property_carousel_loop_after_title', 'propertyhive_template_loop_price', 50 );
	}

	/**
	 * Returns the CSS handler string.
	 *
	 * Works out which CSS to use for the FlexSlider.  Some themes and the Property Hive plugin
	 * come with their own versions so need to use only one.  Will use the Property Hive one if available,
	 * otherwise will include the version supplied with this plugin.
	 *
	 * @return string String to use for the CSS handler when registering and enqueuing.
	 */
	protected function get_flexslider_css_handle() {

		if ( ! empty( $this->flexslider_css_handle ) ) {
			return $this->flexslider_css_handle;
		}

		// check the list of registered styles looking for an existing one to use
		foreach ( array( 'flexslider_css', 'flexslider' ) as $handle ) {
			if ( wp_style_is( $handle ) ) {
				return $handle;
			}
		}

		// otherwise, use ours
		$this->flexslider_css_handle = 'flexslider_css';
		wp_register_style(
			$this->flexslider_css_handle,
			plugin_dir_url( __FILE__ ) . 'css/flexslider.css',
			array(),
			'2.2.2',
			'all'
		);

		return $this->flexslider_css_handle;

	}

}

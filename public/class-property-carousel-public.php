<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/mhcg/property-carousel-propertyhive
 * @since      1.0.0
 *
 * @package    Property_Carousel_Propertyhive
 * @subpackage Property_Carousel_Propertyhive/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, scripts, css and shortcodes.
 *
 * @package    Property_Carousel_Propertyhive
 * @subpackage Property_Carousel_Propertyhive/public
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */
class Property_Carousel_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $property_carousel_propertyhive The ID of this plugin.
	 */
	private $property_carousel_propertyhive;

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
	 * @param      string $property_carousel_propertyhive The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $property_carousel_propertyhive, $version ) {
		$this->property_carousel_propertyhive = $property_carousel_propertyhive;
		$this->version                        = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style(
			$this->property_carousel_propertyhive,
			plugin_dir_url( __FILE__ ) . 'css/property-carousel-public.css',
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
			$this->property_carousel_propertyhive,
			plugin_dir_url( __FILE__ ) . 'js/property-carousel-public.js',
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
			Property_Carousel_Shortcode::SHORTCODE,
			array( $this, 'property_carousel_shortcode' )
		);
	}

	/**
	 * Output property carousel.
	 *
	 * Outputs a FlexSlider for the specified attributes.
	 *
	 * @see  Property_Carousel_Shortcode::property_carousel_shortcode()
	 *
	 * @since 1.0.0
	 * @uses Property_Carousel_Shortcode::is_propertyhive_available()
	 * @uses Property_Carousel_Shortcode::get_flexslider_css_handle()
	 * @uses Property_Carousel_Shortcode::get_flexslider_js_handle()
	 * @uses Property_Carousel_Shortcode::property_carousel_shortcode()
	 *
	 * @param array $attributes The shortcode attributes.
	 *
	 * @return string FlexSlider HTML or empty string if Property Hive plugin isn't active
	 */
	public function property_carousel_shortcode( $attributes ) {
		// Output nothing if Property Hive plugin isn't active.
		if ( ! Property_Carousel_Shortcode::is_propertyhive_available() ) {
			return '';
		}

		// include the relevant styles and scripts and delegate the output the Shortcode helper.
		wp_enqueue_style( $this->get_flexslider_css_handle() );
		wp_enqueue_style( $this->property_carousel_propertyhive );

		wp_enqueue_script( $this->get_flexslider_js_handle() );
		wp_enqueue_script( $this->property_carousel_propertyhive );

		return Property_Carousel_Shortcode::property_carousel_shortcode_output( $attributes );
	}

	/**
	 * Register default template hooks.
	 *
	 * Default template bits from the Property Hive template.  Override as theme as needed.
	 *
	 * @since 1.0.0
	 */
	public function register_default_template_hooks() {
		if ( Property_Carousel_Shortcode::is_propertyhive_available() ) {
			/**
			 * Featured Property Carousel Loop Items
			 *
			 * @see propertyhive_template_loop_property_thumbnail()
			 * @see propertyhive_template_loop_summary()
			 * @see propertyhive_template_loop_price()
			 */
			add_action( 'property_carousel_loop_thumbnail', 'propertyhive_template_loop_property_thumbnail', 10 );

			add_action( 'property_carousel_loop_after_title', 'propertyhive_template_loop_summary', 30 );
			add_action( 'property_carousel_loop_after_title', 'propertyhive_template_loop_price', 50 );
		}
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
		// check the list of registered styles looking for an existing one to use.
		foreach ( array( 'flexslider_css', 'flexslider' ) as $handle ) {
			if ( wp_style_is( $handle ) ) {
				return $handle;
			}
		}

		// otherwise, use ours.
		$flexslider_css_handle = 'flexslider_css';
		wp_register_style(
			$flexslider_css_handle,
			plugin_dir_url( __FILE__ ) . 'css/flexslider.css',
			array(),
			'2.2.2',
			'all'
		);

		return $flexslider_css_handle;
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
		// check the list of registered styles looking for an existing one to use.
		foreach ( array( 'flexslider', 'jquery-flexslider' ) as $handle ) {
			if ( wp_style_is( $handle ) ) {
				return $handle;
			}
		}

		// otherwise, use ours.
		$flexslider_js_handle = 'jquery-flexslider';
		wp_register_script(
			$flexslider_js_handle,
			plugin_dir_url( __FILE__ ) . 'js/jquery.flexslider.js',
			array( 'jquery' ),
			'2.2.2',
			false
		);
		return $flexslider_js_handle;
	}

}

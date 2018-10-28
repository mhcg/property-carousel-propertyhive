<?php
/**
 * The property carousel functionality of the plugin.
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/public
 */

/**
 * The property carousel functionality of the plugin.
 *
 * Defines the shortcode and everything related to its functionality.
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/public
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */
class Property_Carousel_Shortcode {

	/**
	 * Helper class constructor.
	 *
	 * @codeCoverageIgnore
	 */
	private function __construct() {
	}

	/**
	 * Helper class clone.
	 *
	 * @codeCoverageIgnore
	 */
	private function __clone() {
	}

	/** The shortcode. */
	const SHORTCODE = 'property_carousel';

	/**
	 * Checks if Property Hive plugin is available.
	 *
	 * @since 1.0.0
	 *
	 * @todo Probably a better way of detecting if Property Hive active than this.
	 *
	 * @return bool True is Property Hive plugin is active otherwise false
	 */
	public static function is_propertyhive_available() {
		/**
		 * Allows overriding of the availability checking of is_propertyhive_available().
		 *
		 * Mainly used for unit tests as the plugin is not generally available when testing.
		 *
		 * @since 1.0.0
		 */
		$ph_available = apply_filters(
			'property_carousel_is_propertyhive_available',
			defined( 'PH_VERSION' )
		);

		return $ph_available;
	}

	/**
	 * Output property carousel.
	 *
	 * Outputs a FlexSlider for the specified attributes.
	 *
	 * Supported attributes:
	 *
	 * - featured - Featured properties or not ('true' or 'false'). Default is 'true'.
	 * - department - Property Hive department to filter on
	 * - office_id - Branch to filter on
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes The shortcode attributes.
	 *
	 * @return string FlexSlider HTML or empty string if Property Hive plugin isn't active
	 */
	public static function property_carousel_shortcode_output( $attributes = [] ) {
		/**
		 * Hook into the shortcode WP_Query call.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args WP_Query query.
		 * @param array $attributes Shortcode attributes.
		 */
		$query      = apply_filters( 'property_carousel_shortcode_query', self::query_for_shortcode( $attributes ) );
		$properties = new WP_Query( $query );

		if ( ! $properties->have_posts() ) {
			return '';
		}
		/**
		 * Shortcode output
		 */
		ob_start();

		if ( $properties->have_posts() ) : ?>

			<ul class="propertyhive-property-carousel properties clear slides">

				<?php while ( $properties->have_posts() ) : ?>

					<?php
					$properties->the_post();
					require self::property_carousel_loop_template();
					?>

				<?php endwhile; ?>

			</ul>

		<?php endif; ?>

		<?php
		wp_reset_postdata();
		return '<div class="propertyhive-property-carousel-shortcode flexslider">' . ob_get_clean() . '</div>';
	}

	/**
	 * Get the carousel loop template file path.
	 *
	 * Returns a default template for the property carousel items if one doesn't exist in the theme files.
	 *
	 * @since 1.0.0
	 *
	 * @return string Full path of the file to be require(d) for the carousel loop template
	 */
	public static function property_carousel_loop_template() {
		$template = locate_template(
			'property-carousel/property-carousel.php',
			false
		);

		if ( empty( $template ) ) {
			$template = plugin_dir_path( __FILE__ ) . 'partials/property-carousel.php';
		}

		/**
		 * Property carousel loop item template hook.
		 *
		 * @since 1.0.0
		 *
		 * @param string $template The full path of the template file being returned.
		 */
		return apply_filters( 'property_carousel_loop_template', $template );
	}

	/**
	 * Returns an array suitable for passing into post_class() for the LI tag.
	 *
	 * @param int $post_id The post_id of the property.
	 * @return array Array suitable for passing into post_class().
	 */
	public static function get_property_post_class( $post_id ) {
		$featured  = get_post_meta( $post_id, '_featured', true ) ?: 'no';
		$classes   = array( 'clear' );
		$classes[] = 'property-carousel-property';
		if ( 'yes' === $featured ) {
			$classes[] = 'featured';
		}
		return $classes;
	}

	/**
	 * Build a WP_Query object for the shortcode attributes.
	 *
	 * @uses Property_Carousel_Shortcode::meta_query_for_on_market()
	 * @uses Property_Carousel_Shortcode::meta_query_for_featured()
	 * @uses Property_Carousel_Shortcode::meta_query_for_department()
	 * @uses Property_Carousel_Shortcode::meta_query_for_office_id()

	 * @param array $attributes Shortcode attributes array.
	 *
	 * @return array Query for WP_Query object.
	 */
	private static function query_for_shortcode( $attributes ) {
		/**
		 * Supported attributes.
		 *
		 * @var string $featured Show only featured properties or not (true or false), leave blank for properties.
		 * @var string $department Property Hive department to filter on
		 * @var string $office_id Branch to filter on
		 */
		$extract    = shortcode_atts(
			array(
				'featured'   => '',
				'department' => '',
				'office_id'  => '',
			),
			$attributes,
			self::SHORTCODE
		);
		$featured   = $extract['featured'];
		$department = $extract['department'];
		$office_id  = $extract['office_id'];

		/**
		 * Build the WP_Query stuff.
		 *
		 * Only on-market at the very least, plus filtered by additional shortcode attributes.
		 */
		$meta_query = self::build_meta_query( 'yes', $featured, $department, $office_id );
		$query      = array(
			'post_type'           => 'property',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => 'rand',
			'order'               => 'DESC',
			'meta_query'          => $meta_query, // @codingStandardsIgnoreLine WordPress.VIP.SlowDBQuery.slow_db_query
			'posts_per_page'      => 10,
		);

		return $query;
	}

	/**
	 * Build meta_query for WP_Query object.
	 *
	 * @param string $on_market On-market (or not), or blank for all.
	 * @param string $featured Featured (or not), or blank for all.
	 * @param string $department Department (residential-sales, residential-lettings or commercial), or blank for all.
	 * @param string $office_id Office ID, or blank for all.
	 *
	 * @return array Fully formed meta_query for use in WP_Query object.
	 */
	private static function build_meta_query( $on_market, $featured, $department, $office_id ): array {
		$meta_query = array();
		$meta_query = self::meta_query_for_on_market( $meta_query, $on_market );
		$meta_query = self::meta_query_for_featured( $meta_query, $featured );
		$meta_query = self::meta_query_for_department( $meta_query, $department );
		$meta_query = self::meta_query_for_office_id( $meta_query, $office_id );

		return $meta_query;
	}

	/**
	 * Add to supplied meta_query, filter for Featured.
	 *
	 * @param array  $meta_query Current meta_query.
	 * @param string $on_market On-market (or not), or blank for all.
	 *
	 * @return array Amended meta_query.
	 */
	private static function meta_query_for_on_market( $meta_query, $on_market = 'yes' ) {
		if ( ! empty( $on_market ) ) {
			$only_on_market = filter_var( $on_market, FILTER_VALIDATE_BOOLEAN );
			$meta_query[]   = array(
				'key'   => '_on_market',
				'value' => ( true === $only_on_market ? 'yes' : 'no' ),
			);
		}

		return $meta_query;
	}

	/**
	 * Add to supplied meta_query, filter for Featured.
	 *
	 * @param array  $meta_query Current meta_query.
	 * @param string $featured Featured (or not), or blank for all.
	 *
	 * @return array Amended meta_query.
	 */
	private static function meta_query_for_featured( $meta_query, $featured ) {
		if ( ! empty( $featured ) ) {
			$only_featured = filter_var( $featured, FILTER_VALIDATE_BOOLEAN );
			$meta_query[]  = array(
				'key'   => '_featured',
				'value' => ( true === $only_featured ? 'yes' : 'no' ),
			);
		}

		return $meta_query;
	}

	/**
	 * Add to supplied meta_query, filter for Department.
	 *
	 * @param array  $meta_query Current meta_query.
	 * @param string $department Department (residential-sales, residential-lettings or commercial), or blank for all.
	 *
	 * @return array Amended meta_query.
	 */
	private static function meta_query_for_department( $meta_query, $department ) {
		if ( ! empty( $department ) ) {
			$all_departments = array(
				'residential-sales',
				'residential-lettings',
				'commercial',
			);
			if ( false !== array_search( $department, $all_departments, true ) ) {
				$meta_query[] = array(
					'key'     => '_department',
					'value'   => $department,
					'compare' => '=',
				);
			}
		}

		return $meta_query;
	}

	/**
	 * Add to supplied meta_query, filter for Office ID.
	 *
	 * @param array  $meta_query Current meta_query.
	 * @param string $office_id Office ID, or blank for all.
	 *
	 * @return array Amended meta_query.
	 */
	private static function meta_query_for_office_id( $meta_query, $office_id ) {
		if ( ! empty( $office_id ) ) {
			$meta_query[] = array(
				'key'     => '_office_id',
				'value'   => explode( ',', $office_id ),
				'compare' => 'IN',
			);
		}

		return $meta_query;
	}
}

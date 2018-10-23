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

	/** @var string The shortcode */
	const SHORTCODE = 'property_carousel';

	/**
	 * Checks if Property Hive plugin is available.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True is Property Hive plugin is active otherwise false
	 */
	public static function is_propertyhive_available() {
		return defined( 'PH_VERSION' );
	}

	/**
	 * Output property carousel.
	 *
	 * Outputs a FlexSlider for the specified attributes.
	 *
	 * Supported attributes:
	 *
	 * - featured - Featured properties or not (true or false)
	 * - department - Property Hive department to filter on
	 * - office_id - Branch to filter on
	 * - orderby - Usual 'orderby' (for WP_Query)
	 * - order - ASC or DESC (for WP_Query)
	 * - meta_key - Sorting by meta_value (for WP_Query)
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes The shortcode attributes
	 *
	 * @return string FlexSlider HTML or empty string if Property Hive plugin isn't active
	 */
	public static function property_carousel_shortcode_output( $attributes = [] ) {
		$extract = shortcode_atts(
			array(
				'featured'   => 'true',
				'department' => '',
				'office_id'  => '',
				'orderby'    => 'rand',
				'order'      => 'desc',
				'meta_key'   => '',
			),
			$attributes,
			self::SHORTCODE
		);
		/**
		 * @var string $featured Featured properties or not (true or false)
		 * @var string $department Property Hive department to filter on
		 * @var string $office_id Branch to filter on
		 * @var string $orderby Usual 'orderby' (for WP_Query)
		 * @var string $order ASC or DESC (for WP_Query)
		 * @var string $meta_key Optional used sorting by meta_value (for WP_Query)
		 * @var array $post_status Post statuses to filter on, includes private if applicable
		 */
		$featured   = $extract['featured'];
		$department = $extract['department'];
		$office_id  = $extract['office_id'];
		$orderby    = $extract['orderby'];
		$order      = $extract['order'];
		$meta_key   = $extract['meta_key'];

		$post_status = array( 'publish' );
		if ( is_user_logged_in() && current_user_can( 'manage_propertyhive' ) ) {
			$post_status[] = 'private';
		}

		/**
		 * Build and run the WP_Query stuff
		 */
		$meta_query = array(
			array(
				'key'   => '_on_market',
				'value' => 'yes',
			),
			array(
				'key'   => '_featured',
				'value' => ( $featured == 'true' ? 'yes' : 'no' ),
			)
		);
		if ( ! empty( $department ) ) {
			$meta_query[] = array(
				'key'     => '_department',
				'value'   => $department,
				'compare' => '='
			);
		}
		if ( ! empty( $office_id ) ) {
			$meta_query[] = array(
				'key'     => '_office_id',
				'value'   => explode( ",", $office_id ),
				'compare' => 'IN'
			);
		}
		$args = array(
			'post_type'           => 'property',
			'post_status'         => $post_status,
			'ignore_sticky_posts' => 1,
			'orderby'             => $orderby,
			'order'               => $order,
			'meta_query'          => $meta_query,
			'meta_key'            => $meta_key
		);

		/**
		 * Hook into the shortcode WP_Query call.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args WP_Query query.
		 * @param array $attributes Shortcode attributes.
		 */
		$properties = new WP_Query(
			apply_filters( 'property_carousel_shortcode_query', $args, $attributes )
		);

		/**
		 * Shortcode output
		 */
		ob_start();

		if ( $properties->have_posts() ) : ?>

            <ul class="propertyhive-property-carousel properties clear slides">

				<?php while ( $properties->have_posts() ) : $properties->the_post(); ?>

					<?php require self::property_carousel_loop_template(); ?>

				<?php endwhile; // end of the loop. ?>

            </ul>

		<?php endif;

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
}
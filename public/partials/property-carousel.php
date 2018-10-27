<?php
/**
 * The template for displaying a single property within the property carousel.
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/public/partials
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */

// @codeCoverageIgnoreStart

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

$property_carousel_loop_item_classes = Property_Carousel_Shortcode::get_property_post_class( get_the_ID() );
?>

<li <?php post_class( $property_carousel_loop_item_classes ); ?>>

	<?php
	/**
	 * Called before each loop item, within the <li> tag.
	 *
	 * @since 1.0.0
	 */
	do_action( 'property_carousel_before_loop_item' );
	?>

	<div class="thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php
			/**
			 * Called to output a thumbnail within the <a> tag.
			 *
			 * @since 1.0.0
			 * @hooked propertyhive_template_loop_property_thumbnail - 10
			 */
			do_action( 'property_carousel_loop_thumbnail' );
			?>
		</a>
	</div>

	<div class="details">

		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php
		/**
		 * Called after the title link, ideally to provide further details.
		 *
		 * @since 1.0.0
		 * @hooked propertyhive_template_loop_summary - 30
		 * @hooked propertyhive_template_loop_price - 50
		 */
		do_action( 'property_carousel_loop_after_title' );
		?>

	</div>

	<?php
	/**
	 * Called after each look item, still within the <li> tag.
	 *
	 * @since 1.0.0
	 */
	do_action( 'property_carousel_loop_after_details' );
	?>

</li>

// @codeCoverageIgnoreEnd

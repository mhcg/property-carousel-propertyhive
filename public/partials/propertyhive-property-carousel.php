<?php

/**
 * The template for displaying a single property within property carousel.
 *
 * @link       https://github.com/mhcg/propertyhive-property-carousel
 * @since      1.0.0
 *
 * @package    Propertyhive_Property_Carousel
 * @subpackage Propertyhive_Property_Carousel/public/partials
 * @author     MHCG LTD <contact@mhcg.co.uk>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $property;

// Ensure visibility
if ( ! $property ) {
	return;
}

// Extra post classes
$classes   = array( 'clear' );
$classes[] = 'propertyhive-property-carousel-property';
if ( $property->featured == 'yes' ) {
	$classes[] = 'featured';
}
?>

<li <?php post_class( $classes ); ?>>

	<?php do_action( 'propertyhive_before_carousel_loop_item' ); ?>

    <div class="thumbnail">
        <a href="<?php the_permalink(); ?>">
			<?php
			/**
			 * propertyhive_property_carouself_loop_thumbnail hook
			 *
			 * @hooked propertyhive_template_loop_property_thumbnail - 10
			 */
			do_action( 'propertyhive_property_carousel_loop_thumbnail' );
			?>
        </a>
    </div>

    <div class="details">

        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php
		/**
		 * propertyhive_property_carousel_loop_after_title hook
		 *
		 * @hooked propertyhive_template_loop_summary - 30
		 * @hooked propertyhive_template_loop_price - 50
		 */
		do_action( 'propertyhive_property_carousel_loop_after_title' );
		?>

    </div>

	<?php do_action( 'propertyhive_property_carousel_loop_after_details' ); ?>

</li>


<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Define product carousel shortcode
 *
 * @since  1.0.0
 * 
 */
function carousel_shortcode( $atts, $content = null ) {

	$atts = shortcode_atts (array(
		'featured'            => 'yes',
		'items_total'         => 12,
		'items_visible'       => 4,
		'items_desktop'       => '1199,4',
		'items_desktop_small' => '979,3',
		'items_tablet'        => '768,2',
		'items_mobile'        => '479,1',
		'custom_class'        => ''
	), $atts, 'duck-woo-carousel'  );

	global $woocommerce_loop;

	// Get products on sale

	$meta_query   = array();
	$meta_query[] = WC()->query->visibility_meta_query();
	$meta_query[] = WC()->query->stock_status_meta_query();

	// add featured products to metaquey if needed
	if ( 'yes' == $atts['featured'] ) {
		$tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN',
        );
	}

	$meta_query   = array_filter( $meta_query );
    $items_total = $atts['items_total'];
    
	$args = array(
		'posts_per_page'	=> $items_total,
		'post_status' 		=> 'publish',
		'post_type' 		=> 'product',
		'tax_query' 		=>  $tax_query
	);

	// add on slae products to query if needed

	
	ob_start();

	$products = new WP_Query($args);

	$woocommerce_loop['columns'] = $atts['items_visible'];

	if ( $products->have_posts() ) : ?>

		<?php 

			echo '<div class="cherry_wc_product_carousel ' . esc_attr( $atts['custom_class'] ) . '">';
			echo '<ul class="products owl-carousel">';

		?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
                
                <?php echo the_title() . ' <br /> ' ;?>            

			<?php endwhile; // end of the loop. ?>

		<?php 
			echo '</ul>';
			echo '</div>';

		?>

	<?php endif;

	wp_reset_postdata();

	return '<div class="woocommerce">' . ob_get_clean() . '</div>';

    }

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
    
    wp_enqueue_script('slick');
    wp_enqueue_style('slick-css');
    wp_enqueue_script('dd-woo-carousel');
    wp_enqueue_style('dd-woo-carousel');

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

			echo '<div class="duck-carousel owl-carousel' . esc_attr( $atts['custom_class'] ) . '">';

		?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
                <div>
                <?php 	
                        do_action( 'woocommerce_before_shop_loop_item' );
                        do_action( 'woocommerce_before_shop_loop_item_title' );
                        echo '<h4>';
                            echo the_title();
                        echo '</h4>';
                        do_action( 'woocommerce_after_shop_loop_item_title' );
                        echo '<div style="text-align: center;">';
                            do_action( 'woocommerce_after_shop_loop_item' );
                        echo '</div>';
                ?>            
                </div>
			<?php endwhile; // end of the loop. ?>

		<?php 
			echo '</div>';
    endif;

	wp_reset_postdata();

	return '<div class="duck-diver-owl-carousel">' . ob_get_clean() . '</div>';

    }


<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.duckdiverllc.com
 * @since      1.0.0
 *
 * @package    Duck_Woo_Carousel
 * @subpackage Duck_Woo_Carousel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Duck_Woo_Carousel
 * @subpackage Duck_Woo_Carousel/public
 * @author     Howard Ehrenberg<howard@duckdiverllc.com>
 */
class Duck_Woo_Carousel_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
       
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dd-woo-carousel-public.css', array(), $this->version, 'all' );
        wp_register_style('slick-css', plugin_dir_url(__FILE__) . 'js/slick/slick.css' );
	}
	public function enqueue_scripts() {

        wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dd-woo-carousel-public.js', array( 'jquery' ), $this->version, false );
        wp_register_script( 'slick', plugin_dir_url(__FILE__) . 'js/slick/slick.min.js', array('jquery'), '1.12', false);
	}


    public function carousel_shortcode( $atts, $content = null ) {
    
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

			echo '<div class="duck-woo-carousel' . esc_attr( $atts['custom_class'] ) . '">';

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

	return '<div class="woocommerce duck-carousel-wrapper">' . ob_get_clean() . '</div>';

    }
    
}

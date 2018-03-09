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
        $this->register_shortcode();
        $this->include_shortcode();
        
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


    
    public function include_shortcode(){
        require ('dd-woo-carousel-shortcode.php');
    }
    
    public function register_shortcode(){
        add_shortcode('dd-woo-carousel', 'carousel_shortcode');
    }
    
}

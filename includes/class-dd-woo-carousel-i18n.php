<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.duckdiverllc.com
 * @since      1.0.0
 *
 * @package    Duck_Woo_Carousel
 * @subpackage Duck_Woo_Carousel/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Duck_Woo_Carousel
 * @subpackage Duck_Woo_Carousel/includes
 * @author     Howard Ehrenberg<howard@duckdiverllc.com>
 */
class Duck_Woo_Carousel_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dd-woo-carousel',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

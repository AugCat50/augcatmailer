<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://94.244.191.245/wordpress/
 * @since      1.0.0
 *
 * @package    Augcatmailer
 * @subpackage Augcatmailer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Augcatmailer
 * @subpackage Augcatmailer/includes
 * @author     AugCat50 <augcat50@gmail.com>
 */
class Augcatmailer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'augcatmailer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

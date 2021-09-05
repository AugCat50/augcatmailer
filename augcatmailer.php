<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://94.244.191.245/wordpress/
 * @since             1.0.0
 * @package           Augcatmailer
 *
 * @wordpress-plugin
 * Plugin Name:       AugCatMailer
 * Plugin URI:        http://94.244.191.245/wordpress/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            AugCat50
 * Author URI:        http://94.244.191.245/wordpress/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       augcatmailer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AUGCATMAILER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-augcatmailer-activator.php
 */
function activate_augcatmailer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-augcatmailer-activator.php';
	Augcatmailer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-augcatmailer-deactivator.php
 */
function deactivate_augcatmailer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-augcatmailer-deactivator.php';
	Augcatmailer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_augcatmailer' );
register_deactivation_hook( __FILE__, 'deactivate_augcatmailer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-augcatmailer.php';



//
//add_action( 'wp_ajax_my_action', 'my_action_callback' );
//function my_action_callback() {
//	$whatever = intval( $_POST['whatever'] );
//
//	$whatever += 10;
//	echo $whatever;
//
//	wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
//}




/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_augcatmailer() {
//    echo "hello!";
	$plugin = new Augcatmailer();
	$plugin->run();
    //Хуки, обработчики здесь.
}

run_augcatmailer();

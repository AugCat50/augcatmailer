<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://94.244.191.245/wordpress/
 * @since      1.0.0
 *
 * @package    Augcatmailer
 * @subpackage Augcatmailer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Augcatmailer
 * @subpackage Augcatmailer/includes
 * @author     AugCat50 <augcat50@gmail.com>
 */
class Augcatmailer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Augcatmailer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AUGCATMAILER_VERSION' ) ) {
			$this->version = AUGCATMAILER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'augcatmailer';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Augcatmailer_Loader. Orchestrates the hooks of the plugin.
	 * - Augcatmailer_i18n. Defines internationalization functionality.
	 * - Augcatmailer_Admin. Defines all hooks for the admin area.
	 * - Augcatmailer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-augcatmailer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-augcatmailer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-augcatmailer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-augcatmailer-public.php';

		$this->loader = new Augcatmailer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Augcatmailer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Augcatmailer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
     * Объект класса Admin передаётся в Loader::add_action(), где регистрируется обработчик на метод этого переданного объекта.
     *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
        
		$plugin_admin = new Augcatmailer_Admin( $this->get_plugin_name(), $this->get_version() );
        
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        
        //Регистрация хука меню в админке.
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'options_page' );
        
        //Регистрация хука на обработчкик ajax запроса из админки с ключём action : 'save_form'
        $this->loader->add_action( 'wp_ajax_save_form', $plugin_admin, 'ajax_save_form_function' );
        
        //Регистрация хука на обработчкик ajax запроса из админки с ключём action : 'get_form'
        $this->loader->add_action( 'wp_ajax_get_form', $plugin_admin, 'ajax_get_form_function' );
        
        //Регистрация хука на обработчкик ajax запроса из админки с ключём action : 'get_list'
        $this->loader->add_action( 'wp_ajax_get_list', $plugin_admin, 'ajax_get_list_function' );
	}
    
    
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Augcatmailer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	// Здесь зарегаем шорткод [augcat_form name="имя файла до точки разрешения"]
	private function define_shortcodes() {
				
		add_shortcode( 'augcat_form', 'augcat_form_print' );

		function augcat_form_print( $atts ) {
			$data = shortcode_atts( [
				'name' => 'default'
			], 
			$atts );

			$path   = plugin_dir_path( dirname( __FILE__ ) ) . 'storage/' . $data['name'] . ".html";
			$result = file_get_contents( $path );
			
			return $result;
		}
	}
	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
//        
//        if($_SERVER['REQUEST_METHOD'] === "POST") {
//            $this->postController($_POST);
//        }
	}
    
    /**
    * Query analysis
    *
    * 
    */
//    public function postController(array $post) {
//        if(isset($post['action']) && $post['action'] === 'save form'){
//            echo "hello2!";
//            $this->save_form($post);
//        }
//    }
//    
//    public function save_form(array $post) {
//        $obj = new Augcatmailer_Save_Form();
//        $obj->save();
//    }

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Augcatmailer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://94.244.191.245/wordpress/
 * @since      1.0.0
 *
 * @package    Augcatmailer
 * @subpackage Augcatmailer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Augcatmailer
 * @subpackage Augcatmailer/admin
 * @author     AugCat50 <augcat50@gmail.com>
 */
class Augcatmailer_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
        
//        add_action("admin_menu", array($this, "options_page"));

	}
    
    /**
    * Registering plugin menu in admin panel
    * Регистрация меню плагина в админке
    */
    public function options_page() {
        add_options_page(
            "AugCat50 Mailer Options",
            "AugCat50 Mailer",
            "manage_options",
            "augcat50_mailer_options",
            array( $this, 'settings_page' )
        );
    }
    
    /**
    * Connecting the plugin admin page template
    */
    function  settings_page () {
        require_once plugin_dir_path( dirname(__FILE__) ) . "admin/partials/augcatmailer-admin-display.php";
	}
    
    /**
    * Обработчик ajax запросов по сохранению форм
    */
    function ajax_save_form_function() {
        require_once plugin_dir_path( dirname(__FILE__) ) . "includes/class-augcatmailer-save-form.php";
        
        $saveFormObj = new Augcatmailer_Save_Form();
        $result      = $saveFormObj->save($_POST['data']);
        echo $result;
        
//        $qwerty = $saveFormObj->decode($_POST['data']);
//        
//        print_r($qwerty); 
//        echo "<br>";
//        print_r($_POST); 
        
        wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
    }
    
    /**
    * Обработчик ajax запросов по получению кода форм
    */
    function ajax_get_form_function() {
        if ( isset($_POST['data']) ) {
            $path   = plugin_dir_path( dirname(__FILE__) ) . "storage/" . $_POST['data'] . ".html";
            $result = file_get_contents($path);
            echo '<p>Name: ' . $_POST['data'] . ' </p>' . $result;
        } else {
            echo "Данные отсутствуют";
        }
        
        wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
    }
    
    /**
    * Обработчик ajax запросов по получению писка форм. Используется для обновления списка
    */
    function ajax_get_list_function() {
        $list = scandir("../wp-content/plugins/augcatmailer/storage");
        
        //Вывод списка файлов с сохранёнными формами
        foreach ($list as $file) {
            if ($file != '.' && $file != '..') {
                $file = str_replace('.html', '', $file);
                echo "<p class='list__form-name js_list__form-name'>$file</p>";
            }
        }
        
        //Если в массиве есть только '.', '..' - массив пуст.
        if (count($list) == 2) {
            echo '<p>No forms saved.</p>';
        }
        
        wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Augcatmailer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Augcatmailer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/augcatmailer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Augcatmailer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Augcatmailer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        
//        wp_enqueue_script( 'jquery_1', plugin_dir_url( __FILE__ ) . 'js/jquery-3.5.1.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/augcatmailer-admin.js', array( 'jquery' ), $this->version, false );
	}
}

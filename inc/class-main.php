<?php
if ( ! defined( 'ABSPATH' ) )  exit('No direct script access allowed');

/**
 * Live COVID Main Class 
 * @author Chandan Kumar
 * @version 1.0.0
 * @since 1.0.0
 */

if( !class_exists('LCOVID_Main') ){

	class LCOVID_Main{

		/**
		 * Directory of the plugin
		 * @var string
		 */
		public $plugin_dir;

		/**
		 * Path of the plugin
		 * @var string
		 */
		public $plugin_path;

		/**
		 * Folder dir of the plugin
		 * @var string
		 */
		public $plugin_file;

		/**
		 * Static Singleton Holder
		 * @var self
		 */
		protected static $instance;

		/**
		 * Get (and instantiate, if necessary) the instance of the class
		 *
		 * @return self
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		protected function __construct() {
			$this->plugin_path = trailingslashit( LIVE_COVID_LTE_DIR );
			$this->plugin_dir = trailingslashit( LIVE_COVID_LTE_MAIN_PLUGIN_FILE );
			$this->plugin_file = trailingslashit( LIVE_COVID_LTE_PLUGIN_FILE );
			 
			$this->include_files();
			
			// Check if User in Admin Dashboard
			if( is_admin() ){
				self::admin_init();
			}

			add_action( 'widgets_init', [ $this, 'init_wp_widgets' ] );
		
			// Check if Elementor Loaded
			if ( did_action( 'elementor/loaded' ) ) {
		    	add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_elem_widgets' ] );
			}

			add_action( 'wp_enqueue_scripts',array($this,'enque_scripts') );

		}
		
		/**
		* All Actions for Admin Section
		* 
		* @since 1.0.0
		*
		* @access public
		*/

		public static function admin_init(){
			
			// Include Actions files
			require_once trailingslashit( LIVE_COVID_LTE_DIR ) . 'inc/options.php';
			
			// Register Instance
			LCOVID_Settings::instance();

		}

		/**
		* Include all mandatory files for plugin
		* 
		* @since 1.0.0
		*
		* @access protected
		*/

		protected function include_files(){
			require_once $this->plugin_path . 'inc/helper.php';
		    require_once $this->plugin_path . 'inc/class-inputs.php';
		    require_once $this->plugin_path . 'inc/class-lcovid-utils.php';
		    require_once $this->plugin_path . 'inc/class-lcovid-attrs.php';
		    require_once $this->plugin_path . 'inc/shortcodes.php';
		}

		/**
		* Add js and css files for Frontend
		* 
		* @since 1.0.0
		*
		* @access public
		*/

		public function enque_scripts(){
			// Enqueue Styles
			wp_enqueue_style( 'lcvad-style', $this->plugin_dir . 'assets/css/style.css', '', '', 'all' );

			wp_register_script( 'lcvad-numerator',  $this->plugin_dir .'assets/js/jquery-numerator.js' );
			wp_register_script( 'lcovid-script', $this->plugin_dir . 'assets/js/app.js', array('jquery'),'',true );

			//Localize Scripts
			wp_localize_script( 'lcovid-script', 'lcovid_options', get_option('lcovid_options') );

			// Enqueue Main Script File
			wp_enqueue_script( 'lcovid-script');
		}

		/**
		* Init Wordpress Widget Section
		*
		* Fired by `widgets_init` action hook.
		* 
		* @since 1.0.0
		*
		* @access public
		*/
		public function init_wp_widgets() {

			// Include Widget files
			require_once( $this->plugin_path . '/inc/widgets/wp-global.php' );
			require_once( $this->plugin_path . '/inc/widgets/wp-country.php' );

			// Register widget
			register_widget( 'LCOVID_Country_Widget' );
			register_widget( 'LCOVID_Global_Widget' );
		}

		/**
		* Init Elementor Widget Section
		*
		* Fired by `elementor/widgets/widgets_registered` action hook.
		*
		* @link https://code.elementor.com/php-hooks/#elementorwidgetswidgets_registered
		*
		* @access public
		*/
		public function init_elem_widgets() {

			// Include Widget files
			require_once( $this->plugin_path . '/inc/widgets/elem-global.php' );
			require_once( $this->plugin_path . '/inc/widgets/elem-country.php' );
			require_once( $this->plugin_path . '/inc/widgets/elem-table.php' );
			
			// Register widget
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \LCOVID_Global_Elem_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \LCOVID_Country_Elem_Widget() );	
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \LCOVID_Country_Table_Elem_Widget() );	
		}

	}
}
?>

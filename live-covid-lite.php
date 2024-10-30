<?php
/**
 * Plugin Name: Live Covid19 Lite
 * Description: Show Live COVID19 affected data on any wordpress site through wordpress shortcodes, widgets and powerfull elementor widgets
 * Author:      WP Mentals
 * Version:     1.0.0
 * Author URI:  https://wpmentals.com/
 * Plugin URI:  https://www.wpmentals.com/live-covid19
 * Text Domain: live-covid
 * Domain Path: /languages
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html


LIVE COVID19 Lite Plugin
Copyright (C) 2018-2020, WP Mentals, hi@wpmentals.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Live_COVID_LITE {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const TEXT_DOMAIN = 'live-covid';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n(){
		$locale = apply_filters('plugin_locale', get_locale(), self::TEXT_DOMAIN);
	
		load_textdomain(self::TEXT_DOMAIN, WP_LANG_DIR.'/live-covid/'.self::TEXT_DOMAIN.'-'.$locale.'.mo');
		load_plugin_textdomain(self::TEXT_DOMAIN, false, basename( dirname( __FILE__ ) ).'/languages/');
	}

	/**
	 * Initialize the plugin
	 *
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		if(!defined('LIVE_COVID_LTE_DIR')) define('LIVE_COVID_LTE_DIR',dirname( __FILE__ ));
		if(!defined('LIVE_COVID_LTE_MAIN_PLUGIN_FILE')) define('LIVE_COVID_LTE_MAIN_PLUGIN_FILE',plugins_url('',__FILE__));
		if(!defined('LIVE_COVID_LTE_PLUGIN_FILE')) define('LIVE_COVID_LTE_PLUGIN_FILE', __FILE__ );
		if(!defined('LIVE_COVID_LTE_VERSION')) define('LIVE_COVID_LTE_VERSION', self::VERSION );

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
		}

		add_filter( 'plugin_action_links_'.plugin_basename( LIVE_COVID_LTE_PLUGIN_FILE ), [$this,'action_links'] );
		add_filter('plugin_row_meta', [$this,'plugin_meta'], 10, 2  );

		// Check if Live COVID19 PRO is installed, Live COVID19 Lite couldn't run if Pro version is installed.
		if( class_exists('LCOVID_Main') ){
			add_action( 'admin_notices', [ $this, 'admin_notice_deactivate_live_covid' ] );
		}else{
			require_once(LIVE_COVID_LTE_DIR.'/inc/class-main.php');
			LCOVID_Main::instance();
		}

		
	}

	/**
	* Plugin Action Links in Plugin page
	*
	* Fired by `plugin_action_links_{plugin_name}` filter.
	* 
	* @since 1.0.0
	*
	* @access public
	*/

    public function action_links($links){
		$links[] = '<a href="' . esc_url( admin_url( 'options-general.php?page=lcovid-settings&tab=lcovid_shortcodes' ) ) . '"  aria-label="' . esc_attr__( 'Shortcode Generator', 'live-covid' ) . '" style="color:green">' . esc_html__( 'Shortcode Generator', 'domain' ) . '</a>';
		return $links;
	}
	
	/**
	* Plugin Action Links in Plugin page
	* 
	* Fired by `plugin_row_meta` filter.
	*
	* @since 1.0.0
	*
	* @access public
	*/
	public function plugin_meta($links, $file ){
		if ( plugin_basename( LIVE_COVID_LTE_PLUGIN_FILE ) == $file ) {
	        $links['docs'] = '<a target="_blank" href="' . esc_url( 'https://www.wpmentals.com/live-covid19/documentation' ) . '"  aria-label="' . esc_attr__( 'DOCS', 'live-covid' ) . '" >' . esc_html__( 'DOCS', 'live-covid' ) . '</a>';
   		}
   		return (array) $links;
	}

	/**
	 * Admin notice
	 *
	 * Notice when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated to use Elementor Widgets.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Live Covid19', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_deactivate_live_covid() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Pro Plugin name 2: PHP 3: Lite Plugin name */
			esc_html__( 'Please delete "%1$s" Pro version to use "%2$s"', 'live-covid' ),
			'<strong>' . esc_html__( 'Live COVID19' ) . '</strong>',
			'<strong>' . esc_html__( 'Live COVID19 Lite' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

Live_COVID_LITE::instance();

?>
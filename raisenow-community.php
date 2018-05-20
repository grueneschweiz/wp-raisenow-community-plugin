<?php
/**
 * Plugin Name:     RaiseNow donation forms
 * Plugin URI:      https://github.com/grueneschweiz/wp-raisenow-community-plugin
 * Description:     This community plugin lets you add RaiseNow donation forms by shortcode. IMPORTANT: You need to have a contract with https://www.raisenow.com/en to use this plugin.
 * Author:          Cyrill Bolliger | Grüne Schweiz | Les verts suisses
 * Author URI:      https://github.com/cyrillbolliger
 * Text Domain:     raisenow-community
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Raisenow_Community
 */

/**
 * lock out script kiddies: die an direct call
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * abspath to plugins directory
 */
define( 'RAISENOW_COMMUNITY_PATH', dirname( __FILE__ ) );

/**
 * version number (don't forget to change it also in the header)
 */
define( 'RAISENOW_COMMUNITY_VERSION', '1.0.0' );

/**
 * plugin prefix
 */
define( 'RAISENOW_COMMUNITY_PREFIX', 'raisenow-community' );

class Raisenow_Community_Main {
	
	/*
	 * register needed hooks on startup
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( &$this, 'i18n' ) );
		
		if ( is_admin() ) {
			$this->add_admin();
		} else {
			$this->add_frontend();
		}
	}
	
	/**
	 * register admin hooks
	 */
	public function add_admin() {
		// register for all admin pages
		add_action( 'admin_menu', array( &$this, 'add_menu' ) );
		
		// the following hooks are only registered on a contextual basis
		add_action( 'current_screen', function () {
			$context = get_current_screen();
			
			$this->add_short_code_generator( $context );
			$this->add_options( $context );
		} );
	}
	
	/**
	 * register hooks for the shortcode generator for posts, pages and all custom post types.
	 *
	 * @param null|WP_Screen $context
	 */
	public function add_short_code_generator( $context ) {
		$excluded_post_types = array(
			'attachment',
			'revision',
			'nav_menu_item',
			'custom_css',
			'customize_changeset'
		);
		if ( $context->post_type && ! in_array( $context->post_type, $excluded_post_types ) ) {
			add_action( 'admin_enqueue_scripts', array( &$this, 'load_resources' ) );
			
			require_once( RAISENOW_COMMUNITY_PATH . '/includes/class-raisenow-community-admin.php' );
			$admin = new Raisenow_Community_Admin();
			
			add_action( 'media_buttons', array( &$admin, 'add_media_button' ), 15 );
			add_action( 'admin_footer', array( &$admin, 'add_short_code_generator_html' ), 15 );
		}
	}
	
	/**
	 * register the options if we're on the corresponding option page
	 *
	 * @param null|WP_Screen $context
	 */
	public function add_options( $context ) {
		if ( $context->base ) {
			if ( 'options' == $context->base || 'settings_page_' . RAISENOW_COMMUNITY_PREFIX . '_donation_settings' == $context->base ) {
				require_once( RAISENOW_COMMUNITY_PATH . '/includes/class-raisenow-community-options.php' );
				$options = new Raisenow_Community_Options();
				$options->init();
				
				add_action( 'admin_enqueue_scripts', array( &$options, 'add_code_editor' ) );
			}
		}
	}
	
	/**
	 * register frontend hooks
	 */
	public
	function add_frontend() {
		add_action( 'init', array( &$this, 'short_code_handler' ) );
	}
	
	/**
	 * hook in the shortcodes
	 */
	public
	function short_code_handler() {
		require_once( RAISENOW_COMMUNITY_PATH . '/includes/class-raisenow-community-frontend.php' );
		add_shortcode( 'donation_form', array( new Raisenow_Community_Frontend(), 'donation_form' ) );
	}
	
	/**
	 * Add a menu
	 */
	public
	function add_menu() {
		add_options_page(
			__( 'Online donations', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			__( 'Online donations', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			'manage_options',
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			[ &$this, 'display_plugin_optionspage' ]
		);
	}
	
	/**
	 * Menu Callback
	 */
	public
	function display_plugin_optionspage() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) );
		}
		
		// Render the settings template
		include RAISENOW_COMMUNITY_PATH . '/admin/options.php';
	}
	
	/**
	 * I18n.
	 *
	 * Note: Put the translation in the languages folder in the plugins directory,
	 * name the translation files like "nameofplugin-lanugage_COUUNTRY.po". Ex: "raisenow-community-fr_FR.po"
	 */
	public
	function i18n() {
		$path = dirname( plugin_basename( __FILE__ ) ) . '/languages';
		load_plugin_textdomain( RAISENOW_COMMUNITY_PREFIX, false, $path );
	}
	
	/**
	 * load ressources (js, css)
	 */
	public
	function load_resources() {
		// css
		$style = RAISENOW_COMMUNITY_PREFIX . '-admin-css';
		if ( ! wp_style_is( $style, 'enqueued' ) ) {
			if ( ! wp_style_is( $style, 'registered' ) ) {
				wp_register_style(
					$style,
					plugins_url( '/css/' . RAISENOW_COMMUNITY_PREFIX . '-admin.css', __FILE__ ),
					array(),
					RAISENOW_COMMUNITY_VERSION,
					'all'
				);
			}
			wp_enqueue_style( $style );
		}
		
		// js
		$script = RAISENOW_COMMUNITY_PREFIX . '-admin-js';
		if ( ! wp_script_is( $script, 'enqueued' ) ) {
			if ( ! wp_script_is( $script, 'registered' ) ) {
				wp_register_script(
					$script,
					plugins_url( '/js/' . RAISENOW_COMMUNITY_PREFIX . '-admin.js', __FILE__ ),
					array( 'jquery' ),
					RAISENOW_COMMUNITY_VERSION,
					true
				);
			}
			wp_enqueue_script( $script );
		}
	}
	
}

// entry point
new Raisenow_Community_Main();

<?php
/*
Plugin Name: UberMenu Icons | Shared By Themes24x7.com
Plugin URI: http://wpmegamenu.com/icons
Description: Add Font Awesome Icons to your UberMenu menu items
Author: Chris Mavricos, SevenSpark
Author URI: http://sevenspark.com
Version: 3.2.2

/*
Copyright 2011-2015 Chris Mavricos, SevenSpark http://sevenspark.com
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'UberMenu_Icons' ) ) :


final class UberMenu_Icons {
	/** Singleton *************************************************************/

	private static $instance;
	//private $registered_icons;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new UberMenu_Icons;
			self::$instance->setup_constants();
			self::$instance->includes();
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @since 1.0
	 * @access private
	 * @uses plugin_dir_path() To generate plugin path
	 * @uses plugin_dir_url() To generate plugin url
	 */
	private function setup_constants() {
		// Plugin version

		if( ! defined( 'UM_ICONS_VERSION' ) )
			define( 'UM_ICONS_VERSION', '3.2.2' );

		// Plugin Folder URL
		if( ! defined( 'UM_ICONS_PLUGIN_URL' ) )
			define( 'UM_ICONS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Folder Path
		if( ! defined( 'UM_ICONS_PLUGIN_DIR' ) )
			define( 'UM_ICONS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Root File
		if( ! defined( 'UM_ICONS_PLUGIN_FILE' ) )
			define( 'UM_ICONS_PLUGIN_FILE', __FILE__ );
	}

	private function includes() {
		
		require_once UM_ICONS_PLUGIN_DIR . 'includes/functions.php';
		require_once UM_ICONS_PLUGIN_DIR . 'includes/custom-styles.php';
		require_once UM_ICONS_PLUGIN_DIR . 'includes/layouts.php';

		require_once UM_ICONS_PLUGIN_DIR . 'admin/settings.control-panel.php';
		require_once UM_ICONS_PLUGIN_DIR . 'admin/settings.menu-items.php';
		
	}

	/*
	public function register_icons( $group , $iconmap ){
		if( !is_array( $this->registered_icons ) ) $this->registered_icons = array();
		$this->registered_icons[$group] = $iconmap;
	}
	public function degister_icons( $group ){
		if( is_array( $this->registered_icons ) && isset( $this->registered_icons[$group] ) ){
			unset( $this->registered_icons[$group] );
		}
	}
	public function get_registered_icons(){ //$group = '' ){
		return $this->registered_icons;
	}
	*/

}

endif; // End if class_exists check



function UM_ICONS() {
	return UberMenu_Icons::instance();
}


//function umicons_load(){
UM_ICONS();
//}
//add_action( 'uberMenu_load_dependents' , 'umicons_load' );


//Let the user know they need to install UberMenu if they haven't already
add_action( 'plugins_loaded' , 'umicons_ubercheck' , 20 );
function umicons_ubercheck(){
	if( !function_exists( 'ubermenu' ) ) add_action( 'admin_notices', 'umicons_admin_notice' );
}
function umicons_admin_notice() {
    ?><div class="error">
        <p><?php _e( '<strong>UberMenu Icons</strong> is an Extension and requires the UberMenu 3 plugin to function.  Please install and activate <a href="http://wpmegamenu.com">UberMenu 3</a> to use this extension.', 'ubermenu' ); ?></p>
    </div><?php
}



function ubermenu_icons_install() {
	if( function_exists( 'ubermenu_reset_generated_styles' ) ){
		ubermenu_reset_generated_styles();
	}
}
//register_activation_hook( __FILE__, 'ubermenu_icons_install' );

function ubermenu_icons_uninstall() {
	if( function_exists( 'ubermenu_reset_generated_styles' ) ){
		ubermenu_reset_generated_styles();
	}
}
register_deactivation_hook( __FILE__, 'ubermenu_icons_uninstall' );

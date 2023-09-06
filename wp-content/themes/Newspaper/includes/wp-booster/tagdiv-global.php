<?php

/**
 * Theme globals class
 * Here we store the global state of the theme. All globals are here
 */
class tagdiv_global {

	/**
	 * theme plugins
	 * 'PLUGIN_CONSTANT' => 'hash'
	 * @var array
	 */
	private static $td_plugins = array(
		'TD_COMPOSER'       => array( 'version' => 'e12b81d6cbdf467845997a891495df2cx',         'class' => 'tdc_version_check' ),
		'TD_CLOUD_LIBRARY'  => array( 'version' => '0390de2d4222fae8efaeae107c326a4e',    'class' => 'tdb_version_check' ),
		'TD_SOCIAL_COUNTER' => array( 'version' => '69461ef4fcdea0e5d77e02cb42a6183c',   'class' => 'td_social_counter_plugin' ),
		'TD_NEWSLETTER'     => array( 'version' => '43a7dccf4180c2935d794aa8d279e96b',       'class' => 'td_newsletter_version_check' ),
		'TD_SUBSCRIPTION'   => array( 'version' => '___td-subscription___',     'class' => 'tds_version_check' ),
		'TD_MOBILE_PLUGIN'  => array( 'version' => 'b898cb45729c11d2659726d5aea24644',    'class' => 'td_mobile_theme' ),
		'AMP'               => array( 'version' => '___amp___',                 'class' => 'AMP_Autoloader' ),
		'TD_STANDARD_PACK'  => array( 'version' => 'ea43e379b839e31c21a92e9daeba4b6d',    'class' => 'tdsp_version_check' ),
		'TD_WOO'            => array( 'version' => '49c6c0bef9252eb194c60274eed64914',              'class' => 'td_woo_version_check' )
	);


	/**
	 * Get the $td_plugins hashes array
	 * @return array
	 */
	static function get_td_plugins() {
		return self::$td_plugins;
	}

	/**
	 * set below with either http or https string
	 * @var string
	 */
    static $http_or_https = 'http';

	/**
	 * Determines if SSL is used and sets the $http_or_https global
	 */
    static function set_http_or_https() {
	    if ( is_ssl() ) {
		    self::$http_or_https = 'https';
	    }
    }

	/**
	 * the plugins that are installable via the theme > plugins panel & tgma
	 * @var array
	 */
    static $theme_plugins_list = array();

	/**
	 * the plugins that are just for information proposes
	 * @var array
	 */
	static $theme_plugins_for_info_list = array();


    /**
     * the js files that are used in wp-admin
     * @var array
     *
     * @todo check what js files are needed for wp admin
     */
    static $js_files_for_wp_admin = array (
        'td_wp_admin'     => '/includes/wp-booster/wp-admin/js/td_wp_admin.js',
        'td_edit_page'    => '/includes/wp-booster/wp-admin/js/td_edit_page.js',
        'td_page_options' => '/includes/wp-booster/wp-admin/js/td_page_options.js',
        'td_tooltip'      => '/includes/wp-booster/wp-admin/js/tooltip.js',
	    'td_confirm'      => '/includes/wp-booster/wp-admin/js/tdConfirm.js',
    );

}

/**
 * set http or https
 */
tagdiv_global::set_http_or_https();



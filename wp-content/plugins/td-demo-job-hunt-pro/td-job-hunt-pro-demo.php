<?php
/*
Plugin Name: Job Hunt PRO Plugin
Plugin URI: http://tagdiv.com
Description: tagDiv plugin for demos with custom post types & taxonomies
Author: tagDiv
Version: 1.0.0
Author URI: http://tagdiv.com
*/

defined( 'ABSPATH' ) || exit;

add_action( 'tdc_init', function() {
	new td_job_hunt_pro_demo_plugin();
}, 11 );

class td_job_hunt_pro_demo_plugin {

	var $plugin_url = '';
	var $plugin_path = '';

	public function __construct() {

		$this->plugin_url = plugins_url(__FILE__ );
		$this->plugin_path = dirname(__FILE__ );

		/**
		 * ACF
		 */

		// this will allow custom fields meta box on posts when the acf plugin is active
		add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );

		// add local acf fields
		add_action( 'init', array( $this, 'acf_add_local_field_groups' ) );

		// export acf fields: (via json sync)
		add_filter( 'acf/settings/save_json', array( $this, 'set_acf_json_save_folder' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'add_acf_json_load_folder' ) );

		// sync json acf-json fields @see td-demo/includes/acf-json
		add_action( 'admin_init', array( $this, 'sync_acf_fields' ) );

		/**
		 * CPT UI
		 */
		add_action( 'after_setup_theme',  function () {

            // we need priority 9, to avoid invalid tax error
			add_action( 'init', array( $this, 'cptui_register_my_cpts' ), 9 );
			add_action( 'init', array( $this, 'cptui_register_my_taxes' ), 9 );

		});

	}

	public function set_acf_json_save_folder( $path ) {
		return $this->plugin_path . '/includes/acf-json';
	}

	public function add_acf_json_load_folder( $paths ) {
		unset( $paths[0] );

		$paths[] = $this->plugin_path . '/includes/acf-json';

		return $paths;
	}

	public function acf_add_local_field_groups() {

		/*
		 * ACF > Export Field Groups - Generated PHP goes here
		 */

	}

	public function sync_acf_fields() {

		if( ! function_exists('acf_get_field_groups' ) )
			return;

		$groups = acf_get_field_groups();
		$sync = array();

		// return here if no field groups
		if( empty( $groups ) )
			return;

		// find json field groups which have not yet been imported
		foreach( $groups as $group ) {
			$local    = acf_maybe_get( $group, 'local', false );
			$modified = acf_maybe_get( $group, 'modified', 0 );
			$private  = acf_maybe_get( $group, 'private', false );

			// ignore db/php/private field groups
			if( $local !== 'json' || $private ) {
				// do nothing
				continue;
			// append to sync if not yet in database
			} elseif( ! $group['ID'] ) {
				$sync[ $group['key'] ] = $group;
			// append to sync if "json" modified time is newer than database
			} elseif( $modified && $modified > get_post_modified_time( 'U', true, $group['ID'], true ) ) {
				$sync[ $group['key'] ]  = $group;
			}
		}

		// return here if no sync needed
		if( empty( $sync ) )
			return;

		foreach( $sync as $key => $v ) {

			// append fields
			if( acf_have_local_fields( $key ) ) {
				$sync[$key]['fields'] = acf_get_local_fields( $key );
			}

			// import
			$field_group = acf_import_field_group( $sync[$key] );

		}

	}

	// register cptui post types
	function cptui_register_my_cpts() {

        /**
         * Post Type: Jobs
         */
        register_post_type( "tdcpt_jobs", array(
            "label" => esc_html__( "Jobs", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Jobs", "newspaper" ),
                "singular_name" => esc_html__( "Job", "newspaper" ),
            ),
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "tdcpt_jobs", "with_front" => true ],
            "query_var" => true,
            "menu_position" => 6,
            "menu_icon" => "dashicons-list-view",
            "supports" => [ "title", "editor", "thumbnail", "custom-fields", "author" ],
            "show_in_graphql" => false,
        ) );

        /**
         * Post Type: Job applications
         */
        register_post_type( "tdcpt_job_apps", array(
            "label" => esc_html__( "Job applications", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Job applications", "newspaper" ),
                "singular_name" => esc_html__( "Job application", "newspaper" ),
            ),
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "tdcpt_job_apps", "with_front" => true ],
            "query_var" => true,
            "menu_position" => 7,
            "menu_icon" => "dashicons-edit-page",
            "supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
            "show_in_graphql" => false,
        ) );

        /**
         * Post Type: Companies
         */
        register_post_type( "tdcpt_companies", array(
            "label" => esc_html__( "Companies", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Companies", "newspaper" ),
                "singular_name" => esc_html__( "Company", "newspaper" ),
            ),
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "tdcpt_companies", "with_front" => true ],
            "query_var" => true,
            "menu_position" => 8,
            "menu_icon" => "dashicons-groups",
            "supports" => [ "title", "editor", "thumbnail", "custom-fields", "author" ],
            "show_in_graphql" => false,
        ) );

	}

	// register cptui taxonomies
	function cptui_register_my_taxes() {

        /**
         * Taxonomy: Jobs - Salaries
         */
        register_taxonomy( "tdtax_job_salaries", [ "tdcpt_jobs" ], array(
            "label" => esc_html__( "Salaries", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Salaries", "newspaper" ),
                "singular_name" => esc_html__( "Salary", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_job_salaries', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_job_salaries",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Jobs - Types of work
         */
        register_taxonomy( "tdtax_job_work_types", [ "tdcpt_jobs" ], array(
            "label" => esc_html__( "Types of work", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Types of work", "newspaper" ),
                "singular_name" => esc_html__( "Type of work", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_job_work_types', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_job_work_types",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Jobs - Skills
         */
        register_taxonomy( "tdtax_job_skills", [ "tdcpt_jobs" ], array(
            "label" => esc_html__( "Skills", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Skills", "newspaper" ),
                "singular_name" => esc_html__( "Skill", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_job_skills', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_job_skills",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Jobs - Benefits
         */
        register_taxonomy( "tdtax_job_benefits", [ "tdcpt_jobs" ], array(
            "label" => esc_html__( "Benefits", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Benefits", "newspaper" ),
                "singular_name" => esc_html__( "Benefit", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_job_benefits', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_job_benefits",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Jobs - Categories
         */
        register_taxonomy( "tdtax_job_categories", [ "tdcpt_jobs" ], array(
            "label" => esc_html__( "Categories", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Categories", "newspaper" ),
                "singular_name" => esc_html__( "Category", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_job_categories', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_job_categories",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );


        /**
         * Taxonomy: Companies - Markets
         */
        register_taxonomy( "tdtax_company_markets", [ "tdcpt_companies" ], array(
            "label" => esc_html__( "Markets", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Markets", "newspaper" ),
                "singular_name" => esc_html__( "Market", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_company_markets', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_company_markets",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Companies - Countries
         */
        register_taxonomy( "tdtax_company_countries", [ "tdcpt_companies" ], array(
            "label" => esc_html__( "Countries", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Countries", "newspaper" ),
                "singular_name" => esc_html__( "Country", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_company_countries', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_company_countries",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Companies - Technologies
         */
        register_taxonomy( "tdtax_company_technologies", [ "tdcpt_companies" ], array(
            "label" => esc_html__( "Technologies", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Technologies", "newspaper" ),
                "singular_name" => esc_html__( "Technology", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_company_technologies', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_company_technologies",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

        /**
         * Taxonomy: Companies - Benefits
         */
        register_taxonomy( "tdtax_company_benefits", [ "tdcpt_companies" ], array(
            "label" => esc_html__( "Benefits", "newspaper" ),
            "labels" => array(
                "name" => esc_html__( "Benefits", "newspaper" ),
                "singular_name" => esc_html__( "Benefit", "newspaper" ),
            ),
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => [ 'slug' => 'tdtax_company_benefits', 'with_front' => true, ],
            "show_admin_column" => false,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "tdtax_company_benefits",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ) );

	}
}

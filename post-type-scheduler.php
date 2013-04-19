<?php
/*
Plugin Name: Post Type Scheduler
Plugin URI: http://eternalsword.com/post-type-scheduler
Description: Schedule periods in which any published post type content is active.
Version: 1.0
Author: Micah Bucy
Author URI: http://eternalsword.com
Author Email: micah.bucy@eternalsword.com
License:

  Developed from Wordpress Plugin Boilerplate by Tom McFarlin <http://github.com/tommcfarlin/WordPress-Plugin-Boilerplate>

  Copyright 2013 Micah Bucy (micah.bucy@eternalsword.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class PostTypeScheduler {
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		// Register admin styles and scripts and limit the scope
		add_action( 'admin_print_styles-post.php', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_print_scripts-post.php', array( $this, 'register_admin_scripts' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'register_admin_scripts' ) );

		// Core plugin actions and filters
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
	} // end constructor
	
	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
		$domain = 'post-type-scheduler';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		wp_enqueue_style('post-type-scheduler-admin-styles', plugins_url('post-type-scheduler/css/admin.css'), array(), '1366319853');	
		wp_enqueue_style('jquery-ui', plugins_url('post-type-scheduler/css/jquery-ui/jquery-ui-1.10.2.custom.min.css'));
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
		wp_enqueue_script('jquery-ui','https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.8/jquery-ui.min.js');
		wp_enqueue_script('json2', plugins_url('post-type-scheduler/js/json2.min.js'), array(), '1366391097');
		wp_enqueue_script('post-type-scheduler-admin-script', plugins_url('post-type-scheduler/js/admin.js'), array('jquery-ui', 'json2'), '1366399308');
	} // end register_admin_scripts
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	 function register_meta_boxes() {
		 $post_types = get_post_types(array('show_ui' => true), 'objects');
		 foreach($post_types as $post_type) {
			 add_meta_box(
				 $post_type->name."-schedule",
				 $post_type->labels->singular_name.__(" Schedule", "post-type-scheduler"),
				 array($this, 'show_schedule_box'),
				 $post_type->name,
				 'normal',
				 'high'
			 );
		 }
	 } // end register_meta_boxes

	 function show_schedule_box() {
		 include_once('views/post-schedule-metabox.php');
	 } // end show_schedule_box
} // end class

$post_type_scheduler = new PostTypeScheduler();

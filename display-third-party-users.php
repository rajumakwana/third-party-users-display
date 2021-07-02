<?php
/**
 * @package Display Third Party Users
 */
/*
Plugin Name: Display Third Party Users
Plugin URI: https://www.drcsystems.com/wordpress-development
Description: Display Third Party Users is quite possibly the best way in the world to <strong>display user from third party api</strong>.
Version: 1.0.0
Author: DRC Systems
Author URI: https://www.drcsystems.com/
License: GPLv2 or later
Text Domain: thirdpartyusers
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists('add_action') ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'THIRDPARTYUSERS_VERSION', '1.0.0' );
define( 'THIRDPARTYUSERS_MINIMUM_WP_VERSION', '5.7' );
define( 'THIRDPARTYUSERS_MINIMUM_PHP_VERSION', '5.6' );

define( 'THIRDPARTYUSERS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'THIRDPARTYUSERS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'THIRDPARTYUSERS_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
define( 'THIRDPARTYUSERS_PLUGIN_FILE', basename( __FILE__ ) );
define( 'THIRDPARTYUSERS_PLUGIN_FULL_PATH', __FILE__ );


require_once( THIRDPARTYUSERS_PLUGIN_DIR .'includes/loader.php' );

// check PHP version
$exit_msg = 'User Role Editor requires PHP '. THIRDPARTYUSERS_MINIMUM_PHP_VERSION .' or newer. '. 
            '<a href="http://wordpress.org/about/requirements/">Please update!</a>';
ThirdPartyUsers::check_version( PHP_VERSION, THIRDPARTYUSERS_MINIMUM_PHP_VERSION, $exit_msg, __FILE__ );

// check WP version
$exit_msg = 'User Role Editor requires WordPress '. THIRDPARTYUSERS_MINIMUM_WP_VERSION .' or newer. '. 
            '<a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
ThirdPartyUsers::check_version( get_bloginfo( 'version' ), THIRDPARTYUSERS_MINIMUM_WP_VERSION, $exit_msg, __FILE__ );

// Uninstall action
register_uninstall_hook( THIRDPARTYUSERS_PLUGIN_FULL_PATH, array('ThirdPartyUsers', 'uninstall') );

$GLOBALS['thirt_party_users'] = ThirdPartyUsers::get_instance();
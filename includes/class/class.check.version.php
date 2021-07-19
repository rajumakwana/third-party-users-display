<?php

class CheckVersion {
	
    /**
     * Check product version and stop execution if product version is not compatible
     * @param string $version1
     * @param string $version2
     * @param string $error_message
     * @return void
     */
    public static function check_version($version1, $version2, $error_message, $plugin_file_name) {

        if (version_compare($version1, $version2, '<')) {

            if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX )) {

                require_once ABSPATH . '/wp-admin/includes/plugin.php';
                
                deactivate_plugins($plugin_file_name);
                
                wp_die($error_message);

            } else {

                return;

            }

        }

    }
    // end of check_version()

}
//new CheckVersion;
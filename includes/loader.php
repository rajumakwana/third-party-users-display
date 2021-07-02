<?php
/**
 * Project: Display Third Party Users
 * Load related files
 *  
 * Author: DRC Systems
 * email: tanvir.mansuri@drcsystems.com
 *
**/

if( file_exists( THIRDPARTYUSERS_PLUGIN_DIR .'lib/autoload.php' ) ) {

    require_once( THIRDPARTYUSERS_PLUGIN_DIR .'lib/autoload.php'); // <- change happening here
    
}

require_once( THIRDPARTYUSERS_PLUGIN_DIR .'includes/define-constants.php' );
require_once( THIRDPARTYUSERS_PLUGIN_DIR .'includes/class/class.third.party.users.php' );
require_once( THIRDPARTYUSERS_PLUGIN_DIR .'includes/class/class.third.party.users.settings.php' );
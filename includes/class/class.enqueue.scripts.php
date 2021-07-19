<?php

class EnqueueScripts {
	
    /**
     * class constructor
     * 
     */
    public function __construct() {

        add_action( 'wp_enqueue_scripts', array( $this, 'wpdtpu_load_plugin_js' ) );

    }
    // end of __construct()

    /**
     * wp_enqueue_scripts hook, Enqueue scripts and styles for plugin
     * 
     * @return void
     */
    public function wpdtpu_load_plugin_js() {
        
        wp_register_style('wpdtpu-datatables', THIRDPARTYUSERS_PLUGIN_URL . 'includes/css/datatables.min.css' );
        wp_register_style('wpdtpu-bootstrap', THIRDPARTYUSERS_PLUGIN_URL . 'includes/css/bootstrap.min.css' );
        wp_register_style('wpdtpu-datatables-bootstrap-responsive', THIRDPARTYUSERS_PLUGIN_URL . 'includes/css/responsive.bootstrap.min.css' );
        wp_register_style('wpdtpu-style', THIRDPARTYUSERS_PLUGIN_URL. 'includes/css/wpdtpu-style.css' );     

        wp_register_script( 'wpdtpu-jquery', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/jquery-3.6.0.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-datatables', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/jquery.dataTables.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-datatables-responsive', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/dataTables.responsive.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-bootstrap', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/bootstrap.bundle.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-datatables-bootstrap-responsive', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/responsive.bootstrap.min.js', array(), THIRDPARTYUSERS_VERSION, true );
        
        if( get_query_var( 'wpdtpu', false ) !== false ) {
            
            wp_enqueue_style( 'wpdtpu-datatables' );
            wp_enqueue_style( 'wpdtpu-bootstrap' );
            wp_enqueue_style( 'wpdtpu-datatables-bootstrap-responsive' );
            wp_enqueue_style( 'wpdtpu-style' );

            wp_enqueue_script( 'wpdtpu-jquery' );
            wp_enqueue_script( 'wpdtpu-datatables' );
            wp_enqueue_script( 'wpdtpu-datatables-responsive' );
            wp_enqueue_script( 'wpdtpu-bootstrap' );
            wp_enqueue_script( 'wpdtpu-datatables-bootstrap-responsive' );

        }

    }
    // end of wpdtpu_load_plugin_js()

}
//new CheckVersion;
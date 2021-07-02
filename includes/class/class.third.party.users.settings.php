<?php

class ThirdPartyUsersSettings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    protected $wpdtpu_endpoint;
    protected $wpdtpu_users_list;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->wpdtpu_endpoint = 'third-party-users';
        $this->wpdtpu_users_list = 'https://jsonplaceholder.typicode.com/users';
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Third Party Users',
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>Third Party Users Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'wpdtpu_setting_section_endpoint', // ID
            'Endpoint Setting', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'endpoint_slug', 
            'Endpoint Slug', 
            array( $this, 'wpdtpu_endpoint_callback' ), 
            'my-setting-admin', 
            'wpdtpu_setting_section_endpoint'
        );

        add_settings_section(
            'wpdtpu_setting_section_api', // ID
            'Third Party API', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'users_list_api', 
            'Users List API', 
            array( $this, 'wpdtpu_users_list_callback' ), 
            'my-setting-admin', 
            'wpdtpu_setting_section_api'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['wpdtpu_endpoint'] ) )
            $new_input['wpdtpu_endpoint'] = sanitize_text_field( $input['wpdtpu_endpoint'] );

        if( isset( $input['wpdtpu_users_list'] ) )
            $new_input['wpdtpu_users_list'] = sanitize_text_field( $input['wpdtpu_users_list'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        //print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function wpdtpu_endpoint_callback()
    {
        printf(
            '<input type="text" id="wpdtpu_endpoint" name="my_option_name[wpdtpu_endpoint]" value="%s" />',
            isset( $this->options['wpdtpu_endpoint'] ) ? esc_attr( $this->options['wpdtpu_endpoint']) : $this->wpdtpu_endpoint
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function wpdtpu_users_list_callback()
    {
        printf(
            '<input type="text" id="wpdtpu_users_list" name="my_option_name[wpdtpu_users_list]" value="%s" />',
            isset( $this->options['wpdtpu_users_list'] ) ? esc_attr( $this->options['wpdtpu_users_list']) : $this->wpdtpu_users_list
        );
    }
}

if( is_admin() ) {
    new ThirdPartyUsersSettings();
}
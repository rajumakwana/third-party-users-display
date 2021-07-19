<?php
final class ThirdPartyUsers extends EnqueueScripts {

    protected static $instance = null; // object exemplar reference  
	
    protected $dataTableClassObj;

    /**
     * class constructor
     * 
     */
    public function __construct() {
        
        parent::__construct();

        
        if( class_exists(DatatableScripts::class) ){
            $this->dataTableClassObj =  new DatatableScripts();
        }
		register_activation_hook( THIRDPARTYUSERS_PLUGIN_FULL_PATH, array( $this, 'activate' ) );

        add_action( 'init', array( $this, 'wpdtpu_rewrite' ) );
		add_filter( 'query_vars', array( $this, 'wpdtpu_query_vars' ) );
		add_action( 'template_include', array( $this, 'wpdtpu_change_template' ) );
        //add_action( 'wp_footer', array( $this, 'wpdtpu_load_datatable' ), 99 );

    }
    // end of __construct()

    public function getDataTableObj() {

        return $this->dataTableClassObj;
    }
    
    /**
     * funcrion get_instance to create instance of the class
     * 
     * @return object
     */
    public static function get_instance() {
        if ( self::$instance===null ) {
            self::$instance = new ThirdPartyUsers();
        }
        
        return self::$instance;
    }
    // end of get_instance()

    
    /**
     * Execute after the plugin activation
     * 
     * @return void
     */
	public static function activate() {
        set_transient( 'vpt_flush', 1, 60 );
    }
    // end of activate()

    
    /**
     * init hook, Add custom endpoints
     * 
     * @return void
     */
	public function wpdtpu_rewrite() {

        $getEndpoint = get_option( 'my_option_name' );

        $endpoint = ( isset( $getEndpoint['wpdtpu_endpoint'] ) && !empty( $getEndpoint['wpdtpu_endpoint'] ) ) ? $getEndpoint['wpdtpu_endpoint'] : 'third-party-users';

		add_rewrite_rule( '^'.$endpoint.'$', 'index.php?wpdtpu=1', 'top' );

        flush_rewrite_rules();

		if(get_transient( 'vpt_flush' )) {

			delete_transient( 'vpt_flush' );

			flush_rewrite_rules();

		}

    }
    // end of wpdtpu_rewrite()

    
    /**
     * query_vars hook, Add custom query variables
     * 
     * @return array
     */
    public function wpdtpu_query_vars($vars) {

		$vars[] = 'wpdtpu';

		return $vars;

	}
    // end of wpdtpu_query_vars()

    
    /**
     * template_include hook, Set template for display users
     * @param string $template
     * 
     * @return string
     */
	public function wpdtpu_change_template( $template ) {

		if( get_query_var( 'wpdtpu', false ) !== false ) {

            //Check plugin directory next
			$newTemplate = locate_template( array( 'template-wpdtpu.php' ) );

			if( '' != $newTemplate )
				return $newTemplate;

			//Check plugin directory next
			$newTemplate = THIRDPARTYUSERS_PLUGIN_DIR . 'includes/templates/template-wpdtpu.php';

			if( file_exists( $newTemplate ) )
				return $newTemplate;

		}

		//Fall back to original template
		return $template;

	}
    // end of wpdtpu_change_template()

    /**
     * excute on plugin uninstall via WordPress->Plugins->Delete
     * 
     * @return void
     */
    public static function uninstall() {
        
    }
    // end of uninstall()
}
//new ThirdPartyUsers;
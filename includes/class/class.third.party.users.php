<?php

class ThirdPartyUsers {

    protected static $instance = null; // object exemplar reference  

    protected static $columns = ['id','name','username']; // Default columns  
	
    /**
     * class constructor
     * 
     */
    public function __construct() {

		register_activation_hook( THIRDPARTYUSERS_PLUGIN_FULL_PATH, array( $this, 'activate' ) );

        add_action( 'init', array( $this, 'wpdtpu_rewrite' ) );
		add_filter( 'query_vars', array( $this, 'wpdtpu_query_vars' ) );
		add_action( 'template_include', array( $this, 'wpdtpu_change_template' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'wpdtpu_load_plugin_js' ) );

        add_action( 'wp_footer', array( $this, 'wpdtpu_load_datatable' ), 99 );

    }
    // end of __construct()
    
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

        wp_enqueue_style( 'wpdtpu-datatables' );
        wp_enqueue_style( 'wpdtpu-bootstrap' );
        wp_enqueue_style( 'wpdtpu-datatables-bootstrap-responsive' );
        wp_enqueue_style( 'wpdtpu-style' );

        wp_register_script( 'wpdtpu-jquery', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/jquery-3.6.0.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-datatables', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/jquery.dataTables.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-datatables-responsive', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/dataTables.responsive.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-bootstrap', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/bootstrap.bundle.min.js', array(), THIRDPARTYUSERS_VERSION, true );
		wp_register_script('wpdtpu-datatables-bootstrap-responsive', THIRDPARTYUSERS_PLUGIN_URL . 'includes/js/responsive.bootstrap.min.js', array(), THIRDPARTYUSERS_VERSION, true );
        
        wp_enqueue_script( 'wpdtpu-jquery' );
        wp_enqueue_script( 'wpdtpu-datatables' );
        wp_enqueue_script( 'wpdtpu-datatables-responsive' );
        wp_enqueue_script( 'wpdtpu-bootstrap' );
        wp_enqueue_script( 'wpdtpu-datatables-bootstrap-responsive' );

    }
    // end of wpdtpu_load_plugin_js()

    /**
     * Function to return table columns
     * 
     * @return void
     */
    public function wpdtpu_load_datatable_columns() {
        self::$columns = apply_filters( 'wpdtpu_datatable_columns', self::$columns );
        foreach( self::$columns as $k => $v ) {
            echo '<th>'.ucfirst($v).'</th>';
        }
    }
    // end of wpdtpu_load_datatable_columns()
    
    /**
     * wp_footer hook, Add ajax call jquery to display users data from API
     * 
     * @return void
     */
    public function wpdtpu_load_datatable() {

        if( get_query_var( 'wpdtpu', false ) !== false ) {
            
            $getApi = get_option( 'my_option_name' );
            $api = ( isset( $getApi['wpdtpu_users_list'] ) && !empty( $getApi['wpdtpu_users_list'] ) ) ? $getApi['wpdtpu_users_list'] : 'https://jsonplaceholder.typicode.com/users';
        ?>
            <script>
                jQuery(document).ready(function($) {
                    var apiURL = '<?php echo $api ?>';
                    $.fn.dataTable.ext.errMode = 'throw';
                    var jobtable = $('table').DataTable({
                        ajax: {
                            url: apiURL,
                            dataSrc: '',
                            responsive: true,
                            cache: true,
                            error: function (xhr, error, code)
                            {
                                //console.log(error);
                            }
                        },
                        pageLength : 5,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                        columns: [
                            <?php
                                foreach( self::$columns as $k => $v ) {
                                    ?>
                                        {data: '<?php echo $v; ?>'},
                                    <?php
                                }
                            ?>
                        ],
                        columnDefs: [
                            {
                                "render": function (data, type, row) {
                                    return '<a href="javascript:void(0);">' + data + '</a>';
                                },
                                "targets": 0
                            },
                            {
                                "render": function (data, type, row) {
                                    return '<a href="javascript:void(0);">' + data + '</a>';
                                },
                                "targets": 1
                            },
                            {
                                "render": function (data, type, row) {
                                    return '<a href="javascript:void(0);">' + data + '</a>';
                                },
                                "targets": 2
                            }
                        ]
                    });
                    //new $.fn.dataTable.FixedHeader( jobtable );

                    $('table').on( 'click', 'td a', function () {
                        var data = jobtable.row( $(this).parents('tr') ).data();
                        $('table tbody tr').removeClass('selected');
                        $(this).parents('tr').addClass('selected');
                        showUserDetails(data.id);
                    });

                    function showUserDetails(id){
                        $("#wpdtpu-table-user-details").css('filter','blur(3px)');
                        const xhttp = new XMLHttpRequest();
                        xhttp.onload = function() {

                            if(this.responseText){

                                var response = JSON.parse(this.responseText);
                                var prefixID = 'wpdtpu-user-';

                                document.getElementById(prefixID+"id").innerHTML = response.id;
                                document.getElementById(prefixID+"name").innerHTML = response.name;
                                document.getElementById(prefixID+"username").innerHTML = response.username;
                                document.getElementById(prefixID+"email").innerHTML = response.email;
                                document.getElementById(prefixID+"address-street").innerHTML = response.address.street;
                                document.getElementById(prefixID+"address-suite").innerHTML = response.address.suite;
                                document.getElementById(prefixID+"address-city").innerHTML = response.address.city;
                                document.getElementById(prefixID+"address-zipcode").innerHTML = response.address.zipcode;
                                document.getElementById(prefixID+"address-geo-lat").innerHTML = response.address.geo.lat;
                                document.getElementById(prefixID+"address-geo-lng").innerHTML = response.address.geo.lng;

                                //wpdtpu-table-user-details
                                $("#wpdtpu-table-user-details").css('display','block');
                                $("#wpdtpu-table-user-details").css('filter','unset');

                            }
                        }
                        xhttp.open("GET", apiURL+"/"+id, true);
                        xhttp.send();
                    }
                });
            </script>
        <?php
        }
    }
    // end of wpdtpu_load_datatable()


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
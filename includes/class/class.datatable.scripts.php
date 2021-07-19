<?php

final class DatatableScripts {
	
    protected static $columns = ['id','name','username']; // Default columns  

    /**
     * class constructor
     * 
     */
    public function __construct() {

        add_action( 'wp_footer', array( $this, 'wpdtpu_load_datatable' ), 99 );

    }
    // end of __construct()

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

}
//new DatatableScripts;
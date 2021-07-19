<?php
/**
 * The template for displaying third party users
 *
 * @package DRC Systems
 * @subpackage Display Third Party Users
 * @since Display Third Party Users 1.0.0
 */

get_header();
?>
<div class="wpdtpu">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="wpdtpu-inner">
                    <table id="wpdtpu-table" width="100%">
                        <thead>
                            <tr role="row">
                                
                                <?php $GLOBALS['thirt_party_users']->getDataTableObj()->wpdtpu_load_datatable_columns() ?>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div id="wpdtpu-table-user-details" class="" style="display:none;">
                    <ul class=""> <b>User Details</b>
                        <li>ID : <span id="wpdtpu-user-id"></span> </li>
                        <li>Name : <span id="wpdtpu-user-name"></span> </li>
                        <li>Username : <span id="wpdtpu-user-username"></span> </li>
                        <li>Email : <span id="wpdtpu-user-email"></span> </li>
                        
                        <li>Address : </li>
                        <ul class=""> 
                            <li>Street : <span id="wpdtpu-user-address-street"></span> </li>
                            <li>Suite : <span id="wpdtpu-user-address-suite"></span> </li>
                            <li>City : <span id="wpdtpu-user-address-city"></span> </li>
                            <li>Zipcode : <span id="wpdtpu-user-address-zipcode"></span> </li>
                            <li>Geo Location : </li>
                            
                            <ul class=""> 
                                <li>Lattitude : <span id="wpdtpu-user-address-geo-lat"></span> </li>
                                <li>Longitude : <span id="wpdtpu-user-address-geo-lng"></span> </li>
                            </ul>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
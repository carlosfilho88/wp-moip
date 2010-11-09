<?php

require_once('../../../wp-config.php');
require_once('../../../wp-includes/wp-db.php');

if (!defined( 'MN_TABLE' ) )
    define(MN_TABLE, "mn_payments");
    
//Get effective NASP response and save into database
if ($_POST) {
    global $wpdb;
    
    $select = "SELECT cod_moip FROM " . $wpdb->prefix.MN_TABLE
            . " WHERE cod_moip  = '" . $wpdb->escape($_POST['cod_moip']) . "';";
            
    $result = $wpdb->query($wpdb->prepare($select));
                            
    //Get new transaction
    if($result == 0) {
    
    $insert = "INSERT INTO " . $wpdb->prefix.MN_TABLE . 
        " (valor, status_pagamento, cod_moip, forma_pagamento, tipo_pagamento, email_consumidor) 
            VALUES ('"
                          . $wpdb->escape($_POST['valor']). "','"
                          . $wpdb->escape($_POST['status_pagamento']). "','"
                          . $wpdb->escape($_POST['cod_moip']). "','"
                          . $wpdb->escape($_POST['forma_pagamento']). "','"
                          . $wpdb->escape($_POST['tipo_pagamento']). "','"
                          . $wpdb->escape($_POST['email_consumidor'])
                . "');";
                    
    $ok = $wpdb->query($wpdb->prepare($insert));
} else {
    $update = "UPDATE " . $wpdb->prefix.MN_TABLE 
            . " SET status_pagamento = " . $wpdb->escape($_POST['status_pagamento'])
            . " WHERE cod_moip = " . $wpdb->escape($_POST['cod_moip']);
                
    $ok = $wpdb->query($wpdb->prepare($update));
}
    
if($ok){    
    $option_name = 'mn_ajax_reload' ; 
    $newvalue = 'true' ;
      if ( get_option($option_name)  != $newvalue) {
        update_option($option_name, $newvalue);
      } else {
        add_option('mn_ajax_reload', 'true', '', 'no');
      }
    header("HTTP/1.0 200 OK");  // sends response to MOIP 
} else { // if any processing error not expected 
    header("HTTP/1.0 404 Not Found");  // log error and MoIP continues to send posts to your system (7 days, each 15 minutes)
} 

<?php

if (!defined( 'MN_TABLE' ) )
    define(MN_TABLE, "mn_payments");
        
//Install script
function mn_install() {
    global $wpdb;
    $collate = '';
    if($wpdb->supports_collation()) {
            if(!empty($wpdb->charset)) $collate = "DEFAULT CHARACTER SET $wpdb->charset";
            if(!empty($wpdb->collate)) $collate .= " COLLATE $wpdb->collate";
    }
    
    $query="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix.MN_TABLE . "` (
        `id_transacao` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `valor` INT(9) NULL,
        `status_pagamento` INT(2) UNSIGNED NULL,
        `cod_moip` VARCHAR(32) NULL,
        `forma_pagamento` INT(2) UNSIGNED NULL,
        `tipo_pagamento` VARCHAR(32) NULL,
        `email_consumidor` VARCHAR(45) NULL,
        PRIMARY KEY (`id_transacao`)
    ) $collate;";

    $wpdb->query($query);
}

//Unistall script
function mn_uninstall() {
    global $wpdb;
    //Delete any options that's stored also?
    delete_option('mn_check_sandbox');
    delete_option('mn_moip_email');
    delete_option('mn_ajax_reload');
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix.MN_TABLE);
  
}

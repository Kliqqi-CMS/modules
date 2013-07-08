<?php
if(defined('mnminclude')){
    include_once('ldap_settings.php');  // Load in the settings
    
    $include_in_pages = array('login'); // Only include this module on the login script
    $do_not_include_in_pages = array();
    
    if( do_we_load_module() ) {        
        
        module_add_action('tpl_pligg_body_start', 'authenticate_ldap_user', ''); 
         
        include_once(mnmmodules . 'ldap/ldap_main.php'); 

    }
}

?>

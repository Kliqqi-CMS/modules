<?php
    $LDAPDebug = 0;
    
    $LDAPUseLocal = true; 
    
    $LDAPDomainNames = array("YourDomain");
    $LDAPServerNames = array("YourDomain" => "YourServerAddress");
    $LDAPEncryptionType = array("YourDomain" => "clear");
    $LDAPRetrievePrefs = array("YourDomain" => true);
    
    $LDAPSynchUser = array("YourDomain" => true);
    
    $LDAPProxyAgent = array("YourDomain" => "YourProxyAgent");
    $LDAPProxyAgentPassword = array("YourDomain" => "YourProxyAgentPassword");
    
    $LDAPSearchAttributes = array("YourDomain"=>"sAMAccountName");

    $LDAPBaseDNs = array("YourDomain"=>"YourBaseDNs");
    $LDAPUserBaseDNs = array("YourDomain"=>"YourUserBaseDNs");

?>

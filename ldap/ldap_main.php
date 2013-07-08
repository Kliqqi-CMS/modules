<?php
  function authenticate_ldap_user($input) {
    $_SESSION["LDAPDomain"] = "Catholic"; // I'm too lazy to set up the plugin so that it displays a list of valid domains on the login screen
        
    $ldap = new LdapAuthenticationPlugin($input);
  }
  
  class LdapAuthenticationPlugin {
    var $email, $lang, $realname, $nickname, $SearchType;
    var $LDAPUsername;
    var $userLDAPGroups, $foundUserLDAPGroups;
    var $allLDAPGroups;

    function LdapAuthenticationPlugin($input) {
        include_once("ldap_settings.php");
        
        global $LDAPSynchUser;
        
        // Authenticate the user.                    
        $authenticated = $this->authenticate($input["username"], $input["password"]);
        
        if ($authenticated)  {
            $_SESSION["Authenticated"] = true; 

            if (isset($LDAPSynchUser) && $LDAPSynchUser) {
                global $db;

                // Check to see if the user exists in the Pligg DB
                $user=$db->get_row("SELECT user_id FROM " . table_users . " WHERE user_login = '".$input["username"]."'");
                $saltedpass=generateHash($input["password"]);
                
                
                if ($user->user_id > 0) {
                    // User exists in system so update the Pligg DB with the latest email & password for the user
                    mysql_query("UPDATE " . table_users . " SET user_email = '".$this->email."' WHERE user_id = {$user->user_id} LIMIT 1");
                    mysql_query("UPDATE " . table_users . " SET user_pass = '".$saltedpass."' WHERE user_id = {$user->user_id} LIMIT 1");
                } else {
                    // User doesn't exist so dump it into the Pligg DB
                    $username=$db->escape(trim($input["username"]));
                    $userip=$_SERVER['REMOTE_ADDR'];
                    $email=$db->escape(trim($this->email));
    
                    $strsql = "INSERT INTO " . table_users . " (user_login, user_email, user_pass, user_date, user_ip) VALUES ('$username', '$email', '$saltedpass', now(), '$userip')";
                    $db->query($strsql);
                }
            }
        }
    }

    
    /**
    * Everythign below this point is from the wikimedia module created by Ryan Lane
    * See URL: http://www.mediawiki.org/wiki/Extension:LDAP_Authentication
    * 
    */
    
    /**
     * Check whether there exists a user account with the given name.
     * The name will be normalized to MediaWiki's requirements, so
     * you might need to munge it (for instance, for lowercase initial
     * letters).
     *
     * @param string $username
     * @return bool
     * @access public
     */
    function userExists( $username ) {
        global $LDAPAddLDAPUsers;

        $this->printDebug("Entering userExists",1);

        //If we can't add LDAP users, we don't really need to check
        //if the user exists, the authenticate method will do this for
        //us. This will decrease hits to the LDAP server.
        //We do however, need to use this if we are using smartcard authentication.
        if ( (!isset($LDAPAddLDAPUsers[$_SESSION['LDAPDomain']]) || !$LDAPAddLDAPUsers[$_SESSION['LDAPDomain']]) && !$this->useSmartcardAuth()) {
            return true;
        }

        $ldapconn = $this->connect();
        if ($ldapconn) {
            $this->printDebug("Successfully connected",1);
            $searchstring = $this->getSearchString($ldapconn,$username);

            //If we are using smartcard authentication, and we got
            //anything back, then the user exists.
            if ($this->useSmartcardAuth() && $searchstring != '') {
                //getSearchString is going to bind, but will not unbind
                //Let's clean up
                @ldap_unbind();
                return true;
            }

            //Search for the entry.
            $entry = @ldap_read($ldapconn, $searchstring, "objectclass=*");

            //getSearchString is going to bind, but will not unbind
            //Let's clean up
            @ldap_unbind();
            if (!$entry) {
                $this->printDebug("Did not find a matching user in LDAP",1);
                //user wasn't found
                return false;
            } else {
                $this->printDebug("Found a matching user in LDAP",1);
                return true;
            }
        } else {
            $this->printDebug("Failed to connect",1);
            return false;
        }
        
    }

    /**
     * Connect to LDAP
     *
     * @return resource
     * @access private
     */
    function connect() {
        global $LDAPServerNames;
        global $LDAPEncryptionType;
        
        $this->printDebug("Entering Connect",1);

        //If the user didn't set an encryption type, we default to tls
        if ( isset($LDAPEncryptionType[$_SESSION["LDAPDomain"]]) ) {
            $encryptionType = $LDAPEncryptionType[$_SESSION["LDAPDomain"]];
        } else {
            $encryptionType = "tls";
        }

        //Set the server string depending on whether we use ssl or not
        switch($encryptionType) {
            case "ssl":
                $this->printDebug("Using SSL",2);
                $serverpre = "ldaps://";
                break;
            default:
                $this->printDebug("Using TLS or not using encryption.",2);
                $serverpre = "ldap://";
        }

        //Make a space seperated list of server strings with the ldap:// or ldaps://
        //string added.
        $servers = "";
        $tmpservers = $LDAPServerNames[$_SESSION['LDAPDomain']];
        $tok = strtok($tmpservers, " ");
        while ($tok) {
            $servers = $servers . " " . $serverpre . $tok;
            $tok = strtok(" ");
        }
        $servers = rtrim($servers);

        $this->printDebug("Using servers: $servers",2);

        //Connect and set options
        $ldapconn = @ldap_connect( $servers );
        ldap_set_option( $ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option( $ldapconn, LDAP_OPT_REFERRALS, 0);

        //TLS needs to be started after the connection is made
        if ( $encryptionType == "tls" ) {
            $this->printDebug("Using TLS",2);
            if ( !ldap_start_tls( $ldapconn ) ) {
                $this->printDebug("Failed to start TLS.",2);
                return;
            }
        }

        return $ldapconn;
    }

    /**
     * Check if a username+password pair is a valid login, or if the username
     * is allowed access to the site.
     * The name will be normalized to Pligg's requirements, so
     * you might need to munge it (for instance, for lowercase initial
     * letters).
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @access public
     */
    function authenticate( $username, $password='' ) {
        global $LDAPRetrievePrefs;

        $this->printDebug("Entering authenticate", 1);

        //If the user is using smartcard authentication, we need to ensure
        //that he/she isn't trying to fool us by sending a username other
        //than the one the web server got from the smartcard.
        if ( $this->useSmartcardAuth() && $LDAPSSLUsername != $username ) {
            $this->printDebug("The username provided doesn't match the username on the smartcard. The user is probably trying to log in to the smartcard domain with password authentication. Denying access.",2);
            return false;
        }

        //We need to ensure that if we require a password, that it is
        //not blank. We don't allow blank passwords, so we are being
        //tricked if someone is supplying one when using password auth.
        //Smartcard authentication uses a pin, and does not require
        //a password to be given; a blank password here is wanted.
        if ( '' == $password && !$this->useSmartcardAuth() ) {
            $this->printDebug("User used a blank password",1);
            return false;
        }

        $ldapconn = $this->connect();
        if ( $ldapconn ) {
            $this->printDebug("Connected successfully",1);

            //Mediawiki munges the username before authenticate is called,
            //this can mess with authentication, group pulling/restriction,
            //preference pulling, etc. Let's allow the user to use
            //a lowercased username.
            if ( isset($LDAPLowerCaseUsername[$_SESSION['LDAPDomain']]) && $LDAPLowerCaseUsername[$_SESSION['LDAPDomain']] ) {
                $username = strtolower($username);
                $this->printDebug("Lowercasing the username: $username",1);
            }

            $userdn = $this->getSearchString($ldapconn, $username);

            //It is possible that getSearchString will return an
            //empty string; if this happens, the bind will ALWAYS
            //return true, and will let anyone in!
            if ('' == $userdn) {
                $this->printDebug("User DN is blank",1);
                // Lets clean up.
                @ldap_unbind();
                return false;
            }

            //If we are using password authentication, we need to bind as the
            //user to make sure the password is correct.
            if ( !$this->useSmartcardAuth() ) {
                $this->printDebug("Binding as the user",1);

                //Let's see if the user can authenticate.
                $bind = $this->bindAs($ldapconn, $userdn, $password);
                if (!$bind) {
                    // Lets clean up.
                    @ldap_unbind();
                    return false;
                }
                $this->printDebug("Binded successfully",1);

                if ( isset( $LDAPSearchStrings[$_SESSION['LDAPDomain']] ) ) { 
                    $ss = $LDAPSearchStrings[$_SESSION['LDAPDomain']];
                    if ( strstr( $ss, "@" ) || strstr( $ss, '\\' ) ) {
                        //We are most likely configured using USER-NAME@DOMAIN, or
                        //DOMAIN\\USER-NAME.
                        //Get the user's full DN so we can search for groups and such.
                        $userdn = $this->getUserDN($ldapconn, $username);
                        $this->printDebug("Pulled the user's DN: $userdn",1);
                    }
                }

                if ( (isset($LDAPRequireAuthAttribute[$_SESSION['LDAPDomain']]) && $LDAPRequireAuthAttribute[$_SESSION['LDAPDomain']]) ) {
                    $this->printDebug("Checking for auth attributes",1);
                    $filter = "(" . $LDAPAuthAttribute[$_SESSION['LDAPDomain']] . ")";
                    $attributes = array("dn");
                    $entry = ldap_read($ldapconn, $userdn, $filter, $attributes);
                    $info = ldap_get_entries($ldapconn, $entry);
                    if ($info["count"] < 1) {
                        $this->printDebug("Failed auth attribute check",1);
                        // Lets clean up.
                        @ldap_unbind();
                        return false;
                    }
                }
            }

            //Old style groups, non-nestable and fairly limited on group type (full DN
            //versus username). DEPRECATED
            if ($LDAPGroupDN) {
                $this->printDebug("Checking for (old style) group membership",1);
                if (!$this->isMemberOfLdapGroup($ldapconn, $userdn, $LDAPGroupDN)) {
                    $this->printDebug("Failed (old style) group membership check",1);

                    //No point in going on if the user isn't in the required group
                    // Lets clean up.
                    @ldap_unbind();
                    return false;
                }
            }

            //New style group checking
            if ( isset($LDAPRequiredGroups[$_SESSION['LDAPDomain']]) ) {
                $this->printDebug("Checking for (new style) group membership",1);

                if ( isset($LDAPGroupUseFullDN[$_SESSION['LDAPDomain']]) && $LDAPGroupUseFullDN[$_SESSION['LDAPDomain']] ) {
                    $inGroup = $this->isMemberOfRequiredLdapGroup($ldapconn, $userdn);
                } else {
                    if ( (isset($LDAPGroupUseRetrievedUsername[$_SESSION['LDAPDomain']]) && $LDAPGroupUseRetrievedUsername[$_SESSION['LDAPDomain']])
                        && $this->LDAPUsername != '' ) {
                        $this->printDebug("Using the username retrieved from the user's entry.",1);
                        $inGroup = $this->isMemberOfRequiredLdapGroup($ldapconn, $this->LDAPUsername);
                    } else {
                        $inGroup = $this->isMemberOfRequiredLdapGroup($ldapconn, $username);
                    }
                }

                if (!$inGroup) {
                    // Lets clean up.
                    @ldap_unbind();
                    return false;
                }

            }

            //Synch LDAP groups with MediaWiki groups
            if ( isset($LDAPUseLDAPGroups[$_SESSION['LDAPDomain']]) && $LDAPUseLDAPGroups[$_SESSION['LDAPDomain']] ) {
                $this->printDebug("Retrieving LDAP group membership",1);

                //Let's get the user's LDAP groups
                if ( isset($LDAPGroupUseFullDN[$_SESSION['LDAPDomain']]) && $LDAPGroupUseFullDN[$_SESSION['LDAPDomain']] ) {
                    $this->userLDAPGroups = $this->getUserGroups($ldapconn, $userdn, true);
                } else {
                    if ( (isset($LDAPGroupUseRetrievedUsername[$_SESSION['LDAPDomain']]) && $LDAPGroupUseRetrievedUsername[$_SESSION['LDAPDomain']])
                        && $this->LDAPUsername != '' ) {
                        $this->userLDAPGroups = $this->getUserGroups($ldapconn, $this->LDAPUsername, true);
                    } else {
                        $this->userLDAPGroups = $this->getUserGroups($ldapconn, $username, true);
                    }
                }

                //If the user doesn't have any groups there is no need to waste another search.
                if ( $this->foundUserLDAPGroups ) {
                    $this->allLDAPGroups = $this->getAllGroups($ldapconn, true);
                }
            }

            //Retrieve preferences
            if ( isset($LDAPRetrievePrefs[$_SESSION['LDAPDomain']]) && $LDAPRetrievePrefs[$_SESSION['LDAPDomain']] ) {
                $this->printDebug("Retrieving preferences",1);

                $entry = @ldap_read($ldapconn, $userdn, "objectclass=*");
                $info = @ldap_get_entries($ldapconn, $entry);
                $this->email = $info[0]["mail"][0];
                $this->lang = $info[0]["preferredlanguage"][0];
                $this->nickname = $info[0]["displayname"][0];
                $this->realname = $info[0]["cn"][0];

                $this->printDebug("Retrieved: $this->email, $this->lang, $this->nickname, $this->realname",2);
            }

            // Lets clean up.
            @ldap_unbind();
        } else {
            $this->printDebug("Failed to connect",1);
            return false;
        }
       
        $this->printDebug("Authentication passed",1);
        //We made it this far; the user authenticated and didn't fail any checks, so he/she gets in.
        return true;
    }

    /**
     * Modify options in the login template.
     *
     * @param UserLoginTemplate $template
     * @access public
     */
    function modifyUITemplate( &$template ) {
        global $LDAPDomainNames, $LDAPUseLocal;
        global $LDAPAddLDAPUsers;
        global $LDAPUseSmartcardAuth, $LDAPSmartcardDomain;

        $this->printDebug("Entering modifyUITemplate",1);

        if ( !isset($LDAPAddLDAPUsers[$_SESSION['LDAPDomain']]) || !$LDAPAddLDAPUsers[$_SESSION['LDAPDomain']] ) {
            $template->set( 'create', false );
        }

        $template->set( 'usedomain', true );
        $template->set( 'useemail', false );

        $tempDomArr = $LDAPDomainNames;
        if ( $LDAPUseLocal ) {
            $this->printDebug("Allowing the local domain, adding it to the list.",1);
            array_push( $tempDomArr, 'local' );
        }

        if ( $LDAPUseSmartcardAuth ) {
            $this->printDebug("Allowing smartcard login, removing the domain from the list.",1);
            //There is no reason for people to log in directly to the wiki if the are using a
            //smartcard. If they try to, they are probably up to something fishy.
            unset( $tempDomArr[array_search($LDAPSmartcardDomain, $tempDomArr)] );
        }

        $template->set( 'domainnames', $tempDomArr );
    }

    /**
     * Return true if the wiki should create a new local account automatically
     * when asked to login a user who doesn't exist locally but does in the
     * external auth database.
     *
     * This is just a question, and shouldn't perform any actions.
     *
     * @return bool
     * @access public
     */
    function autoCreate() {
        global $LDAPDisableAutoCreate;

        if ( isset($LDAPDisableAutoCreate[$_SESSION['LDAPDomain']]) && $LDAPDisableAutoCreate[$_SESSION['LDAPDomain']] ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Set the given password in LDAP.
     * Return true if successful.
     *
     * @param User $user
     * @param string $password
     * @return bool
     * @access public
     */
    function setPassword( $user, &$password ) {
        global $LDAPUpdateLDAP, $LDAPWriterDN, $LDAPWriterPassword;

        $this->printDebug("Entering setPassword",1);

        if ($_SESSION['LDAPDomain'] == 'local') {
            $this->printDebug("User is using a local domain",1);

            //We don't set local passwords, but we don't want the wiki
            //to send the user a failure.        
            return true;
        } else if ( !isset($LDAPUpdateLDAP[$_SESSION['LDAPDomain']]) || !$LDAPUpdateLDAP[$_SESSION['LDAPDomain']] ) {
            $this->printDebug("Wiki is set to not allow updates",1);

            //We aren't allowing the user to change his/her own password
            return false;
        }

        if (!isset($LDAPWriterDN[$_SESSION['LDAPDomain']])) {
            $this->printDebug("Wiki doesn't have wgLDAPWriterDN set",1);

            //We can't change a user's password without an account that is
            //allowed to do it.
            return false;
        }

        $pass = $this->getPasswordHash($password);

        $ldapconn = $this->connect();
        if ($ldapconn) {
            $this->printDebug("Connected successfully",1);
            $userdn = $this->getSearchString($ldapconn, $user->getName());

            $this->printDebug("Binding as the writerDN",1);
            $bind = $this->bindAs( $ldapconn, $LDAPWriterDN[$_SESSION['LDAPDomain']], $LDAPWriterPassword[$_SESSION['LDAPDomain']] );
            if (!$bind) {
                return false;
            }

            $values["userpassword"] = $pass;

            //Blank out the password in the database. We don't want to save
            //domain credentials for security reasons.
            $password = '';

            $success = ldap_modify($ldapconn, $userdn, $values);

            //Let's clean up
            @ldap_unbind();
            if ($success) {
                $this->printDebug("Successfully modified the user's password",1);
                return true;
            } else {
                $this->printDebug("Failed to modify the user's password",1);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Update user information in LDAP
     * Return true if successful.
     *
     * @param User $user
     * @return bool
     * @access public
     */    
    function updateExternalDB( $user ) {
        global $LDAPUpdateLDAP;
        global $LDAPWriterDN, $LDAPWriterPassword;

        $this->printDebug("Entering updateExternalDB",1);

        if ( (!isset($LDAPUpdateLDAP[$_SESSION['LDAPDomain']]) || !$LDAPUpdateLDAP[$_SESSION['LDAPDomain']]) ||
            $_SESSION['LDAPDomain'] == 'local') {
            $this->printDebug("Either the user is using a local domain, or the wiki isn't allowing updates",1);

            //We don't handle local preferences, but we don't want the
            //wiki to return an error.
            return true;
        }

        if (!isset($LDAPWriterDN[$_SESSION['LDAPDomain']])) {
            $this->printDebug("The wiki doesn't have wgLDAPWriterDN set",1);

            //We can't modify LDAP preferences if we don't have a user
            //capable of editing LDAP attributes.
            return false;
        }

        $this->email = $user->getEmail();
        $this->realname = $user->getRealName();
        $this->nickname = $user->getOption('nickname');
        $this->language = $user->getOption('language');

        $ldapconn = $this->connect();
        if ($ldapconn) {
            $this->printDebug("Connected successfully",1);
            $userdn = $this->getSearchString($ldapconn, $user->getName());

            $this->printDebug("Binding as the writerDN",1);
            $bind = $this->bindAs( $ldapconn, $LDAPWriterDN[$_SESSION['LDAPDomain']], $LDAPWriterPassword[$_SESSION['LDAPDomain']] );
            if (!$bind) {
                return false;
            }

            if ('' != $this->email) { $values["mail"] = $this->email; }
            if ('' != $this->nickname) { $values["displayname"] = $this->nickname; }
            if ('' != $this->realname) { $values["cn"] = $this->realname; }
            if ('' != $this->language) { $values["preferredlanguage"] = $this->language; }

            if (0 != sizeof($values) && ldap_modify($ldapconn, $userdn, $values)) {
                $this->printDebug("Successfully modified the user's attributes",1);
                @ldap_unbind();
                return true;
            } else {
                $this->printDebug("Failed to modify the user's attributes",1);
                @ldap_unbind();
                return false;
            }
        } else {
            $this->printDebug("Failed to Connect",1);
            return false;
        }
    }

    /**
     * Can the wiki create accounts in LDAP?
     * Return true if yes.
     *
     * @return bool
     * @access public
     */    
    function canCreateAccounts() {
        global $LDAPAddLDAPUsers;

        if ( isset($LDAPAddLDAPUsers[$_SESSION['LDAPDomain']]) && $LDAPAddLDAPUsers[$_SESSION['LDAPDomain']] ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Can the wiki change passwords in LDAP?
     * Return true if yes.
     *
     * @return bool
     * @access public
     */    
    function allowPasswordChange() {
        global $LDAPUpdateLDAP, $LDAPMailPassword;

        if ( isset($LDAPUpdateLDAP[$_SESSION['LDAPDomain']]) ) {
            $updateLDAP = $LDAPUpdateLDAP[$_SESSION['LDAPDomain']];
        } else {
            $updateLDAP = false;
        }
        if ( isset($LDAPMailPassword[$_SESSION['LDAPDomain']]) ) {
            $mailPassword = $LDAPMailPassword[$_SESSION['LDAPDomain']];
        } else {
            $mailPassword = false;
        }

        if ( $updateLDAP || $mailPassword ) { 
            return true;
        } else {
            return false;
        }
    }

    /**
     * Add a user to LDAP.
     * Return true if successful.
     *
     * @param User $user
     * @param string $password
     * @return bool
     * @access public
     */
    function addUser( $user, $password ) {
        global $LDAPAddLDAPUsers, $LDAPWriterDN, $LDAPWriterPassword;
        global $LDAPSearchAttributes;
        global $LDAPWriteLocation;
        global $LDAPRequiredGroups, $LDAPGroupDN;
        global $LDAPRequireAuthAttribute, $LDAPAuthAttribute;

        $this->printDebug("Entering addUser",1);

        if ( (!isset($LDAPAddLDAPUsers[$_SESSION['LDAPDomain']]) || !$LDAPAddLDAPUsers[$_SESSION['LDAPDomain']]) ||
            'local' == $_SESSION['LDAPDomain'] ) {
            $this->printDebug("Either the user is using a local domain, or the wiki isn't allowing users to be added to LDAP",1);

            //Tell the wiki not to return an error.
            return true;
        }

        if ($LDAPRequiredGroups || $LDAPGroupDN) {
            $this->printDebug("The wiki is requiring users to be in specific groups, and cannot add users as this would be a security hole.",1);
            //It is possible that later we can add users into
            //groups, but since we don't support it, we don't want
            //to open holes!
            return false;
        }

        if (!isset($LDAPWriterDN[$_SESSION['LDAPDomain']])) {
            $this->printDebug("The wiki doesn't have wgLDAPWriterDN set",1);

            //We can't add users without an LDAP account capable of doing so.
            return false;
        }

        $this->email = $user->getEmail();
        $this->realname = $user->getRealName();
        $username = $user->getName();

        $pass = $this->getPasswordHash($password);

        $ldapconn = $this->connect();
        if ($ldapconn) {
            $this->printDebug("Successfully connected",1);
            $userdn = $this->getSearchString($ldapconn, $username);
            if ('' == $userdn) {
                $this->printDebug("userdn is blank, attempting to use wgLDAPWriteLocation",1);
                if (isset($LDAPWriteLocation[$_SESSION['LDAPDomain']])) {
                    $this->printDebug("wgLDAPWriteLocation is set, using that",1);
                    $userdn = $LDAPSearchAttributes[$_SESSION['LDAPDomain']] . "=" .
                        $username . $LDAPWriteLocation[$_SESSION['LDAPDomain']];
                } else {
                    $this->printDebug("wgLDAPWriteLocation is not set, failing",1);
                    //getSearchString will bind, but will not unbind
                    @ldap_unbind();
                    return false;
                }
            }

            $this->printDebug("Binding as the writerDN",1);
            $bind = $this->bindAs( $ldapconn, $LDAPWriterDN[$_SESSION['LDAPDomain']], $LDAPWriterPassword[$_SESSION['LDAPDomain']] );
            if (!$bind) {
                return false;
            }

            //Set up LDAP attributes
            $values["uid"] = $username;
            $values["sn"] = $username;
            if ('' != $this->email) { $values["mail"] = $this->email; }
            if ('' != $this->realname) {$values["cn"] = $this->realname; }
                else { $values["cn"] = $username; }
            $values["userpassword"] = $pass;
            $values["objectclass"] = "inetorgperson";

            if ($LDAPRequireAuthAttribute) {
                $values[$LDAPAuthAttribute[$_SESSION['LDAPDomain']]] = "true";
            }

            if (@ldap_add($ldapconn, $userdn, $values)) {
                $this->printDebug("Successfully added user",1);
                @ldap_unbind();
                return true;
            } else {
                $this->printDebug("Failed to add user",1);
                @ldap_unbind();
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Set the domain this plugin is supposed to use when authenticating.
     *
     * @param string $domain
     * @access public    
     */
    function setDomain( $domain ) {
        $this->printDebug("Setting domain as: $domain",1);
        $_SESSION['LDAPDomain'] = $domain;
    }

    /**
     * Check to see if the specific domain is a valid domain.
     * Return true if the domain is valid.
     *
     * @param string $domain
     * @return bool
     * @access public
     */
    function validDomain( $domain ) {
        global $LDAPDomainNames, $LDAPUseLocal;

        $this->printDebug("Entering validDomain",1);

        if (in_array($domain, $LDAPDomainNames) || ($LDAPUseLocal && 'local' == $domain)) {
            $this->printDebug("User is using a valid domain.",1);
            return true;
        } else {
            $this->printDebug("User is not using a valid domain.",1);
            return false;
        }
    }

    /**
     * When a user logs in, update user with information from LDAP.
     *
     * @param User $user
     * @access public
     */
    function updateUser( &$user ) {
        global $LDAPRetrievePrefs;
        global $LDAPUseLDAPGroups;

        $this->printDebug("Entering updateUser",1);

        $saveSettings = false;

        //If we aren't pulling preferences, we don't want to accidentally
        //overwrite anything.
        if ( isset($LDAPRetrievePrefs[$_SESSION['LDAPDomain']]) && $LDAPRetrievePrefs[$_SESSION['LDAPDomain']] ) {
            $this->printDebug("Setting user preferences.",1);

            if ('' != $this->lang) {
                $user->setOption('language',$this->lang);
            }
            if ('' != $this->nickname) {
                $user->setOption('nickname',$this->nickname);
            }
            if ('' != $this->realname) {
                $user->setRealName($this->realname);
            }
            if ('' != $this->email) {
                $user->setEmail($this->email);
            }

            $saveSettings = true;
        }

        if ( isset($LDAPUseLDAPGroups[$_SESSION['LDAPDomain']]) && $LDAPUseLDAPGroups[$_SESSION['LDAPDomain']] ) {
            $this->setGroups($user);
            $saveSettings = true;
        }

        if ( $saveSettings ) {
            $this->printDebug("Saving user settings.",1);
            $user->saveSettings();
        }
    }

    /**
     * Return true to prevent logins that don't authenticate here from being
     * checked against the local database's password fields.
     *
     * This is just a question, and shouldn't perform any actions.
     *
     * @return bool
     * @access public
     */
    function strict() {
        global $LDAPUseLocal, $LDAPMailPassword;

        $this->printDebug("Entering strict.",1);

        if ($LDAPUseLocal || $LDAPMailPassword) {
            $this->printDebug("Returning false in strict().",1);
            return false;
        } else {
            $this->printDebug("Returning true in strict().",1);
            return true;
        }
    }

    /**
     * When creating a user account, initialize user with information from LDAP.
     *
     * @param User $user
     * @access public
     */
    function initUser( &$user ) {
        global $LDAPUseLDAPGroups;

        $this->printDebug("Entering initUser",1);

        if ('local' == $_SESSION['LDAPDomain']) {
            $this->printDebug("User is using a local domain",1);
            return;
        }

        //We are creating an LDAP user, it is very important that we do
        //NOT set a local password because it could compromise the
        //security of our domain.
        $user->mPassword = '';

        if ( isset($LDAPRetrievePrefs[$_SESSION['LDAPDomain']]) && $LDAPRetrievePrefs[$_SESSION['LDAPDomain']] ) {
            if ('' != $this->lang) {
                $user->setOption('language',$this->lang);
            }
            if ('' != $this->nickname) {
                $user->setOption('nickname',$this->nickname);
            }
            if ('' != $this->realname) {
                $user->setRealName($this->realname);
            }
            if ('' != $this->email) {
                $user->setEmail($this->email);
            }
        }

        if ( isset($LDAPUseLDAPGroups[$_SESSION['LDAPDomain']]) && $LDAPUseLDAPGroups[$_SESSION['LDAPDomain']] ) {
            $this->setGroups($user);
        }

        $user->saveSettings();
    }

    /**
     * Munge the username to always have a form of uppercase for the first letter,
     * and lowercase for the rest of the letters.
     *
     * @param string $username
     * @return string
     * @access public
     */
    function getCanonicalName( $username ) {
        $this->printDebug("Entering getCanonicalName",1);

        if ( $username != '' ) {
            $this->printDebug("Username isn't empty.",1);

            //We want to use the username returned by LDAP
            //if it exists
            if ( $this->LDAPUsername != '' ) {
                $this->printDebug("Using LDAPUsername.",1);
                $username = $this->LDAPUsername;
            }

            //Change username to lowercase so that multiple user accounts
            //won't be created for the same user.
            $username = strtolower($username);

            //The wiki considers an all lowercase name to be invalid; need to
            //uppercase the first letter
            $username[0] = strtoupper($username[0]);
        }
        $this->printDebug("Munged username: $username",1);
        return $username;
    }

    /**
     * Returns the username pulled from LDAP when getSearchString() was called.
     *
     * @return string
     * @access public
     */
    function getLDAPUsername() {
        return $this->LDAPUsername;
    }

    /**
     * Configures the authentication plugin for use with auto-authentication
     * plugins.
     *
     * @access public
     */
    function autoAuthSetup() {
        global $LDAPUseSmartcardAuth;
        global $LDAPSmartcardDomain;

        $LDAPUseSmartcardAuth = true;
        $this->setDomain($LDAPSmartcardDomain);
    }

    /**
     * Gets the searchstring for a user based upon settings for the domain.
     * Returns a full DN for a user.
     *
     * @param resource $ldapconn
     * @param string $username
     * @return string
     * @access private
     */
    function getSearchString($ldapconn, $username) {
        global $LDAPSearchStrings;
        global $LDAPProxyAgent, $LDAPProxyAgentPassword;

        $this->printDebug("Entering getSearchString",1);

        if (isset($LDAPSearchStrings[$_SESSION['LDAPDomain']])) {
            //This is a straight bind
            $this->printDebug("Doing a straight bind",1);

            $tmpuserdn = $LDAPSearchStrings[$_SESSION['LDAPDomain']];
            $userdn = str_replace("USER-NAME",$username,$tmpuserdn);
        } else {
            //This is a proxy bind, or an anonymous bind with a search
            if (isset($LDAPProxyAgent[$_SESSION['LDAPDomain']])) {
                //This is a proxy bind
                $this->printDebug("Doing a proxy bind",1);
                $bind = $this->bindAs( $ldapconn, $LDAPProxyAgent[$_SESSION['LDAPDomain']], $LDAPProxyAgentPassword[$_SESSION['LDAPDomain']] );
            } else {
                //This is an anonymous bind
                $this->printDebug("Doing an anonymous bind",1);
                $bind = $this->bindAs( $ldapconn );
            }
    
            if (!$bind) {
                $this->printDebug("Failed to bind",1);
                return '';
            }

            $userdn = $this->getUserDN($ldapconn, $username);
        }
        $this->printDebug("userdn is: $userdn",2);
        return $userdn;
    }

    /**
     * Gets the DN of a user based upon settings for the domain.
     * This function will set $this->LDAPUsername
     * You must bind to the server before calling this.
     *
     * @param resource $ldapconn
     * @param string $username
     * @return string
     * @access private
     */
    function getUserDN($ldapconn, $username) {
        global $LDAPSearchAttributes;
        global $LDAPRequireAuthAttribute, $LDAPAuthAttribute;
        global $LDAPBaseDNs;

        $this->printDebug("Entering getUserDN",1);

        //we need to do a subbase search for the entry

        //Smartcard auth needs to check LDAP for required attributes.
        if ( (isset($LDAPRequireAuthAttribute[$_SESSION['LDAPDomain']]) && $LDAPRequireAuthAttribute[$_SESSION['LDAPDomain']])
            && $this->useSmartcardAuth() ) {
            $auth_filter = "(" . $LDAPAuthAttribute[$_SESSION['LDAPDomain']] . ")";
            $srch_filter = "(" . $LDAPSearchAttributes[$_SESSION['LDAPDomain']] . "=" . $this->getLdapEscapedString($username) . ")";
            $filter = "(&" . $srch_filter . $auth_filter . ")";
            $this->printDebug("Created an auth attribute filter: $filter",2);
        } else {
            $filter = "(" . $LDAPSearchAttributes[$_SESSION['LDAPDomain']] . "=" . $this->getLdapEscapedString($username) . ")";
            $this->printDebug("Created a regular filter: $filter",2);
        }

        $attributes = array("*");
        $base = $LDAPBaseDNs[$_SESSION['LDAPDomain']];

        $this->printDebug("Using base: $base",2);

        $entry = @ldap_search($ldapconn, $base, $filter, $attributes);
        if (!$entry) {
            $this->printDebug("Couldn't find an entry",1);
            return '';
        }

        $info = @ldap_get_entries($ldapconn, $entry);

        //This is a pretty useful thing to have for both smartcard authentication,
        //group checking, and pulling preferences.

        $userdn = $info[0]["dn"];
        return $userdn;
    }

    //DEPRECATED
    function isMemberOfLdapGroup( $ldapconn, $userDN, $groupDN ) {
        $this->printDebug("Entering isMemberOfLdapGroup (DEPRECATED)",1);

        //we need to do a subbase search for the entry
        $filter = "(member=" . $this->getLdapEscapedString($userDN) . ")";
        $info = ldap_get_entries( $ldapconn, @ldap_search($ldapconn, $groupDN, $filter) );
        return ( $info["count"] >= 1 );
    }

    /**
     * Determines whether a user is a member of a group, or a nested group.
     *
     * @param resource $ldapconn
     * @param string $userDN
     * @return bool
     * @access private
     */
    function isMemberOfRequiredLdapGroup( $ldapconn, $userDN ) {
        global $LDAPRequiredGroups;
        global $LDAPGroupSearchNestedGroups;

        $this->printDebug("Entering isMemberOfRequiredLdapGroup",1);

        $reqgroups = $LDAPRequiredGroups[$_SESSION['LDAPDomain']];
        for ( $i = 0; $i < count($reqgroups); $i++ ) {
            $reqgroups[$i] = strtolower( $reqgroups[$i] );
        }

        $searchnested = $LDAPGroupSearchNestedGroups[$_SESSION['LDAPDomain']];

        $this->printDebug("Required groups:" . implode(",",$reqgroups) . "",1);

        $groups = $this->getUserGroups($ldapconn, $userDN);

        if ( !$this->foundUserLDAPGroups ) {
            //User isn't in any groups, so he/she obviously can't be in
            //a required one
            $this->printDebug("Couldn't find the user in any groups (1).",1);

            return false;
        } else {
            //User is in groups, let's see if a required group is one of them
            foreach ($groups as $group) {
                if ( in_array( $group, $reqgroups ) ) {
                    $this->printDebug("Found user in a group.",1);
                    return true;
                }
            }

            //We didn't find the user in the group, lets check nested groups
            if ( $searchnested ) {
                //No reason to go on if we aren't allowing nested group
                //searches
                if ( $this->searchNestedGroups($ldapconn, $groups) ) {
                    return true;
                }
            }

            $this->printDebug("Couldn't find the user in any groups (2).",1);

            return false;
        }
    }

    /**
     * Helper function for isMemberOfRequiredLdapGroup.
     * $checkedgroups is used for tail recursion and shouldn't be provided
     * when called externally.
     *
     * @param resource $ldapconn
     * @param string $userDN
     * @param array $checkedgroups
     * @return bool
     * @access private
     */
    function searchNestedGroups( $ldapconn, $groups, $checkedgroups = array() ) {
        global $LDAPRequiredGroups;

        $this->printDebug("Entering searchNestedGroups",1);

        //base case, no more groups left to check
        if (!$groups) {
            $this->printDebug("Couldn't find user in any nested groups.",1);
            return false;
        }

        $this->printDebug("Checking groups:" . implode(",",$groups) . "",2);

        $reqgroups = $LDAPRequiredGroups[$_SESSION['LDAPDomain']];
        for ( $i = 0; $i < count($reqgroups); $i++ ) {
            $reqgroups[$i] = strtolower( $reqgroups[$i] );
        }

        $groupstocheck = array();
        foreach ( $groups as $group ) {
            $returnedgroups = $this->getUserGroups($ldapconn, $group);
            foreach ($returnedgroups as $checkme) {
                $this->printDebug("Checking membership for: $checkme",2);
                if ( in_array( $checkme, $checkedgroups ) ) {
                    //We already checked this, move on
                    continue;
                } else if ( in_array( $checkme, $reqgroups ) ) {
                    $this->printDebug("Found user in a nested group.",1);
                    //Woohoo
                    return true;
                } else {
                    //We'll need to check this group's members now
                    array_push( $groupstocheck, $checkme );
                }
            }
        }

        $checkedgroups = array_unique(array_merge($groups, $checkedgroups));

        //Mmmmmm. Tail recursion. Tasty.
        if ( $this->searchNestedGroups($ldapconn, $groupstocheck, $checkedgroups) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Helper function for isMemberOfRequiredLdapGroup and searchNestedGroups
     * Sets $this->foundUserLDAPGroups
     *
     * @param resource $ldapconn
     * @param string $dn
     * @return array
     * @access private
     */
    function getUserGroups( $ldapconn, $dn, $getShortnames = false ) {
        $this->printDebug("Entering getUserGroups",1);

        //Let's return the saved groups if they are available
        if ( $getShortnames ) {
            if ( isset($this->userLDAPShortnameGroupCache) ) {
                return $this->userLDAPShortnameGroupCache;
            }
        } else {
            if ( isset($this->userLDAPGroupCache) ) {
                return $this->userLDAPGroupCache;
            }
        }

        //We haven't done a search yet, lets do it now
        list($groups, $shortnamegroups) = $this->getGroups( $ldapconn, $dn );

        //Save the groups for next time we are called
        $this->userLDAPGroupCache = $groups;
        $this->userLDAPShortnameGroupCache = $shortnamegroups;

        //We only need to check one of the two arrays, as they should be
        //identical from a member standpoint.
        if (count($groups) == 0) {
            $this->foundUserLDAPGroups = false;
        } else {
            $this->foundUserLDAPGroups = true;
        }

        if ( $getShortnames ) {
            return $shortnamegroups;
        } else {
            return $groups;
        }
    }

    /**
     * Helper function for retrieving all LDAP groups
     * Sets $this->foundAllLDAPGroups
     *
     * @param resource $ldapconn
     * @param string $dn
     * @return array
     * @access private
     */
    function getAllGroups( $ldapconn, $getShortnames = false ) {
        $this->printDebug("Entering getAllGroups",1);

        //Let's return the saved groups if they are available
        if ( $getShortnames ) {
            if ( isset($this->allLDAPShortnameGroupCache) ) {
                return $this->allLDAPShortnameGroupCache;
            }
        } else {
            if ( isset($this->allLDAPGroupCache) ) {
                return $this->allLDAPGroupCache;
            }
        }

        //We haven't done a search yet, lets do it now
        list($groups, $shortnamegroups) = $this->getGroups( $ldapconn, '*' );

        //Save the groups for next time we are called
        $this->allLDAPGroupCache = $groups;
        $this->allLDAPShortnameGroupCache = $shortnamegroups;

        //We only need to check one of the two arrays, as they should be
        //identical from a member standpoint.
        if (count($groups) == 0) {
            $this->foundAllLDAPGroups = false;
        } else {
            $this->foundAllLDAPGroups = true;
        }

        if ( $getShortnames ) {
            return $shortnamegroups;
        } else {
            return $groups;
        }
    }

    /**
     * Helper function for getUserGroups and getAllGroups. You shouldn't
     * call this directly.
     *
     * @param resource $ldapconn
     * @param string $dn
     * @return array
     * @access private
     */
    function getGroups( $ldapconn, $dn ) {
        global $LDAPBaseDNs;
        global $LDAPGroupObjectclass, $LDAPGroupAttribute, $LDAPGroupNameAttribute;
        global $LDAPProxyAgent, $LDAPProxyAgentPassword;

        $this->printDebug("Entering getGroups",1);

        $base = $LDAPBaseDNs[$_SESSION['LDAPDomain']];
        $objectclass = $LDAPGroupObjectclass[$_SESSION['LDAPDomain']];
        $attribute = $LDAPGroupAttribute[$_SESSION['LDAPDomain']];
        $nameattribute = $LDAPGroupNameAttribute[$_SESSION['LDAPDomain']];

        //Search for the groups this user is in
        $filter = "(&($attribute=" . $this->getLdapEscapedString($dn) . ")(objectclass=$objectclass))";

        $this->printDebug("Search string: $filter",2);

        if ( isset($LDAPProxyAgent[$_SESSION['LDAPDomain']]) ) {
            //We'll try to bind as the proxyagent as the proxyagent should normally have more
            //rights than the user. If the proxyagent fails to bind, we will still be able
            //to search as the normal user (which is why we don't return on fail).
            $this->printDebug("Binding as the proxyagentDN",1);
            $bind = $this->bindAs($ldapconn, $LDAPProxyAgent[$_SESSION['LDAPDomain']], $LDAPProxyAgentPassword[$_SESSION['LDAPDomain']]);
        }

        $info = @ldap_search($ldapconn, $base, $filter);
        if ( !$info ) {
            $this->printDebug("No entries returned from search.",2);
            //Return an array with two empty arrays so that other functions
            //don't error out.
            return array( array(), array() );
        }

        $entries = @ldap_get_entries($ldapconn,$info);

        //We need to shift because the first entry will be a count
        array_shift($entries);

        //Let's get a list of both full dn groups and shortname groups
        $groups = array();
        $shortnamegroups = array();
        foreach ($entries as $entry) {
            $mem = strtolower($entry['dn']);
            $shortnamemem = strtolower($entry[$nameattribute][0]);

            array_push($groups,$mem);
            array_push($shortnamegroups,$shortnamemem);
        }

        $both_groups = array();
        array_push($both_groups, $groups);
        array_push($both_groups, $shortnamegroups);

        $this->printDebug("Returned groups:" . implode(",",$groups) . "",2);
        $this->printDebug("Returned groups:" . implode(",",$shortnamegroups) . "",2);

        return $both_groups;
    }

    /**
     * Returns true if this group is in the list of the currently authenticated
     * user's groups, else false.
     *
     * @param string $group
     * @return bool
     * @access private
     */
    function hasLDAPGroup( $group ) {
        $this->printDebug("Entering hasLDAPGroup",1);

        return in_array( strtolower( $group ), $this->userLDAPGroups );
    }

    /**
     * Returns true if an LDAP group with this name exists, else false.
     *
     * @param string $group
     * @return bool
     * @access private
     */
    function isLDAPGroup( $group ) {
        $this->printDebug("Entering isLDAPGroup",1);

        return in_array( strtolower( $group ), $this->allLDAPGroups );
    }

    /**
     * Helper function for updateUser() and initUser(). Adds users into MediaWiki security groups
     * based upon groups retreived from LDAP.
     *
     * @param User $user
     * @access private
     */
    function setGroups( &$user ) {
        $this->printDebug("Pulling groups from LDAP.",1);

        # add groups permissions
        $localAvailGrps = $user->getAllGroups();
        $localUserGrps = $user->getEffectiveGroups();

        $this->printDebug("Available groups are: " . implode(",",$localAvailGrps) . "",1);
        $this->printDebug("Effective groups are: " . implode(",",$localUserGrps) . "",1);

        # note: $localUserGrps does not need to be updated with $cGroup added,
        #       as $localAvailGrps contains $cGroup only once.
        foreach ($localAvailGrps as $cGroup) {
            # did we once add the user to the group?
            if (in_array($cGroup,$localUserGrps)) {
                $this->printDebug("Checking to see if we need to remove user from: $cGroup",1);
                if ((!$this->hasLDAPGroup($cGroup)) && ($this->isLDAPGroup($cGroup))) {
                    $this->printDebug("Removing user from: $cGroup",1);
                    # the ldap group overrides the local group
                    # so as the user is currently not a member of the ldap group, he shall be removed from the local group
                    $user->removeGroup($cGroup);
                }
            } else { # no, but maybe the user has recently been added to the ldap group?
                $this->printDebug("Checking to see if user is in: $cGroup",1);
                if ($this->hasLDAPGroup($cGroup)) {
                    $this->printDebug("Adding user to: $cGroup",1);
                    # so use the addGroup function
                    $user->addGroup($cGroup);
                    # completedfor $cGroup.
                }
            }
        }
    }

    /**
     * Returns a password that is created via the configured hash settings.
     *
     * @param string $password
     * @return string
     * @access private
     */
    function getPasswordHash( $password ) {
        global $LDAPPasswordHash;

        $this->printDebug("Entering getPasswordHash",1);

        if (isset($LDAPPasswordHash[$_SESSION['LDAPDomain']])) {
            $hashtouse = $LDAPPasswordHash[$_SESSION['LDAPDomain']];
        } else {
            $hashtouse = '';
        }
        //Set the password hashing based upon admin preference
        switch ($hashtouse) {
            case 'crypt':
                $pass = '{CRYPT}' . crypt($password);
                break;
            case 'clear':
                $pass = $password;
                break;
            default:
                $pwd_md5 = base64_encode(pack('H*',sha1($password)));
                $pass = "{SHA}".$pwd_md5;
                break;
        }
        $this->printDebug("Password is $pass",2);
        return $pass;
    }

    /**
     * Prints debugging information. $debugText is what you want to print, $debugVal
     * is the level at which you want to print the information.
     *
     * @param string $debugText
     * @param string $debugVal
     * @access private
     */
    function printDebug( $debugText, $debugVal ) {
        global $LDAPDebug;

        if ($LDAPDebug > $debugVal) {
            echo $debugText . "<br>";
        }
    }

    /**
     * Binds as $userdn with $password. This can be called with only the ldap
     * connection resource for an anonymous bind.
     *
     * @param resourse $ldapconn
     * @param string $userdn
     * @param string $password
     * @return bool
     * @access private
     */
    function bindAs( $ldapconn, $userdn=null, $password=null ) {
        //Let's see if the user can authenticate.
        if ($userdn == null || $password == null) {
            $bind = @ldap_bind($ldapconn);
        } else {
            $bind = @ldap_bind($ldapconn, $userdn, $password);
        }
        if (!$bind) {
            $this->printDebug("Failed to bind as $userdn",1);
            $this->printDebug("with password: $password",3);
            return false;
        }
        return true;
    }

    /**
     * Returns true if smartcard authentication is allowed, and the user is
     * authenticating using the smartcard domain.
     *
     * @return bool
     * @access private
     */
    function useSmartcardAuth() {
        global $LDAPUseSmartcartAuth;
        global $LDAPSmartcardDomain;
        
        return $LDAPUseSmartcardAuth && $_SESSION['LDAPDomain'] == $LDAPSmartcardDomain; 
    }

    /**
     * Returns a string which has the chars *, (, ), \ & NUL escaped to LDAP compliant
     * syntax as per RFC 2254
     * Thanks and credit to Iain Colledge for the research and function.
     * 
     * @param string $string
     * @return string
     * @access private
     */
    function getLdapEscapedString ($string) {
        // Make the string LDAP compliant by escaping *, (, ) , \ & NUL
        return str_replace(array("*","(",")","\\","\x00"),array("\\2a","\\28","\\29","\\5c","\\00"),$string);
    }

}

/**
 * Add extension information to Special:Version
 */
$ExtensionCredits['other'][] = array(
    'name' => 'LDAP Authentication Plugin',
    'version' => '1.1e',
    'author' => 'Ryan Lane',
    'description' => 'LDAP Authentication plugin with support for multiple LDAP authentication methods',
    'url' => 'http://meta.wikimedia.org/wiki/LDAP_Authentication'
    );

// The following was derived from the SSL Authentication plugin
// http://www.mediawiki.org/wiki/SSL_authentication

/**
 * Sets up the SSL authentication piece of the LDAP plugin.
 *
 * @access public
 */
function AutoAuthSetup() {
    global $LDAPSSLUsername;
    global $Hooks;
    global $Auth;
    global $LDAPAutoAuthMethod;

    $Auth = new LdapAuthenticationPlugin();

    $Auth->printDebug("Entering AutoAuthSetup.",1);

    //We may add quite a few different auto authenticate methods in the
    //future, let's make it easy to support.
    switch($LDAPAutoAuthMethod) {
        case "smartcard":
            $Auth->printDebug("Allowing smartcard authentication.",1);
            $Auth->printDebug("wgLDAPSSLUsername = $LDAPSSLUsername",2);

            if($LDAPSSLUsername != null) {
                $Auth->printDebug("wgLDAPSSLUsername is not null, adding hooks.",1);
                $Hooks['AutoAuthenticate'][] = 'SSLAuth'; /* Hook for magical authN */
                $Hooks['PersonalUrls'][] = 'NoLogout'; /* Disallow logout link */
            }
            break;
        default:
            $Auth->printDebug("Not using any AutoAuthentication methods .",1);
    }
}

/* No logout link in MW */
function NoLogout(&$personal_urls, $title) {
    $personal_urls['logout'] = null;
}

/**
 * Does the SSL authentication piece of the LDAP plugin.
 *
 * @access public
 */
function SSLAuth(&$user) {
    global $LDAPSSLUsername;
    global $User;
    global $Auth;

    $Auth->printDebug("Entering SSLAuth.",1);

    //Give us a user, see if we're around
    $tmpuser = User::LoadFromSession();

    //They already with us?  If so, quit this function.
    if($tmpuser->isLoggedIn()) {
        $Auth->printDebug("User is already logged in.",1);
        return;
    }

    //Let regular authentication plugins configure themselves for auto
    //authentication chaining
    $Auth->autoAuthSetup();

    //The user hasn't already been authenticated, let's check them
    $Auth->printDebug("User is not logged in, we need to authenticate",1);
    $authenticated = $Auth->authenticate($LDAPSSLUsername);
    if (!$authenticated) {
        //If the user doesn't exist in LDAP, there isn't much reason to
        //go any further.
        $Auth->printDebug("User wasn't found in LDAP, exiting.",1);
        return;
    }

    //We need the username that MediaWiki will always use, *not* the one we
    //get from LDAP.
    $mungedUsername = $Auth->getCanonicalName($LDAPSSLUsername);

    $Auth->printDebug("User exists in LDAP; finding the user by name in MediaWiki.",1);

    //Is the user already in the database?
    $tmpuser = User::newFromName($mungedUsername);

    if ( $tmpuser == null ) {
        $Auth->printDebug("Username is not a valid MediaWiki username.",1);
        return;
    }

    //If exists, log them in
    if($tmpuser->getID() != 0)
    {
        $Auth->printDebug("User exists in local database, logging in.",1);
        $User = &$tmpuser;
        $Auth->updateUser($User);
        $User->setCookies();
        $User->setupSession();
        return;
    }
    $Auth->printDebug("User does not exist in local database; creating.",1);

    //Require SpecialUserlogin so that we can get a loginForm
    require_once('SpecialUserlogin.php');

    //This section contains a silly hack for MW
    global $Lang;
    global $ContLang;
    global $Request;
    if(!isset($Lang))
    {
        $Lang = $ContLang;
        $LangUnset = true;
    }

    $Auth->printDebug("Creating LoginForm.",1);

    //This creates our form that'll let us create a new user in the database
    $lf = new LoginForm($Request);

    //The user we'll be creating...
    $User = &$tmpuser;
    $User->setName($ContLang->ucfirst($mungedUsername));

    $Auth->printDebug("Creating User.",1);

    //Create the user
    $lf->initUser($User);

    //Initialize the user
    $User->setupSession();
    $User->setCookies();
}

?>

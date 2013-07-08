<?php
	$module_info['name'] = 'Submit Antispam Addon';
	$module_info['desc'] = 'Create user authorizations to submit certain number of new stories based on quality of recent user submissions.';
	$module_info['version'] = 0.1;
	
    //  prevents -- Warning: Duplicate entry '1' for key 1 -- and so on   
    $module_info['db_sql'][] = "DELETE FROM ". table_config . " WHERE var_page LIKE 'Submit AntiSpam Addon'";
    
    $module_info['db_sql'][] =  "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1002,'Submit AntiSpam Addon','links_history_count',10,10,'1-50','Links history count',
    'How many latest user links are evaluated when <i><b>average user links votes</b></i> value is calculated','define')";
    
    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1003,'Submit AntiSpam Addon','level_1_votes',2,2,'1-10','Level 1 User Authorization',
    'Define <i><b>average user links votes</b></i> value required to become Level 1 user','define')";
    
    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1004,'Submit AntiSpam Addon','level_2_votes',5,5,'1-20','Level 2 User Authorization',
    'Define <i><b>average user links votes</b></i> value required to become Level 2 user','define')";
    
    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1005,'Submit AntiSpam Addon','level_3_votes',12,12,'1-50','Level 3 User Authorization',
    'Define <i><b>average user links votes</b></i> value required to become Level 3 user','define')";
    
    $module_info['db_sql'][] ="INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1006,'Submit AntiSpam Addon','level_1_submit_links',3,3,'1-10','Level 1 Allowed links count',
    'Define how many links are allowed to submit for user with <b>Level 1</b> authorization <b><i>in 24hrs</i></b>','define')";
    
    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1007,'Submit AntiSpam Addon','level_2_submit_links',10,10,'1-20','Level 2 Allowed links count',
    'Define how many links are allowed to submit for user with <b>Level 2</b> authorization <b><i>in 24hrs</i></b>','define')";
    
    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1008,'Submit AntiSpam Addon','level_3_submit_links',30,30,'1-100','Level 3 Allowed links',
    'Define how many links are allowed to submit for user with <b>Level 3</b> authorization <b><i>in 24hrs</i></b>','define')";

    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1009,'Submit AntiSpam Addon','comment_restriction',True,'True','True/False','Enable comment restriction',
    'Define if  <b>comment submission restriction policy</b> is enabled or not','define')";
    
    $module_info['db_sql'][] = "INSERT  into " . table_config . " (var_id,var_page,var_name,var_value,var_defaultvalue,var_optiontext,var_title,var_desc,var_method)
    VALUES (1010,'Submit AntiSpam Addon','comment_submit_multiplier',2,'2','0.1-10','Comment submission multiplier',
    'Define how many comments are allowed at current authorization level x <b><i>multiplier</i></b>','define')";
   
?>

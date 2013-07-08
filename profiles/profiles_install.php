<?php
	$module_info['name'] = 'Extended Profile Module';
	$module_info['desc'] = 'Allows you to extend the profile section of your members.';
	$module_info['version'] = 'v0.1';
	$module_info['requires'][] = array('users_extra_fields', 0.2);

	// *********************************************************************
	// all the fields that are not input type text are NUMBERED and referenced
	// in /modules/profiles/settings.php and /modules/users_extra_fields/users_extra_fields_init.php
	// when an entry is deleted or added in /modules/profiles/settings.php, it must be deleted or
	// added in this file and in /modules/users_extra_fields/users_extra_fields_init.php
	// as well as modifying (delete the corresponding block of code or add a code in
	// /modules/users_extra_fields/profile_center_fields.tpl (SEE TUTORIAL)
	// *********************************************************************

	$module_info['db_add_field'][]=array('users', 'user_university', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'user_birthdate', 'VARCHAR',  64, '', 0, '');
	// field ** 1 **
	$module_info['db_add_field'][]=array('users', 'user_age', 'tinyint',  1, '', 0, 0);
	// field ** 2 **
	$module_info['db_add_field'][]=array('users', 'user_gender', 'VARCHAR',  16, '', 0, '');
	// field ** 3 **
	$module_info['db_add_field'][]=array('users', 'user_status', 'VARCHAR',  16, '', 0, '');
	// field ** 4 **
	$module_info['db_add_field'][]=array('users', 'user_habits', 'VARCHAR',  16, '', 0, '');
	// field ** 5 **
	$module_info['db_add_field'][]=array('users', 'user_car', 'VARCHAR',  16, '', 0, '');
	// field ** 6 **
	$module_info['db_add_field'][]=array('users', 'user_country', 'VARCHAR',  64, '', 0, '');
	// field ** 7**
	$module_info['db_add_field'][]=array('users', 'user_state', 'VARCHAR',  64, '', 0, '');
	// field ** 8 **
	$module_info['db_add_field'][]=array('users', 'user_bio', 'VARCHAR',  255, '', 0, '');
	// field ** 9 **
	$module_info['db_add_field'][]=array('users', 'user_subscription', 'tinyint',  1, '', 0, 0);

	$module_info['db_add_field'][]=array('users', 'user_interests', 'VARCHAR',  255, '', 0, '');


	$module_info['db_add_field'][]=array('users', 'social_delicious', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_facebook', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_flickr', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_linkedin', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_pownce', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_stumbleupon', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_twitter', 'VARCHAR',  64, '', 0, '');
	$module_info['db_add_field'][]=array('users', 'social_youtube', 'VARCHAR',  64, '', 0, '');

?>
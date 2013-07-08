<?php

// the path to the module. the probably shouldn't be changed unless you rename the profiles folder(s)
define('profiles_path', my_pligg_base . '/modules/profiles/');
// the path to the modules templates. the probably shouldn't be changed unless you rename the profiles folder(s)
define('profiles_tpl_path', '../modules/profiles/templates/');


$users_extra_fields_field[]=array(
	'name' => 'user_birthdate',
	'show_to_user' => true,
	'show_to_user_text' => 'Birthdate:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 1 **
$users_extra_fields_field[]=array(
	'name' => 'user_age',
	'show_to_user' => true,
	'show_to_user_text' => 'Age:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 2 **
$users_extra_fields_field[]=array(
	'name' => 'user_gender',
	'show_to_user' => true,
	'show_to_user_text' => 'Gender:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'user_university',
	'show_to_user' => true,
	'show_to_user_text' => 'University/College:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 3 **
$users_extra_fields_field[]=array(
	'name' => 'user_status',
	'show_to_user' => true,
	'show_to_user_text' => 'Status:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 4 **
$users_extra_fields_field[]=array(
	'name' => 'user_habits',
	'show_to_user' => true,
	'show_to_user_text' => 'Smoking:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 5 **
$users_extra_fields_field[]=array(
	'name' => 'user_car',
	'show_to_user' => true,
	'show_to_user_text' => 'Car:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 6 **
$users_extra_fields_field[]=array(
	'name' => 'user_country',
	'show_to_user' => true,
	'show_to_user_text' => 'Country:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 7 **
$users_extra_fields_field[]=array(
	'name' => 'user_state',
	'show_to_user' => true,
	'show_to_user_text' => 'State/Province:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'user_interests',
	'show_to_user' => true,
	'show_to_user_text' => 'Interests:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 8 **
$users_extra_fields_field[]=array(
	'name' => 'user_bio',
	'show_to_user' => true,
	'show_to_user_text' => 'Bio:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_delicious',
	'show_to_user' => true,
	'show_to_user_text' => 'del.icio.us:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_facebook',
	'show_to_user' => true,
	'show_to_user_text' => 'Facebook:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_flickr',
	'show_to_user' => true,
	'show_to_user_text' => 'Flickr:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_linkedin',
	'show_to_user' => true,
	'show_to_user_text' => 'LinkedIn:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_pownce',
	'show_to_user' => true,
	'show_to_user_text' => 'Pownce:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_stumbleupon',
	'show_to_user' => true,
	'show_to_user_text' => 'Stumble Upon:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_twitter',
	'show_to_user' => true,
	'show_to_user_text' => 'Twitter:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

$users_extra_fields_field[]=array(
	'name' => 'social_youtube',
	'show_to_user' => true,
	'show_to_user_text' => 'YouTube:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// field ** 9 **
$users_extra_fields_field[]=array(
	'name' => 'user_subscription',
	'show_to_user' => true,
	'show_to_user_text' => 'Subscription:',
	'show_to_admin' => true,
	'editby_user' => true,
	'editby_admin' => true
	);

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('profiles_path', profiles_path);
	$main_smarty->assign('profiles_tpl_path', profiles_tpl_path);
}

?>
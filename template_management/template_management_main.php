<?php
function template_management_showpage(){
	// Method for identifying modules 
	define('modulename', 'template_management'); 

	global $main_smarty, $the_template, $db;

	$main_smarty->assign('modulename', modulename);

	include_once(mnminclude.'admin_config.php');

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');

	if($canIhaveAccess == 1)
	{

		if(isset($_REQUEST['action'])){$action = sanitize($_REQUEST['action'], 3);}else{$action='';}
		if(isset($_REQUEST['template'])){$template = sanitize($_REQUEST['template'], 3);}else{$template='';}
		if(isset($_REQUEST['version'])){$version = sanitize($_REQUEST['version'], 3);}else{$version='';}
		if(isset($_REQUEST['path'])){$download_path = sanitize($_REQUEST['path'], 3);}else{$download_path='';}
		if(is_writable('./templates')){
			$can_write = true;
		} else {
			$can_write = false;
		}
		$main_smarty->assign('can_write_to_template_folder', $can_write);

		if($action == "down_and_ext"){

			$url = "http://www.pligg.com/PackedTemplates/download.php?template=" . $template;
			$r = new HTTPRequest($url);
			$new_url = $r->DownloadToString();
			$msg = template_management_download($new_url);

			$x = explode('/', str_replace('.tar', '', $new_url));
			$filename = '/' . $x[count($x) - 2] . '_template.tar';
			$msg = template_management_unpack($filename);

		}

		if($action == "viewonline"){

			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');

			$main_smarty->display(template_management_tpl_path . '/blank.tpl');

			$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Template_Management_BreadCrumb');
			$navwhere['link2'] = URL_template_management;

			define('pagename', 'template_management'); 
			$main_smarty->assign('pagename', pagename);

			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
			$main_smarty = do_sidebar($main_smarty);
		

			$main_smarty->assign('tpl_center', template_management_tpl_path . 'template_management_viewonline');
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}

		if($action == "setDefault"){
			$config = new pliggconfig;
			$config->var_id = 52;
			$config->var_value = $template;
			$config->store(false);
			header('Location: module.php?module=template_management');
		}

		if($action == "pack"){
			if(is_dir('./templates/' . $template)){
				$msg = template_management_pack($template, $version);
			} else {
				$msg = 'Error, invalid template.';
			}
		}

		if($action == "unpack"){
			$msg = template_management_unpack($template);
		}

		if($action == "download"){
			$msg = template_management_download($download_path);
		}

		if($action == "delete"){
			$msg = template_management_delete($template);
		}

		if($action == "deletePacked"){
			$msg = template_management_delete_packed($template);
		}



		if(!isset($msg)){$msg = '';}
		$main_smarty->assign('msg', $msg);

		// find out what template is currently installed
			$config = new pliggconfig;
			$config->var_id = 52;
			$config->read();
			$current_template = $config->var_value;
			$main_smarty->assign('current_template', $current_template);

		// find out what templates are available
			$template_folders = array();
			$default_template_details = array(); // the default template
			$available_template_details = array(); // templates installed and available for use
			$incompatible_template_details = array(); // templates that are not marked as compatible
			$extracted_templates = array(); // packed templates that are found to be already extracted
			$packed_templates = array(); // packed templates, havn't checked to see if extracted or not

			if ($handle = opendir('./templates')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != ".svn") {
						if(!is_dir('./templates/' . $file)){
							if(strpos($file, 'template.tar') > 0){
								$packed_templates[$file] = $file;
							}
						}
					}
				}
				closedir($handle);
			}

			if ($handle = opendir('./templates')) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != ".svn") {
						if(is_dir('./templates/' . $file)){
							if(file_exists('./templates/' . $file . '/template_details.php')){
								$template_folders[] = $file;
								$details = template_management_read_details($file);
								$details['folder'] = $file;
								$details['can_install'] = true;
								$details['URL_pack'] = 'module.php?module=template_management&action=pack&template=' . $details['folder'] . '&version=' . $details['version'];

								// if this is the default yget template, don't allow it to be packed or unpacked
								// we don't want to break the default template in any way.
								if($file == 'yget'){
									$details['allow_pack_and_unpack'] = false;
								} else {								
									$details['allow_pack_and_unpack'] = true;
								}

								$tmp_file = '/templates/' . $details['folder'] . '_template.tar';
								if(file_exists('.' . $tmp_file)){

									$details['is_packed'] = my_pligg_base . $tmp_file;
									$extracted_templates[$file] = $tmp_file;

									$f = $details['folder'] . '_template.tar';
									if(isset($packed_templates[$f])){unset($packed_templates[$f]);}

								} else {
									$details['is_packed'] = 0;
								}

								if($current_template == $file){
									$default_template_details[$file] = $details;
								} else if($details['designed_for_pligg_version'] != pligg_version()){
									$details['can_install'] = false;
									$incompatible_template_details[$file] = $details;
								} else {
									$available_template_details[$file] = $details;
								}
							}
						}
					}
				}
				closedir($handle);
			}
			$main_smarty->assign('template_folders', $template_folders);
			$main_smarty->assign('default_template_details', $default_template_details);
			$main_smarty->assign('available_template_details', $available_template_details);
			$main_smarty->assign('incompatible_template_details', $incompatible_template_details);
			$main_smarty->assign('packed_templates', $packed_templates);

		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');

		$main_smarty->display(template_management_tpl_path . '/blank.tpl');

		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Template_Management_BreadCrumb');
		$navwhere['link2'] = URL_template_management;

		define('pagename', 'template_management'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		$main_smarty = do_sidebar($main_smarty);
		
		$main_smarty->assign('tpl_center', template_management_tpl_path . 'template_management_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');

	} else {

		echo "not for you.";

	}
}

function template_management_read_details($template){
	global $main_smarty;
	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	include('./templates/' . $template . '/template_details.php');
	return $template_info;

}

function template_management_pack($template, $version = 0){
	global $main_smarty;
	
	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	
	$main_smarty->display(template_management_tpl_path . '/blank.tpl');

	include_once('../' . template_management_path . 'class.tar.php');

	$file = '/templates/' . $template . '_template.tar';

	$tar_object = new Archive_Tar('.' . $file);
	$v_list[0]='./templates/' . $template;
	$tar_object->create($v_list);
	return $main_smarty->get_config_vars('PLIGG_Template_Management_HasBeenPacked') . ' <a href = "' . my_pligg_base . $file . '">' . $file . '</a>';
}

function template_management_unpack($template){
	global $main_smarty;

	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	
	$main_smarty->display(template_management_tpl_path . '/blank.tpl');

	if(file_exists('./templates/' . $template)){

		include_once('../' . template_management_path . 'class.tar.php');

		$tar_object = new Archive_Tar('./templates/' . $template);
		$tar_object->extract("./");

		return $main_smarty->get_config_vars('PLIGG_Template_Management_PackedTemplatesExtracted');

	} else {
		return $main_smarty->get_config_vars('PLIGG_Template_Management_Template_Error');
	}
}

function template_management_download($download_path){
	global $main_smarty;

	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	
	$main_smarty->display(template_management_tpl_path . '/blank.tpl');

	$x = explode('/', str_replace('.tar', '', $download_path));

	$filename = '/' . $x[count($x) - 2] . '_template.tar';

	$r = new HTTPRequest($download_path);
	$somecontent = $r->DownloadToString();

	$filename = './templates' . $filename;

	if (!$handle = fopen($filename, 'w')) {
		return "Cannot open file ($filename)";
	}

	if (fwrite($handle, $somecontent) === FALSE) {
		return "Cannot write to file ($filename)";
	}

	fclose($handle);

	return $main_smarty->get_config_vars('PLIGG_Template_Management_DownloadSuccess');

}

function template_management_delete($template){
	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	
	if(deltree('./templates/' . $template)){
		return 'The template has been deleted';
	} else {
		return 'There was an error deleting the template.';
	}

}

function template_management_delete_packed($template){
	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	
	if(unlink ('./templates/' . $template)){
		return 'The packed template file has been deleted';
	} else {
		return 'There was an error deleting the packed template file.';
	}
}

function deltree($path) {
	// Method for identifying modules 
	define('modulename', 'template_management'); 
	$main_smarty->assign('modulename', modulename);
	
  if (is_dir($path)) {
      if (version_compare(PHP_VERSION, '5.0.0') < 0) {
        $entries = array();
      if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) $entries[] = $file;

        closedir($handle);
      }
      } else {
        $entries = scandir($path);
        if ($entries === false) $entries = array(); // just in case scandir fail...
      }

    foreach ($entries as $entry) {
      if ($entry != '.' && $entry != '..') {
        deltree($path.'/'.$entry);
      }
    }

    return rmdir($path);
  } else {
      return unlink($path);
  }
}
?>

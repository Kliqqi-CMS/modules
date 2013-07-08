<?php
if(defined('mnminclude')){
	include_once (dirname(__FILE__) . '/../../libs/db.php');
	include_once('version_check_settings.php');
	
	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('admin_index');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {	
	
		global $main_smarty, $current_user;
		if($current_user->user_level == 'god'){
					
			$result = mysql_query("SELECT * FROM ". table_misc_data ." WHERE name='pligg_version'") or die(mysql_error());  
			$row = mysql_fetch_array( $result );

			$filename = '../modules/version_check/current.txt';
			$yourversion = $row['data'];

			// Let's make sure the file exists and is writable first.
			if (is_writable($filename)) {

				    if (!$handle = fopen($filename, 'w')) {
				         echo '<div style="position:absolute;left:300px;top:10px;display:block;background:#fff;padding:2px 5px 2px 5px;border:2px dashed #FFAC58;">Cannot open file $filename to write the Pligg version for Version Check Module!</div>';
				         exit;
				    }

				    // Write $yourversion to our opened file.
					// If there's an error
				    if (fwrite($handle, $yourversion) === FALSE) {
				        echo '<div style="position:absolute;left:300px;top:10px;display:block;background:#fff;padding:2px 5px 2px 5px;border:2px dashed #FFAC58;">Cannot write to the file $filename for the Version Check Module</div>';
				        exit;
				    }
					
				    // echo "Success, wrote $yourversion to file $filename for the Version Check Module";

				    fclose($handle);

			} else {
				    echo '<div style="position:absolute;left:300px;top:10px;display:block;background:#fff;padding:2px 5px 2px 5px;border:2px dashed #FFAC58;">The file $filename is not writable! Please create current.txt or chmod it to 777 in /modules/version_check/</div>';
			}

			$pliggfilename = '../modules/version_check/latest.txt';
			$pliggversion = "http://www.pligg.com/pliggversion.php";
			
			function url_exists($pliggversion) {
			    $hdrs = @get_headers($pliggversion);
			    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
			} 

			if (url_exists($pliggversion)) {
			$fh = fopen($pliggversion, 'r');
			$pliggversionoutput = fread($fh, 10);
			fclose($fh);
			
			$latestversion = $pliggversionoutput;

			// Let's make sure the file exists and is writable first.
			if (is_writable($pliggfilename)) {

				    if (!$handle = fopen($pliggfilename, 'w')) {
				         echo '<div style="position:absolute;left:300px;top:10px;display:block;background:#fff;padding:2px 5px 2px 5px;border:2px dashed #FFAC58;">Cannot open file $pliggfilename to write the Pligg version for Version Check Module!</div>';
				         exit;
				    }

				    // Write $latestversion to our opened file.
					// If there's an error
				    if (fwrite($handle, $latestversion) === FALSE) {
				        echo '<div style="position:absolute;left:300px;top:10px;display:block;background:#fff;padding:2px 5px 2px 5px;border:2px dashed #FFAC58;">Cannot write to the file $pliggfilename for the Version Check Module</div>';
				        exit;
				    }
					
				    // echo "Success, wrote $latestversion to file $pliggfilename for the Version Check Module";

				    fclose($handle);

			} else {
				    echo '<div style="position:absolute;left:300px;top:10px;display:block;background:#fff;padding:2px 5px 2px 5px;border:2px dashed #FFAC58;">The file $pliggfilename is not writable! Please create current.txt or chmod it to 777 in /modules/version_check/</div>';
			}

			} else {
			    echo '<div style="font-weight:bold;position:absolute;left:300px;top:10px;display:block;background:#fff;padding:4px 6px 4px 6px;border:2px dashed #FFAC58;">Could not connect to the Pligg server to check for the latest version.<br />Please try again later.</div>';
			}

			// define files to compare
			$file1 = "../modules/version_check/current.txt";
			$file2 = "../modules/version_check/latest.txt";

			$yourversion = strtoupper(dechex(crc32(file_get_contents($file1))));
			$pliggversion = strtoupper(dechex(crc32(file_get_contents($file2))));

			$current = (file_get_contents($file1));
			$latest = (file_get_contents($file2));

			if ($yourversion!=$pliggversion) {
			
			$main_smarty->assign('latest', $latest);
			$main_smarty->assign('current', $current);
			module_add_action_tpl('tpl_pligg_admin_legend_before', version_check_tpl_path . 'version_check_above_center.tpl');		
			
			} else {
			echo '';
			}
		}
	}
}
?>
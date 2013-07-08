{config_load file=pligg_update_lang_conf}

{php}
// Comment out the next line if you want to turn off 24 hour caching
include(mnminclude.'../modules/pligg_update/cache_start.php'); 
// This next file defines cURL functions
include(mnminclude.'../modules/pligg_update/curl.php'); 

// Loading the Pligg Download page to get the version number.
$url = 'http://www.pligg.com/download.php';
$data = FetchContent($url);
// I use the Registered date below because it is a constant number that won't change
$string_1 = '<h1>Pligg Version';
$string_2 = '</h1>';
$latestversion = extract_unit($data, $string_1, $string_2);
// Strip out HTML tags
$latestversion = strip_tags($latestversion);

$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
if ($result=mysql_query($sql)) {
  if ($row=mysql_fetch_row($result)) {
    $yourversion = $row[0];
  }
} else {
  echo "<!-- SQL Error ".mysql_error()." -->";
}

// Uncomment the next line to test the alert message
//$yourversion = '0.0.1';

if ($yourversion < $latestversion) {
print('<div style="float:left;position:absolute;top:0;left:0;width:100%;border-bottom:2px solid #DBDB99;background:#FFFFD4;">
	<div style="margin:0 auto;padding:5px 10px;color:#2E2E2D;">
		<h2 style="font-size:13px;font-weight:bold;">'.$this->_confs['PLIGG_UPDATE_NEW_VERSION_AVAILABLE'].' 
		 <a href="http://www.pligg.com/download.php">'.$this->_confs['PLIGG_UPDATE_NEW_VERSION_DOWNLOAD'] .' '.$latestversion.'</a></h2>
	</div>
</div>');
}

include(mnminclude.'../modules/pligg_update/cache_end.php'); 
{/php}

{config_load file=pligg_update_pligg_lang_conf}
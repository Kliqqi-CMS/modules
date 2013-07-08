<?php
//  This cache script is from http://www.addedbytes.com/php/caching-output-in-php/

// Settings
$cachedir = '../cache/'; // Directory to cache files in
$cachetime = 86400; // Seconds to cache files for
$cacheext = 'cache'; // Extension to give cached files (usually cache, htm, txt)

// Ignore List 
/*
$ignore_list = array(
'pligg.com/rss.php',
'pligg.com/demo/'
);
*/

$page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // Requested page
$cachefile = $cachedir . md5($page) . '.' . $cacheext; // Cache file to either load or create

 
$ignore_page = false;
for ($i = 0; $i < count($ignore_list); $i++) {
$ignore_page = (strpos($page, $ignore_list[$i]) !== false) ? true : $ignore_page;
}
 
$cachefile_created = ((@file_exists($cachefile)) and ($ignore_page === false)) ? @filemtime($cachefile) : 0;
@clearstatcache();
 
// Show file from cache if still valid
if (time() - $cachetime < $cachefile_created) {
	//ob_start('ob_gzhandler');
	@readfile($cachefile);
	//echo 'This Data is Cached';
	//ob_end_flush();
}
 
// If we're still here, we need to generate a cache file
ob_start();
 
?>
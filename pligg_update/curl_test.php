<html>
<head>
<title>Curl Test</head>
</head>
<body>
<div style="margin:0 auto;width:400px;"><div style="padding:20px;background:#eee;border:1px dashed #bbb;">
<?php
// The next 2 lines check if CURL is enabled in php.ini. If it is not enabled remove the semicolon from ;extension=php_curl.dll and restart Apache.
if (function_exists('curl_init')) {
  print '<strong>cURL library</strong> <span style="color:#3E8F3E;">is installed</span><br />';
} else {
  print '<strong>cURL library</strong> <span style="color:#CD1414;">is NOT installed</span><br />
		<p style="margin:3px 0;padding:0;">1. Open your php.ini file and remove the semicolon from the beginning of the line:</p>
			<div style="margin:0;padding:4px;background:#fff;">;extension=php_curl.dll</div>
		<p style="margin:3px 0;padding:0;">2. Restart Apache.</p><hr />
		<p style="margin:3px 0;padding:0;">You may need to install curl if it is not preinstalled on your web server. Either contact your web host for directions or to have a professional install it or follow these <a href="http://curl.haxx.se/docs/install.html">manual cURL installation instructions</a>. You may also be able to install cURL through a webpanel tool like Cpanel.</p><br />';
} 
if (function_exists('file_get_contents')) {
  print '<strong>file_get_contents function</strong> <span style="color:#3E8F3E;">is enabled</span>';
} else {
  print '<strong>file_get_contents function</strong> <span style="color:#CD1414;">is NOT enabled</span>';
} 

?>
</div></div>
</body>
</html>
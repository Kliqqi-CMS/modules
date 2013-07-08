<?php

function check_blacklist(){

	$ruleFile = blacklist_list_path;
	$text = $_SERVER['REMOTE_ADDR'];

	if(check_blacklist_rules($ruleFile, $text)){

		header("HTTP/1.0 404 Not Found");

		include(blacklist_lib_path . '../templates/404.php');

		die();

	}
}



function check_blacklist_rules($ruleFile, $text)
{
	if(!file_exists( $ruleFile)) { echo $ruleFile . " does not exist\n"; return false; }
	$handle = fopen( $ruleFile, "r");
	while (!feof($handle))
		{
		$buffer = fgets($handle, 4096);
		$splitbuffer = explode("####", $buffer);
		$expression = $splitbuffer[0];
		$explodedSplitBuffer = explode("/", $expression);
		$expression = strtoupper($explodedSplitBuffer[0]);
		if (strlen($expression) > 0)
			{
			if(preg_match("/".trim($expression)."/", $text))
				{ return true; }
			}
		}
	fclose($handle);
	return false;
}



?>

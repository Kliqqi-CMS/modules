<?php
// Now the script has run, generate a new cache file
$fp = @fopen($cachefile, 'w');

// save the contents of output buffer to the file
@fwrite($fp, ob_get_contents());
@fclose($fp);

ob_end_flush();
?>
{php}
$deny = array("111.111.111", "222.222.222", "122.160.234.98");
if (in_array ($_SERVER['REMOTE_ADDR'], $deny)) {
   header("location: http://www.pligg.com/spam/");
   exit();
} {/php}
<?php
include('../../config.php');

$id=$_REQUEST['id'];
$sql="SELECT featured_image FROM " . table_prefix . "featured WHERE featured_id=".$id."";
$news = $db->get_results($sql);
$news = object_2_array($news);
ob_end_clean();
ob_start();
header ("Content-type: image/jpeg");
echo $news[0]['featured_image'];
ob_end_flush();
exit;


?>
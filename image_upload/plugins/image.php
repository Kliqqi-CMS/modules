<?php

// Load settings
@include_once("../image_upload_settings.php");

# Get image location
$image_file = $_REQUEST['img'];
$image_path = module_imageupload_basedir."/".my_pligg_base.module_imageupload_imagedir.$image_file;
$image_url = module_imageupload_imagedir.$image_file;

$thisImage = getimagesize($image_path);
$thisImageWidth = $thisImage[0];
$thisImageHeight = $thisImage[1];

?>

<img border="0" width="<?php echo $thisImageWidth; ?>" height="<?php echo $thisImageHeight; ?>" src="/<?php echo $image_url; ?>" alt="" />

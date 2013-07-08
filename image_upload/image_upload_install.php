<?php
$GDArray = gd_info();
$gd_version = ereg_replace('[[:alpha:][:space:]()]+', '', $GDArray['GD Version']);

$module_info['name'] = 'Image Upload';
$module_info['desc'] = 'Allows an image (JPG, GIF, PNG, WBMP) to be attached to submission with a custom caption (optional; default is story title). GD '.$gd_version.' is currently installed.';
$module_info['version'] = 1.03;
?>
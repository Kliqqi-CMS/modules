<?php

// Load settings
@include_once("../image_upload_settings.php");

# Constants
define(MAX_WIDTH, (isset($_REQUEST['w']) ? $_REQUEST['w'] : 90));
define(MAX_HEIGHT,(isset($_REQUEST['h']) ? $_REQUEST['h'] : 90));

# Get Pligg Base
$thisfilepath = $_SERVER['PHP_SELF'];
$deep = substr_count($thisfilepath, "/");
$thisdirpath = explode("/", $thisfilepath);
$thisImagePath = $_SERVER['DOCUMENT_ROOT']."/".strtolower($thisdirpath[($deep - 4)])."/".module_imageupload_imagedir;

# Get image location
$imageFile = $_REQUEST['img'];
$imagePath = $thisImagePath.$imageFile;


# Load image
$img = null;
$ext = strtolower(end(explode('.', $imagePath)));
if ($ext == 'jpg' || $ext == 'jpeg') {
    $img = @imagecreatefromjpeg($imagePath);
} else if ($ext == 'png') {
    $img = @imagecreatefrompng($imagePath);
# Only if your version of GD includes GIF support
} else if ($ext == 'gif') {
    $img = @imagecreatefromgif($imagePath);
}

# If an image was successfully loaded, test the image for size
if ($img) {

    # Get image size and scale ratio
    $width = imagesx($img);
    $height = imagesy($img);
    $scale = min(MAX_WIDTH/$width, MAX_HEIGHT/$height);

        if (module_imageupload_thumb_square)
        {

                if($width> $height)
                {
                        $x = ceil(($width - $height) / 2 );
                        $width = $height;
                }

                $tmp_img = ImageCreatetruecolor(MAX_WIDTH,MAX_HEIGHT);
                @imagecopyresampled($tmp_img, $img, 0, 0, $x, $y, MAX_WIDTH, MAX_HEIGHT, $width, $height);
                @imagedestroy($img);
                $img = $tmp_img;

        } else {

                # If the image is larger than the max shrink it
                if ($scale < 1) {
                        $new_width = floor($scale*$width);
                        $new_height = floor($scale*$height);

                        # Create a new temporary image
                        $tmp_img = imagecreatetruecolor($new_width, $new_height);

                        # Copy and resize old image into new image
                        @imagecopyresampled($tmp_img, $img, 0, 0, 0, 0,
                                                         $new_width, $new_height, $width, $height);
                        @imagedestroy($img);
                        $img = $tmp_img;
                }
        }
}

# Create error image if necessary
if (!$img) {
    $img = imagecreate(MAX_WIDTH, MAX_HEIGHT);
    imagecolorallocate($img,0,0,0);
    $c = imagecolorallocate($img,70,70,70);
    imageline($img,0,0,MAX_WIDTH,MAX_HEIGHT,$c2);
    imageline($img,MAX_WIDTH,0,0,MAX_HEIGHT,$c2);
}

# Display the image
header("Content-type: image/jpeg");
imagejpeg($img);
@imagedestroy($img);
?>
<?php

// Outputs basic debug/process information
function image_upload_printdebug($text)
{
        global $main_smarty;

        include_once('image_upload_settings.php');

        if ((module_imageupload_debugmode) && ($main_smarty->get_template_vars(isadmin) == 1))
        {
                echo $text."<br/>";
        }
}

// Outputs basic debug/process information
function image_upload_printerrors($errorArray)
{
        include_once('image_upload_settings.php');

        $errorCount = count($errorArray);

        if (module_imageupload_showerrors)
        {
                echo "<p class=\"error\">".$errorCount." image error(s) found.<br/>";
                for ($i = 0; $i <= $errorCount - 1; $i++)
                {
                        echo "<strong>".$errorArray[$i]."</strong><br/>";
                }
                if (module_imageupload_error_post != "")
                {
                        echo "<br/>".module_imageupload_error_post."<br/>";
                }
                echo "</p><br/>";

        }
}


// Format file size
function formatbytes($val, $digits = 3, $mode = "SI", $bB = "B")
{
        $si = array("", "k", "M", "G", "T", "P", "E", "Z", "Y");
        $iec = array("", "Ki", "Mi", "Gi", "Ti", "Pi", "Ei", "Zi", "Yi");
        switch(strtoupper($mode))
        {
                case "SI" : $factor = 1000; $symbols = $si; break;
                case "IEC" : $factor = 1024; $symbols = $iec; break;
                default : $factor = 1000; $symbols = $si; break;
        }
        switch($bB)
        {
                case "b" : $val *= 8; break;
                default : $bB = "b"; break;
        }
        for($i=0;$i<count($symbols)-1 && $val>=$factor;$i++)
                $val /= $factor;
        $p = strpos($val, ".");
        if($p !== false && $p > $digits) $val = round($val);
    elseif($p !== false) $val = round($val, $digits-$p);
        return round($val, $digits) . " " . $symbols[$i] . $bB;
}


// Delete Image function
function image_upload_delete_handler()
{
        global $smarty, $main_smarty, $db;

        include_once('image_upload_settings.php');

        // Debug Info
        image_upload_printdebug("START: image_upload_delete_handler");
        image_upload_printdebug("Image delete process started.");

        // Variables
        $imagePath = module_imageupload_basedir.module_imageupload_imagedir;
        $linkID = $main_smarty->get_template_vars(submit_id);

        // Get Image File from DB - Edit entry mode
        if ($main_smarty->get_template_vars(module_imageupload_filename_field2) != "")
        {
                $imageFile = $main_smarty->get_template_vars(module_imageupload_filename_field2);

                // Debug Info
                image_upload_printdebug("File to delete = ".$imagePath.$imageFile);

                if (file_exists($imagePath.$imageFile))
                {
                        // Delete file
                        @unlink($imagePath.$imageFile);

                        // Debug Info
                        image_upload_printdebug("Image file deleted.");
                        image_upload_printdebug("Clearing ".module_imageupload_filename_field." field in database.");
                        image_upload_printdebug("SQL query = UPDATE ".table_links." SET ".module_imageupload_filename_field."='' WHERE link_id='$linkID'");

                        // Remove filename from DB
                        $db->query("UPDATE ".table_links." SET ".module_imageupload_filename_field."='' WHERE link_id='$linkID'");

                        // Remove caption from DB
                        $db->query("UPDATE ".table_links." SET ".module_imageupload_caption_field."='' WHERE link_id='$linkID'");

                        // Debug Info
                        image_upload_printdebug("Database updated.");
                } else {

                        // Debug Info
                        image_upload_printdebug("File not found... possibly deleted already.");

                }
        }

        // Debug Info
        image_upload_printdebug("END: image_upload_delete_handler");
}


// Preview Image function
function image_upload_preview_handler()
{
        global $smarty, $main_smarty, $link, $db;

        include_once('image_upload_settings.php');
        // Get Story Title
        $storyTitle = htmlentities(stripslashes($main_smarty->get_template_vars(title_short)));

        // Get Story ID
        //$storyID = htmlentities($main_smarty->get_template_vars(link_id));
        $storyID = $link->id;

        // Full server path to image directory
        $imagePath = module_imageupload_basedir.module_imageupload_imagedir;

        // Get Image filename
        if ($main_smarty->get_template_vars(module_imageupload_filename_field) == "")
        {
                $imageFile = module_imageupload_fullsize_prefix.$storyID.".jpg";
        } else {
                $imageFile = $main_smarty->get_template_vars(module_imageupload_filename_field);
        }

        // Get Caption
        if ($main_smarty->get_template_vars(module_imageupload_caption_field) != "")
        {
                $imageCaption = $main_smarty->get_template_vars(module_imageupload_caption_field);
        }

        // Debug Info
        image_upload_printdebug("START: image_upload_preview_handler");
        image_upload_printdebug("Story ID = ".$storyID);
        image_upload_printdebug("Image Path = ".$imagePath.$imageFile);
        image_upload_printdebug("Possible Image File = ".$imageFile);

        if (module_imageupload_customcaptions)
        {
                image_upload_printdebug("Using custom captions...");
                image_upload_printdebug("Custom caption = ".$imageCaption);
        } else {
                if (module_imageupload_img_caption)
                {
                        image_upload_printdebug("Image Caption = ".$storyTitle);
                } else {
                        image_upload_printdebug("Image Caption = Photo");
                }
        }

        // Let's be sure the file exists and hasn't been deleted for some reason
        if (file_exists($imagePath.$imageFile))
        {
                if (module_imageupload_customcaptions)
                {
                        $imageCaption = htmlentities(stripslashes($imageCaption));
                } else {
                        if (module_imageupload_img_caption)
                        {
                                $imageCaption = $storyTitle;
                        } else {
                                $imageCaption = "Photo";
                        }
                }

                if (!module_imageupload_usesmarty)
                {
                        echo module_imageupload_img_css_pre;

                        if (module_imageupload_use_thumb)
                        {
                                if (module_imageupload_use_thickbox)
                                {
                                        // Use Thickbox method
                                        echo module_imageupload_thickbox_pre1 . $imageFile . module_imageupload_thickbox_pre2 . $imageCaption . module_imageupload_thickbox_pre3 . module_imageupload_preview_pre . module_imageupload_thumb_generator . module_imageupload_thumb_generator_pre . $imageFile . module_imageupload_thumb_generator_post . module_imageupload_preview_post . module_imageupload_thickbox_post;
                                        echo module_imageupload_legendtext;
                                } else {
                                        // Use Direct link method
                                        echo module_imageupload_directlink_pre1 . $imageFile . module_imageupload_directlink_pre2 . $imageCaption . module_imageupload_directlink_pre2 . module_imageupload_preview_pre . module_imageupload_thumb_generator . module_imageupload_thumb_generator_pre . $imageFile . module_imageupload_thumb_generator_post . module_imageupload_preview_post . module_imageupload_directlink_post;
                                        echo module_imageupload_legendtext;
                                }
                        } else {
                                // Just show the fullsize image
                                echo module_imageupload_preview_pre.module_imageupload_imagedir.$imageFile.module_imageupload_preview_post;
                        }

                        echo module_imageupload_img_css_post;

                } else {

                        // Set Smarty Variables
                        $main_smarty->assign('module_imageupload_thumbnail_src', module_imageupload_thumb_generator.module_imageupload_thumb_generator_pre.$imageFile.module_imageupload_thumb_generator_post);
                        $main_smarty->assign('module_imageupload_image_filename', $imageFile);
                        $main_smarty->assign('module_imageupload_image_caption', $imageCaption);

                        // Debug Info
                        image_upload_printdebug("Smarty variables set for image filename and caption... no image will be displayed.  You must handle this yourself.");

                }

        } else {

                // Debug Info
                image_upload_printdebug("No image found to display.");

        }

        // Debug Info
        image_upload_printdebug("END: image_upload_preview_handler");
}


// Preview Image function (edit)
function image_upload_edit_preview_handler()
{
        global $main_smarty;

        include_once('image_upload_settings.php');

        // Try getting field info from edit entry
        $imageFile = $main_smarty->get_template_vars(module_imageupload_filename_field2);

        $imagePath = module_imageupload_basedir.module_imageupload_imagedir;

        // Get Story Title
        $storyTitle = htmlentities(stripslashes($main_smarty->get_template_vars(submit_title)));

        // Debug Info
        image_upload_printdebug("START: image_upload_edit_preview_handler");
        image_upload_printdebug("Image Path = ".$imagePath.$imageFile);

        // Let's be sure the file exists and hasn't been deleted for some reason
        if (($imageFile != "") && (file_exists($imagePath.$imageFile)))
        {
                if (module_imageupload_customcaptions)
                {
                        $imageCaption = stripslashes($main_smarty->get_template_vars(module_imageupload_caption_field2));
                } else {
                        if (module_imageupload_img_caption)
                        {
                                $imageCaption = $storyTitle;
                        } else {
                                $imageCaption = "Photo";
                        }
                }

                if (module_imageupload_use_thumb)
                {
                        if (module_imageupload_use_thickbox)
                        {
                                // Use Thickbox method
                                echo module_imageupload_thickbox_pre1 . $imageFile . module_imageupload_thickbox_pre2. $imageCaption . module_imageupload_thickbox_pre3 . module_imageupload_preview_pre . module_imageupload_thumb_generator . module_imageupload_thumb_generator_pre . $imageFile . module_imageupload_thumb_generator_post . module_imageupload_preview_post . module_imageupload_thickbox_post;
                        } else {
                                // Use Direct link method
                                echo module_imageupload_directlink_pre1 . $imageFile . module_imageupload_directlink_pre2. $imageCaption . module_imageupload_directlink_pre3 . module_imageupload_preview_pre . module_imageupload_thumb_generator . module_imageupload_thumb_generator_pre . $imageFile . module_imageupload_thumb_generator_post . module_imageupload_preview_post . module_imageupload_directlink_post;
                        }
                } else {
                        // Just show the fullsize image
                        echo module_imageupload_preview_pre.module_imageupload_imagedir.$imageFile.module_imageupload_preview_post;
                }
                echo "<br/>";

        } else {

                // Debug Info
                image_upload_printdebug("No image found to display.");

        }

        // Debug Info
        image_upload_printdebug("END: image_upload_edit_preview_handler");
}


// Image Upload form function
function image_upload_form_handler()
{
        global $smarty, $main_smarty;

        include_once('image_upload_settings.php');

        // Get Link ID
        $linkID = $main_smarty->get_template_vars('submit_id');

        // Debug Info
        image_upload_printdebug("START: image_upload_form_handler");
        image_upload_printdebug("Link ID #".$linkID);

        if ((isset($_REQUEST['delimg'])) && (strip_tags($_REQUEST['delimg'] == 1)))
        {
                // Debug Info
                image_upload_printdebug("Request to delete image received.");

                if ($linkID != "")
                {
                        // Debug Info
                        image_upload_printdebug("Attempting to delete image for link ID # ".$linkID);

                        // Initiate delete image function
                        image_upload_delete_handler();
                }

                $imageFile = "";

        } else {

                // Get image file name from DB -- edit entry
                $imageFile = $main_smarty->get_template_vars(module_imageupload_filename_field2);
        }

        echo "<p class=\"l-mid\">";
        echo "<label for=\"trackback\">".module_imageupload_field_title."</label>";

        if ($imageFile != "")
        {
                // Keep original image
                echo "<input type=\"hidden\" name=\"".module_imageupload_filename_field."\" value=\"".$imageFile."\" />";

                // Show image
                image_upload_edit_preview_handler();

                echo "<a href=\"".$_SERVER['PHP_SELF']."?id=".$_REQUEST['id']."&delimg=1\" onclick=\"return confirm('Are you sure you want to delete this image and caption?')\">Delete Image</a>";
        } else {
                // Provide form details to upload image
                echo "<span class=\"form-note\">".module_imageupload_field_instructions."</span><br />";
                echo "<input type=\"file\" name=\"".module_imageupload_filename_field."\" id=\"".module_imageupload_filename_field."\" size=\"20\" class=\"form-full\" />";
        }

        echo "</p><br/>";

        if (module_imageupload_customcaptions)
        {
                $imageCaption = htmlentities(stripslashes($main_smarty->get_template_vars(module_imageupload_caption_field2)));

                // Provide form details to upload image
                echo "<p class=\"l-mid\">";
                echo "<label for=\"trackback\">".module_imageupload_caption_title."</label>";
                echo "<span class=\"form-note\">".module_imageupload_caption_instructions."</span><br />";
                echo "<input type=\"text\" name=\"".module_imageupload_caption_field."\" id=\"".module_imageupload_caption_field."\" value=\"".$imageCaption."\" size=\"".module_imageupload_customcaption_fieldlength."\" maxlength=\"".module_imageupload_customcaption_length."\" />";
                echo "</p><br/>";
        }

        // Debug Info
        image_upload_printdebug("END: image_upload_form_handler.");
}


// Upload Image function
function image_upload_process_handler()
{
        global $db, $smarty, $main_smarty, $linkres;

        include_once('image_upload_settings.php');

        $module_error = false;

        // Debug Info
        image_upload_printdebug("START: image_upload_process_handler.");

        // Get the image real name, temp name, submission ID
        $imageFilename = $_FILES[module_imageupload_filename_field]['name'];
        $sourceFile = $_FILES[module_imageupload_filename_field]['tmp_name'];

        if ($sourceFile != "")
        {
                if (isset($_POST['id']))
                {
                        $linkID = strip_tags($_POST['id']);
                } else {
                        $module_error = true;
                        $module_errors[] = "- Submission entry id not found.";
                }

                // Get new names
                $destFile = module_imageupload_fullsize_prefix.$linkID;
                $destPath = module_imageupload_basedir.module_imageupload_imagedir;

                // Get image dimensions
                $thisImage = getimagesize($sourceFile);
                $thisImageFileSize = filesize($sourceFile);
                $thisImageWidth = $thisImage[0];
                $thisImageHeight = $thisImage[1];
                $thisImageMimeType = $thisImage['mime'];

                // Debug Info
                image_upload_printdebug("Original image filename = ".$imageFilename);
                image_upload_printdebug("Temp image filename = ".$sourceFile);
                image_upload_printdebug("Link ID = ".$linkID);
                image_upload_printdebug("Raw File size = ".$thisImageFileSize);
                image_upload_printdebug("Formatted File size = ".formatbytes($thisImageFileSize));
                image_upload_printdebug("Max allowed file size = ".(module_imageupload_upload_maxsize * 1000) * 1000);
                image_upload_printdebug("Max allowed image x height = ".module_imageupload_upload_maxwidth."x".module_imageupload_upload_maxheight);
                image_upload_printdebug("Destination file = ".$destFile);
                image_upload_printdebug("Destination path = ".$destPath);
                image_upload_printdebug("Image data = ".$thisImageWidth."x".$thisImageHeight." (".$thisImageMimeType.")");

                // Test image against max width / height constraints
                if (($thisImageWidth > module_imageupload_upload_maxwidth) || ($thisImageHeight > module_imageupload_upload_maxheight))
                {
                        $module_error = true;
                        $module_errors[] = "- This image exceeds the ".module_imageupload_upload_maxwidth."x".module_imageupload_upload_maxheight." (width x height) maximum.";
                }

                // Test image against max file size constraints
                if ($thisImageFileSize > ((module_imageupload_upload_maxsize * 1000) * 1000))
                {
                        $module_error = true;
                        $module_errors[] = "- This image exceeds the allowed file size of ".module_imageupload_upload_maxsize."MB";
                }

                // Determine Mime Type
                if (!$module_error)
                {
                        switch ($thisImageMimeType)
                        {
                                case "image/jpeg":
                                        $module_error = false;
                                        $tempExt = ".jpg";
                                        break;
                                case "image/gif":
                                        $module_error = false;
                                        $tempExt = ".gif";
                                        break;
                                case "image/png":
                                        $module_error = false;
                                        $tempExt = ".png";
                                        break;
                                case "image/wbmp":
                                        $module_error = false;
                                        $tempExt = ".wbmp";
                                        break;
                                default:
                                        if ($imageAttached)
                                        {
                                                $module_error = true;
                                                $module_errors[] = "- Unknown image type.  Only JPG, PNG, GIF and WMBP allowed.";
                                        }
                        }
                }

                // Process file, remove re-posts, and convert if necessary
                if (!$module_error)
                {
                        if (file_exists($destPath.$destFile.$tempExt))
                        {
                                @unlink($destPath.$destFile.$tempExt);
                        }

                        // Convert image if not JPG
                        switch ($thisImageMimeType)
                        {
                                case "image/jpeg":
                                        // No conversion needed

                                        // Debug Info
                                        image_upload_printdebug("No image conversion necessary.");

                                        if(!move_uploaded_file($sourceFile, $destPath.$destFile.$tempExt))
                                        {
                                                $module_error = true;
                                                $module_errors[] = "- Error processing image.";
                                                // Delete original
                                                @unlink($destPath.$destFile.$tempExt);
                                        }
                                        break;

                                case "image/gif":
                                case "image/png":
                                case "image/wbmp":
                                        // Include image converter class
                                        @include_once('plugins/class.imageconverter.inc.php');

                                        // Debug Info
                                        image_upload_printdebug("Conversion of image file beginning...");

                                        if(move_uploaded_file($sourceFile, $destPath.$destFile.$tempExt))
                                        {
                                                $tempDest = $destPath.$destFile.$tempExt;

                                                // Convert image to JPG
                                                $img = new ImageConverter($tempDest, "jpg", $destPath);
                                                @unlink($tempDest);

                                                // Get converted image dimensions
                                                $destImage = getimagesize($destPath.$destFile.".jpg");
                                                $destImageWidth = $destImage[0];
                                                $destImageHeight = $destImage[1];
                                                $destImageMimeType = $destImage['mime'];

                                                @unlink($tempDest);

                                                // Debug Info
                                                image_upload_printdebug("Dest Filename = ".$destPath.$destFile.".jpg");
                                                image_upload_printdebug("Dest image width = ".$destImageWidth);
                                                image_upload_printdebug("Dest image height = ".$destImageHeight);
                                                image_upload_printdebug("Dest image mime type = ".$destImageMimeType);

                                        } else {
                                                // Debug Info
                                                image_upload_printdebug("Unable to move source file to dest for conversion.  Deleting source file.");

                                                $module_error = true;
                                                $module_error_message = module_imageupload_errorcode_2;
                                                // Delete original
                                                @unlink($sourceFile);
                                        }
                                        break;
                        }
                }

                // Check if we need to resize image to meet fullsize width or height setting
                if (!$module_error)
                {
                        // Debug Info
                        image_upload_printdebug("Checking image dimensions for possible resizing.");

                        $destFile .= ".jpg";

                        # Check to see if the image needs to be rescaled.
                        switch (module_imageupload_fullsize_maxtoggle)
                        {
                                case "w":
                                        if ($thisImageWidth > module_imageupload_fullsize_width)
                                        {
                                                // Include image resize functions
                                                include_once('plugins/class.thumbnail.inc.php');

                                                // Debug Info
                                                image_upload_printdebug("Image is wider than setting, attempting to reduce.");
                                                image_upload_printdebug("Dest Path = ".$destPath);
                                                image_upload_printdebug("Dest File = ".$destFile);

                                                $convertImage = new thumbnail($destPath.$destFile);
                                                $convertImage->size_auto(module_imageupload_fullsize_width);
                                                $convertImage->jpeg_quality(module_imageupload_jpg_quality);
                                                $convertImage->save($destPath.$destFile, module_imageupload_gdversion);

                                                $destImage = getimagesize($destPath.$destFile);
                                                $destImageWidth = $destImage[0];
                                                $destImageHeight = $destImage[1];

                                                // Debug Info
                                                image_upload_printdebug("Converted image is ".$destImageWidth."x".$destImageHeight);

                                        }
                                        break;

                                case "h":
                                        if ($thisImageHeight > module_imageupload_fullsize_height)
                                        {
                                                // Include image resize functions
                                                include_once('plugins/class.thumbnail.inc.php');

                                                // Debug Info
                                                image_upload_printdebug("Image is taller than setting, attempting to reduce.");
                                                image_upload_printdebug("Dest Path = ".$destPath);
                                                image_upload_printdebug("Dest File = ".$destFile);

                                                $convertImage = new thumbnail($destPath.$destFile);
                                                $convertImage->size_auto(module_imageupload_fullsize_height);
                                                $convertImage->jpeg_quality(module_imageupload_jpg_quality);
                                                $convertImage->save($destPath.$destFile, module_imageupload_gdversion);

                                                getimagesize($destPath.$destFile);
                                                $destImageWidth = $destImage[0];
                                                $destImageHeight = $destImage[1];

                                                // Debug Info
                                                image_upload_printdebug("Converted image is ".$destImageWidth."x".$destImageHeight);
                                        }
                                        break;

                        }
                }

                if (!$module_error)
                {
                        // Debug Info
                        image_upload_printdebug("Updating database with image filename.");

                        // Update database
                        $db->query("UPDATE ".table_links." set ".module_imageupload_filename_field."='$destFile' WHERE link_id='$linkID'");

                        if (module_imageupload_customcaptions)
                        {
                                // Debug Info
                                image_upload_printdebug("Using custom image caption.");

                                $imageCaption = $_POST[module_imageupload_caption_field];

                                if ($imageCaption != "")
                                {
                                        // Debug Info
                                        image_upload_printdebug("Custom image caption: ".$imageCaption);

                                        $imageCaption = strip_tags($imageCaption);
                                        $imageCaption = addslashes($imageCaption);

                                        // Debug Info
                                        image_upload_printdebug('Updating database with custom image caption');

                                        // Update database
                                        $db->query("UPDATE ".table_links." set ".module_imageupload_caption_field."='".$imageCaption."' WHERE link_id='$linkID'");
                                }
                        }

                        // Debug Info
                        image_upload_printdebug("Database updated.");

                } else {

                        @unlink($sourceFile);
                        @unlink($destPath.$destFile.".jpg");
                        // Output error messages
                        image_upload_printerrors($module_errors);

                }
        }

        // Debug Info
        image_upload_printdebug("END: image_upload_process_handler.");

}

?>
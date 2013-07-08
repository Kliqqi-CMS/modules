<?php

// the path to the module. the probably shouldn't be changed unless you rename the image_upload folder(s)
define('image_upload_path', my_pligg_base . '/modules/image_upload/');

// the path for smarty / template lite plugins
define('image_upload_plugins_path', my_pligg_base . '/modules/image_upload/plugins');

// Image Base Dir
define('module_imageupload_basedir', $_SERVER['DOCUMENT_ROOT'].my_pligg_base."/");


/* ------ Configuration Settings -------------------------- */
// Debug Mode
define('module_imageupload_debugmode', false);                                            # Make this true to see what is happening behind the scenes -- must be logged in as an Admin.  Turn off for production environments.


// Errors and Max Constraints for uploads
define('module_imageupload_error_post', 'You can still submit this entry and edit it later with a smaller image or click MODIFY to try a different image.');                                                                                                        # Error message post text
define('module_imageupload_upload_maxwidth', 1200);                                        # Maximum allowed image width
define('module_imageupload_upload_maxheight', 1200);                                # Maximum allowed image height
define('module_imageupload_upload_maxsize', 0.5);                                                # Maximum allowed image size (in MB)


// Module Runtime Settings
define('module_imageupload_showerrors', true);                                            # Make this true to output user error messages
define('module_imageupload_imagedir', 'images/');                                        # Name of your images directory; include trailing slash; must be writeables
define('module_imageupload_gdversion', 2);                                                        # Your GD version installed
define('module_imageupload_jpg_quality', 80);                                                # 1-100 (JPG Quality for resized images)
define('module_imageupload_use_thickbox', true);                                        # Use Thickbox for fullsize overlay?
define('module_imageupload_use_thumb', true);                                                # Show thumbnail in story (true) or fullsize (false)
define('module_imageupload_thumb_width', 60);                                                # Maximum thumbnail width
define('module_imageupload_thumb_height', 60);                                                # Maximum thumbnail height
define('module_imageupload_thumb_square', false);                                        # True to show thumbnails as squares (assuming thumb W = H), false to
                                                                                                                                        # scale thumbnail to fit within thumb WxH space
define('module_imageupload_fullsize_prefix', 'img_');                                # Fullsize image filename prefix
define('module_imageupload_fullsize_maxtoggle', 'w');                                # Fullsize image max toggle;
                                                                                                                                        # w (resize image if width is larger than fullsize width
                                                                                                                                        # h (resize image if heighti s larger than fullsize height
define('module_imageupload_fullsize_width', 800);                                        # Fullsize image width (maximum)
define('module_imageupload_fullsize_height', 800);                                        # Fullsize image height (maximum)


// Internal Pligg Field Names
define('module_imageupload_filename_field', 'link_field1');                        # This should be link field you've enabled for photo uploads.
define('module_imageupload_filename_field2', 'submit_link_field1');        # This should be the same number as the above variable.
define('module_imageupload_caption_field', 'link_field2');                        # If custom caption enabled, this is the extrafield to hold it.
define('module_imageupload_caption_field2', 'submit_link_field2');         # This should be the same number as the above variable.


// Custom Image Caption
define('module_imageupload_customcaptions', true);                                        # Set to false to allow user to enter caption; true to use story title or 'Photo' as defined below in module_imageupload_img_caption
define('module_imageupload_customcaption_fieldlength', 60);                        # Text field max chars
define('module_imageupload_customcaption_maxlength', 255);                        # Text field max chars


// Image Caption defaults
define('module_imageupload_img_caption', true); # If no custom captions is used then set to true to use story title, false to use 'Photo'


// Form Elements
define('module_imageupload_field_title', 'Photo Upload (optional):');                                        # Field title for photo upload
define('module_imageupload_field_instructions', 'Select a JPG, GIF, PNG or WBMP photo from your computer (Max '.module_imageupload_upload_maxsize.'MB and '.module_imageupload_upload_maxwidth.'x'.module_imageupload_upload_maxheight.' dimensions');        # Field instructions
define('module_imageupload_caption_title', 'Photo caption (optional):'); # Field title for captions
define('module_imageupload_caption_instructions', 'Please enter a caption for this photo (Max. '.module_imageupload_customcaption_maxlength.' characters)');        # Field instructions for caption



// Smarty Info
define('module_imageupload_usesmarty', false);   # Set to false to have the module show the thumbnail, true to hide thumbnails and set smarty variable instead.  You will need to handle the actual display of the thumbnails yourself.



// Module Image Styling / Linking
define('module_imageupload_legendtext', '');                                                                                        # Legend text which appears below thumbnail


// Thumbnail Generator Settings (Do not change unless you have to)
define('module_imageupload_thumb_generator', image_upload_plugins_path.'/thumb.php');        # PHP Script to handle dynamic thumbnail creation
define('module_imageupload_thumb_generator_pre', '?img=');                                                                # Image name supplied to script
define('module_imageupload_thumb_generator_post', "&w=".module_imageupload_thumb_width."&h=".module_imageupload_thumb_height);                        # Image settings


// Styling
define('module_imageupload_preview_pre', '<img border="1" src="');                                                # Pre Styling for Thumbnail or fullsize
define('module_imageupload_preview_post', '" alt="" />');                                                                # Post styling for thumbnail or fullsize
define('module_imageupload_img_css_pre', '<div style="float:right; border: #e4e4e4 solid 2px; padding: 1px;">');                                                                                                                                                                # Pre CSS Styling
define('module_imageupload_img_css_post', '</div>');                                                                        # Post CSS Styling


// Thickbox
define('module_imageupload_thickbox_pre1', '<a href="'.my_pligg_base.'/'.module_imageupload_imagedir);        # Thickbox Pre 1 string
define('module_imageupload_thickbox_pre2', '" title="');                                                                # Thickbox Pre 2 string
define('module_imageupload_thickbox_pre3', '" rel="gb_page_center[auto, auto]">');                                                # Thickbox Pre 3 string
define('module_imageupload_thickbox_post', '</a>');                                                                                # Thickbox Post string


// No Thickbox
define('module_imageupload_directlink_pre1', '<div style="float:right; border: #e4e4e4 solid 2px; padding: 1px;"><a href="'.my_pligg_base.'/'.module_imageupload_imagedir);        # Directlink Pre 1 string
define('module_imageupload_directlink_pre2', '" title="');                                                                # Directlink Pre 2 string
define('module_imageupload_directlink_pre3', '">');                                                                                # Directlink Pre 3 string
define('module_imageupload_directlink_post', '</a></div>');                                                                        # Directlink Post string


// Really don't touch anything past this line.
if (module_imageupload_use_thickbox)
{
        if(is_object($main_smarty)){
                $main_smarty->assign('load_thickbox', 1);
        }
}

if(is_object($main_smarty))
{
        $main_smarty->assign('image_upload_path', image_upload_path);
}

?>
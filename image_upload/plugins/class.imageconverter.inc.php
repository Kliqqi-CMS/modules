<?php
######
## ImageConverter
## Convert various image type that supported by PHP
## ie: JPEG, GIF, PNG, SWF, WBMP
## Version 0.9
## 15th January 2005
#######
## Author: Huda M Elmatsani
## Email : 	justhuda ## netscape ## net
#######
## Copyright (c) 2005 Huda M Elmatsani All rights reserved.
## This program is free for any purpose use.
########
## Description:
## Casting image type from one type to another is useful for
## web experience, because each type has advantage and disadvantage.
## With JPEG you can reduce the quality to get affordable filesize,
## with GIF you can make it transparent or make an animation,
## with PNG you can avoid from GIF restriction,
## with SWF you can protect your image or make a movie.
## This class helps you doing this various conversion within a single line.
##
## Requirements:
## - GD Library
## - Ming Library
##
## Sintax:
## new ImageConverter( original_file, converted_file_type [, output]);
##
## note: output = 1 means the image is displayed to browser
##       output = 0 or no argument means the image is saved
##
## new ImageConverter('jakarta.png','jpg') => convert to JPEG
## new ImageConverter('jakarta.jpg','gif') => convert to GIF
## new ImageConverter('jakarta.gif','png') => convert to PNG
## new ImageConverter('jakarta.gif','swf') => convert to SWF
## 
##
## Example:
## new ImageConverter('jakarta.gif','jpg',1)
## the result is showed to the browser.
##
## new ImageConverter('aceh.png','swf');
## the result is saved to the disk with name 'aceh.swf'
##
## Limitation:
## Can not convert SWF file to other type :(
##
##########

class ImageConverter {

	var $imtype;
	var $im;
	var $imname;
	var $imconvertedtype;
	var $output;
	var $finalFilePath;
	
	function imageConverter() {

		/* parse arguments */
		$numargs 		= func_num_args();
		$imagefile  	= func_get_arg(0);
		$convertedtype 	= func_get_arg(1);
		$this->finalFilePath	= func_get_arg(2);
		$output 		= 0;
		if($numargs > 3) $this->output 	= func_get_arg(3);

		/* ask the type of original file */
		$fileinfo  		= pathinfo($imagefile);
		$imtype 		= $fileinfo["extension"];
		$this->imname 	= basename($fileinfo["basename"],".".$imtype);
		$this->imtype	= $imtype;

		/* create the image variable of original file */
		switch ($imtype) {
		case "gif":
			$this->im 	=  imageCreateFromGIF($imagefile);
			break;
		case "jpg":
			$this->im 	=  imageCreateFromJPEG($imagefile);
			break;
		case "png":
			$this->im 	=  imageCreateFromPNG($imagefile);
			break;
		case "wbmp":
			$this->im 	=  imageCreateFromWBMP($imagefile);
			break;
		/*
		mail me if you have/find this functionality bellow  */
		/*
		case "swf":
			$this->im 	= $this->imageCreateFromSWF($imagefile);
			break;
		*/
		}

		/* convert to intended type */
		$this->convertImage($convertedtype);
	}

	function convertImage($type) {

		/* check the converted image type availability,
		   if it is not available, it will be casted to jpeg :) */
		$validtype = $this->validateType($type);


		if($this->output) {

			/* show the image  */
			switch($validtype){
				case 'jpeg' :
				case 'jpg' 	:
					header("Content-type: image/jpeg");
					if($this->imtype == 'gif' or $this->imtype == 'png') {
						$image = $this->replaceTransparentWhite($this->im);
						imageJPEG($image);
					} else
					imageJPEG($this->im);
					break;
				case 'gif' :
					header("Content-type: image/gif");
					imageGIF($this->im);
					break;
				case 'png' :
					header("Content-type: image/png");
					imagePNG($this->im);
					break;
				case 'wbmp' :
					header("Content-type: image/vnd.wap.wbmp");
					imageWBMP($this->im);
					break;
				case 'swf' :
					header("Content-type: application/x-shockwave-flash");
					$this->imageSWF($this->im);
					break;
			}
			
			// Memory cleanup
			@imagedestroy($this->im);

		} else {
			/* save the image  */
			switch($validtype){
				case 'jpeg' :
				case 'jpg' 	:
					if($this->imtype == 'gif' or $this->imtype == 'png') {
						/* replace transparent with white */
						$image = $this->replaceTransparentWhite($this->im);
						imageJPEG($image,$this->finalFilePath.$this->imname.".jpg");
					} else
					imageJPEG($this->im,$this->finalFilePath.$this->imname.".jpg");
					break;
				case 'gif' :
					imageGIF($this->im,$this->finalFilePath.$this->imname.".gif");
					break;
				case 'png' :
					imagePNG($this->im,$this->finalFilePath.$this->imname.".png");
					break;
				case 'wbmp' :
					imageWBMP($this->im,$this->finalFilePath.$this->imname.".wbmp");
					break;
				case 'swf' :
					$this->imageSWF($this->im,$this->finalFilePath.$this->imname.".swf");
					break;

			}
			
			// Memory cleanup
			@imagedestroy($this->im);

		}
	}

	/* convert image to SWF  */
	function imageSWF() {

		/* parse arguments */
		$numargs = func_num_args();
		$image   = func_get_arg(0);
		$swfname = "";
		if($numargs > 1) $swfname = func_get_arg(1);

		/* image must be in jpeg and
		   convert jpeg to SWFBitmap
		   can be done by buffering it */
		ob_start();
		imagejpeg($image);
		$buffimg = ob_get_contents();
		ob_end_clean();

		$img 	= new SWFBitmap($buffimg);

		$w = $img->getWidth();
		$h = $img->getHeight();

		$movie = new SWFMovie();
		$movie->setDimension($w, $h);
		$movie->add($img);

		if($swfname)
			$movie->save($swfname);
		else
			$movie->output;

	}


	/* convert SWF to image  */
	function imageCreateFromSWF($swffile) {

		die("No SWF converter in this library");

	}

	function validateType($type) {
		/* check image type availability*/
		$is_available = FALSE;

		switch($type){
			case 'jpeg' :
			case 'jpg' 	:
				if(function_exists("imagejpeg"))
				$is_available = TRUE;
				break;
			case 'gif' :
				if(function_exists("imagegif"))
				$is_available = TRUE;
				break;
			case 'png' :
				if(function_exists("imagepng"))
				$is_available = TRUE;
				break;
			case 'wbmp' :
				if(function_exists("imagewbmp"))
				$is_available = TRUE;
				break;
			case 'swf' :
				if(class_exists("swfmovie"))
				$is_available = TRUE;
				break;
		}
		if(!$is_available && function_exists("imagejpeg")){
			/* if not available, cast image type to jpeg*/
			return "jpeg";
		}
		else if(!$is_available && !function_exists("imagejpeg")){
		   die("No image support in this PHP server");
		}
		else
			return $type;
	}

	function replaceTransparentWhite($im){
		$src_w = ImageSX($im);
		$src_h = ImageSY($im);
		$backgroundimage = imagecreatetruecolor($src_w, $src_h);
		$white =  ImageColorAllocate ($backgroundimage, 255, 255, 255);
		ImageFill($backgroundimage,0,0,$white);
		ImageAlphaBlending($backgroundimage, TRUE);
		imagecopy($backgroundimage, $im, 0,0,0,0, $src_w, $src_h);
		return $backgroundimage;
	}
}
?>
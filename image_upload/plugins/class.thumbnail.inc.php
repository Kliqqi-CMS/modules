<?

class thumbnail
{
	var $img;

	function thumbnail($imgfile)
	{
		//detect image format
		$this->img["format"]=ereg_replace(".*\.(.*)$","\\1",$imgfile);
		$this->img["format"]=strtoupper($this->img["format"]);
		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") 
		{
			//JPEG
			$this->img["format"]="JPEG";
			$this->img["src"] = ImageCreateFromJPEG ($imgfile);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			$this->img["format"]="PNG";
			$this->img["src"] = ImageCreateFromPNG ($imgfile);
		} else {
			//DEFAULT
			exit();
		}

		@$this->img["lebar"] = imagesx($this->img["src"]);
		@$this->img["tinggi"] = imagesy($this->img["src"]);

		//default quality jpeg
		$this->img["quality"]=75;
	}

	function size_auto($size=100)
	{
		//size
		if ($this->img["lebar"]>=$this->img["tinggi"]) 
		{
    		$this->img["lebar_thumb"]=$size;
    		@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		} else {
	    	$this->img["tinggi_thumb"]=$size;
    		@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
 		}
	}

	function jpeg_quality($quality=75)
	{
		//jpeg quality
		$this->img["quality"]=$quality;
	}

	function show($gd_version)
	{
		@Header("Content-Type: image/".$this->img["format"]);

 		if($gd_version==2)
		{
			$this->img["des"] = imagecreatetruecolor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
			@imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"],$this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);
	    }

		if($gd_version==1)
		{
			$this->img["des"] = imagecreate($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);

  		    @imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);
		}

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") 
		{
			//JPEG
			imageJPEG($this->img["des"],"", $this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"]);
		}
	}

	function save($save="", $gd_version)
	{
		if($gd_version==2)
		{
			$this->img["des"] = imagecreatetruecolor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);

  		    @imagecopyresampled ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);
		}

		if($gd_version==1)
		{
			$this->img["des"] = imagecreate($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);

			@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);
		}

 		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") 
 		{
			//JPEG
			imageJPEG($this->img["des"],"$save", $this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"],"$save");
		}
		
		// Memory cleanup
		@imageDestroy($this->img["des"]);
	}
}

?>
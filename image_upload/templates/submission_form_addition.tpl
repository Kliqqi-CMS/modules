{config_load file=$image_upload_lang_conf}

<p class="l-mid">
	<label for="{#PLIGG_MESSAGING_From#}">
		{#PLIGG_IMAGEUPLOAD_Field_Description#}
	</label>
				
	<input type="text" name="link_field{#module.imageupload.filename_field#}" id="link_field{#module.imageupload.filename_field#}" value="" size="20" class="form-full" />
	
	{if PLIGG_IMAGEUPLOAD_Field_Note neq ""}
		{#PLIGG_IMAGEUPLOAD_Field_Note#}
	{/if}
</p>		
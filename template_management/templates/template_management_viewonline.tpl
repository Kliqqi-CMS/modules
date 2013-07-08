{config_load file=template_management_lang_conf}

<fieldset>
	<legend><img src="{$template_management_image_path}layout.png" align="absmiddle"/> {#PLIGG_Template_Management_BreadCrumb#}</legend>

		{php}
			$url = 'http://www.pligg.com/templates.php?view=module&tmver=0.13&referrer=' . my_pligg_base . '/' . URL_template_management;
			$r = new HTTPRequest($url);
			echo $r->DownloadToString();
		{/php}
</fieldset>
{config_load file=template_management_pligg_lang_conf}

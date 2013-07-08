{checkActionsTpl location="tpl_pligg_module_mootools_share_start"}
<!-- Start MooTools Share -->
{config_load file=mootools_share_lang_conf}
<div class="share-storylist">
	<a class="tool share" href="{$my_base_url}{$story_url}">{#Mootools_Share_Share#}</a>&nbsp; |&nbsp; 
	<div class="share-hover">
		<input type="text" value="{$my_base_url}{$story_url}" class="share-diggbar-url" onfocus="this.select()" readonly>
		<ul class="share-actions">
			<li class="twitter">
				<a href="http://twitter.com/home?status={$title_short}:%20{$my_base_url}{$story_url}" target="_blank">{#Mootools_Share_Twitter#}</a>
			</li>
			<li class="email">
				<a href="mailto:?subject={$title_short}:%20{$my_base_url}{$story_url}">{#Mootools_Share_Email#}</a>
			</li>
			<li class="facebook">
				<a href="http://www.facebook.com/share.php?u=http%3A%2F%2Ffb-share-control.com%2F%3Fu%3D{$my_base_url}{$story_url}%26d%3D{php}$the_content=$this->get_template_vars('story_content');echo substr($the_content, 0, 200);{/php}%26t%3D{$title_short}%26i%3D" target="_blank">{#Mootools_Share_Facebook#}</a>
			</li>
		</ul>
	</div>
</div>
<!-- End MooTools Share -->
{checkActionsTpl location="tpl_pligg_module_mootools_share_end"}
{config_load file=mootools_share_pligg_lang_conf}
{*
	{section name=fnews loop=$featured}
		<a href="{$featured[fnews].link_url}">{$featured[fnews].link_title}</a>
		{$featured_path}featured.php?id={$featured[fnews].featured_id}
		{$featured[fnews].link_summary}
	{/section} 
*}			

<div id="headline" class="featured_headline">
	<img width="75px" height="21px" alt="" src="{$my_pligg_base}/templates/{$the_template}/images/headline.png"/>

	{section name=featured loop=$news max=1 step=-1}
		<div class="title"><a href="{$featured[featured].link_url}">{$news[featured].featured_link_title}</a></div>
		<div class="meta">Submitted 
			{php}
				$timestamp = $this->_vars['featured'][$this->_sections['featured']['index']]['link_date'];
				list($year, $month, $day) = split("-", $timestamp);
				$timestamp = date('F d, Y', mktime(0, 0, 0, $month, $day, $year));
				echo $timestamp;
			{/php}
			| {$featured[featured].link_votes} votes | {$featured[featured].link_comments} comments 
		</div> 
		<div style="float:left;margin:0 2px 1px 0;">
			<a href="{$featured[featured].link_url}"><img style="border:1px solid #ccc;padding:2px;" src="{$my_pligg_base}/modules/featured/phpthumb/phpThumb.php?src={$my_base_url}{$my_pligg_base}%2fmodules%2ffeatured%2ffeatured.php%3fid%3d{$featured[featured].featured_id}&w=300" alt=""></a>
		</div>
		<p>{$news[featured].featured_description}</p>
		<p><a title="Permanent Link to {$news[featured].featured_link_title}" rel="bookmark" href="{$featured[featured].link_url}">Read the full story &raquo;</a></p>
		<div class="clear;"> </div>
	{/section}
</div>

<div id="featured" class="featured_past">
	<img width="72px" height="17px" alt="" src="{$my_pligg_base}/templates/{$the_template}/images/featured.png" style="width: 72px; height: 17px;"/>
	{section name=featured loop=$news step=-1 start=-2 max=3}
		<div class="clearfloat">
			<a href="{$featured[featured].link_url}" rel="bookmark" title="Permanent Link to {$news[featured].featured_link_title}">
			<img class="left" src="{$my_pligg_base}/modules/featured/phpthumb/phpThumb.php?src={$my_base_url}{$my_pligg_base}%2fmodules%2ffeatured%2ffeatured.php%3fid%3d{$featured[featured].featured_id}&w=100" alt="">
			</a>
			<div class="info">
				<a class="title" href="{$featured[featured].link_url}">{$news[featured].featured_link_title}</a>
				<div class="meta">Submitted 
					{php}
						$timestamp = $this->_vars['featured'][$this->_sections['featured']['index']]['link_date'];
						list($year, $month, $day) = split("-", $timestamp);
						$timestamp = date('M d, Y', mktime(0, 0, 0, $month, $day, $year));
						echo $timestamp;
					{/php}
					| {$featured[featured].link_votes} votes
				<p>{$news[featured].featured_description|substr:0:125}...</p>
				</div> 
			</div>
		</div>
	{/section}
</div>

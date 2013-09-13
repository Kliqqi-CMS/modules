{*
	{section name=fnews loop=$featured}
		<a href="{$featured[fnews].link_url}">{$featured[fnews].link_title}</a>
		{$featured_path}featured.php?id={$featured[fnews].featured_id}
		{$featured[fnews].link_summary}
	{/section} 
*}

{literal}
<style type="text/css">
hr.soften {
	margin-top:12px;
	margin-bottom:12px;
}
.featured_image {
	
}
.featured_headline {
	
}
.featured_title {
	font-size:2.0em;
	font-weight:bold;
	line-height:1.4em;
	padding:0;
	margin:0;
}
.featured_meta{
	font-size:0.8em;
	margin-bottom:2px;
}
.featured_past {
	
}
.image_wrapper {
	text-align:center;
}
.past_image {
	
}
.past_title {
	font-size:1.1em;
	font-weight:bold;
	margin:0 0 2px 0;
}
.past_data {

}
.past_meta {
	font-size:0.65em;
	margin:0 0 2px 0;
}
.past_description {
	font-size:0.8em;
}
.past_read_more_wrapper {
	padding-top:20px;
}
.past_read_more {
	font-size:0.8em;
}
</style>
{/literal}


<div class="well featured_wrapper">
	{section name=featured loop=$news max=1 step=-1}

		<div class="pull-left col-md-2 image_wrapper">
			<a href="{$featured[featured].link_url}">
				<img width="100%" class="img-thumbnail img-responsive featured_image" src="{$my_base_url}{$my_pligg_base}/{$featured_URL}&amp;action=view_image&amp;id={$news[featured].featured_id}" alt="">
			</a>
		</div>
		
		<div class="pull-left col-md-10 featured_headline" id="headline">
			<h3 class="featured_title"><a href="{$featured[featured].link_url}">{$news[featured].featured_link_title}</a></h3>
			<div class="featured_meta"> 
				<i class="icon-calendar"></i>
				{php}
					$timestamp = $this->_vars['featured'][$this->_sections['featured']['index']]['link_date'];
					list($year, $month, $day) = preg_split("/-/", $timestamp);
					$timestamp = date('F d, Y', mktime(0, 0, 0, $month, $day, $year));
					echo $timestamp;
				{/php}
				| {$featured[featured].link_votes} 
				<i class="icon-thumbs-up"></i>  
				| {$featured[featured].link_comments} 
				<i class="icon-comments"></i>  
			</div>
			<div class="featured_description">
				<p>{$news[featured].featured_description}</p>
				<p><a class="btn btn-success" title="Permanent Link to {$news[featured].featured_link_title}" href="{$featured[featured].link_url}">Read the full story &raquo;</a></p>
			</div>
		</div>
		
	{/section}
	
	<div class="clearfix"></div>
	
	{section name=featured loop=$news step=-1 start=-2 max=3}
		<hr class="soften" />
		<div class="featured_past">
			<div class="pull-left col-md-2 image_wrapper">
				<a href="{$featured[featured].link_url}" rel="bookmark" title="Permanent Link to {$news[featured].featured_link_title}">
					<img width="60%" class="img-thumbnail img-responseive past_image" src="{$my_base_url}{$my_pligg_base}/{$featured_URL}&amp;action=view_image&amp;id={$news[featured].featured_id}" alt="">
				</a>
			</div>
			<div class="pull-left col-md-8 past_data">
				<h5 class="past_title"><a href="{$featured[featured].link_url}">{$news[featured].featured_link_title}</a></h5>
				<div class="past_meta"> <i class="icon-calendar"></i>
					{php}
						$timestamp = $this->_vars['featured'][$this->_sections['featured']['index']]['link_date'];
						list($year, $month, $day) = preg_split("/-/", $timestamp);
						$timestamp = date('M d, Y', mktime(0, 0, 0, $month, $day, $year));
						echo $timestamp;
					{/php}
					| {$featured[featured].link_votes} <i class="icon-thumbs-up"></i>  | {$featured[featured].link_comments} <i class="icon-comments"></i> 
				</div> 
				<div class="past_description">
					<p>{$news[featured].featured_description|substr:0:200}...</p>
				</div>
			</div>
			<div class="pull-left col-md-2 past_read_more_wrapper">
				<a class="btn btn-default btn-sm past_read_more" href="{$featured[featured].link_url}">Read More</a>
			</div>
			<div class="clearfix"></div>
		</div>
	{/section}
	
	<div class="clearfix"></div>
</div>

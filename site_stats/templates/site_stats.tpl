{config_load file=site_stats_lang_conf}
{if $pagename eq "story"}
	{if $url_short neq "http://" && $url_short neq "://"}
		<link rel="stylesheet" href="{$my_pligg_base}/modules/site_stats/templates/style.css" type="text/css" media="screen" charset="utf-8" />
		<div class="story_stats">
			<h4 style="margin:0 0 3px 0;padding:0;font-size:14px;border-bottom:1px solid #ccc;">{#site_stats_title#}</h4>
			{checkActionsTpl location="tpl_pligg_module_site_stats_start"}
			{php}
			/* Start Google Pagerank */
			/* Source: http://www.pagerankcode.com/download-script.html */
				include_once './modules/site_stats/pagerank.php';
				$orig_url = $this->_vars['url_short'];
				$story_url = str_replace("http://www.", "http://", $orig_url); 
				$pr = getPageRank($story_url);
				if ($pr > 0) {
					// Display the Google Pagerank Text and number
					echo '<p class="story_stats_text">'.$this->_confs['site_stats_google_pr'].' '.$pr.'</p>';
					
					// Multiply PR value by 10 to make a wider graph image
					$positive = $pr * 10;
					// Find the value for the negative space
					$negative = 100 - $positive;
					// echo '<br />'.$positive.'<br />'.$negative.'<br />';
					
					// Display the Google Pagerank graph bar
					print '<img src="http://www.google.com/images/pos.gif" width="'.$positive.'" height="4" border="0" title="Pagerank '.$pr.'" alt="" style="margin-bottom:4px;"><img src="http://www.google.com/images/neg.gif" width="'.$negative.'" height="4" border="0" title="Pagerank '.$pr.'" alt="" style="margin:2px 0 4px 0;">'; 
				}
			/* End Google Pagerank */

			include_once './modules/site_stats/fetch.php';
			
			$domain = str_replace("www.", "", $orig_url);
			$domain = str_replace("http://", "", $domain); 
			
			/* Start Alexa Stats */
				$url3 = 'http://www.alexa.com/siteinfo/'.$domain;
				$data = FetchContent($url3);
		
				$string_7 = '<td class="end">';
				$string_8 = '</div>';
				$info4 = extract_unit($data, $string_7, $string_8);
				$info4 = strip_tags($info4); 
				$info4 = preg_replace("/[^a-zA-Z0-9\s]/", " ", $info4);
				if ($info4 != 'No data') {
					echo '<p class="story_stats_text"><a href="'.$url3.'" rel="nofollow">'.$this->_confs['site_stats_alexa_online_since'].' '.$info4.'</a></p>';
				}	
				
				$string_5 = '<td>';
				$string_6 = '</div>';
				$info3 = extract_unit($data, $string_5, $string_6);
				$info3 = strip_tags($info3); 
				echo '<p class="story_stats_text" style="margin:1px 0;"><a href="'.$url3.'" rel="nofollow">'.$this->_confs['site_stats_alexa_ranked'].' '.$info3.' '.$this->_confs['site_stats_on_alexa'].'</a></p>';
			/* End Alexa Stats */

			/* Start Google Search Results */
				$url = 'http://www.google.com/search?q=site%3A'.$this->_vars['url_short'];
				$data = FetchContent($url);
				// Extract information between STRING 1 & STRING 2
				$string_1 = '</b> of <b>';
				$string_2 = '</b> from <b>';
				$info1 = extract_unit($data, $string_1, $string_2);
				// Strip out HTML tags
				$info1 = strip_tags($info1); 
				
				if ($info1 > 0) {
					echo '<p class="story_stats_text"><a href="'.$url.'" rel="nofollow">'.$info1.' '.$this->_confs['site_stats_google_indexed'].'</a></p>';
				}else{
					$url = 'http://www.google.com/search?q=site%3A'.$this->_vars['url_short'];
					$data = FetchContent($url);
					// Extract information between STRING 1 & STRING 2
					$string_1 = '</b> of about <b>';
					$string_2 = '</b> from <b>';
					$info1 = extract_unit($data, $string_1, $string_2);
					// Strip out HTML tags
					$info1 = strip_tags($info1);
					echo '<p class="story_stats_text"><a href="'.$url.'" rel="nofollow">'.$info1.' '.$this->_confs['site_stats_google_indexed'].'</a></p>';
				}
			/* End Google Search Results */

			/* Start Google Link Results */
				$url2 = 'http://www.google.com/search?q=link%3A'.$this->_vars['url_short'];
				$data = FetchContent($url2);
				$string_3 = '</b> of <b>';
				$string_4 = '</b> linking to <b>';
				$info2 = extract_unit($data, $string_3, $string_4);
				$info2 = strip_tags($info2); 
				
				if ($info2 > 0) {
					echo '<p class="story_stats_text" style="margin-top:2px;"><a href="'.$url2.'" rel="nofollow">'.$info2.' '.$this->_confs['site_stats_google_incoming'].'</a></p>';
				}else{
					$url2 = 'http://www.google.com/search?q=link%3A'.$this->_vars['url_short'];
					$data = FetchContent($url2);
					$string_3 = '</b> of about <b>';
					$string_4 = '</b> linking to <b>';
					$info2 = extract_unit($data, $string_3, $string_4);
					$info2 = strip_tags($info2); 
					echo '<p class="story_stats_text" style="margin-top:2px;"><a href="'.$url2.'" rel="nofollow">'.$info2.' '.$this->_confs['site_stats_google_incoming'].'</a></p>';
				}
			/* End Google Link Results */
			
			/* Start Compete Stats */
				$url5 = 'http://siteanalytics.compete.com/'.$domain;
				$data = FetchContent($url5);
				//echo '<!-- '.$data.' -->';
				$string_9 = '<div class="error-message">';
				$string_10 = '</div>';
				$info7 = extract_unit($data, $string_9, $string_10);
				$info7 = strip_tags($info7); 
				if ($info7 != 'No data found for distie.com.') {
					$string_11 = '<div class="number value">';
					$string_12 = '</div>';
					$info5 = extract_unit($data, $string_11, $string_12);
					$info5 = strip_tags($info5); 
					if ($info5 != '') {
						echo '<p class="story_stats_text" style="margin-top:2px;"><a href="'.$url5.'" rel="nofollow">'.$info5.' '.$this->_confs['site_stats_compete_unique'].'</a></p>';
					}
					
					$string_13 = '<div id="sess" class="metric">';
					$string_14 = '<div class="number delta-negative">';
					$info6 = extract_unit($data, $string_13, $string_14);
					$info6 = strip_tags($info6);
					$info6 = preg_replace("/Visits/", "", $info6);
					if ($info6 != '') {
						echo '<p class="story_stats_text" style="margin-top:2px;"><a href="'.$url5.'" rel="nofollow">'.$info6.' '.$this->_confs['site_stats_compete_views'].'</a></p>';
					}
				}
				
				
			/* End Compete Stats */
			
			{/php}

			{checkActionsTpl location="tpl_pligg_module_site_stats_end"}
		</div>

		{literal}
		<script tyle="text/javascript">
		//our cache object
		var cache = {};
		var formatTweets(info) {  
			//formats tweets, does whatever you want with the tweet information
		};

		//event
		$('myForm').addEvent('submit',function() {
			var handle = $('pligg').value; //davidwalshblog, for example
			var cacheHandle = handle.toLowerCase();
			if(cache[cacheHandle]) {
				formatTweets(cache[cacheHandle]);
			}
			else {
				//gitter
				var myTwitterGitter = new TwitterGitter(handle,{
					count: 10,
					onComplete: function(tweets,user) {
						cache[user.toLowerCase()] = tweets;
						formatTweets(tweets);
					}
				}).retrieve();
			}
		});

		</script>
		{/literal}
		
	{/if}
{/if}



{config_load file=site_stats_pligg_lang_conf}
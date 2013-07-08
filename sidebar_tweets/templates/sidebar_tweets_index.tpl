{php}
//////////////////////////////

class tweet {
	var $config;
	public $tweetsString;
	//function tweet ($newconfig=array()) {
	function __construct($config=array()) {
		$default = array(
			'username' => null,                             // [string or array] required unless using the 'query' option; one or more twitter screen names
			'list' => null,                                 // [string]   optional name of list belonging to username
			'favorites' => false,                           // [boolean]  display the user's favorites instead of his tweets
			'query' => null,                                // [string]   optional search query
			'avatar_size' => null,                          // [integer]  height and width of avatar if displayed (48px max)
			'count' => 3,                                   // [integer]  how many tweets to display?
			'fetch' => null,                                // [integer]  how many tweets to fetch via the API (set this higher than 'count' if using the 'filter' option)
			'page' => 1,                                    // [integer]  which page of results to fetch (if count != fetch, you'll get unexpected results)
			'retweets' => true,                             // [boolean]  whether to fetch (official) retweets (not supported in all display modes)
			'intro_text' => null,                           // [string]   do you want text BEFORE your your tweets?
			'outro_text' => null,                           // [string]   do you want text AFTER your tweets?
			'join_text' =>  null,                           // [string]   optional text in between date and tweet, try setting to "auto"
			'auto_join_text_default' => "i said,",          // [string]   auto text for non verb: "i said" bullocks
			'auto_join_text_ed' => "i",                     // [string]   auto text for past tense: "i" surfed
			'auto_join_text_ing' => "i am",                 // [string]   auto tense for present tense: "i was" surfing
			'auto_join_text_reply' => "i replied to",       // [string]   auto tense for replies: "i replied to" @someone "with"
			'auto_join_text_url' => "i was looking at",     // [string]   auto tense for urls: "i was looking at" http:...
			'twitter_url' => "twitter.com",                 // [string]   custom twitter url, if any (apigee, etc.)
			'twitter_api_url' => "api.twitter.com",         // [string]   custom twitter api url, if any (apigee, etc.)
			'twitter_search_url' => "search.twitter.com",   // [string]   custom twitter search url, if any (apigee, etc.)
			'template' => "{avatar}{time}{join}{text}",     // [string or function] template used to construct each tweet <li> - see code for available vars		
			'comparator' => create_function('$a,$b',        // [function] comparator used to sort tweets (see Array.sort)
			'return $b["tweet_time"] - $a["tweet_time"];'),
			'filter'=>create_function('$a','return true;'), // [function] whether or not to include a particular tweet (be sure to also set 'fetch')
			'proto' => "http:",                             // [string] protocol to use (http or https)
			'print' => True,                                // [boolean] Prints or no
		);
		$config = array_merge($default, $config);
		if (is_string($config['username']) ){
			$config['username'] = array($config['username']);
		}
		$this->config = $config;
		$count = ($config['fetch'] === null ? $config['count'] : $config['fetch']);
		if ($config['list']) {
			$url = $config['proto']."//".$config['twitter_api_url']."/1/".$config['username'][0]."/lists/".$config['list']."/statuses.json?page=".$config['page']."&per_page=".$count."&callback=?";
		} elseif ($config['favorites']) {
			$url = $config['proto']."//".$config['twitter_api_url']."/favorites/".$config['username'][0].".json?page=".$config['page']."&count=".$count."&callback=?";
		} elseif ($config['query'] === null && sizeof($config['username']) == 1) {
			$ret = ($config['retweets'] ? '&include_rts=1' : '');
			$url = $config['proto'].'//'.$config['twitter_api_url'].'/1/statuses/user_timeline.json?screen_name='.$config['username'][0].'&count='.$count.$ret.'&page='.$config['page'].'&callback=?';
		} else {
			$query = ($config['query'] ? $config['query'] : 'from:'.implode(' OR from:', $config['username']));
			$url = $config['proto'].'//'.$config['twitter_search_url'].'/search.json?&q='.urlencode($query).'&rpp='.$count.'&page='.$config['page'].'&callback=?';
		}

		$data = file_get_contents($url);
		$dataN = ( substr($data,0,1) == "(" ? substr($data,1,-2) : $data) ;
		$json = json_decode($dataN, True);
		if (isset($json['results']) ) {
			$json = $json['results'];
		}		
	
		$tweets = array();	

		foreach( $json as $item) {
			if ($config['join_text'] == "auto") {
				if (preg_match("/^(@([A-Za-z0-9-_]+)) .*/i", $item['text'])) {
					$join_text = $config['auto_join_text_reply'];
				} elseif (preg_match("/(^\w+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+) .*/i", $item['text'])) {
					$join_text = $config['auto_join_text_url'];
				} elseif (preg_match("/^((\w+ed)|just) .*/im", $item['text'])) {
					$join_text = $config['auto_join_text_ed'];
				} elseif (preg_match("/^(\w*ing) .*/i", $item['text'])) {
					$join_text = $config['auto_join_text_ing'];
				} else {
					$join_text = $config['auto_join_text_default'];
				}
			}
	
			// Basic building blocks for constructing tweet <li> using a template
			$screen_name = ( isset($item['from_user']) ? $item['from_user'] : $item['user']['screen_name']);
			$source = $item['source'];
			$user_url = "http://".$config['twitter_url']."/".$screen_name;
			$avatar_size = $config['avatar_size'];
			$avatar_url = ( isset($item['profile_image_url']) ? $item['profile_image_url'] : $item['user']['profile_image_url']);
			$tweet_url = "http://".$config['twitter_url']."/".$screen_name."/status/".$item['id_str'];
			$retweet = isset($item['retweeted_status']);
			$retweeted_screen_name = ($retweet && is_array($item['retweeted_status']) ? $item['retweeted_status']['user']['screen_name'] : null);
			/*if ( $retweet && is_array($item['retweeted_status']['user']) ) {
				$retweeted_screen_name = $item['retweeted_status']['user']['screen_name'];
			}
			else {
				$retweeted_screen_name = null;
			}*/
			$tweet_time = $this->parse_date($item['created_at']);
			$tweet_relative_time = $this->relative_time(array($tweet_time));
			$tweet_raw_text = ($retweet && is_array($item['retweeted_status']) ? 'RT @'.$retweeted_screen_name.' '.$item['retweeted_status']['text'] : $item['text'] ); // avoid '...' in long retweets
			$tweet_text = $this->parse_text($tweet_raw_text); 
	
			// Default spans, and pre-formatted blocks for common layouts
			$user = '<a class="tweet_user" href="'.$user_url.'">'.$screen_name.'</a>';
			$join = ($config['join_text'] ? '<span class="tweet_join"> '.$join_text.' </span>' : ' ');
			$avatar = (isset($avatar_size) ? '<a class="tweet_avatar" href="'.$user_url.'"><img src="'.$avatar_url.'" height="'.$avatar_size.'" width="'.$avatar_size.'" alt="'.$screen_name.'\'s avatar" title="'.$screen_name.'\'s avatar" border="0"/></a>' : '');
			$time = '<span class="tweet_time"><a href="'.$tweet_url.'" title="view tweet on twitter">'.$tweet_relative_time.'</a></span>';
			$text = '<span class="tweet_text">'.$tweet_text.'</span>';
			$reply_url = "http://".$config['twitter_url']."/intent/tweet?in_reply_to=".$item['id_str'];
			$retweet_url = "http://".$config['twitter_url']."/intent/retweet?tweet_id=".$item['id_str'];
			$favorite_url = "http://".$config['twitter_url']+"/intent/favorite?tweet_id=".$item['id_str'];
			$reply_action = '<a class="tweet_action tweet_reply" href="'.$reply_url.'">reply</a>';
			$retweet_action = '<a class="tweet_action tweet_retweet" href="'.$retweet_url.'">retweet</a>';
			$favorite_action = '<a class="tweet_action tweet_favorite" href="'.$favorite_url.'">favorite</a>';
			
			$tweets[] = array('item' => $item, // For advanced users who want to dig out other info
				'screen_name' => $screen_name,
				'user_url' => $user_url,
				'avatar_size' => $avatar_size,
				'avatar_url' => $avatar_url,
				'source' => $source,
				'tweet_url' => $tweet_url,
				'tweet_time' => $tweet_time,
				'tweet_relative_time' => $tweet_relative_time,
				'tweet_raw_text' => $tweet_raw_text,
				'tweet_text' => $tweet_text,
				'retweet' => $retweet,
				'retweeted_screen_name' => $retweeted_screen_name,
				'user' => $user,
				'join' => $join,
				'avatar' => $avatar,
				'time' => $time,
				'text' => $text,
				'reply_url' => $reply_url,
				'favorite_url' => $favorite_url,
				'retweet_url' => $retweet_url,
				'reply_action' => $reply_action,
				'favorite_action' => $favorite_action,
				'retweet_action' => $retweet_action
			);
		}
		$tweets = array_filter($tweets, $config['filter']); //Array filtering
		usort($tweets, $config['comparator']); //Array sorting
		$tweets = array_slice($tweets, 0, $config['count']);

		$introstr = ($introstr === null ? '' : "<p class=\"tweet_intro\">".$config['intro_text']."</p>");
		$outrostr = ($outrostr === null ? '' : "<p class=\"tweet_outro\">".$config['outro_text']."</p>");
	
		$retstr = "<ul class=\"tweet_list\">";
		foreach ($tweets as $tweet) {
			$retstr .= "<li>".$this->expand_template($tweet)."</li>";
		}
		$retstr = $introstr.$retstr."</ul>".$outrostr;
		if ($config['print']) {
			print($retstr);
		}
		$this->tweetsString = $retstr;
	}
	function parse_date($date_str) {
		// The non-search twitter APIs return inconsistently-formatted dates, which Date.parse
	   	// cannot handle in IE. We therefore perform the following transformation:
	   	// "Wed Apr 29 08:53:31 +0000 2009" => "Wed, Apr 29 2009 08:53:31 +0000"		
	   	//return strtotime(preg_replace('/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i', '$1,$2$4$3', $date_str));
	   	//return date_create_from_format("D, M d Y H:i:s O", preg_replace('/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i', '$1,$2$4$3', $date_str));
	   	return strtotime($date_str);
	}
	function relative_time($date) {
		$relative_to = (sizeof($date) > 1 ? $date[1] : time());
		$delta = intval($relative_to - $date[0]);
		$r = '';
		if ($delta < 60) {
			$r = $delta .' seconds ago';
		} elseif($delta < 120) {
			$r = 'a minute ago';
		} elseif($delta < (45*60)) {
			$r = (strval(intval($delta / 60))).' minutes ago';
		} elseif($delta < (2*60*60)) {
			$r = 'an hour ago';
		} elseif($delta < (24*60*60)) {
			$r = '' . strval(intval($delta / 3600)).' hours ago';
		} elseif($delta < (48*60*60)) {
			$r = 'a day ago';
		} else {
			$r = strval(intval($delta / 86400)).' days ago';
		}
		return 'about ' . $r;
	}
	function parse_text($raw_text) {
		$config = $this->config;
		//Url See http://daringfireball.net/2010/07/improved_regex_for_matching_urls
		$urlregexp = "/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/i";
		$raw_text = preg_replace_callback($urlregexp, 
			create_function('$matches',
				'$url = ( preg_match("/^[a-z]+:/i",$matches[1]) ? $matches[1] : "http://".$matches[1] );'.
				'return "<a href=\"".$url."\">".$matches[1]."</a>";'
			), $raw_text);
		$userregexp = "/[\@]+(\w+)/i";
		$raw_text = preg_replace($userregexp, '@<a href="http://'.$config['twitter_url'].'/$1">$1</a>', $raw_text);
		//TODO: Support various latin1 (\u00**) and arabic (\u06**) alphanumeric chars
		$hashregexp = "/(?:^| )[\#]+([\w]+)/i";
		$usercond = ($config['username'] && sizeof($config['username']) == 1 ? '&from='.implode("%2BOR%2B", $config['username']) : '');
		$raw_text = preg_replace($hashregexp, ' <a href="http://'.$config['twitter_search_url'].'/search?q=&tag=$1&lang=all'.$usercond.'">#$1</a>', $raw_text);
		return $raw_text;
	}
	function expand_template($info) {
		$config = $this->config;
		if (is_string($config['template']) ) {
			$result = $config['template'];
			foreach( $info as $key => $value) {
				if (! is_array($value) ) {
					$result = preg_replace("/\{".$key."\}/", ($value === null ? '' : $value), $result);
				}
			}
			return $result;
		}
		elseif (is_callable($config['template']) ) {
			return $config['template']($info);
		}
	}
}

//////////////////////////////
{/php}

{literal}
<style type="text/css">
.tweet, .query {
font-family: Georgia, serif;
font-size: 120%;
color: #085258;
}

.tweet .tweet_list, .query .tweet_list {
-webkit-border-radius: .5em;
list-style-type: none;
margin: 0;
padding: 0;
overflow-y: hidden;
font-size:0.85em;
}

.tweet .tweet_list .awesome, .tweet .tweet_list .epic, .query .tweet_list .awesome, .query .tweet_list .epic {
text-transform: uppercase; 
}

.tweet .tweet_list li, .query .tweet_list li {
overflow-y: auto;
overflow-x: hidden;
padding: .5em;
}

.tweet .tweet_list li a, .query .tweet_list li a {
color: #0C717A; 
}

.tweet .tweet_list .tweet_even, .query .tweet_list .tweet_even {
background-color: #91E5E7; 
}

.tweet .tweet_list .tweet_avatar, .query .tweet_list .tweet_avatar {
padding-right: .5em;
float: left; 
}

.tweet .tweet_list .tweet_avatar img, .query .tweet_list .tweet_avatar img {
vertical-align: middle; 
}
</style>
{/literal}

<div class="headline">
	<div class="sectiontitle">Recent Tweets</div>
</div>
<div class="boxcontent">
	<ul class="sidebar-stories" style="margin:0;padding:0;">
		<div class="tweet">
			{php}

				$username = $this->_vars['sidebar_tweets_id'];
				$count = $this->_vars['sidebar_tweets_num'];
				
				$tweet = new tweet(array(
					'username' => $username,
					'join_text' => "auto",
					'avatar_size' => 16,
					'count' => $count,
					'auto_join_text_default' => "we said,",
					'auto_join_text_ed' => "we",
					'auto_join_text_ing' => "we were",
					'auto_join_text_reply' => "we replied to",
					'auto_join_text_url' => "we were checking out"
				));
				
			{/php}
		</div>
	</ul>
</div>
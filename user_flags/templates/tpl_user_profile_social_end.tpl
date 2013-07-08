<!-- tpl_user_profile_social_end.tpl (user_flags) -->
			{if $isadmin}
				{if $user_lastip neq '' || $user_lastip neq '0'}
					<a href="http://api.hostip.info/get_html.php?ip={$user_lastip}&position=true"><img src="http://api.hostip.info/flag.php?ip={$user_lastip}" style="height:23px;width:23px;" class="img-circle"></a></td>
				{elseif $user_ip neq '' && $user_ip neq '0'}
					<a href="http://api.hostip.info/get_html.php?ip={$user_ip}&position=true"><img src="http://api.hostip.info/flag.php?ip={$user_ip}" style="height:23px;width:23px;" class="img-circle"></a></td>
				{/if}
			{/if}
<!--/tpl_user_profile_social_end.tpl (user_flags) -->
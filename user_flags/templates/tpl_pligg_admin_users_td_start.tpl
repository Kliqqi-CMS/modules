<!-- tpl_pligg_admin_user_td_start.tpl (user_flags) -->
					<td style="width:40px;text-align:center;vertical-align:middle;">
						{if $userlist[nr].user_ip neq '0' && $userlist[nr].user_ip neq ''}
							<a href="http://api.hostip.info/get_html.php?ip={$userlist[nr].user_ip}&position=true"><img src="http://api.hostip.info/flag.php?ip={$userlist[nr].user_ip}" style="width:25px;"></a>
						{/if}
					</td>
<!--/tpl_pligg_admin_user_td_start.tpl (user_flags) -->
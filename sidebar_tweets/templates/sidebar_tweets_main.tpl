<fieldset>

	<legend>Sidebar Tweets</legend>
	<p>Please enter your Twitter username, followed by how many status updates you would like to display.</p>

	{if $templatelite.post.sidebar_tweets_id}
		<div class="alert alert-success fade in">
			<a data-dismiss="alert" class="close">×</a>
			Saved Settings!
		</div>
	{/if}

	<form action="" method="POST" id="thisform">
		<table class="table table-bordered table-striped">
			<tbody>
				<tr>
					<td style="width:125px"><label>Twitter Account:</label></td>
					<td><input type="text" name="sidebar_tweets_id" id="sidebar_tweets_id" class="span4" value="{$settings.sidebar_tweets_id}"/></td>
				</tr>
				<tr>
					<td><label>Number of Posts:</label></td>
					<td>
						<select name="sidebar_tweets_num" id="sidebar_tweets_num" class="input-mini">
						  <option {if $settings.sidebar_tweets_num == "1"}SELECTED {/if}value="1">1</option>
						  <option {if $settings.sidebar_tweets_num == "2"}SELECTED {/if}value="2">2</option>
						  <option {if $settings.sidebar_tweets_num == "3"}SELECTED {/if}value="3">3</option>
						  <option {if $settings.sidebar_tweets_num == "4"}SELECTED {/if}value="4">4</option>
						  <option {if $settings.sidebar_tweets_num == "5"}SELECTED {/if}value="5">5</option>
						  <option {if $settings.sidebar_tweets_num == "6"}SELECTED {/if}value="6">6</option>
						  <option {if $settings.sidebar_tweets_num == "7"}SELECTED {/if}value="7">7</option>
						  <option {if $settings.sidebar_tweets_num == "8"}SELECTED {/if}value="8">8</option>
						  <option {if $settings.sidebar_tweets_num == "9"}SELECTED {/if}value="9">9</option>
						  <option {if $settings.sidebar_tweets_num == "10"}SELECTED {/if}value="10">10</option>
						</select> 
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div class="submitbuttonfloat">
							<input type="submit" name="submit" value="Save Settings" class="btn btn-primary" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</fieldset>
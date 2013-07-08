<!--close_comments_1.tpl-->

{literal}
<style type="text/css">
.comments_close{
    background-color: #F9F9F9;
    border: 1px solid #DDDDDD;
    border-radius: 4px 4px 4px 4px;
    margin: 15px 0;
    padding: 14px 19px;
    position: relative;
}
</style>
{/literal}


{php}
// Establish a connection to the database
include_once './libs/dbconnect.php';
mysql_connect(EZSQL_DB_HOST,EZSQL_DB_USER,EZSQL_DB_PASSWORD);
mysql_select_db(EZSQL_DB_NAME) or die ('MySQL Error: ' . mysql_error());

// Get the existing registration renamer user count
$sql = "SELECT * FROM pligg_misc_data WHERE name='close_comment_method' ";
$result = mysql_query($sql) or die( mysql_error() );
$row = mysql_fetch_assoc($result);

// Check if this is your first time running the script
if(isset($row['data'])) {
	// Assign existing database value for the registration rename user counter
	$close_comment_method = $row['data'];
	if ($close_comment_method == "both"){
		
	} elseif ($close_comment_method == "manual"){
		
	} elseif ($close_comment_method == "time"){
		
	} else {
		// Alert the admin that they need to configure the module
		if ($this->_vars['isadmin'] == 1){
			echo '<div class="alert alert-danger">No method has been set yet for the Close Comments Module. Please <a href="'.$this->_vars['my_base_url'].$this->_vars['my_pligg_base'].'/module.php?module=close_comments">configure it here</a>.</div>';
		}
	}
}

//echo $this->_vars['link_id'];

{/php}

<div class="comments_close">
	<h4 style="color:#9E0C0C;">Comments Are Closed</h4>
	<p>This article's comment submission form has been disabled. No new comments can be added to this story at this time.</p>
</div>

<!--/close_comments_1.tpl-->
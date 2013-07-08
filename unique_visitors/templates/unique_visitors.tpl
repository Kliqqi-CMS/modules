{config_load file=unique_visitors_lang_conf}
{checkActionsTpl location="tpl_pligg_module_unique_visitors_start"}

{* Example CSS Styles. You should add this to your template CSS document to make module upgrades easier *}
{literal}
<style type="text/css">
.unique_visitors_main {padding:10px;}
.unique_visitors {}
.unique_visitors_now {}
.unique_visitors_day {}
.unique_visitors_week {}
.unique_visitors_month {}
</style>
{/literal}

{php}
$fiveminutesago = time() - (5 * 60);
$fiveminutes = date('Y-m-d H:i:s', $fiveminutesago);
$onedayago = time() - (24 * 60 * 60);
$lastday = date('Y-m-d H:i:s', $onedayago);
$oneweekago = time() - (7 * 24 * 60 * 60);
$lastweek = date('Y-m-d H:i:s', $oneweekago);
$onemonthago = time() - (30 * 24 * 60 * 60);
$lastmonth = date('Y-m-d H:i:s', $onemonthago);

session_start();
include_once('config.php');
$active_sessions = 0;
$delete_minutes = 43200; # minutes in a month
if($sid = session_id()) # if there is an active session
{
	echo '<div class="headline"><div class="sectiontitle">';
	echo $this->_confs['Unique_Visitors_Activity'];
	echo '</div></div><div class="unique_visitors_main">';
	
    # Get Users IP address
    $ip = $_SERVER['REMOTE_ADDR'];
    # Delete users from the table if time is greater than $delete_minutes
    mysql_query("DELETE FROM `" . table_prefix . "unique_visitors` WHERE 
    `date` < DATE_SUB(NOW(),INTERVAL $delete_minutes MINUTE)")or die(mysql_error());
    
    # Check to see if the current ip is in the table
    $sql = mysql_query("SELECT * FROM " . table_prefix . "unique_visitors WHERE ip='$ip'");
    $row = mysql_fetch_array($sql);
    # If the ip isn't in the table add it.
    if(!$row){
        mysql_query("INSERT INTO `" . table_prefix . "unique_visitors` (`ip`, `session`, `date`) 
        VALUES ('$ip', '$sid', NOW()) ON DUPLICATE KEY UPDATE `date` = NOW()")or die(mysql_error());
    }

	/*
	// 5 Minutes
	$sessions = mysql_query("SELECT * FROM " . table_prefix . "unique_visitors WHERE date > '$fiveminutes' AND date < NOW() ")or die(mysql_error());
	$active_sessions = mysql_num_rows($sessions);
	echo '<div class="unique_visitors user_online_now">'.$this->_confs['Unique_Visitors_Now'];
	echo $active_sessions.'</div>';
	*/
	
	// Last Day
	$sessions = mysql_query("SELECT * FROM " . table_prefix . "unique_visitors WHERE date > '$lastday' AND date < NOW() ")or die(mysql_error());
	$active_sessions = mysql_num_rows($sessions);
	echo '<div class="unique_visitors unique_visitors_day">'.$this->_confs['Unique_Visitors_Day'];
	echo $active_sessions.'</div>';

	// Last Week
	$sessions = mysql_query("SELECT * FROM " . table_prefix . "unique_visitors WHERE date > '$lastweek' AND date < NOW() ")or die(mysql_error());
	$active_sessions = mysql_num_rows($sessions);
	echo '<div class="unique_visitors unique_visitors_week">'.$this->_confs['Unique_Visitors_Week'];
	echo $active_sessions.'</div>';

	// Last Month
	$sessions = mysql_query("SELECT * FROM " . table_prefix . "unique_visitors WHERE date > '$lastmonth' AND date < NOW() ")or die(mysql_error());
	$active_sessions = mysql_num_rows($sessions);
	echo '<div class="unique_visitors unique_visitors_month">'.$this->_confs['Unique_Visitors_Month'];
	echo $active_sessions.'</div>';

	echo '</div>';
}

{/php}

{checkActionsTpl location="tpl_pligg_module_unique_visitors_end"}
{config_load file=unique_visitors_pligg_lang_conf}
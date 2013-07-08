<?php	
	$module_info['name'] = 'Author Comment Subscription';
	$module_info['desc'] = 'Sends an email to an article author when a comment is added to their story if they choose to subscribe.';
	$module_info['version'] = 0.1;
	$module_info['db_add_field'][]=array(table_prefix . 'links', 'comment_subscription', 'INT',  20, "NOT NULL", 0, '0');
?>
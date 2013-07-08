<?php
	$module_info['name'] = 'TinyMCE WYSIWYG';
	$module_info['desc'] = 'Javascript HTML WYSIWYG editor. This module <strong>replaces your "HTML Tags to Allow"</strong> settings for regular, admin and god level users with &lt;b&gt; &lt;strong&gt; &lt;ul&gt; &lt;ol&gt; &lt;li&gt; &lt;p&gt; &lt;br&gt; &lt;span&gt; &lt;em&gt; tags to allow for basic WYSIWYG formatting.';
	$module_info['version'] = 0.2;
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=tinymce';
	$module_info['homepage_url'] = 'http://forums.pligg.com/pligg-modules/17794-tinymce-wysiwyg-editor.html';
	$module_info['settings_url'] = './admin_config.php?page=Submit';

	$module_info['db_sql'][] = "UPDATE ".table_config." SET var_value='<b><strong><ul><ol><li><p><br><span><em>' WHERE var_name='Story_Content_Tags_To_Allow_Normal'";
	$module_info['db_sql'][] = "UPDATE ".table_config." SET var_value='<b><strong><ul><ol><li><p><br><span><em>' WHERE var_name='Story_Content_Tags_To_Allow_Admin'";
	$module_info['db_sql'][] = "UPDATE ".table_config." SET var_value='<b><strong><ul><ol><li><p><br><span><em>' WHERE var_name='Story_Content_Tags_To_Allow_God'";


?>
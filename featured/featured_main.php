<?php
function featured_showpage() {
	global $db, $main_smarty, $the_template;
	
	$main_smarty = do_sidebar($main_smarty);
	
	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');

	if($canIhaveAccess == 1) {
	
		$action = $_REQUEST['action'];

		switch($action) {
			case "addfeatured": {
				if($_POST['submit']!=null) {
					$title_safe = addslashes($_POST['featured_link_title']);
					$description_safe = addslashes($_POST['featured_description']);
					$info['featured_link_id']=$_POST['featured_link_id'];
					$info['featured_link_title']=$title_safe;
					$info['featured_description']=$description_safe;
					$info['featured_enabled']=$_POST['status'];

					if($_FILES['image']['type']!=null)
					$image_type=explode("/",$_FILES['image']['type']);
					$image_name=$_FILES['image']['name'];
					$image_tmp=$_FILES['image']['tmp_name'];
					
					// Checking featured ID Exists Or Not
					if(is_numeric($info['featured_link_id'])==true) {
						$featured_check="SELECT featured_link_id FROM " . table_prefix . "featured WHERE featured_link_id=".$info['featured_link_id']."";
						$result=$db->query($featured_check);
						$featured_check2="SELECT link_id FROM " . table_prefix . "links WHERE link_id=".$info['featured_link_id'];
						$result2=$db->query($featured_check2);
					}

					if($info['featured_link_id']==null) {
						$err="Featured ID must not be left blank!";
					}
					else if(is_numeric($info['featured_link_id'])==false) {
						$err="Featured ID must be an integer.";
					}
					else if($result!=null) {
						$err="The Featured ID you entered aleady exists in the database.";
					}
					else if($result2==null) {
						$err="The Featured ID you entered doesn't match any existing news in the database.";
					}
					else if($info['featured_link_title']==null) {
						$err="Featured Title must not be left blank!";
					}
					else if($info['featured_description']==null) {
						$err="Featured Description must not be left blank!";
					}
					else if($image_name==null) {
						$err="You must upload a background image for this Featured News!";
					}
					else if($image_type['0']!='image') {
						$err="You must upload an <strong>image file</strong> for the background image.";
					}

					if($err) {
						$main_smarty->assign('err',$err);
					}
					else {
						$handle = fopen($image_tmp, "r");
						$contents = fread($handle, filesize($image_tmp));
						$info['featured_image']=addslashes($contents);
						$featured_insert="INSERT INTO ".table_prefix."featured SET ";
						foreach($info as $key=>$value) {
							$featured_insert.=$key."="."'".$value."'".",";
						}
						$featured_insert=substr($featured_insert,0,strlen($featured_insert)-1);
						$db->query($featured_insert);
						$main_smarty->assign('msg','Featured News successfully added!');				
					}
				}
				$main_smarty->assign('tpl_center', featured_tpl_path . 'featured_add');
				$main_smarty->display($template_dir . '/admin/admin.tpl');			
				break;
			}
			
			case "editfeatured": {
				$featured_id=$_REQUEST['id'];
				$featured_sql="SELECT * FROM " . table_prefix . "featured WHERE featured_id=".$featured_id."";
				$featured_news = $db->get_results($featured_sql);
				$featured_news = object_2_array($featured_news);
				
				if($_POST['submit']!=null) {
					$title_safe = addslashes($_POST['featured_link_title']);
					$description_safe = addslashes($_POST['featured_description']);
					$info['featured_link_id']=$_POST['featured_link_id'];
					$info['featured_link_title']=$title_safe;
					$info['featured_description']=$description_safe;
					$info['featured_enabled']=$_POST['status'];

					if($_FILES['image']['type']!=null)
					$image_type=explode("/",$_FILES['image']['type']);
					$image_name=$_FILES['image']['name'];
					$image_tmp=$_FILES['image']['tmp_name'];

					// Checking featured ID Exists Or Not
					if(is_numeric($info['featured_link_id'])==true&&$info['featured_link_id']!=$featured_news['0']['featured_link_id']) {
						$featured_check="SELECT * FROM " . table_prefix . "featured WHERE featured_link_id=".$info['featured_link_id']."";
						$result=$db->query($featured_check);
					}
					if(is_numeric($info['featured_link_id'])==true) {
						$featured_check2="SELECT link_id FROM " . table_prefix . "links WHERE link_id=".$info['featured_link_id'];
						$result2=$db->query($featured_check2);
					}

					if($info['featured_link_id']==null) {
						$err="Featured ID must not be left blank!";
					}
					else if(is_numeric($info['featured_link_id'])==false) {
						$err="You must enter an integer for the Featured ID.";
					}
					else if($info['featured_link_title']==null) {
						$err="Featured Title must not be left blank!";
					}
					else if($info['featured_description']==null) {
						$err="Featured Description must not be left blank!";
					}
					else if($result2==null) {
						$err="The Featured ID you entered doesn't match any existing news in the database.";
					}					
					else if($image_name!=null) {
						if($image_type['0']!='image') {
							$err="You must upload an <strong>image file</strong> for the background image.";
						}
					}

					if($err) {
						$main_smarty->assign('err',$err);
					}
					else {
						if($image_name!=null) {
							$handle = fopen($image_tmp, "r");
							$contents = fread($handle, filesize($image_tmp));
							$info['featured_image']=addslashes($contents);		
						}
						$featured_edit="UPDATE ".table_prefix."featured SET ";
						foreach($info as $key=>$value) {
							$featured_edit.=$key."="."'".$value."'".",";
						}
						$featured_edit=substr($featured_edit,0,strlen($featured_edit)-1);
						$featured_edit.=" WHERE featured_id=".$featured_id."";
						$db->query($featured_edit);
						$main_smarty->assign('msg','Featured news successfully edited.');
					}
				}
				$query_edit="SELECT * FROM " . table_prefix . "featured WHERE featured_id=".$featured_id;
				$news = $db->get_results($query_edit);
				$news = object_2_array($news);
				$main_smarty->assign('news',$news);
				$main_smarty->assign('tpl_center', featured_tpl_path . 'featured_edit');
				$main_smarty->display($template_dir . '/admin/admin.tpl');			
				break;
			}

			case "manage_news": {
				if($_GET['delete']!=null) {
					$id=$_GET['id'];
					$del_query="DELETE FROM ".table_prefix."featured WHERE featured_id=".$id."";
					$db->query($del_query);
					$main_smarty->assign('msg','Featured news successfully deleted.');
				}
				$sql = "SELECT * FROM " . table_prefix . "featured ORDER BY featured_id DESC";
				$news = $db->get_results($sql);
				$news = object_2_array($news);
				$main_smarty->assign('news',$news);
				$main_smarty->assign('tpl_center', featured_tpl_path . 'featured_admin');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
				break;
			}

			case "view_image":{
				$id=$_REQUEST['id'];
				$sql="SELECT featured_image FROM ".table_prefix."featured WHERE featured_id=".$id."";
				$news = $db->get_results($sql);
				$news = object_2_array($news);
				ob_end_clean();
				ob_start();
				header ("Content-type: image/jpeg");
				echo $news[0]['featured_image'];
				exit;
				break;
			}

			default: {
				$sql = "SELECT * FROM " . table_prefix . "featured ORDER BY featured_id DESC";
				$news = $db->get_results($sql);
				$news = object_2_array($news);
				$main_smarty->assign('news',$news);
				$main_smarty->assign('tpl_center', featured_tpl_path . 'featured_admin');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
				break;
			}
		}
 	}
	else {
		$action = $_REQUEST['action'];
		switch($action) {
			case "view_image": {
				$id=$_REQUEST['id'];
				$sql="SELECT featured_image FROM " . table_prefix . "featured WHERE featured_id=".$id."";
				$news = $db->get_results($sql);
				$news = object_2_array($news);
				ob_end_clean();
				ob_start();
				header ("Content-type: image/jpeg");
				echo $news[0]['featured_image'];
				ob_end_flush();
				exit;
				break;
			}
		}
	}
}

function featured_getdata(&$vars) {
	global $db, $main_smarty, $the_template;
	$featured_sql="SELECT featured_id, featured_link_id, featured_enabled FROM " . table_prefix . "featured WHERE featured_enabled='Yes' ORDER BY featured_id ASC";
	$featured = $db->get_results($featured_sql);
	$featured = object_2_array($featured);
	for($i=0;$i<count($featured);$i++) {
		$news=null;
		$sql_news="SELECT link_id, link_url, link_title, link_title_url, link_summary, link_date, link_votes, link_comments FROM " . table_prefix . "links WHERE link_id=".$featured[$i]['featured_link_id'];
		$news= $db->get_results($sql_news);
		foreach($news as $dblink) {
			$featured[$i]['link_summary'] = str_replace("\n", "<br />", $dblink->link_summary);
			$featured[$i]['link_summary'] = str_replace("’", "'", $featured[$i]['link_summary']);
			$featured[$i]['link_summary'] = str_replace("–", "-", $featured[$i]['link_summary']);
			$featured[$i]['link_summary']= str_replace("—", "-", $featured[$i]['link_summary']);
			$featured[$i]['link_summary'] = str_replace("“", "\"", $featured[$i]['link_summary']);
			$featured[$i]['link_summary'] = str_replace("”", "\"", $featured[$i]['link_summary']);	
			$featured[$i]['link_title']=$dblink->link_title;
			$featured[$i]['link_date']=$dblink->link_date;
			$featured[$i]['link_votes']=$dblink->link_votes;
			$featured[$i]['link_comments']=$dblink->link_comments;
		}
		$featured[$i]['link_url']=my_pligg_base."/story.php?title=".$dblink->link_title_url;
		
		$sql = "SELECT * FROM " . table_prefix . "featured ORDER BY featured_id ASC";
		$news = $db->get_results($sql);
		$news = object_2_array($news);
		$main_smarty->assign('news',$news);
		
	}
	$main_smarty->assign('featured',$featured);
	$var=$main_smarty->fetch(featured_tpl_path . 'featured.tpl');
	$main_smarty->assign('featured',$var);
}
?>
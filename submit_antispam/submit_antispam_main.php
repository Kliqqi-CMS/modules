<?php
//============================================================================
// ____________________PLIGG Submit AntiSpam Module ADDON_____________________
//
//  Created by AnAlienHolakres3               ||| XXXXX  XX     XX XXXX   XXXX
// (c) 2008-2009                Jakub Holasek ||| XXXXX  XX     XX X      X
// @last_update                    23/11/2008 ||| XX     XX     XX X  XX  X  XX
// @version                              0.15 ||| XX     XXXXXX XX XXXXX  XXXXX
//
// This file can be used by Pligg community.
//=============================================================================

//*****************************************************************************
//  Function check_submit_authorization() checks if user is authorized to submit
//  specific link or comment
//  @param mode - link or comment
//*****************************************************************************
function check_submit_authorization($location) {

	global $current_user, $db, $main_smarty,$the_template;

  $location = implode($location);  
  // if user is ADMIN or GOD then there is no restriction         
  
  force_authentication(); 
  $canIhaveAccess = 0;
  $canIhaveAccess = $canIhaveAccess + checklevel('admin');
  $canIhaveAccess = $canIhaveAccess + checklevel('moderator');
  
  // default authorization level = 0 => 1 link per day
  $authorization_submit_level=0;  
               
  if ($canIhaveAccess) {
    $main_smarty->assign('admin_present',true);
    return true;   
    
  } else { 
      
      $sql = "SELECT var_value FROM " . table_config . " WHERE var_name LIKE";             
      // get how many links in history is evaluated
      $var = 'links_history_count';
      
      $links_history_count = $db->get_var($sql . " '". $var."'");       
      // get how many votes is needed to user get authorization level 1
      $var = 'level_1_votes';
      $level_1_votes = $db->get_var($sql . " '". $var."'");       
      
      // get how many votes is needed to user get authorization level 2      
      $var = 'level_2_votes';
      $level_2_votes = $db->get_var($sql . " '". $var."'");       
      
      // get how many votes is needed to user get authorization level 3      
      $var = 'level_3_votes';
      $level_3_votes = $db->get_var($sql . " '". $var."'");       
      
      // get how many links can user submit when reach authorization level 1
      $var = 'level_1_submit_links';
      $level_1_submit_links = $db->get_var($sql . " '". $var."'");       
      // get how many links can user submit when reach authorization level 2
      $var = 'level_2_submit_links';
      $level_2_submit_links = $db->get_var($sql . " '". $var."'");       
      
      // get how many links can user submit when reach authorization level 3
      $var = 'level_3_submit_links';
      $level_3_submit_links = $db->get_var($sql . " '". $var."'");     
      
      // get how many links user has ever submitted
      $user_ever_submitted_links_count = $db->get_var(
      "SELECT count(link_id) FROM " . table_links . 
      " WHERE link_author=".$current_user->user_id .
      " AND
      link_status not like 'discard'");
        
      
      // get actual average votes value   
      $sum_vv = $db->get_var("SELECT sum(vote_value) FROM " .table_votes ."
                                                        JOIN " .table_links. " ON " . table_links .".link_id=" .table_votes .".vote_link_id 
                                                         WHERE link_author=".$current_user->user_id ." AND link_status not like 'discard' 
                                                         ORDER BY link_date LIMIT $links_history_count");

     if ($sum_vv) {                                                                      
           
            if (!$links_history_count) {echo "Links history count in submit antispam addon cannot be set 0"; die;}
     
            if ($user_ever_submitted_links_count < $links_history_count) {
                $average_votes_value = $sum_vv/($user_ever_submitted_links_count*10);
          
            } else {
                $average_votes_value = $sum_vv/($links_history_count*10);
         
            }
     } else {
       $average_votes_value = 0;   
       
     }
      // get user submitted links in last 24 hours
      $_24hrs=strtotime("-1 day");
      $links_in_24_hrs=$db->get_var("SELECT count(link_id) FROM " .table_links. 
                                    " WHERE link_author=$current_user->user_id AND link_date > FROM_UNIXTIME($_24hrs) AND link_status not like 'discard'");
      $last_link_date =$db->get_var("SELECT link_date FROM ". table_links. " WHERE link_author=$current_user->user_id  AND link_status not like 'discard' ORDER BY link_date desc LIMIT 1");
      $last_link_date_plus_24h=date('m/d/Y h:i a',strtotime($last_link_date)+3600*24);
      //what authorization submit level user has
      if ($average_votes_value >= $level_3_votes) {
          $authorization_submit_level=3;
          } else if ($average_votes_value >= $level_2_votes) {
                $authorization_submit_level = 2;
                    } else if ($average_votes_value >= $level_1_votes) {
                                $authorization_submit_level = 1;
                            }
                            
    // how many links are in current authorization level                            
     switch ($authorization_submit_level) {
             case 0:
             $submit_limit = 1;
             break;
             case 1:
             $submit_limit = $level_1_submit_links;
             break;
             case 2:
             $submit_limit = $level_2_submit_links;
             break;
             case 3:
             $submit_limit = $level_3_submit_links;
             break;
     }
     
   if ($location == "submit_post_authentication") { 
   
     if ($links_in_24_hrs >= $submit_limit){     
        $main_smarty->assign('submit_mode',"link");                  
        $main_smarty->assign('submitted_in_24h',$links_in_24_hrs);
        $main_smarty->assign('actual_limit',$submit_limit); 
        $main_smarty->assign('actual_limit_r',round($submit_limit,0));  
        $main_smarty->assign('current_authorization_level',$authorization_submit_level);   
        
        $main_smarty->assign('authorization_level_0_submit_allowed',1);  // for level 0 there is only  1 link per day
        $main_smarty->assign('authorization_level_1_submit_allowed',$level_1_submit_links);
        $main_smarty->assign('authorization_level_2_submit_allowed',$level_2_submit_links);
        $main_smarty->assign('authorization_level_3_submit_allowed',$level_3_submit_links);
        $main_smarty->assign('authorization_level_1_required_votes',$level_1_votes);
        $main_smarty->assign('authorization_level_2_required_votes',$level_2_votes);
        $main_smarty->assign('authorization_level_3_required_votes',$level_3_votes);
        $main_smarty->assign('last_date',$last_link_date);  
        $main_smarty->assign('last_date_plus_24h',$last_link_date_plus_24h);  
        $main_smarty->assign('average_votes_value',round($average_votes_value,2));  
        $main_smarty->assign('tpl_center',submit_antispam_tpl_path . '/submit_error');    
        $main_smarty->display($the_template . '/pligg.tpl');         
        
        die;
      
     } else {
        $main_smarty->assign('submitted_links_24h',$links_in_24_hrs);    
        $main_smarty->assign('links_actual_limit',$submit_limit);   
                                                                                           
     }         
     
  } else if ($location == "story_insert_comment") {           
         
  //check if comment restriction is in use
    $comment_restriction = $db->get_var("SELECT var_value FROM " . table_config . " WHERE var_name LIKE 'comment_restriction'");
    
    if($comment_restriction) {        
        
    // get how many comments user submitted in 24 hours
         $comments_in_24_hrs=$db->get_var("SELECT count(comment_id) FROM " . table_comments .           
                                    " WHERE comment_user_id=$current_user->user_id AND comment_date > FROM_UNIXTIME($_24hrs)");  
                                    
        // get comment submit multiplier                                                               
        $submit_multiplier=$db->get_var("SELECT var_value FROM ". table_config . " WHERE var_name LIKE 'comment_submit_multiplier'");
               
        // average get user comment votes value, please note this value is increased by 1 bc. at the beginning user has no votes 
        // and we need to multiply * 1 (not 0)
         $average_u_c_v=$db->get_var("SELECT avg(comment_votes) FROM ". table_comments . " WHERE comment_user_id=$current_user->user_id LIMIT $links_history_count");
         $average_u_c_v++;
                 
         $comments_limit = $submit_limit * $submit_multiplier*$average_u_c_v;
                
         $last_comment_date =$db->get_var("SELECT comment_date FROM ". table_comments. 
                " WHERE comment_user_id=$current_user->user_id ORDER BY comment_date desc LIMIT 1");  
                
         $last_comment_date_plus_24h=date('m/d/Y h:i a',strtotime($last_comment_date)+3600*24);              
        
        if ($comments_limit <= $comments_in_24_hrs) {
            $main_smarty->assign('submit_mode',"comment");
            $main_smarty->assign('submitted_in_24h',$comments_in_24_hrs);
            $main_smarty->assign('actual_limit',round($comments_limit,2));   
            $main_smarty->assign('actual_limit_r',round($comments_limit,0));   
            $main_smarty->assign('current_authorization_level',$authorization_submit_level);   
            $main_smarty->assign('authorization_level_0_submit_allowed',1);  // for level 0 there is only  1 link per day
            $main_smarty->assign('authorization_level_1_submit_allowed',$level_1_submit_links);
            $main_smarty->assign('authorization_level_2_submit_allowed',$level_2_submit_links);
            $main_smarty->assign('authorization_level_3_submit_allowed',$level_3_submit_links);
            $main_smarty->assign('authorization_level_1_required_votes',$level_1_votes);
            $main_smarty->assign('authorization_level_2_required_votes',$level_2_votes);
            $main_smarty->assign('authorization_level_3_required_votes',$level_3_votes);
            $main_smarty->assign('last_date',$last_comment_date);  
            $main_smarty->assign('last_date_plus_24h',$last_comment_date_plus_24h);  
            $main_smarty->assign('average_votes_value',round($average_votes_value,2));  
            $main_smarty->assign('average_comm_vot_value',round($average_u_c_v,2));
            $main_smarty->assign('link_submit_limit',round($submit_limit,2));   
            $main_smarty->assign('submit_mul',$submit_multiplier);
            $main_smarty->assign('tpl_center',submit_antispam_tpl_path . '/submit_error');    
            $main_smarty->display($the_template . '/pligg.tpl');  
                
            die; 
        } else {
              // do nothing   
              
                            
        }
         
      }
     
    }   
      
  }     
     
}


  
   
?>
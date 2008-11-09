<?php
 	if (@txpinterface == 'admin') { 
	
	        add_privs('auto_delete_set', '1,2,3,6');
			
            register_tab('extensions', 'auto_delete', 'Auto Delete');
            register_callback('auto_delete_set' , 'auto_delete'); 
            register_callback('expired_lists' , 'article');        
        }

function auto_delete_set($event, $step)
{ 
	    	$where = "name = 'auto_delete_pref'";
            $pref_set = ps('pref_set');
            $action = ps('action');
            $current_set = "Installing";
			
         if(!empty($pref_set)){
            safe_update('txp_prefs', "`val` = '$pref_set'", $where);
         }
		 
         if($pref_set == 2) {
             	$current = 'Automated Delete'; 
			 } elseif($pref_set == 1) {
             	$current = 'Delete by Link'; 
			 } else { 
			 	$current = 'Set Preferences'; 
		  }
			 
		pagetop('Auto Delete Preferences', $current);
		echo "<div align=\"center\" style=\"margin-top:3em\">";
		echo form(			
                  fInput("submit", "manual_set", "Save", "smallerbox").'<br />Set to Delete by Link'.sp.
                  fInput("radio", "pref_set", "1", "radio").'<br />Set to Automated Delete'.
                  fInput("radio", "pref_set", "2", "radio").
				  eInput("auto_delete").sInput("step_b")
		);
		
         extract(safe_row('val as auto_delete_now' , 'txp_prefs' , $where));
		 
          if(isset($auto_delete_now)) {
		  
             if($auto_delete_now == 2) {
			 
             		$current_set = 'Automated Delete';
			 }
			  
				elseif($auto_delete_now == 1) {
				
             $current_set = 'Delete by Link';
			 
		  }
		     } else { 
		  
		  	 auto_delete_install(); 
			 
		  } 
                echo '<br /><p><strong>Current Setting:'.$current_set.'</strong></p>';
		echo "</div>";

}

// -------------------------------------------------------------

function auto_delete_install()
{
		safe_insert('txp_prefs', "`name` = 'auto_delete_pref', `val` = '1', `html` = 'yesnoradio', `prefs_id` = 1, `type` = 2, `event` = 'admin', `position` = 0");
}

//---------------------------------------------------------------
function expired_lists()
     {
	$where = "Expires > 0";
	$automate = "name = 'auto_delete_pref'";
    $expire_field = "Expires";
    $action = gps("action");
	
     extract(safe_row('val as auto_delete_now' , 'txp_prefs' , $automate));
	 
    $result = safe_rows_start('*', 'textpattern', $expire_field);
	
    if($action == 'delete' || $auto_delete_now == 2) { 
	
		while($row = nextRow($result)) {
		
          if(strtotime($row[$expire_field]) <= mktime()+tz_offset()) {
		  
				   $where = "ID=".$row['ID']."";
                   safe_delete('textpattern', $where );
           	} 
		} 
		
		update_lastmod(); return ;
		
      }
	   
     $insert = '<h3 class="plain"><a href="#expired" onclick="toggleDisplay(\'expired\'); return false;">Expired Articles</a></h3><div id="expired" style="display:none;"><ul class="plain-list">';
	 
		while($row = nextRow($result)) {
		
            if(strtotime($row[$expire_field]) <= mktime()+tz_offset()) {
		  
			$insert .= '<li><a href="?event=article'.a.'step=edit'.a.'ID='.$row['ID'].'">'.$row['Title'].'</a></li>';
			
            } 
		 }
		
     $insert .= '</ul>';
     $insert .= '<p><a href="?event=article'.a.'action=delete">Delete All Expired</a></p></div>';
		
     	if (is_callable('dom_attach')) {
		
		    echo dom_attach('article-col-1', $insert, $insert, 'div');
		
		}
    }
?>

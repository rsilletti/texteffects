

<?php
 	if (@txpinterface == 'admin') {
 					add_privs('delete_expired', '1,2,6');
            		register_tab("extensions", "delete_expired", "Expired");
					register_callback("expired_list", "delete_expired");       
        }

//---------------------------------------------------------------
function expired_list()
     {
	    $where = "Expires > 0";
        $expire_field = "Expires";
        $action = gps("action");
	    $result = safe_rows_start('*', 'textpattern', $expire_field);
		
        if($action == 'delete') { 
			while($row = nextRow($result))
               {
          		if(strtotime($row[$expire_field]) <= mktime()+tz_offset()) {
					$where = "ID=".$row['ID']."";
                    safe_delete('textpattern', $where );
                } 
			}
        }
		 
        $insert = '<h3 class="plain"><a href="?event=delete_expired&step=new_select">Expired Articles</a></h3><div id="expired" style="margin: .3em auto auto auto; text-align: center;"><ul class="plain-list">';
		
		while($row = nextRow($result)) {
		
          if(strtotime($row[$expire_field]) <= mktime()+tz_offset()) 
          	{
				$insert .= '<li><a href="?event=article'.a.'step=edit'.a.'ID='.$row['ID'].'">'.$row['Title'].'</a></li>';
         	} 
		 }
        $insert .= '</ul>';
		
			if(has_privs('article.delete'))
			{
       			$insert .= '<p><a href="?event=delete_expired'.a.'action=delete" onclick="return verify(\'Permanently delete ALL expired articles?\')">Delete All Expired</a></p></div>';
			}
			
	echo $insert;
     }

?>


<?php
 	if (@txpinterface == 'admin') { 
            register_callback('expired_list' , 'article');        
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
			 
			update_lastmod();
        }
		 
        $insert = '<h3 class="plain"><a href="#expired" onclick="toggleDisplay(\'expired\'); return false;">Expired Articles</a></h3><div id="expired" style="display:none;"><ul class="plain-list">';
		
		while($row = nextRow($result)) {
		
          if(strtotime($row[$expire_field]) <= mktime()+tz_offset()) 
          	{
				$insert .= '<li><a href="?event=article'.a.'step=edit'.a.'ID='.$row['ID'].'">'.$row['Title'].'</a></li>';
         	} 
		 }
        $insert .= '</ul>';
		
			if(has_privs('article.delete'))
			{
       			$insert .= '<p><a href="?event=article'.a.'action=delete" onclick="return verify(\'Permanently delete ALL expired articles?\')">Delete All Expired</a></p></div>';
			}
			
     		if(is_callable('dom_attach')) 
			{
				echo dom_attach('article-col-1', $insert, $insert, 'div');
			}
     }

?>
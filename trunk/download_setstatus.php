<?php

function ras_download_setstatus( $atts ) 
{	
	global $thisfile;
	assert_file();
				
		extract(lAtts(array(
			'setstatus' => '4',
		), $atts));
	if( $setstatus == 2 || $setstatus == 3 || $setstatus == 4 ) {	
	$where = "`id`='".$thisfile['id']."'";
	$set = "`status`='".$setstatus."'";
		safe_update('txp_file', $set, $where );
        } else {
     return "Status must be set to 2, 3 or 4 ";
     }
}

?>

<?php
	function download_setstatus( $atts ) 
	{
	
		global $thisfile;
		assert_file();
				
		extract(lAtts(array(
			'setstatus' => '4',
		), $atts));
		
		$where = "`id`='".$thisfile['id']."'";
		$set = "`status`='".$setstatus."'";
			safe_update('txp_file', $set, $where );
	}
?>

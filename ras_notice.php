<?php
//----------------------------------------------------------------------------
	function ras_notice($atts)
	{
		extract(lAtts(array(
			'format' => 'day, hour, minute, second',
			'type' => 'apos'
		),$atts));
		$diff_atts = array();
		switch ($type) {
		case 'apos' :
		
        	$time_diff = new RasTimeDiff(ts_diff::apos_diff());
			$tense = ($time_diff->total < 0) ? "Will begin in " : "In Progress for ";
		break;
		
		case 'axpr' :  
        	$time_diff = new RasTimeDiff(ts_diff::axpr_diff());
			$tense = ($time_diff->total < 0) ? "Will expire in " : "Has been expired for ";
		break;
		
		case 'amdf' : 
        	$time_diff = new RasTimeDiff(ts_diff::amdf_diff());
		break;
		
		}
		
		$days = abs($time_diff->days); 
		($days == 1) ? $sing_days = ' Day' : $sing_days = ' Days';
		$hours = abs($time_diff->hours);
		($hours == 1) ? $sing_hours = ' Hour' : $sing_hours = ' Hours'; 
		$minutes = abs($time_diff->minutes);
		($minutes == 1) ? $sing_minutes = ' Minute' : $sing_minutes = ' Minutes'; 
		$seconds = abs($time_diff->seconds);
		($seconds == 1) ? $sing_seconds = ' Second' : $sing_seconds = ' Seconds'; 
		$total = abs($time_diff->total);
		
		$output = '';
		
		foreach (do_list($format) as $opt) {
			switch($opt) 
			{
	    		case 'day'    : $output .= ($days) ? $days.' Days' : '';
				break;	
				case 'hour'   : $output .= ($hours) ? ' '.sprintf("%02s", $hours).$sing_hours : ' No Hours';
				break;
	    		case 'minute' : $output .= ($minutes) ? ' '.sprintf("%02s", $minutes).$sing_minutes : ' No Minutes';
				break;
				case 'second' : $output .= ($seconds) ? ' '.sprintf("%02s", $seconds).$sing_seconds : '--';
				break;
			}
		}
		return $tense.$output;
	}


//-----------------------------------------------------------------------------

	function ras_cal_notice($atts)
	{
		extract(lAtts(array(
			'format' 		=> 'hour, minute, second',
			'type' 			=> 'apos',
			'wraptag' 		=> '',
			'break'			=> '<br />',
			'delimit' 		=> ':',
			'lead_future'   => '',
			'trail_future'  => '',
			'lead_past'  	=> '',
			'trail_past'  	=> '',
			'day_text'    	=> '',
			'class'        	=> __FUNCTION__		
		),$atts));
		$diff_atts = array();		
		switch ($type) {
		case 'apos' :		
        	$time_diff = new RasTimeDiff(ts_diff::apos_diff());
			$tense = ($time_diff->total < 0);
		break;
		
		case 'axpr' :  
        	$time_diff = new RasTimeDiff(ts_diff::axpr_diff());
			$tense = ($time_diff->total < 0);
		break;
		
		case 'amdf' : 
        	$time_diff = new RasTimeDiff(ts_diff::amdf_diff());
			$tense = ($time_diff->total < 0);
		break;
		
		}
				
		$format = do_list($format);
		
		$days = abs($time_diff->days); $hours = abs($time_diff->hours); $minutes = abs($time_diff->minutes); $seconds = abs($time_diff->seconds); $total = abs($time_diff->total);
		
		($day_text == '') ? ($day_text == 1) ? $day_text = ' Day' : $day_text = ' Days' : ''; 
		$output = '';
				(in_array('day', $format)) ? $output .= ($days) ? $days.$day_text.$break : '' : '';
				(in_array('hour', $format)) ? $output .= ($hours) ? ' '.sprintf("%02s", $hours).$delimit : '00:' :'';
				(in_array('minute', $format)) ? $output .= ($minutes) ? sprintf("%02s", $minutes).$delimit : '00:' : '';
				(in_array('second', $format)) ? $output .= ($seconds) ? sprintf("%02s", $seconds) : '--' :'';
				
				if($tense) {
					$out = $lead_future.$output.$trail_future;
				} else {
					$out = $lead_past.$output.$trail_past;
				}
				
		 		return ($wraptag) ? doTag($out, $wraptag, $class, '','') : $output;
	}

//---------------------------------------------------------------------------------------------

	
class RasTimeDiff {

        private $diff =0;

	function __construct($diff)
	{

  	$this->total = $diff;
	$count = 0;
	if($diff > 0) {

		while ($diff > 86400) {
			++$count;
				$diff = $diff - 86400;	


			}
			$this->days = $count;
			
	$count = 0;
	
		while ($diff > 3600) {
			++$count;
				$diff = $diff - 3600;	
			}
			$this->hours = $count;
			
	$count = 0;

		while ($diff > 60) {
			++$count;
				$diff = $diff - 60;	
			}
			$this->minutes = $count;
			$this->seconds = $diff;
			
	return $this;

	
	}
	 
	else 
	
	if($diff < 0) {
	
			$diff = abs($diff);
			
		while ($diff > 86400) {
			--$count;
				$diff = $diff - 86400;	
			}
			$this->days = $count;
			
	$count = 0;
	
		while ($diff > 3600) {
			--$count;
				$diff = $diff - 3600;	
			}
			$this->hours = $count;
			
	$count = 0;

		while ($diff > 60) {
			--$count;
				$diff = $diff - 60;	
			}
			$this->minutes = $count;
			$this->seconds = $diff* -1;
			
	return $this;
	
		}
			else return 0;
		}
	}
//-------------------------------------------------------------------------------------------
class ts_diff {
 static function apos_diff() {
		global $thisarticle;
		assert_article();
	return time() - $thisarticle['posted'] ;
	}
 static function axpr_diff() {
		global $thisarticle;
		assert_article();
	return time() - $thisarticle['expires'] ;
	}
 static function amdf_diff() {
		global $thisarticle;
		assert_article();
	return time() - $thisarticle['modified'] ;
	}
 static function cpos_diff() {
		global $thiscomment;
		assert_comment();
	return time() - $thiscomment['posted'] ;
	}
 static function fpos_diff() {
		global $thisfile;
		assert_file();
	return time() - $thisfile['created'] ;
	}
 static function fmdf_diff() {
		global $thisfile;
		assert_file();
	return time() - $thisfile['modified'] ;
	}
 static function lpos_diff() {
		global $thislink;
		assert_link();
	return time() - $thislink['date'] ;
	}
}
//-------------------------------------------------------------------------------------------

	function ras_posted_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));

	global $thisarticle;
	assert_article();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thisarticle['posted'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thisarticle['posted'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thisarticle['posted'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thisarticle['posted'] ;
		break;	
		}
	return '';
	}

//----------------------------------------------------------------------

	function ras_expired_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));

	global $thisarticle;
	assert_article();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thisarticle['expires'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thisarticle['expires'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thisarticle['expires'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thisarticle['expires'] ;
		break;	
		}
	return '';
	}

//-------------------------------------------------------------------

	function ras_modified_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));
	global $thisarticle;
	assert_article();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thisarticle['modified'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thisarticle['modified'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thisarticle['modified'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thisarticle['modified'] ;
		break;	
		}
	return '';
	}

//---------------------------------------------------------------------

	function ras_comment_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));
		
	global $thiscomment;
	assert_comment();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thiscomment['posted'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thiscomment['posted'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thiscomment['posted'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thiscomment['posted'];
		break;	
		}
	return '';
	}

//-------------------------------------------------------------------

	function ras_file_created_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));
	
	global $thisfile;
	assert_file();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thisfile['created'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thisfile['created'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thisfile['created'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thisfile['created'];
		break;	
		}
		
	return '';
	}

//--------------------------------------------------------------

	function ras_file_modified_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));
		
	global $thisfile;
	assert_file();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thisfile['modified'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thisfile['modified'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thisfile['modified'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thisfile['modified'];
		break;	
		}	
	return '';
	}

//--------------------------------------------------------------------

	function ras_link_elapsed($atts)
	{
		extract(lAtts(array(
			'format' => 'seconds'
		),$atts));

		
	global $thislink;
	assert_link();
	
	switch ($format) {
		case 'days' :		
			return (time() - $thislink['date'])/86400 ;
		break;
		
		case 'hours' :  
			return (time() - $thislink['date'])/3600 ;
		break;
		
		case 'minutes' : 
			return (time() - $thislink['date'])/60 ;
		break;
		
		case 'seconds' : 
			return time() - $thislink['date'];
		break;	
		}
	return '';
	}
?>

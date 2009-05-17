<?php

/**
* @license http://www.gnu.org/licenses/licenses.html#GPL
* @package txpdiff
*/

/**
* Returns diff value in days, hours, minutes, and seconds
* as passed as seconds for total diff as an integer - both positive
* and negative values.
*
* @package txpdiff
* @author Rick Silletti
* @copyright 2009 Rick Silletti
*/

	
class rasTimeDiff {

	function __construct($diff)
	{
            if ( !is_int($diff)) { 
                   trigger_error(gTxt('error_integer_diff_type'));
                   return false;
             }

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

			
		while ($diff < 86400) {
			--$count;
				$diff = $diff + 86400;	
			}
			$this->days = $count;			
	$count = 0;
	
		while ($diff < 3600) {
			--$count;
				$diff = $diff + 3600;	
			}
			$this->hours = $count;			
	$count = 0;

		while ($diff < 60) {
			--$count;
				$diff = $diff + 60;	
			}
			$this->minutes = $count;
			$this->seconds = $diff;			
	return $this;	
		}
		else return 0;
	  }
	}

?>
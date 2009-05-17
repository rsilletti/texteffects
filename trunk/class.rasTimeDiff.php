<?php
//---------------------------------------------------------------------------------------------

	
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
        function __toString() {
                return "{$this->total}";
          }
	}

?>
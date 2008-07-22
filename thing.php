<?php

//--------------------------------------------------------------------------------

    function ras_thing($atts)  {
	 
	 		extract(lAtts(array(
			'array_name'        => NULL,
			'element'           => NULL,
		), $atts));
		
		return $array_name($element); 
 }
 
	function thisarticle($element)  { 
		global $thisarticle; 
		return $thisarticle[$element]; 
	}
	
	function thispage($element)  { 
		global $thispage; 
		return $thispage[$element]; 
	}


//----------------------------------------------------------------------------------

?>

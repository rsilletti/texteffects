<?php

class CustomByName {

public $fieldname;

        function __construct($fieldname)
        {
        $this->name = $fieldname;
        
			$where = "val='".doSlash($this->name)."'";
			$rs = safe_row('name', 'txp_prefs', $where);
			
		$this->field = rtrim($rs['name'], '_set');
			  
        return $this;
        
        }
}

class SumName extends CustomByName {
		
		function __construct($fieldname) {
		        
		    parent::__construct($fieldname);
		$where = "".$this->field." > 0";        	
		$num = safe_row("SUM(".$this->field.")" , 'textpattern' , $where);
    	$this->result = $num["SUM(".$this->field.")"];
    	return $this;
    	}
		        	
}

class CountName extends CustomByName {
		
		function __construct($fieldname) {
		        
		    parent::__construct($fieldname);
		$where = "".$this->field." > 0";
		$num = safe_row("COUNT(".$this->field.")" , 'textpattern' , $where);
    	$this->result = $num["COUNT(".$this->field.")"];
    	return $this;
    	}
		        	
}

class MaxName extends CustomByName {
		
		function __construct($fieldname) {
		        
		    parent::__construct($fieldname);
		$where = "".$this->field." > 0";        	
		$num = safe_row("MAX(".$this->field.")" , 'textpattern' , $where);
    	$this->result = $num["MAX(".$this->field.")"];
    	return $this;
    	}
		        	
}

class MinName extends CustomByName {
		
		function __construct($fieldname) {
		        
		    parent::__construct($fieldname);
		$where = "".$this->field." > 0";        	
		$num = safe_row("MIN(".$this->field.")" , 'textpattern' , $where);
    	$this->result = $num["MIN(".$this->field.")"];
    	return $this;
    	}
		        	
}

?>
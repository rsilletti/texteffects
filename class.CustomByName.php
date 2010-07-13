<?php

class CustomByName {

private $name;
private $debug;

        function __construct($name, $debug=null)
        {
        $this->name = $name;
        $this->debug = $debug;
        
			$where = "val='".doSlash($this->name)."'";
			$rs = safe_row('name', 'txp_prefs', $where);
			
		$this->field = rtrim($rs['name'], '_set');
		$this->where = "".$this->field." > 0"; 
		return ($debug) ? dmp($this) : $this;
		
        }
        
        function sumName() {
        	$num = safe_row("SUM(".$this->field.")" , 'textpattern' , $this->where);
    		$this->result = $num["SUM(".$this->field.")"];
    		return $this->result;
        }

        function countName() {
        	$num = safe_row("COUNT(".$this->field.")" , 'textpattern' , $this->where);
    		$this->result = $num["COUNT(".$this->field.")"];
    		return $this->result;
        }

        function maxName() {
        	$num = safe_row("MAX(".$this->field.")" , 'textpattern' , $this->where);
    		$this->result = $num["MAX(".$this->field.")"];
    		return $this->result;
        }

        function minName() {
        	$num = safe_row("MIN(".$this->field.")" , 'textpattern' , $this->where);
    		$this->result = $num["MIN(".$this->field.")"];
    		return $this->result;
        }
}

?>
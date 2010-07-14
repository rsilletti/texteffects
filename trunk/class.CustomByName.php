<?php
/**
* @license http://www.gnu.org/licenses/licenses.html#GPL
* @package txpcustom_fields
*/

/**
* Returns extracted values from custom fields set to integer values by custom
* field named as text. Extracted values are : the sum of integer values,
* the min and max integer values, and the number of rows with integer values set.
*
* @package txpcustom_fields
* @author Rick Silletti
* @copyright 2010 Rick Silletti
*/

/**
* Class constructor is passed a field name as text 
* and returns the textpattern table column name that
* is associated with it.
* @return text 
*/
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
/**
* Sum of integer values in custom field column. 
* function call obj->sumName()
* @return integer
*/        
        function sumName() {
        	$num = safe_row("SUM(".$this->field.")" , 'textpattern' , $this->where);
    		return $num["SUM(".$this->field.")"];
        }
/**
* Number of rows containg integer values in custom field column. 
* function call obj->countName()
* @return integer
*/
        function countName() {
        	$num = safe_row("COUNT(".$this->field.")" , 'textpattern' , $this->where);
    		return $num["COUNT(".$this->field.")"];
        }
/**
* Largest integer value in custom field column. 
* function call obj->maxName()
* @return integer
*/
        function maxName() {
        	$num = safe_row("MAX(".$this->field.")" , 'textpattern' , $this->where);
    		return $num["MAX(".$this->field.")"];
        }
/**
* Smallest integer value in custom field column. 
* function call obj->minName()
* @return integer
*/
        function minName() {
        	$num = safe_row("MIN(".$this->field.")" , 'textpattern' , $this->where);
    		return $num["MIN(".$this->field.")"];
        }
}

?>
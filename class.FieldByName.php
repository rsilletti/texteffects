<?php
/**
* @license http://www.gnu.org/licenses/licenses.html#GPL
* @package txpcustom_fields
*/

/**
* Returns custom field names by textpattern table column relationship to name set in preferences.
* 
*
* @package txpcustom_fields
* @author Rick Silletti
* @copyright 2010 Rick Silletti
*/

/**
* Class constructor is passed a field name as text 
* and returns the textpattern table column name that
* is associated with it.
* @param custom field name as text
* @return textpattern column name as text 
*/

class FieldByName {

private $name;
private $debug;

		function __construct($name, $debug=null)
		{
		$this->name = $name;
		$this->debug = $debug;

			$where = "val='".doSlash($this->name)."'";
			$rs = safe_row('name', 'txp_prefs', $where);

				if($rs) 
				{

				$this->field = rtrim($rs['name'], '_set');

				} else { trigger_error(gTxt('name_not_found')); }

		return ($debug) ? dmp($this) : $this;
		}

/**
* Returns value set in custom field named per article from inside article form. 
* function call obj->fieldData()
* @return text
*/

		function fieldData() 
		{
		global $thisarticle;

		assert_article();

		return $thisarticle[strtolower($this->name)];
		}

/**
* Returns an indexed array of values set in custom field named. 
* function call obj->fieldsData()
* @return array
*/

		function fieldsData() 
		{
			$where_data = " `".$this->field."` !=  ''";
			$this->num = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$where_data."");

		return $this->num;
		}
}

?>
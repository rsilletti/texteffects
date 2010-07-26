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

/**
* Returns textpattern table data indexed by custom field named 
* with active data per article from inside article form. 
* function call obj->articleData()
* @param textpattern table field name/names as comma delimited list, default is '', all.
* @return array
*/

		function articleData($col="*") 
		{
		global $thisarticle;

		assert_article(); 

		$this->col_list = $col;
		$txp_col = getThings("SHOW FIELDS FROM ".safe_pfx('textpattern')."");
		$txp_col[] = "*";

		if(array_intersect(do_list($this->col_list), $txp_col) === do_list($this->col_list)) {
			$where_data = " `".$this->field."` !=  ''";
			$this->num = getRow("SELECT ".$this->col_list." FROM ".safe_pfx('textpattern')." WHERE ".$where_data." and ID = ".$thisarticle['thisid']."");
		} else { trigger_error(gTxt('column_not_found')); }

		return $this->num;
		}
		

/**
* Returns textpattern table data indexed by custom field named with active data. 
* function call obj->articlesData()
* @param textpattern table field name/names as comma delimited list, default is '', all.
* @return array
*/

		function articlesData($col="*") 
		{
		$this->col_list = $col;
		$txp_col = getThings("SHOW FIELDS FROM ".safe_pfx('textpattern')."");
		$txp_col[] = "*";

		if(array_intersect(do_list($this->col_list), $txp_col) === do_list($this->col_list)) {
			$where_data = " `".$this->field."` !=  ''";
			$this->num = getRows("SELECT ".$this->col_list." FROM ".safe_pfx('textpattern')." WHERE ".$where_data."");
		} else { trigger_error(gTxt('column_not_found')); }

		return $this->num;
		}
}

?>
<?php
/**
* Returns custom field names by textpattern table column relationship to name set in preferences.
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
* 02110-1301 USA
*
* rsilletti@gmail.com
*
* @package txpcustom_fields
*/

/**
*
* @package txpcustom_fields
* @author Rick Silletti
* @copyright 2010 Rick Silletti
*/

/**
* Class constructor is passed a field name as text 
* and returns the textpattern table column name that
* is associated with it.
* @param text custom field name.
* @return text $name textpattern column name. 
*/

class FieldByName {

private $name;
private $debug;
public $where_null;

		function __construct($name, $debug=null)
		{
		$this->name = $name;
		$this->debug = $debug;

			$where = "val='".doSlash($this->name)."'";
			$rs = safe_row('name', 'txp_prefs', $where);

				if($rs) 
				{

				$this->field = rtrim($rs['name'], '_set');
				$this->where_null = " `".$this->field."` != '' ";

				} else { trigger_error(gTxt('name_not_found')); }

			if($debug) 
			{

				dmp($this);
				$multi = safe_rows('name', 'txp_prefs', $where);
				(sizeof($multi) > 1) ? trigger_error(gTxt('duplicate_fieldname')) : '';

			} else { return $this; }
		}

/**
* function call obj->fieldData()
* @global $thisarticle
* @return text Value set in custom field named per article from inside article form.
*/

		function fieldData() 
		{
		global $thisarticle;

		assert_article();

		return $thisarticle[strtolower($this->name)];
		}

/**
* function call obj->fieldsData()
* @return array Indexed array of values set in custom field named
*/

		function fieldsData() 
		{
			$this->num = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");

		return $this->num;
		}

/**
* Returns textpattern table data indexed by custom field named 
* with active data per article from inside article form. 
* function call obj->articleData()
* @global $thisarticle
* @param string $col textpattern table field name/names as comma delimited list, default is '', all.
* @return array Article data as set in column selection.
*/

		function articleData($col="*") 
		{
		global $thisarticle;

		assert_article(); 

		$this->col_list = $col;
		$txp_col = getThings("SHOW FIELDS FROM ".safe_pfx('textpattern')."");
		$txp_col[] = "*";

		if(array_intersect(do_list($this->col_list), $txp_col) === do_list($this->col_list)) {
			$this->num = getRow("SELECT ".$this->col_list." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null." and ID = ".$thisarticle['thisid']."");
		} else { trigger_error(gTxt('column_not_found')); }

		return $this->num;
		}

/**
* Returns textpattern table data indexed by custom field named with active data. 
* function call obj->articlesData()
* @param string $col textpattern table field name/names as comma delimited list, default is '', all.
* @return array Article data as set in column selection.
*/

		function articlesData($col="*") 
		{
		$this->col_list = $col;
		$txp_col = getThings("SHOW FIELDS FROM ".safe_pfx('textpattern')."");
		$txp_col[] = "*";

		if(array_intersect(do_list($this->col_list), $txp_col) === do_list($this->col_list)) {
			$this->num = getRows("SELECT ".$this->col_list." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");
		} else { trigger_error(gTxt('column_not_found')); }

		return $this->num;
		}
}

/**
* Extended class is passed a field name as text 
* and returns aggregate results by function calls of numeric field entries only.
* Aggregates : SUM, COUNT, MAX, MIN, AVG. 
* @param text custom field name.
* @return text $name textpattern column name. 
*/

class AggregateByName extends FieldByName  {

/**
* Sum of number values in custom field column. 
* function call obj->sumName()
* @param boolean $debug return error text for non numeric entry in field if set to 1, default is false.
* @return double
*/        
		function sumName($debug=null) {
			$num = array();
			$rs = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");

				foreach ($rs as $e) {
					if (is_numeric($e)) {
						$num[] = $e;
					} else if ($debug) { trigger_error(gTxt('non_numeric_entry')); }			
				}

			return array_sum($num);
		}

/**
* Count of number values in custom field column. 
* function call obj->countName()
* @param boolean $debug return error text for non numeric entry in field if set to 1, default is false.
* @return integer
*/         
		function countName($debug=null) {
			$num = array();
			$rs = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");

				foreach ($rs as $e) {
					if (is_numeric($e)) {
						$num[] = $e;
					} else if ($debug) { trigger_error(gTxt('non_numeric_entry')); }			
				}

			return count($num);
		}

/**
* Minimum value in custom field column. 
* function call obj->minName()
* @param boolean $debug return error text for non numeric entry in field if set to 1, default is false.
* @return double
*/ 
		function minName($debug=null) {
			$num = array();
			$rs = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");

				foreach ($rs as $e) {
					if (is_numeric($e)) {
						$num[] = $e;
					} else if ($debug) { trigger_error(gTxt('non_numeric_entry')); }			
				}
				sort($num);

			return $num[0];
		}

/**
* Maximum value in custom field column. 
* function call obj->maxName()
* @param boolean $debug return error text for non numeric entry in field if set to 1, default is false.
* @return double
*/         
		function maxName($debug=null) {
			$num = array();
			$rs = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");

				foreach ($rs as $e) {
					if (is_numeric($e)) {
						$num[] = $e;
					} else if ($debug) { trigger_error(gTxt('non_numeric_entry')); }			
				}
				rsort($num);

			return $num[0];
		}

/**
* Average value in custom field column. 
* function call obj->avgName()
* @param boolean $debug return error text for non numeric entry in field if set to 1, default is false.
* @return double
*/ 
		function avgName($debug=null) {
			$num = array();
			$rs = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$this->where_null."");

				foreach ($rs as $e) {
					if (is_numeric($e)) {
						$num[] = $e;
					} else if ($debug) { trigger_error(gTxt('non_numeric_entry')); }			
				}

			return (array_sum($num) / count($num));
		}
}
?>
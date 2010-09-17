<?php
/**
* Returns custom field names by textpattern table column relationship to name set in preferences.
*
* Copyright (C) 2010 Rick Silletti
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
* Rick Silletti, 1 April 1990
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
* function call obj->fieldData()
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
			$where_data = " `".$this->field."` !=  ''";
			$this->num = getThings("SELECT ".$this->field." FROM ".safe_pfx('textpattern')." WHERE ".$where_data."");

		return $this->num;
		}

/**
* Returns textpattern table data indexed by custom field named 
* with active data per article from inside article form. 
* function call obj->articleData()
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
			$where_data = " `".$this->field."` !=  ''";
			$this->num = getRow("SELECT ".$this->col_list." FROM ".safe_pfx('textpattern')." WHERE ".$where_data." and ID = ".$thisarticle['thisid']."");
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
			$where_data = " `".$this->field."` !=  ''";
			$this->num = getRows("SELECT ".$this->col_list." FROM ".safe_pfx('textpattern')." WHERE ".$where_data."");
		} else { trigger_error(gTxt('column_not_found')); }

		return $this->num;
		}
}

?>
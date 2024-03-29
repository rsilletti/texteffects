<?php

/**
*
* This plugin is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This plugin is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* To received a copy of the GNU Lesser General Public
* License write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
* 02110-1301 USA
*
* rsilletti@gmail.com
*
*/

function ras_author_list ($atts, $thing = NULL) 
{
		global $s, $thisauthor;
		extract(lAtts(array(
			'break'        => br,
			'label'        => '',
			'labeltag'     => '',
			'sort'         => 'user_id desc',
			'form'        => '',
			'wraptag'      => '',
			'type'         => 'Publisher,Managing Editor,Copy Editor,Staff writer,Freelancer,Designer',
			'section'      => '',
			'this_section' => 0,
			'class'        => __FUNCTION__
		), $atts));
		
			foreach(do_list($type) as $num)
				{
				switch(strtolower($num))
					{
					case 'publisher' : $privs[] = 1; break;
					case 'managing editor' : $privs[] = 2; break;
					case 'copy editor' : $privs[] = 3; break;
					case 'staff writer' : $privs[] = 4; break;
					case 'freelancer' : $privs[] = 5; break;
					case 'designer' : $privs[] = 6; break;
					case '0' : $privs[] = 0; break;
					case '1' : $privs[] = 1; break;
					case '2' : $privs[] = 2; break;
					case '3' : $privs[] = 3; break;
					case '4' : $privs[] = 4; break;
					case '5' : $privs[] = 5; break;
					case '6' : $privs[] = 6; break;
					case '7' : $privs[] = 7; break;
					case '8' : $privs[] = 8; break;
					case '9' : $privs[] = 9; break;
					default	 : trigger_error(gTxt('error_type_attribute: '.$num));
					}
				}
		
 		 $sort = doSlash($sort);
		
		 $where = " 1 order by ".$sort."";
		
		 $rs = safe_column('user_id', 'txp_users', $where);

		 $section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;
		 
			$out = array();
			$count = 0;
			$last = 0;

		 foreach($rs as $index)
		    {
			    $where = "user_id='".$index."'";
			    $author_count = safe_field('privs', 'txp_users', $where);
		
					if(in_array($author_count , $privs)) {
						++$last;
					}
		    }
		
		 $old_author = $thisauthor;
		 
		 foreach($rs as $row)
		    {
			    $where = "user_id='".$row."'";
			    $author_priv = safe_field('privs', 'txp_users', $where);
		
			if (empty($form) && empty($thing))
				{
					if(in_array($author_priv , $privs))
					{
		      		++$count;
		      			$thisauthor['is_first'] = ($count == 1);
		      			$thisauthor['is_last'] = ($count == $last);
						$author_name = safe_field('RealName', 'txp_users', $where);
						$out[] = href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name)));
					}
				}
				else
				{

				if(in_array($author_priv , $privs))
				{
				
		     	 ++$count;
		      		$thisauthor['is_first'] = ($count == 1);
		     		$thisauthor['is_last'] = ($count == $last);
					extract(safe_row('RealName, name', 'txp_users', $where));
					$thisauthor['realname'] = $RealName;
					$thisauthor['name'] = $name;
					$out[] = ($thing) ? parse($thing) : parse_form($form);
				}	
				}
		    }

                  $thisauthor = (isset($old_author) ? $old_author : NULL);
		  
			if ($out)
			{
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class);
			}

		return '';
}
// -------------------------------------------------------------

	function ras_authors($atts)
	{
	global $thisarticle, $s, $thisauthor;

		extract(lAtts(array(
			'link'         => '',
			'title'        => 1,
			'section'      => '',
			'this_section' => 0,
		), $atts));

		$author_name = get_author_name($thisarticle['authorid']);

		
		if (!empty($thisauthor['realname']))
		{
			$author_name = $thisauthor['realname'];
		}

		
		if($thisarticle)
		{
			$display_name = htmlspecialchars( ($title) ? $author_name : $thisarticle['authorid'] );
		}
		else
		{
			$display_name = htmlspecialchars( ($title) ? $author_name : $thisauthor['name'] );
		}

		$section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;

	return ($link) ? href($display_name, pagelinkurl(array('s' => $section, 'author' => $author_name)), ' rel="author"') : $display_name;
	}

// -------------------------------------------------------------

	function ras_user()
	{
		global $thisauthor, $author ;

		$author_name = $author;
		
		if (!empty($thisauthor['name']))
		{
			$author_name = $thisauthor['name'];
		}

		return $author_name;
	}
// -------------------------------------------------------------
	function ras_if_first_author($atts, $thing)
	{
		global $thisauthor;
                assert_author();
		return parse(EvalElse($thing, !empty($thisauthor['is_first'])));
	}

// -------------------------------------------------------------
	function ras_if_last_author($atts, $thing)
	{
		global $thisauthor;
                assert_author();
		return parse(EvalElse($thing, !empty($thisauthor['is_last'])));
	}
//--------------------------------------------------------------
  	function assert_author() {
         global $thisauthor;
		    if(empty($thisauthor))
              trigger_error(gTxt('error_author_context'));
      }


?>

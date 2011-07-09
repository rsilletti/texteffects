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


				if(getThing("select * from `".PFX."txp_lang` where name='publisher' and event='admin'")){
					safe_update('txp_lang', "event='common'", "    name='publisher' 
																or name='managing_editor' 
																or name='copy_editor' 
																or name='staff_writer' 
																or name='freelancer' 
																or name='designer'" );
				}


	function ras_author_credits($atts, $thing = NULL) 
	{
	global $s, $thisauthor;
		extract(lAtts(array(
			'break'        => '',
			'label'        => '',
			'labeltag'     => '',
			'sort'         => 'user_id desc',
			'form'        => '',
			'wraptag'      => '',
			'type'         => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19',
			'section'      => '',
			'this_section' => 0,
			'link'         => 1,
			'title'        => 1,
			'active_only'  => 1,
			'select_by'    => 1,
			'rank_by'      => 'articles',
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
					case '10' : $privs[] = 10; break;
					case '11' : $privs[] = 11; break;
					case '12' : $privs[] = 12; break;
					case '13' : $privs[] = 13; break;
					case '14' : $privs[] = 14; break;
					case '15' : $privs[] = 15; break;
					case '16' : $privs[] = 16; break;
					case '17' : $privs[] = 17; break;
					case '18' : $privs[] = 18; break;
					case '19' : $privs[] = 19; break;
					default	 : trigger_error(gTxt('error_type_attribute: '.$num));
					}
				}

		$sort = doSlash($sort);		
		$where = " 1 order by ".$sort."";
		
		$rs = safe_rows('user_id,name', 'txp_users', $where);

		$section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;
		$out = array();
		$data = array();

		$old_author = $thisauthor;
		 
		foreach($rs as $row)
		{
			$where = "user_id='".$row['user_id']."'";
			$author_priv = safe_field('privs', 'txp_users', $where);

			if (empty($form) && empty($thing))
			{
				$where_author = "AuthorID='".$row['name']."'";
				$where_content = "author='".$row['name']."'";	
				
			$select = ras_select_by($select_by, $where_author, $where_content);

			if($select || !$active_only) 
			{
				if(in_array($author_priv , $privs))
				{
					extract(safe_row('RealName,name,email,privs as level,last_access', 'txp_users', $where));
					$thisauthor['realname'] = $RealName;
					$thisauthor['name'] = $name;
					$thisauthor['email'] = $email;
					$thisauthor['privs'] = $level;
					$thisauthor['last_access'] = $last_access;

					$display_name = htmlspecialchars( ($title) ? $thisauthor['realname'] : $thisauthor['name'] );
						
					$option = array();

					foreach(do_list($rank_by) as $rank) {
						switch(strtolower($rank))
						{
							case 'articles' : $option[] = intval(ras_articlecount()); break;
							case 'links'    : $option[] = intval(ras_linkcount()); break;
							case 'files'    : $option[] = intval(ras_filecount()); break;
							case 'images'   : $option[] = intval(ras_imagecount()); break;
							case 'authors'  : $option[] = $display_name; break;
							default         : { $option[] = NULL; trigger_error(gTxt('error_rank_by_attribute: '.$rank)); } 
						}
					}
					 
					if(count(do_list($rank_by)) == 1) 
					{ 
						$option[] = NULL;
						$option[] = NULL;
					}
					else if(count(do_list($rank_by)) == 2)
					{
						$option[] = NULL;
					}

				$data[] = array('firstcount' => $option[0] , 'nextcount' => $option[1], 'lastcount' => $option[2], 'thename' => $display_name, 'thehtml' => ($link) ? href($display_name, pagelinkurl(array('s' => $section, 'author' => $thisauthor['realname']))) : $display_name);
				}
			}
			}
			else
			{
				$where_author = "AuthorID='".$row['name']."'";
				$where_content = "author='".$row['name']."'";

			$select = ras_select_by($select_by, $where_author, $where_content);

			if($select || !$active_only) 
			{
				if(in_array($author_priv , $privs))
				{
					extract(safe_row('RealName,name,email,privs as level,last_access', 'txp_users', $where));
					$thisauthor['realname'] = $RealName;
					$thisauthor['name'] = $name;
					$thisauthor['email'] = $email;
					$thisauthor['privs'] = $level;
					$thisauthor['last_access'] = $last_access;

					$display_name = htmlspecialchars( ($title) ? $thisauthor['realname'] : $thisauthor['name'] );
					
					$option = array();

					foreach(do_list($rank_by) as $rank) {
						switch(strtolower($rank))
						{
							case 'articles' : $option[] = intval(ras_articlecount()); break;
							case 'links'    : $option[] = intval(ras_linkcount()); break;
							case 'files'    : $option[] = intval(ras_filecount()); break;
							case 'images'   : $option[] = intval(ras_imagecount()); break;
							case 'authors'  : $option[] = $display_name; break;
							default         : { $option[] = NULL; trigger_error(gTxt('error_rank_by_attribute: ').$rank); }
						}
					}
					 
					if(count(do_list($rank_by)) == 1) 
					{ 
						$option[] = NULL;
						$option[] = NULL;
					}
					else if(count(do_list($rank_by)) == 2)
					{
						$option[] = NULL;
					}

				$data[] = array('firstcount' => $option[0] , 'nextcount' => $option[1], 'lastcount' => $option[2], 'thename' => $display_name, 'thehtml' => ($thing) ? parse($thing) : parse_form($form) );
				}
			}
			}
		}
		$thisauthor = (isset($old_author) ? $old_author : NULL);

		if(!empty($data))
		{
		foreach ($data as $key => $row) {
			$firstcount[$key]  = $row['firstcount'];
			$nextcount[$key] = $row['nextcount'];
			$lastcount[$key] = $row['lastcount'];
			$thename[$key] = $row['thename'];
			$thehtml[$key] = $row['thehtml'];
		}

		($option['1'] == NULL) ?
		array_multisort($firstcount, (is_string($option[0])) ? SORT_ASC : SORT_DESC , $thename, SORT_ASC, $data) :
		array_multisort($firstcount, (is_string($option[0])) ? SORT_ASC : SORT_DESC , $nextcount, (is_string($option[1])) ? SORT_ASC : SORT_DESC, $lastcount, (is_string($option[2])) ? SORT_ASC : SORT_DESC, $data);

		}
					foreach($data as $row) 
					{
						$out[] = $row['thehtml'];
					}

			if ($out)
			{
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class);
			}

	return '';
	}
// -------------------------------------------------------------

	function ras_select_by($selection, $where_author, $where_content )
	{
		$select = 0;
		
		switch($selection)
		{
			case 0 : break;			
				// 1 true if an article has been posted
			case 1 : $select = safe_count('textpattern', $where_author); break;
				// 2 true if a file has been uploaded
			case 2 : $select = safe_count('txp_file', $where_content); break;
				// 3 true if an article has been posted or a file uploaded
			case 3 : $select = (safe_count('txp_file', $where_content) || safe_count('textpattern', $where_author)) ; break;
				// 4 true if an article has been posted and a file uploaded
			case 4 : $select = (safe_count('txp_file', $where_content) && safe_count('textpattern', $where_author)) ; break;
				// 5 true if an article has been posted and a file has not been uploaded
			case 5 : $select = (!safe_count('txp_file', $where_content) && safe_count('textpattern', $where_author)) ; break;
				// 6 true if a file has been uploaded and an article has not been posted
			case 6 : $select = (safe_count('txp_file', $where_content) && !safe_count('textpattern', $where_author)) ; break;
				// 7 true if an image has been uploaded
			case 7 : $select = safe_count('txp_image', $where_content); break;
				// 8 true if an image or a file has been uploaded
			case 8 : $select = (safe_count('txp_file', $where_content) || safe_count('txp_image', $where_content)) ; break;
				// 9 true if an image and a file have been uploaded
			case 9 : $select = (safe_count('txp_file', $where_content) && safe_count('txp_image', $where_content)) ; break;
				// 10 true if an image has been uploaded and a file has not been uploaded
			case 10 : $select = (!safe_count('txp_file', $where_content) && safe_count('txp_image', $where_content)) ; break;
				// 11 true if a file has been uploaded and an image has not been uploaded
			case 11 : $select = (safe_count('txp_file', $where_content) && !safe_count('txp_image', $where_content)) ; break;
				// 12 true if an article has been posted or an image uploaded
			case 12 : $select = (safe_count('txp_image', $where_content) || safe_count('textpattern', $where_author)) ; break;
				// 13 true if an article has been posted and an image uploaded
			case 13 : $select = (safe_count('txp_image', $where_content) && safe_count('textpattern', $where_author)) ; break;
				// 14 true if an article has been posted and an image has not been uploaded
			case 14 : $select = (!safe_count('txp_image', $where_content) && safe_count('textpattern', $where_author)) ; break;
				// 15 true if an article has not been posted and an image has been uploaded
			case 15 : $select = (safe_count('txp_image', $where_content) && !safe_count('textpattern', $where_author)) ; break;
				// 16 true if an article has been posted or an image uploaded or a file uploaded
			case 16 : $select = (safe_count('txp_image', $where_content) || safe_count('txp_file', $where_content) || safe_count('textpattern', $where_author)) ; break;
				// 17 true if an article has been posted and an image uploaded and a file uploaded
			case 17 : $select = (safe_count('txp_image', $where_content) && safe_count('txp_file', $where_content) && safe_count('textpattern', $where_author)) ; break;
			default : trigger_error(gTxt('error_select_by_attribute_out_of_range: '.$selection));
		}
	return $select;
	}

// -------------------------------------------------------------

	function ras_authors($atts)
	{
	global $thisarticle, $s, $thisauthor;

		extract(lAtts(array(
			'link'         => '',
			'title'		   => 1,
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

	function ras_author_info($atts, $thing = NULL)
	{
	global $thisauthor;
	
		extract(lAtts(array(
			'author_name'    => $thisauthor['realname'],
			'title'          => 1,
			'link'           => 0,
			'wraptag'        => 'p',
			'class'          => __FUNCTION__
		), $atts));
				
		$where = "RealName='".$author_name."'";

		$old_author = $thisauthor;

		extract(safe_row('RealName,name,email,privs as level,last_access', 'txp_users', $where));
		$thisauthor['realname'] = $author_name;
		$thisauthor['name'] = $name;
		$thisauthor['email'] = $email;
		$thisauthor['privs'] = $level;
		$thisauthor['last_access'] = $last_access;

		$display_name = htmlspecialchars( ($title) ? $author_name : $name );

		if(empty($form) && empty($thing))
		{
			$out = ($link) ? href($display_name, pagelinkurl(array('author' => $author_name)), ' rel="author"') : $display_name;
		}
		else
		{
			$out = ($thing) ? parse($thing) : parse_form($form);
		}
		
		$thisauthor = (isset($old_author) ? $old_author : NULL);

		return doTag($out, $wraptag, $class);
	}

// -------------------------------------------------------------

	function ras_author_role($atts)
	{
	global $thisauthor;
		extract(lAtts(array(
			'wraptag'        => '',
			'class'          => __FUNCTION__
		), $atts));

		ras_assert_author();

		if (getThings("show tables like '".PFX."smd_um_groups'")) {
			$where_level = "id='".$thisauthor['privs']."'";		
			extract(safe_row('name', 'smd_um_groups', $where_level));
			$out = gTxt($name);				
		}
		else
		{
			switch($thisauthor['privs'])
			{
			case '0' : $out = gTxt('none'); break;
			case '1' : $out = gTxt('publisher'); break;
			case '2' : $out = gTxt('managing_editor'); break;
			case '3' : $out = gTxt('copy_editor'); break;
			case '4' : $out = gTxt('staff_writer'); break;
			case '5' : $out = gTxt('freelancer'); break;
			case '6' : $out = gTxt('designer'); break;
			}
		}

		return doTag($out, $wraptag, $class);
	}

// -------------------------------------------------------------

	function ras_last_login($atts)
	{
	global $thisauthor, $dateformat;
			
		extract(lAtts(array(
			'class'   => '',
			'format'  => '',
			'gmt'     => '',
			'lang'    => '',
			'wraptag' => ''
		), $atts));
		
		ras_assert_author();
		
		if ($format)
		{
			$out = safe_strftime($format, strtotime($thisauthor['last_access']), $gmt, $lang);
		}
		else			
		{
			$out = safe_strftime($dateformat, strtotime($thisauthor['last_access']));
		}

		return ($wraptag) ? doTag($out, $wraptag, $class) : $out;
	}

// -------------------------------------------------------------

	function ras_author_mailto($atts, $thing = NULL)
	{
	global $thisauthor;

		extract(lAtts(array(
			'email'   => $thisauthor['email'],
			'linktext' => gTxt('contact'),
			'title'     => '',
		), $atts));

		ras_assert_author();

		return email(array('email' => $email, 'linktext' => $linktext, 'title' => $title), $thing);


	}

// -------------------------------------------------------------

	function ras_email_text()
	{
	global $thisauthor;
	
	return $thisauthor['email'];
	}
// -------------------------------------------------------------

	function ras_filecount()
	{
	global $thisauthor;

	ras_assert_author();

	$where = "author='".$thisauthor['name']."'";
	$rs = safe_row('COUNT(id)' , 'txp_file' , $where);

	return $rs['COUNT(id)'];

	}

// -------------------------------------------------------------
	function ras_articlecount()
	{
	global $thisauthor;

	ras_assert_author();

	$where = "AuthorID='".$thisauthor['name']."'";
	$rs = safe_row('COUNT(ID)' , 'textpattern' , $where);

    return $rs['COUNT(ID)'];
	}

// -------------------------------------------------------------

	function ras_imagecount()
	{
	global $thisauthor;

	ras_assert_author();

	$where = "author='".$thisauthor['name']."'";
	$rs = safe_row('COUNT(id)' , 'txp_image' , $where);

	return $rs['COUNT(id)'];
	}

// -------------------------------------------------------------

	function ras_linkcount()
	{
	global $thisauthor;

	ras_assert_author();

	$where = "author='".$thisauthor['name']."'";
	$rs = safe_row('COUNT(id)' , 'txp_link' , $where);

	return $rs['COUNT(id)'];
	}

//--------------------------------------------------------------
	function ras_assert_author() 
	{
	global $thisauthor;

		if(empty($thisauthor))
		trigger_error(gTxt('error_author_context'));
	}


?>

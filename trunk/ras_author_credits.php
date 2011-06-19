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
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
* 02110-1301 USA
*
* rsilletti@gmail.com
*
*/

function ras_author_credits ($atts, $thing = NULL) 
{
	global $s, $thisauthor;
		extract(lAtts(array(
			'break'        => '',
			'label'        => '',
			'labeltag'     => '',
			'sort'         => 'user_id desc',
			'form'        => '',
			'wraptag'      => '',
			'type'         => 'Publisher,Managing Editor,Copy Editor,Staff writer,Freelancer,Designer',
			'section'      => '',
			'this_section' => 0,
			'link'         => 1,
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
				$select = 0;

				switch($select_by)
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
					default : $select = 0;
				}

			if($select || !$active_only) 
			{
				if(in_array($author_priv , $privs))
				{
						extract(safe_row('RealName, name', 'txp_users', $where));
						$thisauthor['name'] = $name;
						$author_name = safe_field('RealName', 'txp_users', $where);
						$option = array();

					foreach(do_list($rank_by) as $rank) {
						switch(strtolower($rank))
						{
							case 'articles' : $option[] = ras_articlecount(); break;
							case 'links'    : $option[] = ras_linkcount(); break;
							case 'files'    : $option[] = ras_filecount(); break;
							case 'images'   : $option[] = ras_imagecount(); break;
						}
				} (count(do_list($rank_by)) == 1) ? $option[] = NULL : '';

				$data[] = array('firstcount' => $option['0'] , 'nextcount' => $option['1'], 'thehtml' => ($link) ? href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name))) : $author_name);
				}
			}
		}
		else
		{
				$where_author = "AuthorID='".$row['name']."'";
				$where_content = "author='".$row['name']."'";
				$select = 0;

				switch($select_by)
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
					default : $select = 0;
				}

			if($select || !$active_only) 
			{
				if(in_array($author_priv , $privs))
				{
					extract(safe_row('RealName, name', 'txp_users', $where));
					$thisauthor['realname'] = $RealName;
					$thisauthor['name'] = $name;
					$option = array();

					foreach(do_list($rank_by) as $rank) {
						switch(strtolower($rank))
						{
							case 'articles' : $option[] = ras_articlecount(); break;
							case 'links'    : $option[] = ras_linkcount(); break;
							case 'files'    : $option[] = ras_filecount(); break;
							case 'images'   : $option[] = ras_imagecount(); break;
						}
					} (count(do_list($rank_by)) == 1) ? $option[] = NULL : '';

				$data[] = array('firstcount' => $option['0'] , 'nextcount' => $option['1'], 'thehtml' => ($thing) ? parse($thing) : parse_form($form) );
				}
			}
			}
		}
		$thisauthor = (isset($old_author) ? $old_author : NULL);

		foreach ($data as $key => $row) {
			$firstcount[$key]  = $row['firstcount'];
			$nextcount[$key] = $row['nextcount'];
			$thehtml[$key] = $row['thehtml'];
		}
		($option['1'] == NULL) ?
		array_multisort($firstcount, SORT_DESC, $thehtml, SORT_ASC, $data) :
		array_multisort($firstcount, SORT_DESC, $nextcount, SORT_DESC, $data);

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

function ras_author($atts)
{
	global $thisarticle, $s, $thisauthor;

		extract(lAtts(array(
			'link'         => '',
			'section'      => '',
			'this_section' => 0,
		), $atts));

		$author_name = get_author_name($thisarticle['authorid']);		
		if (!empty($thisauthor['realname']))
		{
			$author_name = $thisauthor['realname'];
		}
		$section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;
	return ($link) ? href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name)), ' rel="author"') : $author_name;
}

// -------------------------------------------------------------

function ras_user()
{
	global $thisarticle,  $thisauthor, $author ;
		$author_name = $author;
		$login_name = $thisarticle['authorid']; 

		if (!empty($thisauthor['name']))
		{
			$author_name = $thisauthor['name'];
		}
	return $author_name;
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
		where = "author='".$thisauthor['name']."'";
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
function ras_assert_author() {
	global $thisauthor;
	if (empty($thisauthor))
	trigger_error(gTxt('error_author_context'));
}

?>
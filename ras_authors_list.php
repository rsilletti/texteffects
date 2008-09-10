<?php

function ras_authors_list ($atts) 
{
		global $s;
		extract(lAtts(array(
			'break'        => br,
			'label'        => '',
			'labeltag'     => '',
			'sort'         => 'user_id desc',
			'wraptag'      => '',
			'type'         => 'Publisher,Managing Editor,Copy Editor,Staff writer,Freelancer,Designer',
			'section'      => '',
			'this_section' => 0,
			'class'        => __FUNCTION__
		), $atts));
		
		 	foreach(do_list($type) as $num)
				{
				switch($num)
					{
					case 'Publisher' : $privs[] = 1; break;
					case 'Managing Editor' : $privs[] = 2; break;
					case 'Copy Editor' : $privs[] = 3; break;
					case 'Staff writer' : $privs[] = 4; break;
					case 'Freelancer' : $privs[] = 5; break;
					case 'Designer' : $privs[] = 6; break;
					}
				}
		
 		 $sort = doSlash($sort);
		
		 $where = " 1 order by ".$sort."";
		
		 $rs = safe_column('user_id', 'txp_users', $where);

		 $section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;
		 
  		 foreach($rs as $row)
		    {
 				$where = "user_id='".$row."'";
			    $author_priv = safe_field('privs', 'txp_users', $where);
				
				if(in_array($author_priv , $privs))
				{
					$author_name = safe_field('RealName', 'txp_users', $where);
					$out[] = href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name)));
				}
		    }
		  
			if ($out)
			{
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class);
			}

		return '';
}

//------------------------------------- 4.0.7 model core modification required -----------------------------------------

function mod_authors_list ($atts, $thing = NULL) 
{
		global $s, $thisauthor;
		extract(lAtts(array(
			'break'        => br,
			'label'        => '',
			'labeltag'     => '',
			'sort'         => 'user_id desc',
			'wraptag'      => '',
			'type'         => 'Publisher,Managing Editor,Copy Editor,Staff writer,Freelancer,Designer',
			'section'      => '',
			'this_section' => 0,
			'class'        => __FUNCTION__
		), $atts));
		
			foreach(do_list($type) as $num)
				{
				switch($num)
					{
					case 'Publisher' : $privs[] = 1; break;
					case 'Managing Editor' : $privs[] = 2; break;
					case 'Copy Editor' : $privs[] = 3; break;
					case 'Staff writer' : $privs[] = 4; break;
					case 'Freelancer' : $privs[] = 5; break;
					case 'Designer' : $privs[] = 6; break;
					}
				}
		
 		 $sort = doSlash($sort);
		
		 $where = " 1 order by ".$sort."";
		
		 $rs = safe_column('user_id', 'txp_users', $where);

		 $section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;
		 
		 	$out = array();
			$count = 0;
			$last = count($rs);
		
		 $old_author = $thisauthor;
		 
  		 foreach($rs as $row)
		    {
			
		      ++$count;
			  
			   	$where = "user_id='".$row."'";
			    $author_priv = safe_field('privs', 'txp_users', $where);
		
			if (empty($form) && empty($thing))
				{
					if(in_array($author_priv , $privs))
					{
						$author_name = safe_field('RealName', 'txp_users', $where);
						$out[] = href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name)));
					}
				}
				else
				{
				
				if(in_array($author_priv , $privs))
				{
						$author_name = safe_field('RealName', 'txp_users', $where);
			            $author_id = safe_field('name', 'txp_users', $where);
						$thisauthor = array('realname' => $author_name, 'name' => $author_id);
						$thisauthor['is_first'] = ($count == 1);
						$thisauthor['is_last'] = ($count == $last);
					$out[] = ($thing) ? parse($thing) : parse_form($form);
				}
				
				}
		    }
			
		  $thisauthor = $old_author;
		  
			if ($out)
			{
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class);
			}

		return '';
}

?>

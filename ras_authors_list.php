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

//------------------------------------- 4.0.7 model, use mod_author in place of core author tag --------------

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
						$author_name = safe_field('RealName', 'txp_users', $where); // A bit clunky
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
// -------------------------------------------------------------

	function mod_author($atts)
	{
		global $thisarticle, $s, $thisauthor;

		assert_article();

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

		return ($link) ?
			href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name))) :
			$author_name;
	}
// -------------------------------------------------------------
	function if_first_author($atts, $thing)
	{
		global $thisauthor;
		assert_author();
		return parse(EvalElse($thing, !empty($thisauthor['is_first'])));
	}

// -------------------------------------------------------------
	function if_last_author($atts, $thing)
	{
		global $thisauthor;
		assert_author();
		return parse(EvalElse($thing, !empty($thisauthor['is_last'])));
	}
//--------------------------------------------------------------
  	function assert_author() {
         global $thisauthor;
		    if (empty($thisauthor))
              trigger_error(gTxt('error_author_context'));
      }

//--------------------------------------------------------------------------------
// Array values called by array name as text (no leading $) and elemnet as text --
//--------------------------------------------------------------------------------
// Attributes are array_name & element for self closing tags ---------------------

    function ras_thing($atts, $thing = NULL)  { // The tag definition
	 
	 		extract(lAtts(array(
			'array_name'        => NULL,
			'element'           => NULL,
		), $atts));
		
		  $thing = trim('ras_'.$thing);

		  $array_name = 'ras_'.$array_name ; 		 
		  
		 if(is_callable($thing))		   
		  {
		  	 return $thing();			 
		  }
		  
		if(is_callable($array_name))		   
		  {
		  	 return $array_name($element);			 
		  }
		  
		 return ''; 
 	}
//---------------------------------------------------------------------------------
	
	function ras_thisauthor($element)  { 
		global $thisauthor;
		
		$available_elements = array(
			'realname',
			'name'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thisauthor[$element]; 
		}	
	}
//--------------------------------------------------------------------------------
// Functions list, to add your own and make thier value accessable via ras_thing, 
// alias it by prefixing ras_ to the variable name as the function name. 
// Render your variable global and return it as the function return value.
//------------------------------- Thus -------------------------------------------

	
	function ras_author() {
		global $author;
		return $author;
	}
	
// Tags for variables are wraptags of the variable name as text  //

?>

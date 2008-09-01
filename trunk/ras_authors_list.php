<?php

function ras_authors_list ($atts, $thing = NULL) 
{
		global $s, $thisauthor;
		extract(lAtts(array(
			'break'        => br,
			'label'        => '',
			'labeltag'     => '',
			'sort'         => 'AuthorId desc',
			'wraptag'      => '',
			'form'         => '',
			'section'      => '',
			'this_section' => 0,
			'class'        => __FUNCTION__
		), $atts));
		
 		 $sort = doSlash($sort);
		
		 $where = " 1 order by ".$sort."";
		
		 $rs = array_unique(safe_column('AuthorId', 'textpattern', $where));

		 $section = ($this_section) ? ( $s == 'default' ? '' : $s ) : $section;
		 
  		 foreach($rs as $row)
		    {
 				$where = "name='".$row."'";
				 $author_name = safe_field('RealName', 'txp_users', $where);
				$out[] = href($author_name, pagelinkurl(array('s' => $section, 'author' => $author_name)));
		    }
		  
			if ($out)
			{
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class);
			}

		return '';
}
?>

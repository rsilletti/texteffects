<?php

//----------NOTICE-----------------------------------------------------//
// These functions will collide with plugin functions of the same name //
//---------------------------------------------------------------------//

//---------------------------------------------------------------
function ras_file_download_list($atts, $thing = NULL)
	{
		global $thisfile;

		extract(lAtts(array(
		    'id'       => '',
			'break'    => br,
			'category' => '',
			'class'    => __FUNCTION__,
			'form'     => 'files',
			'label'    => '',
			'labeltag' => '',
			'limit'    => 10,
			'offset'   => 0,
			'sort'     => 'filename asc',
			'wraptag'  => '',
			'status'   => '4',
		), $atts));

		if (!is_numeric($status))
			$status = getStatusNum($status);

		$where = array('1=1');
		if ($category) $where[] = "category IN ('".join("','", doSlash(do_list($category)))."')";
		if ($id) $where[] = "id IN ('".join("','", doSlash(do_list($id)))."')";
		if ($status) $where[] = "status = '".doSlash($status)."'";

		$qparts = array(
			'order by '.doSlash($sort),
			($limit) ? 'limit '.intval($offset).', '.intval($limit) : '',
		);

		$rs = safe_rows_start('*', 'txp_file', join(' and ', $where).' '.join(' ', $qparts));

		if ($rs)
		{
			$out = array();

			while ($a = nextRow($rs))
			{
				$thisfile = file_download_format_info($a);

				$out[] = ($thing) ? parse($thing) : parse_form($form);

				$thisfile = '';
			}

			if ($out)
			{
				if ($wraptag == 'ul' or $wraptag == 'ol')
				{
					return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class);
				}

				return ($wraptag) ? tag(join($break, $out), $wraptag) : join(n, $out);
			}
		}
		return '';
	}

//------------------------------------------------------------------------

	function ras_if_download_id($atts, $thing)
	{
		global $thisfile;
		assert_file();

		extract(lAtts(array(
			'id' => '',
		), $atts));

		if ($id)
		{
			return parse(EvalElse($thing, in_list($thisfile['id'], $id)));
		}
	}

//-------------------------------------------------------------------------

function ras_if_category_type($atts,$thing)
	{
	global $c;
                extract(lAtts(array(
						 'type' => NULL,
						 'name' => $c
                 ),$atts));
	
                 if($c != trim($name)) 
                      {
                         return parse(EvalElse($thing, 0));
                      } 
                       else {
				 	$c = doSlash(trim($name));
			      }
  
		$where = "name='".doSlash($c)."' and type='".doSlash($type)."'";
		$rs = safe_row('*' , 'txp_category' , $where);
	        return parse(EvalElse($thing, !empty($rs)));
	}

//--------------------------------------------------------------------------------

class VLD // Link validation 
 { 
     function VLD($text) // Class constructor 
        {
		 $this->http =   preg_match('/^http/', $text);
		 $this->mailto = preg_match('/^mailto/', $text);
         $this->email =  preg_match('/@\w+[\.]/', $text);
		 }
 } // End Class VLD
 
function is_email($text)  { $VLD = new VLD($text); return $VLD->email; }
function is_mailto($text) { $VLD = new VLD($text); return $VLD->mailto; }
function is_http($text)   { $VLD = new VLD($text); return $VLD->http; }

//----------------------------------------------------------------------------------

 function ras_plugin_credits($atts)
	{
	global $prefs;
		extract(lAtts(array(
			'label' => '',
			'labeltag' => '',
			'link' => '',
			'sort' => 'name asc',
			'break' => 'br',
			'breakclass' => '',
			'wraptag' => '',
			'id' => '',
			'ver' => '',
			'cache' => '',
			'class' => __FUNCTION__
		),$atts));
		
        $result = safe_rows_start('name,author,author_uri,version', 'txp_plugin', "status = 1 order by $sort");
		
		while($a = nextRow($result)) {
		
		$out = $a['name'] . '&nbsp;&nbsp;';
		
		if(!$link) {
		$out .= $a['author'] . '&nbsp;&nbsp;';
		} 
		else {
							 // Look for leading "http" 
						if (is_http($a['author_uri']))  
							{
								 $out .= href($a['author'] , $a['author_uri']) . '&nbsp;&nbsp;';
							} 
							// Look for leading "mailto" 
						elseif(is_mailto($a['author_uri']))
						    { 
								 $out .= href($a['author'] , $a['author_uri']) . '&nbsp;&nbsp;';
							}
							// Look for "@" and "." in text and append "mailto:" on true
						elseif(is_email($a['author_uri'])) 
						    {
								 $out .= href($a['author'] , 'mailto:' .$a['author_uri']) . '&nbsp;&nbsp;';
							} 
							// Prepend "http://" to unclassified text as default	
		                else 
							{              
								 $out .= href($a['author'] , 'http://' .$a['author_uri']) . '&nbsp;&nbsp;'; 
							}
		}
		if($ver) {
			$out .= 'Version&nbsp;' . $a['version'];
		}
		    $line[] = $out;
		}
		// shamelessly appropriated from load_plugins
		
		if($cache) { 
					$line[] = "<br />Current Cache Files";
		if (!empty($prefs['plugin_cache_dir'])) {
			$dir = rtrim($prefs['plugin_cache_dir'], '/') . '/';
			# allow a relative path
			if (!is_dir($dir))
				$dir = rtrim(realpath(txpath.'/'.$dir), '/') . '/';
			$dh = @opendir($dir);
			while ($dh and false !== ($f = @readdir($dh))) {
				if ($f{0} != '.')
					$line[] = basename($f, '.php');
			}
		}
	}
				if($line)
				
		return doLabel($label, $labeltag) . doWrap($line, $wraptag, $break, $class,$breakclass,'','', $id); 
	}

//--------------------------------------------------------

function ras_page_of($atts)
{
global $is_article_list;
                extract(lAtts(array(
                         'wraptag' => 'span',
						 'id' => '',
			   			 'class'    => __FUNCTION__
                 ),$atts));
 	$out = ($is_article_list) ? 'Page ' .pg() . ' of ' .numPages() : '';
 		return ($wraptag) ? doTag($out, $wraptag, $class, '', $id) : $out;
}

//--------------------------------------------------------

function pg()       { global $thispage; return $thispage['pg']; }
function numPages() { global $thispage; return $thispage['numPages']; }

//---------------------------------------------------------

function ras_downloads_tab($atts)
{
global $permlink_mode;
                extract(lAtts(array(
                         'category' => '',
						 'limit'    => '10',
						 'width'  => '10px ',
						 'html_id' => 'list',
						 'align' => 'left',
						 'label' => 'Count',
						 'label_l' => 'Top',
						 'label_r' => 'Downloads',
						 'where' => '1',
			   			 'class'    => __FUNCTION__
                 ),$atts));
 if($category)
	{ 
		$where = "category='".doSlash($category)."'";
	}
  $where .=" order by downloads desc limit $limit";
          $result = safe_rows_start('*' , 'txp_file' , $where);	
		$out[] = startTable($html_id , $align , $class);
		$out[] = tr(hCell($label_l.'&nbsp;'.$limit.'&nbsp;'.$label_r).hCell($label)).n;	
	while($row = nextRow($result))
          {
		 $out[] = ($permlink_mode == 'messy') ?
			 tr(td(' <a href="'.hu.'index.php?s=file_download&id='.$row['id'].'"> ' .$row["filename"] . '</a>' , $width, $class) . td($row["downloads"] , $width, $class)).n :
			 tr(td(' <a href="'.hu.'file_download/'.$row['id'].'"> ' .$row["filename"] . '</a>' , $width, $class) . td($row["downloads"] , $width, $class)).n; 			
         }
		 $out[] = endTable();
return join($out, '');
}

//-------------------------------------------------------------------------

function ras_downloads_top($atts)
{
global $permlink_mode;
                extract(lAtts(array(
                         'category' => '',
						 'limit'    => '10',
						 'label'    => '',
						 'labeltag' => '',
                         'break' => 'br',
                         'wraptag' => 'p',
						 'id' => '',
						 'where' => '1',
			   			 'class'    => __FUNCTION__
                 ),$atts));
 if($category)
	{ 
		$where = "category='".doSlash($category)."'";
	}
  $where .=" order by downloads desc limit $limit";
          $result = safe_rows_start('*' , 'txp_file' , $where);		
	while($row = nextRow($result))
          {
		 $out[] = ($permlink_mode == 'messy') ?
			 ' <a href="'.hu.'index.php?s=file_download&id='.$row['id'].'"> ' .$row["filename"] . '</a> : ' .$row["downloads"] . ' ' :
			 ' <a href="'.hu.'file_download/'.$row['id'].'"> ' .$row["filename"] . '</a> : ' .$row["downloads"] . ' '; 			
         }
			if (is_array($out)) {
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class, $id);
			}
return false;
}

//-----------------------------------------------------------------------------

function ras_downloads_max($atts)
{
global $permlink_mode;
                extract(lAtts(array(
                         'category' => '',
						 'label'    => '',
						 'labeltag' => '',
                         'break' => 'br',
                         'wraptag' => 'p',
						 'id' => '',
						 'where' => '1',
			   			 'class'    => __FUNCTION__
                 ),$atts)); 
 if($category)
	{ 
		$where = "category='".doSlash($category)."'";
	}
 extract(safe_row('MAX(downloads) as max' , 'txp_file' , $where)); 
        $result = safe_rows_start('*' , 'txp_file' , "downloads='$max'");	
	while($row = nextRow($result))
          {
		 $out[] = ($permlink_mode == 'messy') ?
			 ' <a href="'.hu.'index.php?s=file_download&id='.$row['id'].'"> ' .$row["filename"] . '</a> : ' . $max . ' ' :
			 ' <a href="'.hu.'file_download/'.$row['id'].'"> ' .$row["filename"] . '</a> : ' . $max . ' '; 			
         }
			if (is_array($out)) {
				return doLabel($label, $labeltag).doWrap($out, $wraptag, $break, $class, $id);
			}
		return false;
}

//------------------------------------------------------------------------------

	function ras_downloads_total($atts)
	{
                extract(lAtts(array(
                         'category' => '',
						 'where' => '1'
                 ),$atts)); 
 if($category)
	{ 
		$where = "category='".doSlash($category)."'";
	}
		$rs = safe_row('SUM(downloads)' , 'txp_file' , $where);
    return $rs['SUM(downloads)'];
	}
	
//---------------------Original conditionals authored by Jayrope TXP forum-------------------------------

	function aa_dates_today($atts,$thing)
	{
  		global $uPosted;
		extract(lAtts(array(
			'date' => '',
			'offset' => '0'
		),$atts));
        return parse(Evalelse($thing, ( ceil((mktime() + tz_offset())/86400) == (ceil($uPosted/86400) ) )));
	}

//------------------------------------------------------------------------------

		function aa_dates_past($atts,$thing)
	{
  		global $thisarticle;
        return parse(Evalelse($thing, (ceil(mktime()/86400) > ceil($thisarticle['posted']/86400))));
	}

//------------------------------------------------------------------------------

		function aa_dates_future($atts,$thing)
	{
  		global $thisarticle;
        return parse(Evalelse($thing, (ceil(mktime()/86400) < ceil($thisarticle['posted']/86400))));

	}
	
//-----------------------------------------------------------------------------

	function ras_dates_today($atts,$thing)
	{
  		global $thisarticle;
		assert_article();
		extract(lAtts(array(
			'type' => 'apos',
			'setdate' => '',
			'offset' => ''
		),$atts));
		
	switch($type) {
		case 'apos' : $tz_date = strtotime(date('Y-m-d', $thisarticle['posted'] + tz_offset()));
		break;
		case 'axpr' : $tz_date = strtotime(date('Y-m-d', $thisarticle['expires'] + tz_offset()));
		break;
		case 'amdf' : $tz_date = strtotime(date('Y-m-d', $thisarticle['modified'] + tz_offset()));
		break;
	}
	
	$thedate = ($setdate) ? $setdate : date('Y-m-d' , mktime() + tz_offset() - ($offset * 86400));
		 return parse(Evalelse($thing, strtotime($thedate) == $tz_date ));
	}
	
//------------------------------------------------------------------------------

	function ras_dates_before($atts,$thing)
	{
  		global $thisarticle;
		assert_article();
		extract(lAtts(array(
		    'include_today' => '',
			'type' => 'apos',
			'setdate' => date('Y-m-d' , mktime() + tz_offset()) 
		),$atts));
		
	switch($type) {
		case 'apos' : $tz_date = strtotime(date('Y-m-d', $thisarticle['posted'] + tz_offset()));
		break;
		case 'axpr' : $tz_date = strtotime(date('Y-m-d', $thisarticle['expires'] + tz_offset()));
		break;
		case 'amdf' : $tz_date = strtotime(date('Y-m-d', $thisarticle['modified'] + tz_offset()));
		break;
	}
	
	if(empty($include_today)) {
		return parse(Evalelse($thing, strtotime($setdate) > $tz_date ));
		} else { return parse(Evalelse($thing, strtotime($setdate) >= $tz_date )); }
	}

//------------------------------------------------------------------------------

	function ras_dates_after($atts,$thing)
	{
  		global $thisarticle;
		assert_article();
		extract(lAtts(array(
		    'include_today' => '',
			'type' => 'apos',
			'setdate' => date('Y-m-d' , mktime() + tz_offset()) 
		),$atts));
		
	switch($type) {
		case 'apos' : $tz_date = strtotime(date('Y-m-d', $thisarticle['posted'] + tz_offset()));
		break;
		case 'axpr' : $tz_date = strtotime(date('Y-m-d', $thisarticle['expires'] + tz_offset()));
		break;
		case 'amdf' : $tz_date = strtotime(date('Y-m-d', $thisarticle['modified'] + tz_offset()));
		break;
	}
	
	if(empty($include_today)) {
		return parse(Evalelse($thing, strtotime($setdate) < $tz_date ));
		} else { return parse(Evalelse($thing, strtotime($setdate) <= $tz_date )); }
	}

//-------------------------------------------------------------------------------

function ras_enable_content($atts,$thing)
{
  		global $thisarticle, $thislink, $thisfile;
		extract(lAtts(array(
			'days' => '',
			'hours' => '',
			'minutes' => '',
			'type' => 'apos'
		),$atts));
		
	$offset = $days * 86400 + $hours * 3600 + $minutes * 60;
	
	array();
	
	switch ($type) {
		case 'apos' :
		assert_article(); 
        	return parse(Evalelse($thing, $thisarticle['posted'] + $offset > mktime() ));
		break;
		case 'axpr' :
		assert_article();  
        	return parse(Evalelse($thing, $thisarticle['expires'] + $offset > mktime() ));
		break;
		case 'amdf' :
		assert_article();  
        	return parse(Evalelse($thing, $thisarticle['modified'] + $offset > mktime() ));
		break;
		case 'cpos' :
		assert_comment();  
        	return parse(Evalelse($thing, $thiscomment['posted'] + $offset > mktime() ));
		break;
		case 'fpos' :
		assert_file(); 
		    return parse(Evalelse($thing, $thisfile['created'] + $offset > mktime() ));
		break;
		case 'fmdf' :
		assert_file(); 
		    return parse(Evalelse($thing, $thisfile['modified'] + $offset > mktime() ));
		break;
		case 'lpos' :
		assert_link(); 
		    return parse(Evalelse($thing, $thislink['date'] + $offset > mktime() ));
		break;
	}
}
//--------------------4.0.7 Development---------------------------------
	function ras_dates_days($atts, $thing='')
	{
	global $thisarticle;
	assert_article();
	return ceil(mktime()/86400) - ceil(strtotime(date('Y-m-d', $thisarticle['posted'] + tz_offset()))/86400);
	}

	function ras_dates_hours($atts, $thing='')
	{
	global $thisarticle;
	assert_article();
	return ceil(mktime()/3600) - ceil(strtotime(date('Y-m-d', $thisarticle['posted'] + tz_offset()))/3600);
	}

	function ras_dates_minutes($atts, $thing='')
	{
	global $thisarticle;
	assert_article();
	return ceil(mktime()/60) - ceil(strtotime(date('Y-m-d', $thisarticle['posted'] + tz_offset()))/60);
	}
//-----------------------------------------------------------------------
	function ras_if_article_category1($atts, $thing)
	{
		global $thisarticle;
		assert_article();
		extract(lAtts(array(
			'name' => '',
		),$atts));
	return parse(EvalElse($thing, in_list($thisarticle['category1'] , $name)));
	}

//---------------------------------------------------------------------------------

	function ras_if_article_category2($atts, $thing)
	{
		global $thisarticle;
		assert_article();
		extract(lAtts(array(
			'name' => '',
		),$atts));
	return parse(EvalElse($thing, in_list($thisarticle['category2'] , $name)));
	}
	
//--------------------------------------------------------------------------------

	function ras_if_links_today($atts,$thing)
	{
  		global $thisarticle, $thislink;
                assert_article();
                assert_link();
		extract(lAtts(array(
			'setdate' => ''
		),$atts));
	$tz_date = ($setdate) ? $setdate : date('Y-m-d', $thisarticle['posted'] + tz_offset());
	$thelink = strtotime(date('Y-m-d' , $thislink['date'] + tz_offset()));
		 return parse(Evalelse($thing, $thelink == strtotime($tz_date )));
	}
	
//---------------------------------------------------------------------------------

	function ras_if_article_image($atts, $thing)
	{
		global $thisarticle;
		assert_article();
		extract(lAtts(array(
			'image_number' => '',
		),$atts));
		if($image_number != '') {
			return parse(EvalElse($thing, $thisarticle['article_image'] == $image_number));
		} else {
		return parse(EvalElse($thing, $thisarticle['article_image'] != ''));
		}
	}
	
//---------------------------------------------------------------------------------

function ras_if_article_keywords($atts, $thing)
	{
		global $thisarticle;
		assert_article();
		extract(lAtts(array(
			'keyword_list' => '',
			'mode' => '0',
		),$atts));
		$keyword_list = do_list($keyword_list);
		$keywords = do_list($thisarticle['keywords']);
	switch ($mode) {
		case 0:
   		$condition = $thisarticle['keywords'];
    	        break;
		case 1:
   		$condition = (array_diff($keyword_list, $keywords) === array_diff($keywords, $keyword_list)); 
   		break;
		case 2:
   		$condition = (array_intersect($keyword_list, $keywords) === $keyword_list); 
    	        break;
		case 3:
   		$condition = (array_intersect($keywords, $keyword_list) === $keywords);
    	        break;
		case 4:
   		$condition = in_list($keyword_list[0], $thisarticle['keywords']);
    	        break;
	}
		return parse(EvalElse($thing, $condition));
	}

// straight from the online PHP manual (bishop)
	
function array_equal($a, $b) {
    return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
}

?>

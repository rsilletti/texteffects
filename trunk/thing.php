<?php

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
 
 //------------------------------------------------------------------------------
 // Available arrays list --------------------------------------------------------
 //------------------------------------------------------------------------------
 
	function ras_thisarticle($element)  { 
		global $thisarticle;
		 
		$available_elements = array(
			'thisid',
			'posted',
			'modified',
			'annotate',
			'comments_invite',
			'authorid',
			'title',
			'url_title',
			'category1',
			'category2',
			'section',
			'keywords',
			'article_image',
			'comments_count',
			'body',
			'excerpt',
			'override_form',
			'status',
			'is_first',
			'is_last'
		);

		if (!in_array($element, $available_elements))
		{
			return 'is a custom field name or element is not an array member ';
			
		} else {
		
			return $thisarticle[$element]; 
		}
	}

//--------------------------------------------------------------------------------

	function ras_thispage($element)  { 
		global $thispage;
		
		$available_elements = array(
			'pg',
			'numPages',
			's',
			'c',
			'grand_total',
			'total'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thispage[$element]; 
		}
	}

//--------------------------------------------------------------------------------

	function ras_thiscomment($element)  { 
		global $thiscomment;
		
		$available_elements = array(
  			'discussid',
  			'parentid',
  			'name',
  			'email',
  			'web',
  			'ip',
  			'posted',
  			'message',
  			'visible',
  			'time'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thiscomment[$element]; 
		}
	}

//---------------------------------------------------------------------------------

	function ras_thislink($element)  { 
		global $thislink;
		
		$available_elements = array(
			'id',
			'linkname',
			'url',
			'description',
			'date',
			'category'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thislink[$element]; 
		}
	}

//---------------------------------------------------------------------------------

	function ras_thisfile($element)  { 
		global $thisfile;
		
		$available_elements = array(
			'id',
			'filename',
			'category',
			'permissions',
			'descriptions',
			'downloads',
			'status',
			'modified',
			'created',
			'size'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thisfile[$element]; 
		}
	}

//----------------------------------------------------------------------------------

	function ras_prefs($element)  { 
		global $prefs;
		
			$available_elements = array(
  		'prefs_id',
  		'sitename',
  		'siteurl',
  		'site_slogan',
  		'language',
  		'url_mode',
  		'timeoffset',
  		'comments_on_default',
  		'comments_default_invite',
  		'comments_mode',
  		'comments_disabled_after',
  		'use_textile',
  		'ping_weblogsdotcom',
  		'rss_how_many',
  		'logging',
  		'use_comments',
  		'use_categories',
  		'use_sections',
  		'send_lastmod',
  		'path_from_root',
  		'lastmod',
  		'comments_dateformat',
  		'dateformat',
  		'archive_dateformat',
  		'comments_moderate',
  		'img_dir',
  		'comments_disallow_images',
  		'comments_sendmail',
  		'file_max_upload_size',
  		'file_list_pageby',
  		'path_to_site',
  		'article_list_pageby',
  		'link_list_pageby',
  		'image_list_pageby',
  		'log_list_pageby',
  		'comment_list_pageby',
  		'permlink_mode',
  		'comments_are_ol',
  		'is_dst',
  		'locale',
  		'tempdir',
  		'file_base_path',
  		'blog_uid',
  		'blog_mail_uid',
  		'blog_time_uid',
  		'edit_raw_css_by_default',
  		'allow_page_php_scripting',
  		'allow_article_php_scripting',
  		'allow_raw_php_scripting',
 		'comments_use_fat_textile',
  		'show_article_category_count',
  		'show_comment_count_in_feed',
  		'syndicate_body_or_excerpt',
  		'include_email_atom',
  		'comment_means_site_updated',
  		'never_display_email',
  		'comments_require_name',
  		'comments_require_email',
  		'articles_use_excerpts',
  		'allow_form_override',
  		'attach_titles_to_permalinks',
  		'permalink_title_format',
  		'expire_logs_after',
  		'use_plugins',
  		'custom_1_set',
  		'custom_2_set',
  		'custom_3_set',
  		'custom_4_set',
  		'custom_5_set',
  		'custom_6_set',
  		'custom_7_set',
  		'custom_8_set',
  		'custom_9_set',
  		'custom_10_set',
  		'ping_textpattern_com',
  		'use_dns',
  		'admin_side_plugins',
  		'comment_nofollow',
  		'use_mail_on_feeds_id',
  		'max_url_len',
  		'spam_blacklists',
  		'override_emailcharset',
  		'production_status',
  		'comments_auto_append',
  		'dbupdatetime',
  		'version',
  		'gmtoffset',
  		'plugin_cache_dir',
  		'textile_updated',
  		'title_no_widow',
  		'lastmod_keepalive',
  		'enable_xmlrpc_server'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $prefs[$element]; 
		}
	}
//----------------------------------------------------------------------------------

	function ras_pretext($element)  { 
		global $pretext;
		
		$available_elements = array(
  			'id',
  			's',
  			'c',
  			'q',
  			'pg',
  			'p',
  			'month',
  			'author',
  			'request_uri',
  			'qs',
  			'subpath',
  			'req',
  			'status',
  			'page',
  			'css',
  			'path_from_root',
  			'pfr',
  			'path_to_site',
  			'permlink_mode',
  			'sitename',
  			'secondpass'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $pretext[$element]; 
		}
	}

//--------------------------------------------------------------------------------

	function ras_thissection($element)  { 
		global $thissection;
		
		$available_elements = array(
			'name',
			'title'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thissection[$element]; 
		}	
	}

//---------------------------------------------------------------------------------
	
	function ras_thiscategory($element)  { 
		global $thiscategory;
		
		$available_elements = array(
			'name',
			'title',
			'type'
		);
		
		if (!in_array($element, $available_elements))
		{
			return ' element not an array member ';
			
		} else {
		 
			return $thiscategory[$element]; 
		}	
	}

//--------------------------------------------------------------------------------
// Functions list, to add your own and make thier value accessable via ras_thing, 
// alias it by prefixing ras_ to the variable name as the function name. 
// Render your variable global and return it as the function return value.
//------------------------------- Thus -------------------------------------------


	function ras_microstart()
	{
		global $microstart;
		return $microstart;
	}
	
// Tags this way: <txp:ras_thing>microstart</txp:ras_thing>  //

?>

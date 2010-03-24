<?php
	if (@txpinterface == 'admin') {
		add_privs('lang_manage', '1,2,6');
                //-- Event is "lang_manage"
		register_tab("extensions", "lang_manage", "Textpack Manager");
		register_callback("ras_lang_page", "lang_manage");
	}
	
//--------------------------------------------------------------
function ras_lang_page() {
				$msg = "Textpacks";
                  if (!getThing("show fields from `".PFX."txp_lang` like 'pack'")) {
                   $rs = safe_alter("txp_lang", " ADD `pack` VARCHAR( 16 ) NULL DEFAULT NULL AFTER `id`");
                   $msg = ($rs) ? "`pack` field installed in txp_lang" : '';
                  }

			pagetop("Textpacks", $msg );
	                echo n.'<table style="margin: 1em auto; text-align: center;">';
                        echo n.
			tr(
				tda(
					form(
						tag(gTxt('install_textpack'), 'label', ' for="textpack-install"').n.
						'<br /><textarea id="textpack-install" class="code" name="textpack" cols="45" rows="25"></textarea>'.n.
						tag(popHelp('get_textpack'), 'span', ' style="vertical-align: top;"').
						graf(fInput('submit', 'install_new', gTxt('upload'), 'smallerbox')).
						eInput('lang_manage').
						sInput('ras_get_textpack')
					, '', '', 'post', 'text_uploader')
				,' colspan="3"')
			);
                        echo endTable();
                        
           if(gps('step') == 'ras_get_textpack') {
              ras_get_textpack();
           }
           if(gps('step') == 'delete_select') {
              ras_pack_delete(gps('pack_id'));
           }
           
          ras_packid_get();
}

//-------------------------------------------------------------
function ras_pack_delete($pack_id) { 
				safe_delete('txp_lang' , "pack='$pack_id' " );
    return $pack_id; 
}

//-------------------------------------------------------------
function ras_packid_get() {

  $rs = safe_column("pack","txp_lang", " pack != '' " );
	    echo n.'<div style="margin: .3em auto auto auto; text-align: center;">';  
		echo n.n.startTable('list');

		if ($rs)
		{
			echo assHead(gTxt('ras_pack_id') , 'delete', '', '');			
				foreach ($rs as $id) {					
					echo tr(n.td($id).td(dLink('lang_manage', 'delete_select', 'pack_id', $id),30));
			    }
		}
				
		echo endTable();
	    echo '</div>';
  return true;
  
  }

//-------------------------------------------------------------
function ras_lang_get() {
  $where = " lang != '' ";
  $rs = safe_column("lang","txp_lang", $where );
    $out = '<p style="margin-left: .5em;">Current Languages</p>';
    $out .= '<ul style="margin: .5em auto;">';
  	foreach( $rs as $element ) {
  	   $out .= "<li>".$element."</li>";
  	   }
  	$out .= "</ul><br />";
  return $out;
  }

//-------------------------------------------------------------
	function ras_get_textpack()
	{
		$textpack = ps('textpack');
		$n = ras_install_textpack($textpack);
                echo '<p style="margin: 1em auto; text-align: center;">'.
                  gTxt("textpack_strings_installed").' '.
                $n.'</p>';
	}
//-------------------------------------------------------------
	function ras_install_textpack($textpack)
		{
		global $prefs;

		$textpack = explode(n, $textpack);
		if (empty($textpack)) return 0;

		// presume site language equals textpack language
		$language = get_pref('language', 'en-gb');
		$done = 0;
		foreach ($textpack as $line)
		{
			$line = trim($line);
			// A line starting with #, not followed by @ is a simple comment
			if (preg_match('/^#[^@]/', $line, $m))
			{
				continue;
			}

			// A line matching "#@language xx-xx" establishes the designated language for all subsequent lines
			if (preg_match('/^#@language\s+(.+)$/', $line, $m))
			{
				$language = doSlash($m[1]);
				continue;
			}
			// A line matching "#@packid x ... x" establishes the designated packid for all subsequent lines
			if (preg_match('/^#@packid\s+(.+)$/', $line, $m))
			{
				$packid = doSlash($m[1]);
				continue;
			}

			// A line matching "#@event_name" establishes the event value for all subsequent lines
			if (preg_match('/^#@([a-zA-Z0-9_-]+)$/', $line, $m))
			{
				$event = doSlash($m[1]);
				continue;
			}

			// Data lines match a "name => value" pattern. Some white space allowed.
			if (preg_match('/^(\w+)\s*=>\s*(.+)$/', $line, $m))
			{
				if (!empty($m[1]) && !empty($m[2]))
				{
					$name = doSlash($m[1]);
					$value = doSlash($m[2]);
					$where = "lang='$language' AND name='$name'";
					if (safe_count('txp_lang', $where))
					{
						safe_update('txp_lang',	"lastmod=NOW(), data='$value', pack='$packid', event='$event'", $where);
					}
					else
					{
						safe_insert('txp_lang',	"lastmod=NOW(), data='$value', pack='$packid', event='$event', lang='$language', name='$name'");
					}
					++$done;
				}
			}
                    }
		return $done;
	}
?>
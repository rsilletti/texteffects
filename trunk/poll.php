<?php

poll_table_install();

//********************************//
// Admin side tags and functions //
//********************************//

	if (@txpinterface == 'admin') {
		add_privs('poll_prefs', '1,2,6');
		add_privs('poll_db', '1,2,6');
                //-- Event is "poll_prefs"
		register_tab("extensions", "poll_prefs", "Polls");
		register_callback("ras_poll_prefs", "poll_prefs");
		        //-- Event is "poll_db"
		register_callback("ras_poll_db", "poll_db");
	}
		if (@txpinterface == 'public') {
			register_callback("ras_submit_db", "pretext");
		}

// Step switching for admin interface
		
function ras_poll_prefs() {
			pagetop("Poll Preferences", "Poll Settings");
			
	switch (gps('step')) {
		case 'new_select':
   		ras_new_select();  
   		break;
		case 'edit_select':
   		ras_edit_select(gps('poll_id')); 
    	break;
		case 'delete_select':
   		ras_delete_select(gps('poll_id'));
    	break;
		case '' : poll_list();
	}
}

// Database writes

function ras_poll_db() {

	pagetop("Poll Preferences", "Poll Saved");
			
		extract(doSlash(psa(array('poll_id', 'name', 'prompt', 'n0', 'n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'n7', 'n8', 'n9' ,'step', 'event'))));
		$where = "id='".$poll_id."'";
		
  switch($step) {
	case 'edit_poll' :
		safe_update('txp_poll',
			"name='".$name."' ,
			 prompt='".$prompt."',
			 n0='".$n0."', 
			 n1='".$n1."', 
			 n2='".$n2."', 
			 n3='".$n3."', 
			 n4='".$n4."', 
			 n5='".$n5."', 
			 n6='".$n6."', 
			 n7='".$n7."', 
			 n8='".$n8."',  
			 n9='".$n9."'
		 ",$where);
    break;
			 
	case 'new_poll' : if(!$name) break;
		safe_insert('txp_poll',
			"name='".$name."' ,
			 prompt='".$prompt."',
			 n0='".$n0."', 
			 n1='".$n1."', 
			 n2='".$n2."', 
			 n3='".$n3."', 
			 n4='".$n4."', 
			 n5='".$n5."', 
			 n6='".$n6."', 
			 n7='".$n7."', 
			 n8='".$n8."',  
			 n9='".$n9."'
		 ");
	break;
  }
		 
	poll_list();
}


// Displays a list of available polls as a default page

	function poll_list()
	{
	  		  $where ="1 = 1 order by id desc ";
			  $rs = safe_rows_start('*' , 'txp_poll' , $where);	
	    echo n.'<div style="margin: .3em auto auto auto; text-align: center;">';
		echo n.'<h3>Select a poll to edit or delete. </h3><p><a href="?event=poll_prefs&step=new_select" >'.poll_gTxt('add_new_poll').'</a>.</p><br />';  
		echo n.n.startTable('list');

		if ($rs and numRows($rs) > 0)
		{
			echo assHead('id', 'name', poll_gTxt('poll_prompt') , 'edit', 'delete', '', '');

			while ($a = nextRow($rs))
			{
				foreach ($a as $key => $value) {
					$$key = htmlspecialchars($value);
				}
				echo tr(

					n.td($id).
					td($name).
					td($prompt).

					td(
					eLink('poll_prefs', 'edit_select', 'poll_id', $id, gTxt('edit').'&nbsp;&rsaquo;&nbsp;'.$name)
					).

					td(
				    dLink('poll_prefs', 'delete_select', 'poll_id', $id)
					,30)
				);
			}
		}
				unset($name, $page, $deletelink);
				
		echo endTable();
	    echo '</div>';
	}

// Create a new poll form

function ras_new_select() {
			
		echo form(
			hed(poll_gTxt('add_new_poll').'<p><a href="?event=poll_prefs" >'.poll_gTxt('do_not_save').'</a></p>', 3,' style="margin-top: 2em; text-align: center;"').

			startTable('edit').
			tr(
				fLabelCell(poll_gTxt('poll_name')).
				fInputCell('name')
			).
			tr(
				fLabelCell(poll_gTxt('poll_prompt')).
				fInputCell('prompt','','','88')
			).
			tr(
				fLabelCell(poll_gTxt('p_option_1')).
				fInputCell('n0')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_2')).
				fInputCell('n1')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_3')).
				fInputCell('n2')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_4')).
				fInputCell('n3')
			).
			tr(
				fLabelCell(poll_gTxt('p_option_5')).
				fInputCell('n4')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_6')).
				fInputCell('n5')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_7')).
				fInputCell('n6')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_8')).
				fInputCell('n7')
			).
			tr(
				fLabelCell(poll_gTxt('p_option_9')).
				fInputCell('n8')
			).

			tr(
				fLabelCell(poll_gTxt('p_option_10')).
				fInputCell('n9')
			).

			tr(
				td().
				td(
					fInput('submit', '', gTxt('save_new'), 'publish')
				)
			).

			endTable().

			eInput('poll_db').
			sInput('new_poll')
		);
	}

// Edit an exsisting poll form
	
function ras_edit_select($poll_id) {	
	 
						$where = "id='".$poll_id."'";
						$row = safe_row('*', 'txp_poll', $where );
		echo form(
			hed(poll_gTxt('edit_poll').'<p><a href="?event=poll_prefs" >'.poll_gTxt('do_not_edit').'</a></p>', 3,' style="margin-top: 2em; text-align: center;"').

			startTable('edit').
			tr(
				fLabelCell(gTxt('id')).
				fInputCell('poll_id', $row['id'])
			).
			tr(
				fLabelCell(poll_gTxt('poll_name')).
				fInputCell('name', $row['name'])
			).
			tr(
				fLabelCell(poll_gTxt('poll_prompt')).
				fInputCell('prompt', $row['prompt'],'','88')
			).
			tr(
				fLabelCell(poll_gTxt('p_option_1')).
				fInputCell('n0', $row['n0'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_2')).
				fInputCell('n1', $row['n1'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_3')).
				fInputCell('n2', $row['n2'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_4')).
				fInputCell('n3', $row['n3'])
			).
			tr(
				fLabelCell(poll_gTxt('p_option_5')).
				fInputCell('n4', $row['n4'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_6')).
				fInputCell('n5', $row['n5'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_7')).
				fInputCell('n6', $row['n6'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_8')).
				fInputCell('n7', $row['n7'])
			).
			tr(
				fLabelCell(poll_gTxt('p_option_9')).
				fInputCell('n8', $row['n8'])
			).

			tr(
				fLabelCell(poll_gTxt('p_option_10')).
				fInputCell('n9', $row['n9'])
			).

			tr(
				td().
				td(
					fInput('submit', '', gTxt('save'), 'publish')
				)
			).

			endTable().

			eInput('poll_db').
			sInput('edit_poll')
		);
	}

// delete selected poll
	
function ras_delete_select($poll_id) {

				$where = "id='".$poll_id."'";
				safe_delete('txp_poll' , $where);
            poll_list();
}

//********************************//
// Public side tags and functions //
//********************************//

function ras_poll($atts, $thing =NULL) {

		extract(lAtts(array(
			'poll_id'   => '1',
			'controltag'=> 'fieldset', 
			'labeltag'=> 'h3',
			'prompttag'=> 'p',
			'controlbreak'=> 'br',
			'control_class'=> 'ras_poll_control',
			'prompt_class'=> 'ras_poll_prompt',
			'form_id'     => __FUNCTION__
		), $atts));
		
			$where = "id='".$poll_id."'";
			$this_poll = safe_row('id,name,prompt', 'txp_poll', $where );
			$poll_bits = safe_row('n0,n1,n2,n3,n4,n5,n6,n7,n8,n9', 'txp_poll', $where );
			if(empty($this_poll)) {
				return '';
			};
			$form = n.'<'.$labeltag.' class="'.$class.'" >'.$this_poll['name'].'</'.$labeltag.'>'.n.' <'.$prompttag.' class="'.$prompt_class.'">'. $this_poll['prompt'].'</'.$prompttag.'>'.n;
			
		$out = '<div id="poll">';
		
			if(gps('step') == 'poll_response')
						{
				$poll_nums = safe_row('r0,r1,r2,r3,r4,r5,r6,r7,r8,r9', 'txp_poll', $where );
			for($i = 0; $i <= 9; $i++ ) {
				$bit = 'n'.$i ;
				$num = 'r'.$i ;
				
			 ($poll_bits[$bit] != '') ? $poll_html[] = n.$poll_bits[$bit].'&nbsp;'.$poll_nums[$num] : '' ;					
					
			}
			
			$out .= $form.doWrap($poll_html, $controltag, $controlbreak, $control_class).n ;
					
			} else {
			
			for($i = 0; $i <= 9; $i++ ) {
				$bit = 'n'.$i ;
				if ($poll_bits[$bit] != '') $poll_html[] = n.$poll_bits[$bit].'&nbsp;'.radio('selection', $bit , '0') ;
			}
			
			$out .= form(
					$form.doWrap($poll_html, $controltag, $controlbreak, $control_class).n.
					fInput('submit', 'poll', gTxt('submit'), 'publish').n.

			hInput('poll_id', $this_poll['id']).n.
			eInput('poll_submit').n.
			sInput('poll_response')  
		);
		
			}
		
		$out .= '</div>';
		
return $out;
}

// Write poll response to the database.

function ras_submit_db () {

		extract(doSlash(psa(array('poll_id', 'name', 'prompt', 'n0', 'n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'n7', 'n8', 'n9' ,'step', 'event', 'selection'))));
		$where = "id='".$poll_id."'";
		
		if($step == 'poll_response') {
			$stat = 'r'.substr($selection, -1);
				$current = safe_field( $stat ,'txp_poll' , $where);
					$newstat = $current + 1;
					$what = $stat.'='.$newstat;
				safe_update('txp_poll', $what ,$where);
		}
}

// Development

function ras_poll_id () {
	global $this_poll;
	
	return $this_poll['id'];
}

function ras_poll_name ($this_poll) {
	
	return $this_poll['name'];
}

function ras_poll_prompt ($this_poll) {
	
	return $this_poll['prompt'];
}
	
// Install and language interface adapted from zem_event plugin Copyright (C) 2006-2007 Alex Shiels http://thresholdstate.com/

function poll_table_install() {
	if (!getThings("show tables like '".PFX."txp_poll'")) {
		safe_query("create table if not exists ".PFX."txp_poll (

			id int auto_increment not null primary key,
			name varchar(255),
			prompt varchar(255),
			r0 int unsigned,
			n0 varchar(255),
			r1 int unsigned,
			n1 varchar(255),
			r2 int unsigned,
			n2 varchar(255),
			r3 int unsigned,
			n3 varchar(255),
			r4 int unsigned,
			n4 varchar(255),
			r5 int unsigned,
			n5 varchar(255),
			r6 int unsigned,
			n6 varchar(255),
			r7 int unsigned,
			n7 varchar(255),
			r8 int unsigned,
			n8 varchar(255),
			r9 int unsigned,
			n9 varchar(255)		
			);");
		safe_insert('txp_poll',
			"name='Default 1'
		");
		}
	}
	
function poll_gTxt($what, $atts = array()) {

	$lang = array(
		'p_option_1'               => 'Option 1',
		'p_option_2'               => 'Option 2',
		'p_option_3'               => 'Option 3',
		'p_option_4'               => 'Option 4',
		'p_option_5'               => 'Option 5',
		'p_option_6'               => 'Option 6',
		'p_option_7'               => 'Option 7',
		'p_option_8'               => 'Option 8',
		'p_option_9'               => 'Option 9',
		'p_option_10'              => 'Option 10',
		'poll_name'                => 'Poll Name',
		'poll_prompt'              => 'Poll Prompt',
	    'add_new_poll'             => 'Create a New Poll',
		'edit_poll'                => 'Edit Poll',
		'delete_poll'              => 'Delete Poll',
		'permanent_delete_poll'    => 'Permanetly Delete Existing Poll',
		'do_not_delete'            => 'Don`t delete this poll',
		'do_not_save'              => 'Don`t save this poll',
		'do_not_edit'              => 'Don`t edit this poll',
		'active_fields'            => 'Active fields'
	);

	return strtr($lang[$what], $atts);
}


?>

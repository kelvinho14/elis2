<?php
 
class elis_plugin_blurb{ //extends block_base {

	function __construct() {
        global $PAGE;
        $this->title		= get_string('blurb_activity', 'block_elis2');
        $this->act_prefix	= 'blurb';
        $this->isbn			= '';
        $this->explain_text 		= 'Can you write a new blurb for your book?';
        $this->explain_recommended	= 'Fiction / Non-fiction';
        
    }
	function allowed($cohort){
		return in_array($cohort,array(7,8,9,10,11));
	}
	
	function render_icon(){
		global $CFG;
		return '<img src="'.$CFG->wwwroot.'/blocks/elis2/activity/'.$this->act_prefix.'/img/icon.jpg" title="'.$this->title.'">';
	}
	
	function render_form($show_result=false,$uid=''){
		$js = array();
 		$min = 70;
 		$max = 100;
 		
		$html = '<table>';
		list($r_js,$r_html) = elis2_lib::activityTextboxRow('Write a new blurb for the book in your own words. Say what the book\'s strengths are (70-100 words):',$this->act_prefix.'_q1',$this->isbn,true,$min,$max,$uid,$show_result);
		$html.=$r_html;		
		$js = array_merge($js,$r_js);
		
		if($show_result==false)
		$html .= elis2_lib::activityCheckboxRow('Spoiler Alert','Please tick if your activity review contains information that might spoil the book for others ',$this->act_prefix.'_q2',$this->isbn,$uid);
		$html .= '</table>';
		
		return array($html,$js);
	}
	
	function render_result($uid,$name){

		$html.='<table>';
		$html.='<tr><td>'.$this->render_icon().' '.$this->title.'</td></tr>';
		$html.='<tr><td>'.$name.'</td></tr>';
		list($form_html) = $this->render_form(1,$uid);
		$html.='<tr><td>'.$form_html.'</td></tr>';
		$html.='</table>';
		return $html;
	}
}

?>
<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Manage files in folder in private area.
 *
 * @package   moodle
 * @copyright 2010 Petr Skoda (http://skodak.org)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
            
require('../../config.php');
require_once("add_form.php");
require_once("lib.php");
require_once("$CFG->dirroot/repository/lib.php");
            
$blockid = optional_param('id', 0, PARAM_INT);
$bulletin_id = optional_param('edit', 0, PARAM_INT);
require_login();
if (isguestuser()) {
    die(); 
}

$returnurl = optional_param('returnurl', '', PARAM_URL);
if (empty($returnurl)) {
    $returnurl = new moodle_url('add.php');
}
$isstaff   = optional_param('isstaff', '', PARAM_INT); 
$context = get_context_instance(CONTEXT_BLOCK, $blockid);

$title = get_string('add_book','block_elis2');
$PAGE->set_url('/blocks/elis2/add.php');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('mydashboard');

$book_title		= optional_param('search_book_title', '', PARAM_TEXT);
$book_author	= optional_param('search_book_author', '',PARAM_TEXT);
$book_isbn 		= optional_param('search_book_isbn', '',PARAM_TEXT);
//$book_has_thumbnail = optional_param('search_book_has_thumbnail', '',PARAM_BOOL);
$book_by_latest		= optional_param('search_book_by_latest', '',PARAM_BOOL);

$book_per_page  = optional_param('book_per_page',SEARCH_BOOK_PER_PAGE,PARAM_INT);
$curr_page  	= optional_param('curr_page',1,PARAM_INT);
$addbook_btn	= optional_param('addbook', '',PARAM_TEXT);
$add_book_by_isbn= optional_param('add_book_by_isbn', '',PARAM_TEXT);
$search_btn 	= optional_param('submitbutton', '',PARAM_TEXT);
$random_btn		 = optional_param('randombutton', '',PARAM_TEXT);
$random_search = ($random_btn!='')?true:false;



$data = new stdClass();
$data->block_id = $blockid;
$data->returnurl = $returnurl;
$data->contextid = $context->id;
$data->random_search = $random_search;
if($data->random_search==true){
	$data->book_title = chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122));
}else{
	$data->book_title = $book_title;
	$data->book_author = $book_author;
	$data->book_isbn = $book_isbn;
}
//$data->book_has_thumbnail = $book_has_thumbnail;
$data->book_by_latest		= $book_by_latest;
$data->book_per_page = $book_per_page;
$data->curr_page = $curr_page;



// grab the block config data 
if ($configdata = $DB->get_field('block_instances', 'configdata', array('id' => $blockid))) {
            $config = unserialize(base64_decode($configdata));
}

$mform = new elis2_add_form(null, array('data'=>$data, 'options'=>$options, 'config'=>$config));



echo $OUTPUT->header();
echo $OUTPUT->box_start('generalbox');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
?>

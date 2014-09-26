<?php
/**
 * The question type class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

require_once ($CFG->libdir . '/questionlib.php');

/**
 * The javaunittest question type.
 *
 * @copyright 2005 Mark Nielsen
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest extends question_type {
	public function response_file_areas() {
		return array (
				'attachments',
				'answer' 
		);
	}
	
	/**
	 * code to retrieve the extra data we stored for the question in the database
	 * Get additional information from database and attach it to the question object
	 *
	 * @param question $question        	
	 */
	public function get_question_options($question) {
		global $DB;
		$question->options = $DB->get_record ( 'qtype_javaunittest_options', 
				array (
						'questionid' => $question->id 
				), '*', MUST_EXIST );
		parent::get_question_options ( $question );
	}
	
	/**
	 * Save the units and the answers associated with this question.
	 *
	 * @param array $formdata        	
	 * @return boolean to indicate success of failure.
	 */
	public function save_question_options($formdata) {
		global $DB;
		$context = $formdata->context;
		$update = true;
		
		$options = $DB->get_record ( 'qtype_javaunittest_options', 
				array (
						'questionid' => $formdata->id 
				) );
		
		if (! $options) {
			$update = false;
			$options = new stdClass ();
			$options->questionid = $formdata->id;
		}
		
		$options->responseformat = 'plain';
		$options->responsefieldlines = $formdata->responsefieldlines;
		$options->givencode = $formdata->givencode;
		$options->testclassname = $formdata->testclassname;
		$options->junitcode = $formdata->junitcode;
		
		if ($update) {
			$DB->update_record ( "qtype_javaunittest_options", $options );
		} else {
			$DB->insert_record ( "qtype_javaunittest_options", $options );
		}
	}
	
	/**
	 * Deletes question and its tables from the database
	 *
	 * @param integer $questionid
	 *        	The question being deleted
	 * @param integer $contextid        	
	 * @return boolean to indicate success of failure.
	 */
	public function delete_question($questionid, $contextid) {
		global $DB;
		$DB->delete_records ( 'qtype_javaunittest_options', 
				array (
						'questionid' => $questionid 
				) );
		
		parent::delete_question ( $questionid, $contextid );
	}
	
	/**
	 * Initializes question from the question-type specific database tables
	 *
	 * @return boolean to indicate success of failure
	 */
	protected function initialise_question_instance(question_definition $question, 
			$questiondata) {
		parent::initialise_question_instance ( $question, $questiondata );
		$question->responseformat = 'plain';
		$question->responsefieldlines = $questiondata->options->responsefieldlines;
		$question->givencode = $questiondata->options->givencode;
		$question->testclassname = $questiondata->options->testclassname;
		$question->junitcode = $questiondata->options->junitcode;
	}
	
	/**
	 *
	 * @return array the different response formats that the question type supports.
	 *         internal name => human-readable name.
	 */
	public function response_formats() {
		return array (
				'plain' => get_string ( 'formatplain', 'qtype_javaunittest' ) 
		);
	}
	
	/**
	 *
	 * @return array the choices that should be offered for the input box size.
	 */
	public function response_sizes() {
		$choices = array ();
		for($lines = 5; $lines <= 40; $lines += 5) {
			$choices [$lines] = get_string ( 'nlines', 'qtype_javaunittest', $lines );
		}
		return $choices;
	}
	public function move_files($questionid, $oldcontextid, $newcontextid) {
		parent::move_files ( $questionid, $oldcontextid, $newcontextid );
		$fs = get_file_storage ();
		$fs->move_area_files_to_new_context ( $oldcontextid, $newcontextid, 
				'qtype_javaunittest', 'graderinfo', $questionid );
	}
	protected function delete_files($questionid, $contextid) {
		parent::delete_files ( $questionid, $contextid );
		$fs = get_file_storage ();
		$fs->delete_area_files ( $contextid, 'qtype_javaunittest', 'graderinfo', 
				$questionid );
	}
}

<?php
/**
 * The edit form class for this question type. Each time a question is created moodle uses the
 * edit form to collect data from the teacher. With this form the following attributes of a question 
 * need to be defined: name, question text, geven code and the JUnit test class. Affter editing this 
 * form a question is created in the database with the form's attributes.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

/**
 * javaunittest question type editing form
 */
class qtype_javaunittest_edit_form extends question_edit_form {
	protected function definition_inner($mform) {
		global $DB, $question;
		
		$loaded_initialy = optional_param ( 'reloaded_initialy', 1, PARAM_INT );
		
		$qtype = question_bank::get_qtype ( 'javaunittest' );
		
		$definitionoptions = $this->_customdata ['definitionoptions'];
		$attachmentoptions = $this->_customdata ['attachmentoptions'];
		
		
		// -------------------------- feedback options
		$mform->addElement('select', 'feedbacklevel',
				get_string('feedbacklevel', 'qtype_javaunittest'),
				$qtype->feedback_levels() );
		$mform->setDefault('feedbacklevel', FEEDBACK_ONLY_TIMES);
		
		// -------------------------- size of the response field
		$mform->addElement ( 'select', 'responsefieldlines', 
				get_string ( 'responsefieldlines', 'qtype_javaunittest' ), 
				$qtype->response_sizes () );
		$mform->setDefault ( 'responsefieldlines', 15 );
		
		// -------------------------- "Given Code" Text-Area
		$mform->addElement ( 'textarea', 'givencode', 
				get_string ( 'givencode', 'qtype_javaunittest' ), 
				array (
						'cols' => 80,
						'rows' => 20 
				) );
		$mform->setType ( 'givencode', PARAM_RAW );
		$mform->addHelpButton ( 'givencode', 'givencode', 'qtype_javaunittest' );
		
		// -------------------------- "Test class" Text-Area
		$mform->addElement ( 'textarea', 'testclassname', 
				get_string ( 'testclassname', 'qtype_javaunittest' ), 
				array (
						'cols' => 80,
						'rows' => 1 
				) );
		$mform->setType ( 'testclassname', PARAM_ALPHANUMEXT );
		$mform->addRule ( 'testclassname', null, 'required' );
		$mform->addHelpButton ( 'testclassname', 'testclassname', 
				'qtype_javaunittest' );
		$mform->addElement ( 'textarea', 'junitcode', 
				get_string ( 'uploadtestclass', 'qtype_javaunittest' ), 
				array (
						'cols' => 80,
						'rows' => 20 
				) );
		$mform->setType ( 'junitcode', PARAM_RAW );
		$mform->addRule ( 'junitcode', null, 'required' );
		$mform->addHelpButton ( 'junitcode', 'uploadtestclass', 'qtype_javaunittest' );
	}
	
	public function qtype() {
		return 'javaunittest';
	}
}

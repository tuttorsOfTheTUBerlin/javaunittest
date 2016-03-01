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
require_once ( dirname(__FILE__) . '/lib.php');

/**
 * javaunittest question type editing form
 */
class qtype_javaunittest_edit_form extends question_edit_form {
    protected function definition_inner ( $mform ) {
        
        $loaded_initialy = optional_param ( 'reloaded_initialy', 1, PARAM_INT );
        
        $qtype = question_bank::get_qtype ( 'javaunittest' );
        
        $definitionoptions = $this->_customdata['definitionoptions'];
        $attachmentoptions = $this->_customdata['attachmentoptions'];
  
        // -------------------------- general options
        $mform->addElement ( 'select', 'responsefieldlines', get_string ( 'responsefieldlines', 'qtype_javaunittest' ), 
                $qtype->response_sizes () );
        $mform->setDefault ( 'responsefieldlines', 20 );
        
        $mform->addElement ( 'textarea', 'givencode', get_string ( 'givencode', 'qtype_javaunittest' ), 
                array (
                        'cols' => 110,
                        'rows' => 20 
                ) );
        $mform->setType ( 'givencode', PARAM_RAW );
        $mform->addHelpButton ( 'givencode', 'givencode', 'qtype_javaunittest' );
        $mform->addElement ( 'static', '', '', qtype_javaunittest_generateJsBy ( '#id_givencode', 20 ) );
        
        $mform->addElement ( 'textarea', 'testclassname', get_string ( 'testclassname', 'qtype_javaunittest' ), 
                array (
                        'cols' => 110,
                        'rows' => 1 
                ) );
        $mform->setType ( 'testclassname', PARAM_ALPHANUMEXT );
        $mform->addRule ( 'testclassname', null, 'required' );
        $mform->addHelpButton ( 'testclassname', 'testclassname', 'qtype_javaunittest' );
        
        $mform->addElement ( 'textarea', 'junitcode', get_string ( 'uploadtestclass', 'qtype_javaunittest' ), 
                array (
                        'cols' => 110,
                        'rows' => 20 
                ) );
        $mform->setType ( 'junitcode', PARAM_RAW );
        $mform->addRule ( 'junitcode', null, 'required' );
        $mform->addHelpButton ( 'junitcode', 'uploadtestclass', 'qtype_javaunittest' );   
        $mform->addElement ( 'static', '', '', qtype_javaunittest_generateJsBy ( '#id_junitcode', 20 ) );        
        
        // -------------------------- feedback options
        $mform->addElement( 'header', 'feedbackheader', get_string( 'feedbacklevelheader', 'qtype_javaunittest' ) );

        $mform->addElement ( 'advcheckbox', 'feedbacklevel_studentcompiler', get_string ( 'feedbacklevel_compilerheader', 'qtype_javaunittest' ), get_string ( 'feedbacklevel_studentcompiler', 'qtype_javaunittest' ), array('group' => 1), array(0, 1) );
        $mform->setDefault ( 'feedbacklevel_studentcompiler', 1 );
        $mform->addHelpButton ( 'feedbacklevel_studentcompiler', 'feedbacklevel_studentcompiler', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_studentsignature', null, get_string ( 'feedbacklevel_studentsignature', 'qtype_javaunittest' ), array('group' => 1), array(0, 1) );
        $mform->setDefault ( 'feedbacklevel_studentsignature', 1 );
        $mform->addHelpButton ( 'feedbacklevel_studentsignature', 'feedbacklevel_studentsignature', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_junitcompiler', null, get_string ( 'feedbacklevel_junitcompiler', 'qtype_javaunittest' ), array('group' => 1), array(0, 1) );
        $mform->setDefault ( 'feedbacklevel_junitcompiler', 0 );
        $mform->addHelpButton ( 'feedbacklevel_junitcompiler', 'feedbacklevel_junitcompiler', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_counttests', get_string ( 'feedbacklevel_testnumheader', 'qtype_javaunittest' ), get_string ( 'feedbacklevel_counttests', 'qtype_javaunittest' ), array('group' => 2), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_counttests', 1 );
        $mform->addHelpButton ( 'feedbacklevel_counttests', 'feedbacklevel_counttests', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_times', null, get_string ( 'feedbacklevel_times', 'qtype_javaunittest' ), array('group' => 2), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_times', 1 );
        $mform->addHelpButton ( 'feedbacklevel_times', 'feedbacklevel_times', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_junitheader', null, get_string ( 'feedbacklevel_junitheader', 'qtype_javaunittest' ), array('group' => 2), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_junitheader', 0 );
        $mform->addHelpButton ( 'feedbacklevel_junitheader', 'feedbacklevel_junitheader', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_assertstring', get_string ( 'feedbacklevel_assertheader', 'qtype_javaunittest' ), get_string ( 'feedbacklevel_assertstring', 'qtype_javaunittest' ), array('group' => 3), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_assertstring', 1 );
        $mform->addHelpButton ( 'feedbacklevel_assertstring', 'feedbacklevel_assertstring', 'qtype_javaunittest' );
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_assertexpected', null, get_string ( 'feedbacklevel_assertexpected', 'qtype_javaunittest' ), array('group' => 3), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_assertexpected', 0 );
        $mform->addHelpButton ( 'feedbacklevel_assertexpected', 'feedbacklevel_assertexpected', 'qtype_javaunittest' );
        $mform->disabledIf('feedbacklevel_assertexpected', 'feedbacklevel_assertstring', 'eq', 0);
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_assertactual', null, get_string ( 'feedbacklevel_assertactual', 'qtype_javaunittest' ), array('group' => 3), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_assertactual', 0 );
        $mform->addHelpButton ( 'feedbacklevel_assertactual', 'feedbacklevel_assertactual', 'qtype_javaunittest' );
        $mform->disabledIf('feedbacklevel_assertactual', 'feedbacklevel_assertstring', 'eq', 0);
        
        $mform->addElement ( 'advcheckbox', 'feedbacklevel_junitcomplete', get_string ( 'feedbacklevel_completeheader', 'qtype_javaunittest' ), get_string ( 'feedbacklevel_junitcomplete', 'qtype_javaunittest' ), array('group' => 4), array(0, 1)  );
        $mform->setDefault ( 'feedbacklevel_junitcomplete', 0 );
        $mform->addHelpButton ( 'feedbacklevel_junitcomplete', 'feedbacklevel_junitcomplete', 'qtype_javaunittest' );
        
        // -------------------------- sample solution options
        $mform->addElement( 'header', 'solutionheader', get_string( 'solutionheader', 'qtype_javaunittest' ) );
        
        $mform->addElement ( 'textarea', 'solution', get_string ( 'solution', 'qtype_javaunittest' ),
                array (
                        'cols' => 110,
                        'rows' => 20
                ) );
        $mform->setType ( 'solution', PARAM_RAW );
        $mform->addHelpButton ( 'solution', 'solution', 'qtype_javaunittest' );
        $mform->addElement ( 'static', '', '', qtype_javaunittest_generateJsBy ( '#id_solution', 25, false, true ) );
        
        $mform->addElement ( 'textarea', 'signature', get_string ( 'signature', 'qtype_javaunittest' ),
                array (
                        'cols' => 110,
                        'rows' => 20
                ) );
        $mform->setType ( 'signature', PARAM_RAW );
        $mform->addHelpButton ( 'signature', 'signature', 'qtype_javaunittest' );
        $mform->addElement ( 'static', '', '', qtype_javaunittest_generateJsBy ( '#id_signature', 20, false, true ) );
    }
    
    public function qtype () {
        return 'javaunittest';
    }
    
}
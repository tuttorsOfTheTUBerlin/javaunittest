<?php
/**
 * The renderer type class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();
require_once (dirname ( __FILE__ ) . '/lib.php');

/**
 * Generates the output for javaunittest questions.
 *
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_renderer extends qtype_renderer {
    
    /**
     * Generates the web-side when the student is attempting the question. This is the side which is showed with the
     * question text and the response field
     */
    public function formulation_and_controls ( question_attempt $qa, question_display_options $options ) {
        global $DB;
        
        $question = $qa->get_question ();
        $responseoutput = $question->get_format_renderer ( $this->page );
        
        // Answer field.
        $step = $qa->get_last_step_with_qt_var ( 'answer' );
        
        // Get the question options to show the question text
        $question->options = $DB->get_record ( 'qtype_javaunittest_options', array (
                'questionid' => $question->id 
        ) );
        $code = $question->options->givencode;
        if ( empty ( $options->readonly ) ) {
            $answer = $responseoutput->response_area_input ( 'answer', $qa, $step, $question->responsefieldlines, $options->context, $code );
        } else {
            $answer = $responseoutput->response_area_read_only ( 'answer', $qa, $step, $question->responsefieldlines, $options->context, $code );
        }
        
        // Generate the html code which will be showed
        $result = '';
        $result .= html_writer::tag ( 'div', $question->format_questiontext ( $qa ), array (
                'class' => 'qtext' 
        ) );
        $result .= html_writer::start_tag ( 'div', array (
                'class' => 'ablock' 
        ) );
        $result .= html_writer::tag ( 'div', $answer, array (
                'class' => 'answer' 
        ) );
        $result .= html_writer::end_tag ( 'div' );
        
        return $result;
    }
    
    /**
     * Generates the specific feedback from the database when the attempt is finished and the question is answered.
     */
    public function specific_feedback ( question_attempt $qa ) {
        global $DB, $CFG;
        
        // get feedback from the database
        $record = $DB->get_record ( 'qtype_javaunittest_feedback', array (
                'questionattemptid' => $qa->get_database_id () 
        ), 'feedback' );
        
        if ( $record === false ) {
            return '';
        }
        
        $feedback = $record->feedback;
        
        $question = $qa->get_question ();
        return $question->format_text ( $feedback, 0, $qa, 'question', 'answerfeedback', 1 );
    }
    
    /**
     * Deliveres the correct response from the database
     */
    public function correct_response ( question_attempt $qa ) {

        $question = $qa->get_question ();
        if ( empty ( $question->signature ) || trim ( $question->signature) == '' )
            return null;
        
        $htmlfragment = get_string ( 'solutionannounce', 'qtype_javaunittest' ) . '<br>';
        $newlines = substr_count($question->solution, "\n");
        $attributes = array();
        $attributes['class'] = 'qtype_javaunittest_solution';
        $attributes['rows'] = $newlines < $question->responsefieldlines ? $newlines + 2 : $question->responsefieldlines;
        $attributes['cols'] = 60;
        $htmlfragment .= html_writer::tag ( 'textarea', s ( $question->solution ), $attributes );
        $htmlfragment .= qtype_javaunittest_generateJsBy ( 'textarea.qtype_javaunittest_solution', $attributes['rows'], true );
        
        return $htmlfragment;
    }
}

/**
 * An javaunittest format renderer for javaunittests for the textarea. 
 * Calls qtype_javaunittest_generateJsBy() to improve textarea.
 *
 * @copyright 2011 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_format_plain_renderer extends plugin_renderer_base {
    
    /**
     *
     * @return string the HTML for the textarea.
     */
    protected function textarea ( $response, $code, $lines, $attributes ) {
        $attributes['class'] = $this->class_name () . ' qtype_javaunittest_response';
        $attributes['rows'] = $lines;
        $attributes['cols'] = 60;
        if ( empty ( $response ) ) {
            return html_writer::tag ( 'textarea', s ( $code ), $attributes );
        }
        return html_writer::tag ( 'textarea', s ( $response ), $attributes );
    }
    protected function class_name () {
        return 'qtype_javaunittest_plain';
    }
    public function response_area_read_only ( $name, $qa, $step, $lines, $context, $code ) {
        $newlines = substr_count($code, "\n");
        //$lines = $newlines < $lines ? $newlines + 2 : $lines; // unused since textarea size seems to be a huge recognition value for orientation
        return $this->textarea ( $step->get_qt_var ( $name ), "", $lines, array (
                'readonly' => 'readonly' 
        ) ) . qtype_javaunittest_generateJsBy ( 'textarea.qtype_javaunittest_plain.qtype_javaunittest_response', $lines, true );
    }
    public function response_area_input ( $name, $qa, $step, $lines, $context, $code ) {
        $inputname = $qa->get_qt_field_name ( $name );
        return $this->textarea ( $step->get_qt_var ( $name ), $code, $lines, array (
                'name' => $inputname 
        ) ) . html_writer::empty_tag ( 'input', array (
                'type' => 'hidden',
                'name' => $inputname . 'format',
                'value' => FORMAT_PLAIN 
        ) ) . qtype_javaunittest_generateJsBy ( 'textarea.qtype_javaunittest_plain.qtype_javaunittest_response', $lines, false );
    }
}
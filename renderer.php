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

/**
 * Generates the output for javaunittest questions.
 *
 * @copyright 2009 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_renderer extends qtype_renderer {
	
	/**
	 * Generates the web-side when te student is attempting the question.
	 * This is the side which is showed with the question text and the response field
	 */
	public function formulation_and_controls(question_attempt $qa, 
			question_display_options $options) {
		global $DB;
		
		$question = $qa->get_question ();
		$responseoutput = $question->get_format_renderer ( $this->page );
		
		// Answer field.
		$step = $qa->get_last_step_with_qt_var ( 'answer' );
		
		// Get the question options to show the question text
		$question->options = $DB->get_record ( 'qtype_javaunittest_options', 
				array (
						'questionid' => $question->id 
				) );
		$studentscode = $question->options->givencode;
		if (empty ( $options->readonly )) {
			$answer = $responseoutput->response_area_input ( 'answer', $qa, $step, 
					$question->responsefieldlines, $options->context, $studentscode );
		} else {
			$answer = $responseoutput->response_area_read_only ( 'answer', $qa, 
					$step, $question->responsefieldlines, $options->context, 
					$studentscode );
		}
		
		// Generate the html code which will be showed
		$result = '';
		$result .= html_writer::tag ( 'div', $question->format_questiontext ( $qa ), 
				array (
						'class' => 'qtext' 
				) );
		$result .= html_writer::start_tag ( 'div', 
				array (
						'class' => 'ablock' 
				) );
		$result .= html_writer::tag ( 'div', $answer, 
				array (
						'class' => 'answer' 
				) );
		$result .= html_writer::end_tag ( 'div' );
		
		return $result;
	}
	
	/**
	 * Generates the specific feedback from the database when the attempt is finished
	 * and the question is answered.
	 */
	public function specific_feedback(question_attempt $qa) {
		global $DB, $CFG;
		
		// in question.grade_response() function these data were used to store the
		// feedback
		// in the database.
		$attemptid = optional_param ( 'attempt', '', PARAM_INT );
		$question = $qa->get_question ();
		$step = $qa->get_last_step_with_qt_var ( 'answer' );
		$studentid = $step->get_user_id ();
		$questionid = $question->id;
		
		// compute the unique id of the feedback
		$unique_answerid = ($studentid + $questionid * $attemptid) +
				 ($studentid * $questionid + $attemptid);
		
		// get the feedback from the database
		$answer = $DB->get_records ( 'question_answers', 
				array (
						'question' => $unique_answerid 
				) );
		$answer = array_shift ( $answer );
		
		return $question->format_text ( $answer->feedback, 0, $qa, 'question', 
				'answerfeedback', 1 );
	}
}


/**
 * An javaunittest format renderer for javaunittests where the student should use a
 * plain
 * input box, but with a normal, proportional font.
 *
 * @copyright 2011 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_format_plain_renderer extends plugin_renderer_base {
	/**
	 *
	 * @return string the HTML for the textarea.
	 */
	protected function textarea($response, $studentscode, $lines, $attributes) {
		$attributes ['class'] = $this->class_name () . ' qtype_javaunittest_response';
		$attributes ['rows'] = $lines;
		$attributes ['cols'] = 60;
		
		if (empty ( $response )) {
			return html_writer::tag ( 'textarea', s ( $studentscode ), $attributes );
		}
		return html_writer::tag ( 'textarea', s ( $response ), $attributes );
	}
	protected function class_name() {
		return 'qtype_javaunittest_plain';
	}
	public function response_area_read_only($name, $qa, $step, $lines, $context, 
			$studentscode) {
		return $this->textarea ( $step->get_qt_var ( $name ), "", $lines, 
				array (
						'readonly' => 'readonly' 
				) );
	}
	public function response_area_input($name, $qa, $step, $lines, $context, 
			$studentscode) {
		$inputname = $qa->get_qt_field_name ( $name );
		return $this->textarea ( $step->get_qt_var ( $name ), $studentscode, $lines, 
				array (
						'name' => $inputname 
				) ) . html_writer::empty_tag ( 'input', 
				array (
						'type' => 'hidden',
						'name' => $inputname . 'format',
						'value' => FORMAT_PLAIN 
				) );
	}
}

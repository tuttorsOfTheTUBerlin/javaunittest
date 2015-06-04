<?php
/**
 * The question test class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

global $CFG;
require_once ($CFG->dirroot . '/question/engine/tests/helpers.php');

/**
 * Unit tests for the matching question definition class.
 *
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_question_test extends advanced_testcase {
    public function test_get_question_summary () {
        $javaunittest = test_question_maker::make_an_javaunittest_question ();
        $javaunittest->questiontext = 'Hello <img src="http://example.com/globe.png" alt="world" />';
        $this->assertEquals ( 'Hello [world]', $javaunittest->get_question_summary () );
    }
    public function test_summarise_response () {
        $longstring = str_repeat ( '0123456789', 50 );
        $javaunittest = test_question_maker::make_an_javaunittest_question ();
        $this->assertEquals ( $longstring, 
                $javaunittest->summarise_response ( 
                        array (
                                'answer' => $longstring 
                        ) ) );
    }
}
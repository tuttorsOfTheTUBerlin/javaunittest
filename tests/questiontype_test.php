<?php
/**
 * The test class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

global $CFG;
require_once ($CFG->dirroot . '/question/type/javaunittest/questiontype.php');

/**
 * Unit tests for the javaunittest question type class.
 *
 * @copyright 2010 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_test extends advanced_testcase {
    protected $qtype;
    protected function setUp() {
        $this->qtype = new qtype_javaunittest ();
    }
    protected function tearDown() {
        $this->qtype = null;
    }
    protected function get_test_question_data() {
        $q = new stdClass ();
        $q->id = 1;
        
        return $q;
    }
    public function test_name() {
        $this->assertEquals ( $this->qtype->name (), 'javaunittest' );
    }
    public function test_can_analyse_responses() {
        $this->assertFalse ( $this->qtype->can_analyse_responses () );
    }
    public function test_get_random_guess_score() {
        $q = $this->get_test_question_data ();
        $this->assertEquals ( 0, $this->qtype->get_random_guess_score ( $q ) );
    }
    public function test_get_possible_responses() {
        $q = $this->get_test_question_data ();
        $this->assertEquals ( array (), $this->qtype->get_possible_responses ( $q ) );
    }
}
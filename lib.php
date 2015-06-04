<?php
/**
 * The pluginfile class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

/**
 * Checks file access for javaunittest questions.
 *
 * @package qtype_javaunittest
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool
 */
function qtype_javaunittest_pluginfile ( $course, $cm, $context, $filearea, $args, $forcedownload, 
        array $options = array() ) {
    global $CFG;
    require_once ($CFG->libdir . '/questionlib.php');
    question_pluginfile ( $course, $context, 'qtype_javaunittest', $filearea, $args, $forcedownload, $options );
}
<?php

/**
 * Definition of javaunittest scheduled tasks.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace qtype_javaunittest\task;

class cron_task extends \core\task\scheduled_task {
    
    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name () {
        return get_string ( 'crontask', 'qtype_javaunittest' );
    }
    
    /**
     * Run cron.
     */
    public function execute () {
        global $DB;
        
        // delete feedbacks belonging to question attempts that no longer exist
        
        $subquery = 'SELECT f.id FROM {qtype_javaunittest_feedback} f
		             LEFT JOIN {question_attempts} a ON (f.questionattemptid = a.id)
		             WHERE a.id IS NULL';
        
        $DB->delete_records_select ( 'qtype_javaunittest_feedback', "id IN ($subquery)" );
    }
}
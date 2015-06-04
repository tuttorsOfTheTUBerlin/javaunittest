<?php

/**
 * Definition of javaunittest scheduled tasks.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

$tasks = array (
        array (
                'classname' => 'qtype_javaunittest\task\cron_task',
                'blocking' => 0,
                'minute' => '0',
                'hour' => 'R',
                'day' => '*',
                'month' => '*',
                'dayofweek' => '0' 
        ) 
);

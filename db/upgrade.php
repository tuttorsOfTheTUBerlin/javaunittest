<?php
/**
 * The upgrade class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

/**
 * Upgrade code for the javaunittest question type.
 *
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_javaunittest_upgrade ( $oldversion ) {
    global $CFG, $DB;
    
    $dbman = $DB->get_manager ();
    
    // Moodle v2.2.0 release upgrade line
    // Put any upgrade step following this
    
    if ( $oldversion < 2011102701 ) {
        $sql = "
                  FROM {question} q
                  JOIN {question_answers} qa ON qa.question = q.id
                  WHERE q.qtype = 'javaunittest'
                  AND " . $DB->sql_isnotempty ( 'question_answers', 'feedback', false, true );
        // In Moodle <= 2.0 javaunittest had both question.generalfeedback and
        // question_answers.feedback.
        // This was silly, and in Moodel >= 2.1 only question.generalfeedback. To
        // avoid
        // dataloss, we concatenate question_answers.feedback onto the end of
        // question.generalfeedback.
        $count = $DB->count_records_sql ( "
                SELECT COUNT(1) $sql" );
        if ( $count ) {
            $progressbar = new progress_bar ( 'javaunittest23', 500, true );
            $done = 0;
            
            $toupdate = $DB->get_recordset_sql ( "
                    SELECT q.id,
                           q.generalfeedback,
                           q.generalfeedbackformat,
                           qa.feedback,
                           qa.feedbackformat
                    $sql" );
            
            foreach ( $toupdate as $data ) {
                $progressbar->update ( $done, $count, "Updating javaunittest feedback ($done/$count)." );
                upgrade_set_timeout ( 60 );
                if ( $data->generalfeedbackformat == $data->feedbackformat ) {
                    $DB->set_field ( 'question', 'generalfeedback', $data->generalfeedback . $data->feedback, array (
                            'id' => $data->id 
                    ) );
                } else {
                    $newdata = new stdClass ();
                    $newdata->id = $data->id;
                    $newdata->generalfeedback = qtype_javaunittest_convert_to_html ( $data->generalfeedback, $data->generalfeedbackformat ) . qtype_javaunittest_convert_to_html ( $data->feedback, $data->feedbackformat );
                    $newdata->generalfeedbackformat = FORMAT_HTML;
                    $DB->update_record ( 'question', $newdata );
                }
            }
            
            $progressbar->update ( $count, $count, "Updating javaunittest feedback complete!" );
            $toupdate->close ();
        }
        
        // javaunittest savepoint reached.
        upgrade_plugin_savepoint ( true, 2011102701, 'qtype', 'javaunittest' );
    }
    
    if ( $oldversion < 2011102702 ) {
        // Then we delete the old question_answers rows for javaunittest questions.
        $DB->delete_records_select ( 'question_answers', "question IN (SELECT id FROM {question} WHERE qtype = 'javaunittest')" );
        
        // javaunittest savepoint reached.
        upgrade_plugin_savepoint ( true, 2011102702, 'qtype', 'javaunittest' );
    }
    
    if ( $oldversion < 2015031700 ) {
        $table = new xmldb_table ( 'qtype_javaunittest_options' );
        $field = new xmldb_field ( 'feedbacklevel', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'junitcode' );
        $dbman->add_field ( $table, $field );
        
        $table = new xmldb_table ( 'qtype_javaunittest_feedback' );
        $field = $table->add_field ( 'id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null );
        $field = $table->add_field ( 'questionattemptid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, $field );
        $field = $table->add_field ( 'feedback', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null, $field );
        $table->add_key ( 'primary', XMLDB_KEY_PRIMARY, array (
                'id' 
        ) );
        $table->add_key ( 'usr_fkey', XMLDB_KEY_FOREIGN, array (
                'questionattemptid' 
        ), 'question_attempts', array (
                'id' 
        ) );
        if ( !$dbman->table_exists ( $table ) )
            $dbman->create_table ( $table );
        
        upgrade_plugin_savepoint ( true, 2015031700, 'qtype', 'javaunittest' );
    }
    
    if ( $oldversion < 2016012000 ) {
        $progressbar = new progress_bar ( 'javaunittest_2016012000', 500, true );
        
        // create new feedback fields
        $progressbar->update ( 0, 1, "Updating javaunittest database structure" );
        $table = new xmldb_table ( 'qtype_javaunittest_options' );
        $field = new xmldb_field ( 'feedbacklevel_studentcompiler', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '1', 'junitcode' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_junitcompiler', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'feedbacklevel_studentcompiler' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_times', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '1', 'feedbacklevel_junitcompiler' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_counttests', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '1', 'feedbacklevel_times' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_junitheader', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'feedbacklevel_counttests' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_assertstring', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '1', 'feedbacklevel_junitheader' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_assertexpected', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'feedbacklevel_assertstring' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_assertactual', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'feedbacklevel_assertexpected' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_junitcomplete', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'feedbacklevel_assertactual' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->add_field ( $table, $field );
        
        // initialize new feedback fields depending on old feedback level value
        $progressbar->update ( 0, 1, "Checking existing database entries to update" );
        $count = $DB->count_records_sql ( "SELECT COUNT(id)
                                           FROM ". $CFG->prefix . "qtype_javaunittest_options;" );
        $toupdate = $DB->get_recordset_sql ( "SELECT id, feedbacklevel
                                              FROM ". $CFG->prefix . "qtype_javaunittest_options;" );
        foreach ( $toupdate as $data ) {
            $progressbar->update ( $done, $count, "Updating javaunittest database entries ($done/$count)" );
            upgrade_set_timeout ( 60 );
            if ( $data->feedbacklevel == -1 ) {
                $data->feedbackevel_times = 0;
                $data->feedbackevel_counttests = 0;
                $data->feedbackevel_assertstring = 0;
                $DB->update_record ( 'qtype_javaunittest_options', $data );
            }
            if ( $data->feedbacklevel == 0 ) {
                $data->feedbackevel_times = 1;
                $data->feedbackevel_counttests = 0;
                $data->feedbackevel_assertstring = 0;
                $DB->update_record ( 'qtype_javaunittest_options', $data );
            }
            if ( $data->feedbacklevel == 1 ) {
                $data->feedbackevel_times = 1;
                $data->feedbackevel_counttests = 1;
                $data->feedbackevel_assertstring = 0;
                $DB->update_record ( 'qtype_javaunittest_options', $data );
            }
            if ( $data->feedbacklevel == 2 ) {
                $data->feedbackevel_times = 1;
                $data->feedbackevel_counttests = 1;
                $data->feedbackevel_junitheader = 1;
                $data->feedbackevel_assertstring = 0;
                $DB->update_record ( 'qtype_javaunittest_options', $data );
            }
        }
        $toupdate->close ();
        
        // remove old feedback level field, set savepoint
        $field = new xmldb_field ( 'feedbacklevel', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 'junitcode' );
        if (!$dbman->field_exists($table, $field)) 
            $dbman->drop_field ( $table, $field );
        $progressbar->update ( $count, $count, "Updating javaunittest finished!" );
        upgrade_plugin_savepoint ( true, 2016012000, 'qtype', 'javaunittest' );
    }
    
    if ( $oldversion < 2016020200 ) {
        // create new fiels for sample solution and expected student code signature (for javap)
        $table = new xmldb_table ( 'qtype_javaunittest_options' );
        $field = new xmldb_field ( 'solution', XMLDB_TYPE_TEXT, 'small', null, null, null, null, 'junitcode' );
        $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'signature', XMLDB_TYPE_TEXT, 'small', null, null, null, null, 'solution' );
        $dbman->add_field ( $table, $field );
        $field = new xmldb_field ( 'feedbacklevel_studentsignature', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '1', 'feedbacklevel_studentcompiler' );
        $dbman->add_field ( $table, $field );
        
        upgrade_plugin_savepoint ( true, 2016020200, 'qtype', 'javaunittest' );
    }
    
    return true;
}

/**
 * Convert some content to HTML.
 *
 * @param string $text the content to convert to HTML
 * @param int $oldformat One of the FORMAT_... constants.
 */
function qtype_javaunittest_convert_to_html ( $text, $oldformat ) {
    switch ( $oldformat ) {
        // Similar to format_text.
        
        case FORMAT_PLAIN :
            $text = s ( $text );
            $text = str_replace ( ' ', '&nbsp; ', $text );
            $text = nl2br ( $text );
            return $text;
        
        case FORMAT_MARKDOWN :
            return markdown_to_html ( $text );
        
        case FORMAT_MOODLE :
            return text_to_html ( $text );
        
        case FORMAT_HTML :
            return $text;
        
        default :
            throw new coding_exception ( 'Unexpected text format when upgrading javaunittest questions.' );
    }
}
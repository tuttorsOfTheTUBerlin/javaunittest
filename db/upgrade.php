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
                  AND " .
                 $DB->sql_isnotempty ( 'question_answers', 'feedback', false, true );
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
            
            $toupdate = $DB->get_recordset_sql ( 
                    "
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
                    $DB->set_field ( 'question', 'generalfeedback', $data->generalfeedback . $data->feedback, 
                            array (
                                    'id' => $data->id 
                            ) );
                } else {
                    $newdata = new stdClass ();
                    $newdata->id = $data->id;
                    $newdata->generalfeedback = qtype_javaunittest_convert_to_html ( $data->generalfeedback, 
                            $data->generalfeedbackformat ) . qtype_javaunittest_convert_to_html ( $data->feedback, 
                            $data->feedbackformat );
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
        $DB->delete_records_select ( 'question_answers', 
                "question IN (SELECT id FROM {question} WHERE qtype = 'javaunittest')" );
        
        // javaunittest savepoint reached.
        upgrade_plugin_savepoint ( true, 2011102702, 'qtype', 'javaunittest' );
    }
    
    if ( $oldversion < 2015031700 ) {
        $table = new xmldb_table ( 'qtype_javaunittest_options' );
        $field = new xmldb_field ( 'feedbacklevel', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', 
                'junitcode' );
        $dbman->add_field ( $table, $field );
        
        $table = new xmldb_table ( 'qtype_javaunittest_feedback' );
        $field = $table->add_field ( 'id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, 
                null );
        $field = $table->add_field ( 'questionattemptid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, 
                null, null, $field );
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
<?php
/**
 * Restore class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Martin Gauk, gauk@math.tu-berlin.de
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 OR later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();
class restore_qtype_javaunittest_plugin extends restore_qtype_plugin {
    
    /**
     * Returns the paths to be handled by the plugin at question level
     */
    protected function define_question_plugin_structure () {
        $paths = array ();
        
        // Add own qtype stuff.
        $elename = 'javaunittest';
        $elepath = $this->get_pathfor ( '/javaunittest' ); // We used get_recommended_name() so this works.
        $paths[] = new restore_path_element ( $elename, $elepath );
        
        return $paths; // And we return the interesting paths.
    }
    
    /**
     * Process the qtype/javaunittest element
     */
    public function process_javaunittest ( $data ) {
        global $DB;
        
        $data = ( object ) $data;
        $oldid = $data->id;
        
        // Detect if the question is created or mapped.
        $oldquestionid = $this->get_old_parentid ( 'question' );
        $newquestionid = $this->get_new_parentid ( 'question' );
        $questioncreated = ( bool ) $this->get_mappingid ( 'question_created', $oldquestionid );
        
        // If the question has been created by restore, we need to create its qtype_javaunittest_options too.
        if ( $questioncreated ) {
            // Adjust some columns.
            $data->questionid = $newquestionid;
            // Insert record.
            $newitemid = $DB->insert_record ( 'qtype_javaunittest_options', $data );
            // Create mapping.
            $this->set_mapping ( 'qtype_javaunittest_options', $oldid, $newitemid );
        }
    }
}
    <?php
    /**
     * Backup class for this question type.
     *
     * @package    qtype
     * @subpackage javaunittest
     * @author     Martin Gauk, gauk@math.tu-berlin.de
     * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 OR later
     */
    defined ( 'MOODLE_INTERNAL' ) || die ();
    class backup_qtype_javaunittest_plugin extends backup_qtype_plugin {
        
        /**
         * Returns the qtype information to attach to question element
         */
        protected function define_question_plugin_structure () {
            
            // Define the virtual plugin element with the condition to fulfill.
            $plugin = $this->get_plugin_element ( null, '../../qtype', 'javaunittest' );
            
            // Create one standard named plugin element (the visible container).
            $pluginwrapper = new backup_nested_element ( $this->get_recommended_name () );
            
            // Connect the visible container ASAP.
            $plugin->add_child ( $pluginwrapper );
            
            // Now create the qtype own structures.
            $javaunittest = new backup_nested_element ( 'javaunittest', array (
                    'id' 
            ), array (
                    'responsefieldlines',
                    'givencode',
                    'testclassname',
                    'junitcode' 
            ) );
            
            // Now the own qtype tree.
            $pluginwrapper->add_child ( $javaunittest );
            
            // Set source to populate the data.
            $javaunittest->set_source_table ( 'qtype_javaunittest_options', array (
                    'questionid' => backup::VAR_PARENTID 
            ) );
            
            // Don't need to annotate ids nor files.
            
            return $plugin;
        }
    }
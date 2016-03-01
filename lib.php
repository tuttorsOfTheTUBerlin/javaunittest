<?php
/**
 * The pluginfile class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @author     Michael Rumler, rumler@ni.tu-berlin.de
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
 */
function qtype_javaunittest_pluginfile ( $course, $cm, $context, $filearea, $args, $forcedownload, 
        array $options = array() ) {
    global $CFG;
    require_once ($CFG->libdir . '/questionlib.php');
    question_pluginfile ( $course, $context, 'qtype_javaunittest', $filearea, $args, $forcedownload, $options );
}

/**
 * Requires CSS used for code textareas
 * 
 * @return void sets $_REQUEST['qtype_javaunittest_css_loaded'] = 1; on success
 */
function qtype_javaunittest_require_css () {
    global $CFG, $PAGE;
    $cfg_plugin = get_config ( 'qtype_javaunittest' );
    
    if ( !$PAGE->headerprinted && !isset ( $_REQUEST['qtype_javaunittest_css_loaded'] ) ) {
        if ( $cfg_plugin->editor == 'simple' ) {
            // nothing to be done
        } else if ( $cfg_plugin->editor == 'enabletab' ) {
            // nothing more to be done
        } else if ( $cfg_plugin->editor == 'codemirror' ) {
            $PAGE->requires->css ( new moodle_url ( $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/lib/codemirror.css' ) );
            $PAGE->requires->css ( new moodle_url ( $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/display/fullscreen.css' ) );
            $PAGE->requires->css ( new moodle_url ( $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/dialog/dialog.css' ) );
            $PAGE->requires->css ( new moodle_url ( $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/theme/cm-s-readonly.css' ) );
        } else {
            throw new Exception ( 'qtype_javaunittest: no valid editor setting' );
        }
        $_REQUEST['qtype_javaunittest_css_loaded'] = 1;
    }
}

/**
 * Generates Javascript Code for Code Textareas depending on adminsetting
 * 
 * @param string $selector Parameter for the document.querySelectorAll() call
 * @param int $rows rough hight for CodeMirror editor
 * @param bool $readonly readonly flag for CodeMirror editor
 * @param bool $needredraw autorefresh on activation
 * @return htmlfragment javascript string
 */
function qtype_javaunittest_generateJsBy ( $selector, $rows = 20, $readonly = false, $needredraw = false ) {
    /* Loading js body inlined is realy ugly.
     * Should be loaded as an AMD module in future.
     */
    $cfg_plugin = get_config ( 'qtype_javaunittest' );
    global $CFG;
    
    if ( $cfg_plugin->editor == 'simple' ) {
    
        return '';
        
    } else if ( $cfg_plugin->editor == 'enabletab' ) {
        
        qtype_javaunittest_require_css ();
        if ( !isset ( $_REQUEST['qtype_javaunittest_css_loaded'] ) )
            throw new Exception ( 'qtype_javaunittest: failed to load codemirror css' );
        
        $htmlfragment = '';
        if ( !isset ( $_REQUEST['qtype_javaunittest_jss_loaded'] ) ) {
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/enabletab.js"></script>';
            $_REQUEST['qtype_javaunittest_jss_loaded'] = 1;
        }
        $htmlfragment .= '<script type="text/javascript"> qtype_javaunittest_enableTab("' . $selector . '"); </script>';
        return $htmlfragment;
        
    } else if ( $cfg_plugin->editor == 'codemirror' ) {
        
        qtype_javaunittest_require_css ();
        if ( !isset ( $_REQUEST['qtype_javaunittest_css_loaded'] ) )
            throw new Exception ( 'qtype_javaunittest: failed to load codemirror css' );
        
        $htmlfragment = '';
        if ( !isset ( $_REQUEST['qtype_javaunittest_jss_loaded'] ) ) {
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/enablecodemirror.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/lib/codemirror.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/mode/clike/clike.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/edit/matchbrackets.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/display/fullscreen.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/display/autorefresh.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/dialog/dialog.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/search/search.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/search/searchcursor.js"></script>';
            $htmlfragment .= '<script type="text/javascript" src="' . $CFG->wwwroot . '/question/type/javaunittest/amd/src/codemirror/addon/search/jump-to-line.js"></script>';
            $_REQUEST['qtype_javaunittest_jss_loaded'] = 1;
        }
        
        // get codemirror option values
        $theme = $readonly ? 'readonly' : 'default';
        $readOnly = $readonly ? 'true' : 'false';
        $nocursor = $readonly ? 'true' : 'false';
        $autorefresh = $needredraw ? 'true' : 'false';
        
        $htmlfragment .= '<script type="text/javascript"> qtype_javaunittest_enableCodeMirror("' . $selector . '", "' . $rows . '", "' . $readOnly . '", "' . $nocursor . '", "' . $theme . '", "' . $autorefresh . '" ); </script>';
        return $htmlfragment;
       
    } else {
        
        throw new Exception ( 'qtype_javaunittest: no valid editor setting' );
        
    }

}
<?php
/**
 * Settings for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Martin Gauk, gauk@math.tu-berlin.de
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

if ( $ADMIN->fulltree ) {
    
    // limits
    $settings->add ( 
            new admin_setting_heading ( 'limits', 
                    get_string ( 'limit_heading', 'qtype_javaunittest' ), '' ) );
    
    // memory limit in MB
    $settings->add ( 
            new admin_setting_configtext ( 'qtype_javaunittest/memory_xmx', 
                    get_string ( 'memory_xmx', 'qtype_javaunittest' ), 
                    get_string ( 'memory_xmx_desc', 'qtype_javaunittest' ), 64, PARAM_INT, 4 ) );
    
    // output limit in KB
    $settings->add ( 
            new admin_setting_configtext ( 'qtype_javaunittest/memory_limit_output', 
                    get_string ( 'memory_limit_output', 'qtype_javaunittest' ), 
                    get_string ( 'memory_limit_output_desc', 'qtype_javaunittest' ), 8, PARAM_INT, 4 ) );
    
    // timeout in real time in seconds
    $settings->add ( 
            new admin_setting_configtext ( 'qtype_javaunittest/timeoutreal', 
                    get_string ( 'timeout_real', 'qtype_javaunittest' ), 
                    get_string ( 'timeout_real_desc', 'qtype_javaunittest' ), 35, PARAM_INT, 4 ) );
    
    // remote
    $settings->add ( 
            new admin_setting_heading ( 'remote_execution', 
                    get_string ( 'remote_execution_heading', 'qtype_javaunittest' ), '' ) );
    
    $settings->add ( 
            new admin_setting_configtext ( 'qtype_javaunittest/remoteserver', 
                    get_string ( 'remoteserver', 'qtype_javaunittest' ), 
                    get_string ( 'remoteserver_desc', 'qtype_javaunittest' ), '' ) );
    
    $settings->add ( 
            new admin_setting_configtext ( 'qtype_javaunittest/remoteserver_user', 
                    get_string ( 'remoteserver_user', 'qtype_javaunittest' ), '', '' ) );
    
    $settings->add ( 
            new admin_setting_configpasswordunmask ( 'qtype_javaunittest/remoteserver_password', 
                    get_string ( 'remoteserver_password', 'qtype_javaunittest' ), '', '' ) );
    
    // local
    $settings->add ( 
            new admin_setting_heading ( 'local_execution', 
                    get_string ( 'local_execution_heading', 'qtype_javaunittest' ), 
                    get_string ( 'local_execution_desc', 'qtype_javaunittest' ) ) );
    
    $settings->add ( 
            new admin_setting_configexecutable ( 'qtype_javaunittest/pathjavac', 
                    get_string ( 'pathjavac', 'qtype_javaunittest' ), '', '/usr/lib/jvm/java-7-openjdk-amd64/bin/javac' ) );
    
    $settings->add ( 
            new admin_setting_configexecutable ( 'qtype_javaunittest/pathjava', 
                    get_string ( 'pathjava', 'qtype_javaunittest' ), '', '/usr/lib/jvm/java-7-openjdk-amd64/bin/java' ) );
    
    $settings->add ( 
            new admin_setting_configfile ( 'qtype_javaunittest/pathjunit', 
                    get_string ( 'pathjunit', 'qtype_javaunittest' ), '', '/usr/share/java/junit4.jar' ) );
    
    $settings->add ( 
            new admin_setting_configfile ( 'qtype_javaunittest/pathhamcrest', 
                    get_string ( 'pathhamcrest', 'qtype_javaunittest' ), '', '/usr/share/java/hamcrest-core.jar' ) );
    
    $settings->add ( 
            new admin_setting_configfile ( 'qtype_javaunittest/pathpolicy', 
                    get_string ( 'pathpolicy', 'qtype_javaunittest' ), '', 
                    dirname ( __FILE__ ) . '/polfiles/defaultpolicy' ) );
    
    $settings->add ( 
            new admin_setting_configtext ( 'qtype_javaunittest/precommand', 
                    get_string ( 'precommand', 'qtype_javaunittest' ), 
                    get_string ( 'precommand_desc', 'qtype_javaunittest' ), 'ulimit -t 8' ) ); // max cpu time 8 secs
                                                                                               
    // debug
    $settings->add ( 
            new admin_setting_heading ( 'debug_heading', 
                    get_string ( 'debug_heading', 'qtype_javaunittest' ), 
                    get_string ( 'debug_heading_desc', 'qtype_javaunittest' ) ) );
    
    $settings->add (
    new admin_setting_configcheckbox ( 'qtype_javaunittest/debug_logfile', get_string ( 'debug_logfile',
                    'qtype_javaunittest' ), '', 0 ) );
    
    $settings->add ( 
            new admin_setting_configcheckbox ( 'qtype_javaunittest/debug_nocleanup', 
                    get_string ( 'debug_nocleanup', 'qtype_javaunittest' ), '', 0 ) );
}
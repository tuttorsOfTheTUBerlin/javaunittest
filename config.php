<?php

/**
 * The php configuration file for configuring the question type. 
 *
 * qtype_javaunittest supports either compiling and testing local
 * or for security and computing issues via remote. Switch by
 * changing the value of 'USE_REMOTE' below.
 *
 * Furthermore either the path to java compiler and the path to
 * JUnit compiler have to be set properly in order to compile and
 * test java classes local - or the remote port and remote ip for
 * the compiling and testing server.
 *
 * @package 	qtype
 * @subpackage 	javaunittest
 * @author 		Michael Rumler, rumler@ni.tu-berlin.de
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
global $CFG;

$cfg_dirroot_backslashes = $CFG->dirroot;
$cfg_dirroot = str_replace ( "\\", "/", $cfg_dirroot_backslashes );

/**
 * Switch display settings here.
 * Set SHOW_TIME TRUE or FALSE to enable (default) or disable print used time.
 * Set SHOW_JUNITRESULT_LEVEL to 0 to show nothing
 * 1 to show only failure lines (default)
 * 2 to show stacktrace
 * SHOW_JUNITRESULT > 0 requires a security policy with permission
 * java.lang.RuntimePermission "getStackTrace" grant.
 *
 * @staticvar boolean SHOW_TIME
 * @staticvar int SHOW_JUNITRESULT_LEVEL
 */
define ( 'SHOW_TIME', TRUE );
define ( 'SHOW_JUNITRESULT_LEVEL', 1 );

/**
 * Switch here between local and remote compiling and test running.
 *
 * @staticvar boolean USE_REMOTE
 */
define ( 'USE_REMOTE', FALSE );

/**
 * Force the plugin to set a junit timeout to test classes.
 * B
 * Value in milliseconds (e.g. 10000) or FALSE to disable feature.
 * e.g. define ( 'FORCE_TIMEOUT', 10000 );
 *
 * @staticvar mixed forceTimeout
 */
define ( 'FORCE_TIMEOUT', 10000 );

/**
 * If USE_REMOTE=FALSE configure local path settings here.
 *
 * @staticvar string PATH_TO_JAVAC
 * @staticvar string PATH_TO_JAVA
 * @staticvar string PATH_TO_JUNIT
 * @staticvar string PATH_TO_HAMCREST
 * @staticvar string PATH_TO_POLICY
 */
// e.g. define('PATH_TO_JAVAC', '/usr/lib/jvm/java-7-openjdk-amd64/bin/javac');
define ( 'PATH_TO_JAVAC', '/usr/lib/jvm/java-7-openjdk-amd64/bin/javac' );

// e.g. define ( 'PATH_TO_JAVA', '/usr/lib/jvm/java-7-openjdk-amd64/bin/java' );
define ( 'PATH_TO_JAVA', '/usr/lib/jvm/java-7-openjdk-amd64/bin/java' );

// e.g. define('PATH_TO_JUNIT', '/usr/share/java/junit.jar');
define ( 'PATH_TO_JUNIT', '/opt/junit/junit.jar' );

// e.g. define('PATH_TO_HAMCREST', '/usr/share/java/hamcrest.jar');
define ( 'PATH_TO_HAMCREST', '/opt/junit/hamcrest.jar' );

// e.g. define('PATH_TO_POLICY', dirname(__FILE__) . '/polfiles/defaultpolicy');
define ( 'PATH_TO_POLICY', dirname ( __FILE__ ) . '/polfiles/defaultpolicy' );

/**
 * If USE_REMOTE=TRUE configure remote target here.
 *
 * @staticvar string REMOTE_URL
 */
// remote url, e.g.: define ( 'REMOTE_URL',
// 'http://127.0.0.1/moodle_qtype_javaunittest_remoteserver/server.php' );
define ( 'REMOTE_URL', 
		'http://my.moodle.tld/moodle_qtype_javaunittest_remoteserver/server.php' );

?>

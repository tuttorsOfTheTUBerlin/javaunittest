<?php
/**
 * Strings for component 'qtype_javaunittest', language 'en'
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @author     Michael Rumler, rumler@ni.tu-berlin.de
 * @author     Martin Gauk, gauk@math.tu-berlin.de
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['graderinfo'] = 'Information for graders';
$string['nlines'] = '{$a} lines';
$string['pluginname'] = 'javaunittest';
$string['pluginname_help'] = 'JUnit question type';
$string['pluginname_link'] = 'question/type/javaunittest';
$string['pluginnameadding'] = 'Adding an javaunittest question';
$string['pluginnameediting'] = 'Editing an javaunittest question';
$string['pluginnamesummary'] = 'Allows a Java-code response which is evaluated by a defined JUnit test';
$string['crontask'] = 'Unittest feedback cleanup';
$string['responsefieldlines'] = 'Input box size';
$string['responseformat'] = 'Response format';
$string['testclassname'] = 'JUnit test class name';
$string['testclassname_help'] = 'The JUnit class name of the following JUnit test code. The JUnit class name must be the same as the class name in the following "JUnit test code" section.';
$string['uploadtestclass'] = 'JUnit test class';
$string['uploadtestclass_help'] = 'Please put your JUnit testing code here.';
$string['givencode'] = 'Given code';
$string['givencode_help'] = 'Code which is provided by the instructor';
$string['loadedtestclassheader'] = 'Load test file';

// feedback
$string['feedbacklevel'] = 'Feedback';
$string['feedback_nothing'] = 'nothing';
$string['feedback_only_times'] = 'times';
$string['feedback_times_count_of_tests'] = 'times and count of tests/failures';
$string['feedback_all_except_stacktrace'] = 'all except stacktraces';
$string['CA'] = 'CORRECT ANSWER: All answers are correct.';
$string['PCA'] = 'PARTIALLY CORRECT ANSWER: Some answers are correct, some not.';
$string['WA'] = 'WRONG ANSWER: All answers are wrong.';
$string['CE'] = 'COMPILER ERROR: Your source code does not compile. Please check it for errors.';
$string['JE'] = 'JUNIT TEST FILE ERROR: Test cannot be executed. The given answer seems to be incompatible to the test class or the test class could not be compiled.';
$string['TO'] = 'TIMEOUT: The execution time limit is reached.';
$string['compiling'] = 'compiling... [{$a}s]';
$string['running'] = 'running... [{$a}s]';
$string['ioexception'] = 'IOException occurred.';
$string['filenotfoundexception'] = 'FileNotFoundException occurred.';
$string['arrayindexoutofboundexception'] = 'ArrayIndexOutOfBoundException occurred.';
$string['classcastexception'] = 'ClassCastException occurred.';
$string['negativearraysizeexception'] = 'NegativeArraySizeException occurred.';
$string['nullpointerexception'] = 'NullPointerException occurred.';
$string['outofmemoryerror'] = 'OutOfMemoryError occurred.';
$string['stackoverflowerror'] = 'StackOverflowError occurred.';
$string['stringindexoutofboundexception'] = 'StringIndexOutOfBoundException occurred.';
$string['bufferoverflowexception'] = 'BufferOverflowException occurred.';
$string['bufferunderflowexception'] = 'BufferUnderflowError occurred.';
$string['accesscontrolexception'] = 'AccessControlException occurred.';

// settings
$string['limit_heading'] = 'Resource limits';
$string['memory_xmx'] = 'Memory limit (heap) in MB';
$string['memory_xmx_desc'] = 'This sets the option -Xmx for the Java VM. Specifies the maximum size of the memory allocation pool.';
$string['memory_limit_output'] = 'Memory limit (output) in KB';
$string['memory_limit_output_desc'] = 'Limits the size of outputs during test executions.';
$string['timeout_real'] = 'Timeout';
$string['timeout_real_desc'] = 'Timeout in seconds (real time) for test executions.';
$string['remote_execution_heading'] = 'Execution on other server';
$string['remoteserver'] = 'Remote URL';
$string['remoteserver_desc'] = 'Give a URL to a remote machine if you want remote compiling and test running. Otherwise leave this empty if you wish execution on this server. The remote server may override the settings for memory and time limit. (e.g. http://remoteserver/moodle_qtype_javaunittest/server.php)';
$string['remoteserver_user'] = 'Username';
$string['remoteserver_password'] = 'Password';
$string['local_execution_heading'] = 'Execution on this server';
$string['local_execution_desc'] = 'If you want compiling and test running on this server you need to set the following.';
$string['pathjavac'] = 'Path of javac binary';
$string['pathjava'] = 'Path of java binary';
$string['pathjunit'] = 'Path of junit';
$string['pathhamcrest'] = 'Path of hamcrest';
$string['pathpolicy'] = 'Path of the policy file for the Java Security Manager';
$string['precommand'] = 'Command before test execution';
$string['precommand_desc'] = 'This will be executed on shell before the tests. You may use ulimit to limit resources (e.g. cpu time) for the tests.';
$string['debug_heading'] = 'Local debug information';
$string['debug_heading_desc'] = 'Enable only for testing! (only local java execution)';
$string['debug_logfile'] = 'Save logfiles to temporary directory';
$string['debug_nocleanup'] = 'Do not clean up temporary files and directories';
<?php

/**
 * The question class for this question type.
 *
 * @package 	qtype
 * @subpackage 	javaunittest
 * @author 		Gergely Bertalan, bertalangeri@freemail.hu
 * @author 		Michael Rumler, rumler@ni.tu-berlin.de
 * @reference 	sojunit 2008, SÃƒÂ¼reÃƒÂ§ Ãƒâ€“zcan, suerec@darkjade.net
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU GPL v3 OR later
 */
require_once (dirname ( __FILE__ ) . '/config.php');
defined ( 'MOODLE_INTERNAL' ) || die ();

/**
 * Represents a javaunittest question.
 */
class qtype_javaunittest_question extends question_graded_automatically {
	public $responseformat;
	public $responsefieldlines;
	public $givencode;
	public $testclassname;
	public $automatic_feedback;
	public $hideCompilermsg;
	
	/**
	 * The moodle_page the page we are outputting to.
	 *
	 * @param moodle_page $page        	
	 * @return qtype_javaunittest_format_renderer_base the response-format-specific
	 *         renderer
	 */
	public function get_format_renderer(moodle_page $page) {
		return $page->get_renderer ( 'qtype_javaunittest', 
				'format_' . $this->responseformat );
	}
	
	/**
	 * The methode is called when the question attempt
	 * is actually stared and does necessary initialisation.
	 * In this case only the type of the answer is defined.
	 *
	 * @return array of expected parameters
	 */
	public function get_expected_data() {
		return array (
				'answer' => PARAM_RAW_TRIMMED 
		);
	}
	
	/**
	 * Sumarize the response of the student.
	 *
	 * @param array $response        	
	 * @return string answer OR null
	 */
	public function summarise_response(array $response) {
		if (isset ( $response ['answer'] )) {
			$formatoptions = new stdClass ();
			$formatoptions->para = false;
			return html_to_text ( 
					format_text ( $response ['answer'], FORMAT_HTML, $formatoptions ), 
					0, false );
		} else {
			return null;
		}
	}
	
	/**
	 * Delivers the correct response of the student,
	 * Since we do not have any given correct
	 * response to the question, we return null.
	 *
	 * @return null
	 */
	public function get_correct_response() {
		return null;
	}
	
	/**
	 * Check whether the student has already answered the question.
	 *
	 * @param array $response        	
	 * @return bool true if $response['answer'] is not empty
	 */
	public function is_complete_response(array $response) {
		return ! empty ( $response ['answer'] );
	}
	
	/**
	 * Validate the student's response.
	 * Since we have a gradable response, we always
	 * return an empty string here.
	 *
	 * @param array $response        	
	 * @return string empty string OR please-select-an-answer-message
	 */
	public function get_validation_error(array $response) {
		if ($this->is_gradable_response ( $response )) {
			return '';
		}
		return get_string ( 'pleaseselectananswer', 'qtype_truefalse' );
	}
	
	/**
	 * Every time students change their response in the texteditor this function
	 * is called to check whether the student's newly entered response differs.
	 *
	 * @param array $newresponse        	
	 * @return boolean true if old and new response->answer are equal
	 */
	public function is_same_response(array $prevresponse, array $newresponse) {
		return question_utils::arrays_same_at_key_missing_is_blank ( $prevresponse, 
				$newresponse, 'answer' );
	}
	
	/**
	 * Here happens everything important.
	 * Files are loaded and created.
	 * Compile- and execute-functions are called.
	 * Evaluation of junit output is done.
	 * Grade is calculated.
	 *
	 * @param array $response
	 *        	the response of the student
	 * @return array $fraction
	 *         fraction of the grade. If the max grade is 10 then fraction can be for
	 *         example 2 (10/5 = 2 indicating that from 10 points the student achieved
	 *         5).
	 */
	public function grade_response(array $response) {
		global $CFG, $DB;
		/*
		 * preparation: create a new sub-folder in the course-files-path for each
		 * question. Put the related source codes (Test.java and
		 * student_response.java) of a user into this sub-folder
		 */
		
		// these data are used to create an unique temporary folder
		// in which the JUnit test will be executed
		$step = new question_attempt_step ();
		$studentid = $step->get_user_id ();
		$questionid = $this->id;
		$attemptid = optional_param ( 'attempt', '', PARAM_INT );
		
		// if we are in edit question mode we have no attemptid => use any attemptid
		if (! isset ( $attemptid )) {
			$attemptid = $studentid + $questionid;
		}
		
		// create a unique temp folder to keep the data together in one place
		$cfg_dataroot_backslashes = $CFG->dataroot;
		$cfg_dataroot = str_replace ( "\\", "/", $cfg_dataroot_backslashes );
		$temp_folder = $cfg_dataroot . '/javaunittest_temp_' . $studentid . '_' .
				 $questionid . '_' . $attemptid;
		if (file_exists ( $temp_folder )) {
			$this->delTree ( $temp_folder );
		}
		$this->mkdir_recursive ( $temp_folder );
		
		// create the test class from the database and save it in the temporary folder
		$options = $DB->get_record ( 'qtype_javaunittest_options', 
				array (
						'questionid' => $questionid 
				) );
		$testclassname = $options->testclassname;
		$junitcode = $options->junitcode;
		
		// manipulate content and add timeout
		if (FORCE_TIMEOUT !== FALSE) {
			$timeoutstring = "globalTimeout";
			// make sure identifier is not taken
			while ( strpos ( $junitcode, $timeoutstring ) !== FALSE ) {
				$timeoutstring .= "_";
			}
			$timeoutstring = "\n@Rule\npublic Timeout " . $timeoutstring .
					 " = new Timeout(" . FORCE_TIMEOUT . ");\n";
			$newjunitcode = preg_replace ( 
					'/public class ' . $testclassname . '([\w\d\s])*{/', 
					'public class ' . $testclassname . ' {' . $timeoutstring, 
					$junitcode );
			if ($newjunitcode == $junitcode || $newjunitcode == NULL) {
				$this->automatic_feedback .= "cannot find public class declaration in test class<br>\n";
			}
			$junitcode = $newjunitcode;
		}
		if (! USE_REMOTE) {
			$testFile = $temp_folder . '/' . $testclassname . '.java';
			touch ( $testFile );
			$fh = fopen ( $testFile, 'w' ) or
					 die ( "cannot open file" . $testfile . "<br>\n" );
			fwrite ( $fh, $junitcode );
			fclose ( $fh );
		}
		
		// create the student's response class from the responsefield
		$studentscode = $response ['answer'];
		$matches = array ();
		preg_match ( '/^(?:\s*public)?\s*class\s+(\w[a-zA-Z0-9_]+)/m', $studentscode, 
				$matches );
		if (empty ( $matches [1] )) {
			$studentsclassname = 'Xy';
		} else {
			$studentsclassname = $matches [1];
		}
		
		if (! USE_REMOTE) {
			$studentclass_path = $temp_folder . '/';
			$studentclass = $studentclass_path . $studentsclassname . '.java';
			
			touch ( $studentclass );
			$fh = fopen ( $studentclass, 'w' ) or
					 die ( "cannot open file" . $studentclass . "<br>\n" );
			fwrite ( $fh, $studentscode );
			fclose ( $fh );
		}
		
		// compile the student's response
		if (! USE_REMOTE) {
			$compileroutput = $this->compile ( $studentclass, $temp_folder, 
					$studentsclassname );
			$compileroutput = substr_replace ( $compileroutput, '', 0, 
					strlen ( $temp_folder ) + 1 );
			$compileroutput = addslashes ( $compileroutput );
			$compileroutput = str_replace ( $temp_folder, "\n", $compileroutput );
		} else {
			$targetUrl = REMOTE_URL;
			$javaunittestConfig = get_config ( 'qtype_javaunittest' );
			$post = array (
					'compile' => true,
					'execute' => false,
					'clientversion' => $javaunittestConfig->version,
					'studentid' => $studentid,
					'studentsclassname' => $studentsclassname,
					'questionid' => $questionid,
					'attemptid' => $attemptid,
					'javaclassname' => $studentsclassname,
					'testclassname' => $testclassname,
					'javacode' => $studentscode,
					'junitcode' => $junitcode 
			);
			$start_time = microtime ( TRUE );
			$targetUrl = REMOTE_URL;
			$curlHandle = curl_init ();
			curl_setopt ( $curlHandle, CURLOPT_URL, $targetUrl );
			curl_setopt ( $curlHandle, CURLOPT_POST, 1 );
			curl_setopt ( $curlHandle, CURLOPT_VERBOSE, 1 );
			curl_setopt ( $curlHandle, CURLOPT_POSTFIELDS, $post );
			curl_setopt ( $curlHandle, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt ( $curlHandle, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $curlHandle, CURLOPT_AUTOREFERER, 1 );
			curl_setopt ( $curlHandle, CURLOPT_MAXREDIRS, 10 );
			curl_setopt ( $curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
			$result = curl_exec ( $curlHandle );
			$HTTPStatusCode = curl_getinfo ( $curlHandle, CURLINFO_HTTP_CODE );
			if ($HTTPStatusCode == '403') {
				$this->automatic_feedback = get_string ( 'RSFORBIDDEN', 
						'qtype_javaunittest' ) . " (Status code: 403 )<br>\n";
				$this->hideCompilermsg = TRUE;
			} else if ($HTTPStatusCode == '422') {
				$this->automatic_feedback = get_string ( 'RSWRONGVERSION', 
						'qtype_javaunittest' ) . " (Status code: 422 )<br>\n";
				$this->hideCompilermsg = TRUE;
			} else if ($HTTPStatusCode != '222') {
				$this->automatic_feedback = get_string ( 'RSNOTCOMP', 
						'qtype_javaunittest' ) . " (Status code: " . $HTTPStatusCode .
						 ")<br>\n";
				$this->hideCompilermsg = TRUE;
			}
			curl_close ( $curlHandle );
			$now_time = microtime ( TRUE );
			$time = round ( $now_time - $start_time, 2 );
			! SHOW_TIME or $this->hideCompilermsg == TRUE or
					 $this->automatic_feedback .= "compiling... \t[" . $time . "s]\n";
			$compileroutput = $result;
		}
		
		// create grader's feedback file. This file is used to return a feedback to
		// the student
		$feedbackFile = $temp_folder . '/' . 'feedback.log';
		touch ( $feedbackFile );
		
		// execute junit test if no compilation error. If we have compiler error we
		// jump to the else
		// part, save the compiler error in the feedback file and grade the question
		// with 0 points
		if (USE_REMOTE && strpos ( $compileroutput, "Compilation OK" ) !== FALSE ||
				 ! USE_REMOTE && strlen ( $compilerout ) == 0) {
			if (! USE_REMOTE) {
				$executionoutput = $this->execute ( $temp_folder, $testFile, 
						$testclassname, $studentclass, $studentsclassname );
			} else {
				$targetUrl = REMOTE_URL;
				$javaunittestConfig = get_config ( 'qtype_javaunittest' );
				$post = array (
						'compile' => false,
						'execute' => true,
						'clientversion' => $javaunittestConfig->version,
						'studentid' => $studentid,
						'studentsclassname' => $studentsclassname,
						'questionid' => $questionid,
						'attemptid' => $attemptid,
						'javaclassname' => $studentsclassname,
						'testclassname' => $testclassname 
				);
				$start_time = microtime ( TRUE );
				$targetUrl = REMOTE_URL;
				$curlHandle = curl_init ();
				curl_setopt ( $curlHandle, CURLOPT_URL, $targetUrl );
				curl_setopt ( $curlHandle, CURLOPT_POST, 1 );
				curl_setopt ( $curlHandle, CURLOPT_VERBOSE, 1 );
				curl_setopt ( $curlHandle, CURLOPT_POSTFIELDS, $post );
				curl_setopt ( $curlHandle, CURLOPT_FOLLOWLOCATION, 1 );
				curl_setopt ( $curlHandle, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $curlHandle, CURLOPT_AUTOREFERER, 1 );
				curl_setopt ( $curlHandle, CURLOPT_MAXREDIRS, 10 );
				curl_setopt ( $curlHandle, CURLOPT_HTTP_VERSION, 
						CURL_HTTP_VERSION_1_1 );
				$result = curl_exec ( $curlHandle );
				$HTTPStatusCode = curl_getinfo ( $curlHandle, CURLINFO_HTTP_CODE );
				if ($HTTPStatusCode == '403') {
					$this->automatic_feedback = get_string ( 'RSFORBIDDEN', 
							'qtype_javaunittest' ) . " (Status code: 403)<br>\n";
					$this->hideCompilermsg = TRUE;
				} else if ($HTTPStatusCode == '422') {
					$this->automatic_feedback = get_string ( 'RSWRONGVERSION', 
							'qtype_javaunittesst' ) . " (Status code: 422)<br>\n";
					$this->hideCompilermsg = TRUE;
				} else if ($HTTPStatusCode != '222') {
					$this->automatic_feedback = get_string ( 'RSNOTCOMP', 
							'qtype_javaunittest' ) . " (Status code: " . $HTTPStatusCode .
							 ")<br>\n";
					$this->hideCompilermsg = TRUE;
				}
				curl_close ( $curlHandle );
				$now_time = microtime ( TRUE );
				$time = round ( $now_time - $start_time, 2 );
				! SHOW_TIME or $this->hideCompilermsg == TRUE or
						 $this->automatic_feedback .= "running... \t[" . $time . "s]\n";
				$executionoutput = $result;
			}
			
			// the JUnit-execution-output returns always a String in the first line
			// e.g. "...F",
			// which means that 1 out of 3 test cases didn't pass the JUnit test
			// In the second line it says "Time ..."
			
			// discard the summary
			$executionoutputresult = preg_replace ( '/JUnit version (\d)*.(\d)*/', 
					'', $executionoutput );
			$pos = strpos ( $executionoutputresult, 'Time' );
			$executionoutputresult = substr ( $executionoutputresult, 0, $pos );
			
			// count the failures and errors.
			$numtest = substr_count ( $executionoutputresult, '.' );
			$numfailures = substr_count ( $executionoutputresult, 'F' );
			$numerrors = substr_count ( $executionoutputresult, 'E' );
			$totalerror = $numfailures + $numerrors;
			
			// output results
			$this->automatic_feedback .= "Tests: " . $numtest . "<br>\n";
			$this->automatic_feedback .= "Failures: " . $numfailures . "<br>\n";
			$this->automatic_feedback .= "Errors: " . $numerrors . "<br>\n";
			
			if (strpos (  $executionoutput, "test timed out after" ) !== FALSE) {
				$this->automatic_feedback .= get_string ( 'TO', 'qtype_javaunittest' ) .
						 "<br>\n";
			}
			if (SHOW_JUNITRESULT_LEVEL === 1) {
				$matches = array ();
				$rc = preg_match ( '/Failure:.*/', $executionoutput, $matches );
				if ($rc = 1) {
					$this->automatic_feedback .= "<br>\n";
					foreach ( $matches as $match ) {
						$this->automatic_feedback .= htmlspecialchars ( $match ) .
								 "<br>\n";
					}
				}
			} else if (SHOW_JUNITRESULT_LEVEL === 2) {
				$this->automatic_feedback .= "<br>\n[JUNIT]" .
						 htmlspecialchars ( $executionoutput ) . "[/JUNIT]<br>\n";
			}
			
			// grading
			// CASE 1 - Test compile error
			// if there is something wrong with the test file this is may be either
			// our fold or the students one (e.g. they change a requested methods
			// signature or identifier so we call something not existing
			// in this case we grade as wrong so make sure to proof your test class
			if ($numtest == 0) {
				$fraction = 1;
				$this->hideCompilermsg or $this->automatic_feedback = get_string ( 
						'JE', 'qtype_javaunittest' ) . "<br>\n" .
						 $this->automatic_feedback . "<br>\n<hr><br>\n";
			} 			// CASE 2 - 100% correct answer
			else if ($totalerror == 0) {
				$fraction = 1;
				$this->automatic_feedback = get_string ( 'CA', 'qtype_javaunittest' ) .
						 "<br>\n" . $this->automatic_feedback . "<br>\n<hr><br>\n";
			} 			// CASE 3 - partially correct answer
			else if ($numtest > $totalerror) {
				$fraction = 1 - round ( ($totalerror / $numtest), 2 );
				$this->automatic_feedback = get_string ( 'PCA', 'qtype_javaunittest' ) .
						 "<br>\n" . $this->automatic_feedback . "<br>\n<hr><br>\n";
			} 			// CASE 4 - wrong answer
			else {
				$fraction = 0;
				$this->automatic_feedback = get_string ( 'WA', 'qtype_javaunittest' ) .
						 "<br>" . $this->automatic_feedback . "<br>\n<hr><br>\n";
			}
		} 		// CASE 5 - Answer does not compile => wrong answer. We grade the response
		  // with 0 point
		else {
			$fraction = 0;
			$this->automatic_feedback = get_string ( 'CE', 'qtype_javaunittest' ) .
					 "<br>" . $compileroutput . "<br>\n<hr><br>\n";
		}
		
		// after the grade is computed, a feedback is created. The feedback is the
		// compiler output (in the case of compilation error)
		// or the JUnit test output (in the case when the response can be tested) plus
		// some additional information.
		
		// compute the unique id for the feedback. We need it to store the feedback in
		// the database.
		$unique_answerid = ($studentid + $questionid * $attemptid) +
				 ($studentid * $questionid + $attemptid);
		
		$oldanswers = $DB->get_records ( 'question_answers', 
				array (
						'question' => $unique_answerid 
				) );
		$answer = array_shift ( $oldanswers );
		// if this is the first attempt, we store the fedback in the database
		if (! $answer) {
			$answer = new stdClass ();
			$answer->question = $unique_answerid;
			$answer->feedback = $this->automatic_feedback;
			$answer->answer = '';
			$DB->insert_record ( 'question_answers', $answer );
		} 		// update an existing answer if possible. If the student has already answered
		// the question, we have already created
		// and stored the feedback in the database and we simply update it.
		else {
			$answer->answer = '';
			$answer->feedback = $this->automatic_feedback;
			$DB->update_record ( 'question_answers', $answer );
		}
		
		// at this pont the feedback has already stored in the database and the grade
		// is created. We delete the temporary
		// and return with the coputed fraction of the response.
		$this->delTree ( $temp_folder );
		return array (
				$fraction,
				question_state::graded_state_for_fraction ( $fraction ) 
		);
	}
	
	/**
	 * Assistent function to compile the java code if USE_REMOTE is false.
	 *
	 * @param string $studentclass
	 *        	the response of the student
	 * @param string $temp_folder
	 *        	the temporary folder defined in grade_response() we use to store the
	 *        	data
	 * @param string $studentsclassname
	 *        	the name of the class which has to be compiled
	 * @return string $compileroutput the output of the compiler
	 */
	function compile($studentclass, $temp_folder, $studentsclassname) {
		
		// work out the compile command line
		$compileroutputfile = $temp_folder . '/' . $studentsclassname .
				 '_compileroutput.log';
		touch ( $compileroutputfile );
		
		$command = PATH_TO_JAVAC . ' -cp ' . PATH_TO_JUNIT . ' ' . $studentclass .
				 ' -Xstdout ' . $compileroutputfile;
		
		// execute the command
		$output = shell_exec ( escapeshellcmd ( $command ) );
		
		// get the content of the copiler output
		$compileroutput = file_get_contents ( $compileroutputfile );
		
		return $compileroutput;
	}
	
	/**
	 * Assistent function to compile and execute the junit test if USE_REMOTE is
	 * false.
	 *
	 * @param string $temp_folder
	 *        	the temporary folder defined in grade_response() we use to store the
	 *        	data
	 * @param string $testFile
	 *        	the JUnit test file
	 * @param string $testFileName
	 *        	the name of the JUnit test file
	 * @param string $studentclass
	 *        	the response of the student
	 * @param string $studentsclassname
	 *        	the name of the class which has to be tested
	 * @return string $executionoutput the output of the JUnit test
	 */
	function execute($temp_folder, $testFile, $testFileName, $studentclass, 
			$studentsclassname) {
		
		// create the log file to store the output of the JUnit test
		$executionoutputfile = $temp_folder . '/' . $studentsclassname .
				 '_executionoutput.log';
		$testFileName = str_replace ( ".java", "", $testFileName );
		touch ( $studentclass );
		
		// work out the compile command line to compile the JUnit test
		$command = PATH_TO_JAVAC . ' -cp ' . PATH_TO_JUNIT . ' -sourcepath ' .
				 $temp_folder . ' ' . $testFile . ' > ' . $executionoutputfile .
				 ' 2>&1';
		$this->automaticfeedback .= "command is local: " . $command . "<br>\n";
		// execute the command
		$output = shell_exec ( $command );
		
		// work out the compile command line to execute the JUnit test
		$commandWithSecurity = PATH_TO_JAVA . " -Djava.security.manager=default" .
				 " -Djava.security.policy=" . PATH_TO_POLICY . " ";
		$command = PATH_TO_JAVA . " -cp " . PATH_TO_JUNIT . ":" . PATH_TO_HAMCREST .
				 ":" . $temp_folder . " org.junit.runner.JUnitCore " . $testFileName .
				 " > " . $executionoutputfile . " 2>&1";
		
		// execute the command
		$output = shell_exec ( $command );
		
		// get the execution log
		$executionoutput = file_get_contents ( $executionoutputfile );
		
		return $executionoutput;
	}
	
	/**
	 * read the content of a file
	 *
	 * @param array $fileinfo
	 *        	the file which content will be readed
	 * @return string $contents the content of the file
	 */
	function get_file_content($fileinfo) {
		$fs = get_file_storage ();
		
		// Get file
		$file = $fs->get_file ( $fileinfo ['contextid'], $fileinfo ['component'], 
				$fileinfo ['filearea'], $fileinfo ['itemid'], $fileinfo ['filepath'], 
				$fileinfo ['filename'] );
		
		// Read content
		if ($file) {
			$contents = $file->get_content ();
		} else {
			die ( "cannot read file " . $file );
		}
		return $contents;
	}
	
	/**
	 * Assistent function to create a directory inclusive missing top directories.
	 *
	 * @param string $folder
	 *        	the absolute path
	 * @return boolean true on success
	 */
	function mkdir_recursive($folder) {
		if (is_dir ( $folder )) {
			return true;
		}
		if (! $this->mkdir_recursive ( dirname ( $folder ) )) {
			return false;
		}
		$rc = mkdir ( $folder, 01700 );
		if (! $rc) {
			die ( "cannot create directory " . $folder . "<br>\n" );
		}
		return $rc;
	}
	
	/**
	 * Assistent function to delete a directory tree.
	 *
	 * @param string $dir
	 *        	the absolute path
	 * @return boolean true on success, false else
	 */
	function delTree($dir) {
		$files = array_diff ( scandir ( $dir ), array (
				'.',
				'..' 
		) );
		foreach ( $files as $file ) {
			(is_dir ( "$dir/$file" )) ? delTree ( "$dir/$file" ) : unlink ( 
					"$dir/$file" );
		}
		$rc = rmdir ( $dir );
		return $rc;
	}
}

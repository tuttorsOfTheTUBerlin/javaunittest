<?php

/**
 * The question class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/config.php');
defined('MOODLE_INTERNAL') || die();


/**
 * Represents an javaunittest question.
 *
 */
class qtype_javaunittest_question extends question_graded_automatically {
    public $responseformat;
    public $responsefieldlines;
    public $givencode;
    public $testclassname;
    public $automatic_feedback;


    /**
     * @param moodle_page the page we are outputting to.
     * @return qtype_javaunittest_format_renderer_base the response-format-specific renderer.
     */
    public function get_format_renderer(moodle_page $page) {

        return $page->get_renderer('qtype_javaunittest', 'format_' . $this->responseformat);
    }

     /**
     * return an array of expected parameters. The methode is called when the question attempt 
     * is actually stared and does necessary initialisation. In this case only the type of the
     * answer is defined.
     */
    public function get_expected_data() {

        return array('answer' => PARAM_RAW_TRIMMED);
    }


     /**
     * sumarize the response of the student
     */
    public function summarise_response(array $response) {

        if (isset($response['answer'])) {
            $formatoptions = new stdClass();
            $formatoptions->para = false;
            return html_to_text(format_text(
                    $response['answer'], FORMAT_HTML, $formatoptions), 0, false);
        } else {
            return null;
        }
    }

     /**
     * return the correct response of the student. Since we do not have any given correct
     * response to the question, we return null.
     */
    public function get_correct_response() {

        return null;
    }


     /**
     * check whether the student has already answered the question. 
     */
    public function is_complete_response(array $response) {

        return !empty($response['answer']);
    }


     /**
     * validate the student's response. Since we have a gradable response, we always
     * return an empty string here.
     */
    public function get_validation_error(array $response) {

        if ($this->is_gradable_response($response)) {
            return '';
        }
        return get_string('pleaseselectananswer', 'qtype_truefalse');
    }


     /**
     * every time a student changes his response in the texteditor this function is called
     * to check whether the student's newly entered response is the sane as the previous one.
     */
    public function is_same_response(array $prevresponse, array $newresponse) {

        return question_utils::arrays_same_at_key_missing_is_blank($prevresponse, $newresponse, 'answer');
    }
 

    /**
     * Here happens everything, starting from compiling and executing the proper files
     * till calculating the grade.
     * @param $response the response of the student
     * @return $fraction of the grade. If the max grade is 10 then fraction can be for 
     *         example 2 (10/5 = 2 indicating that from 10 points the student achieved 5).
     */
    public function grade_response(array $response) {

	global $CFG, $DB;

	/* preparation:
         * create a new sub-folder in the course-files-path for each question.
         * Put the related source codes (Test.java and student_response.java) of a user into this sub-folder
         */


	//these data are used to create an unique folder name for the temporary folder
        //in which the JUnit test will be executed
	$step = new question_attempt_step();
	$studentid = $step->get_user_id();
	$questionid = $this->id;

	$attemptid = optional_param('attempt', '', PARAM_INT);

	//if we are in edit question mode we have no attemptid => use any attemptid
	if(!isset($attemptid)) {
		$attemptid = $studentid + $questionid;;
	}

	//create a unique temp folder to keep the data together in one place 
        $cfg_dataroot_backslashes = $CFG->dataroot;
        $cfg_dataroot = str_replace("\\", "/", $cfg_dataroot_backslashes);	
        $temp_folder = $cfg_dataroot . '/javaunittest_temp_' . $studentid . '_' . $questionid . '_' . $attemptid;
	
	if (file_exists($temp_folder)) {
		$this->delTree($temp_folder);
	}
        $this->mkdir_recursive($temp_folder);


	//create the test class from the database and save it in the temporary folder
	$options = $DB->get_record('qtype_javaunittest_options', array('questionid' => $questionid));	
	$testclassname = $options->testclassname;

	$junitcode = $options->junitcode;

	$testFile = $temp_folder . '/' . $testclassname . '.java';

	touch($testFile);
	$fh = fopen($testFile, 'w') or die("can't open file");
	fwrite($fh, $junitcode);
	fclose($fh);


	//create the student's response class from the responsefield
	$studentscode = $response['answer'];
        $matches = array();
        preg_match('/^(?:\s*public)?\s*class\s+(\w[a-zA-Z0-9_]+)/m', $studentscode, $matches);
	if (empty( $matches[1])){
		$studentsclassname = 'Xy';
	} else {
		$studentsclassname = $matches[1];
	}

	$studentclass_path = $temp_folder . '/';
	$studentclass =  $studentclass_path . $studentsclassname . '.java';

	touch($studentclass);
	$fh = fopen($studentclass, 'w') or die("can't open file");
	fwrite($fh, $studentscode);
	fclose($fh);

	//compile the student's response
        $compileroutput = $this->compile($studentclass, $temp_folder, $studentsclassname);
	$compileroutput = substr_replace($compileroutput, '', 0, strlen($temp_folder)+1);
	$compileroutput = addslashes($compileroutput);
	$compileroutput = str_replace($temp_folder, "\n", $compileroutput);


	//create grader's feedback file. This file is used to return a feedback to the student
	$feedbackFile = $temp_folder . '/' . 'feedback.log';
	touch($feedbackFile);

	//execute junit test if no compilation error. If we have compiler error we jump to the else 
        //part, save the compiler error in the feedback file and grade the question with 0 pionts
	if(strlen($compileroutput) == 0){  

		//execute JUnit test
		$executionoutput = $this->execute($temp_folder, $testFile, $testclassname, $studentclass, $studentsclassname);

		//filter the $executionoutput by 'Time 0.000' part in order to get same
		//execution-outputs in the Results->Item analysis grouped together for a better analysis
		$cleaned_executionoutput = preg_replace("/Time:\s([0-9]+[.][0-9]+)\s/","",$executionoutput);
		$cleaned_executionoutput = addslashes($cleaned_executionoutput);

		//initialize the feedback, later will be modified according to the junit test
		$automatic_feedback = $cleaned_executionoutput;
	
		//the JUnit-execution-output returns always a String in the first line e.g. "...F",
            	//which means that 1 out of 4 test cases didn't pass the JUnit test
            	//In the second line it says "Time ..."

            	// Discard the summary.
            	$pos = strpos($executionoutput, 'Time') + 1; //get the pos in the string where 'Time' starts
            	$executionoutputresult = substr($executionoutput, 0, $pos);

            	// Count the failures and errors.
		$numtest = substr_count($executionoutputresult, '.');
		$numfailures = substr_count($executionoutputresult, 'F');
            	$numerrors = substr_count($executionoutputresult, 'E');
		$totalerror = $numfailures + $numerrors;

		//after we counted the failures and errors we can grade the response

		//CASE 1
		//if there is something wrong with the test file this is our fault -> we did not created the question
		//properly. Therefore we grade the student's answer as correct. We don't know whether it is correct or not 
		//but since our JUnit testfile is wrong and we could not execute the test because of our fault, we grade the answer
		//as correct. 
		if($numtest == 0){
			$fraction = 1; 
			$this->automatic_feedback = get_string('JE', 'qtype_javaunittest') . "\n\n";
			
		}
		//CASE 2
		//100% correct answer
		else if($totalerror == 0){
			$fraction = 1; 
			$this->automatic_feedback = get_string('CA', 'qtype_javaunittest') . "\n\n" . $automatic_feedback;
		}
		//CASE 3
		//partially correct answer
		else if($numtest > $totalerror){
			$fraction = 1 - round(( $totalerror / $numtest),2);
			$this->automatic_feedback = get_string('PCA', 'qtype_javaunittest') . "\n\n" . $automatic_feedback;
		}
		//CASE 4
		// wrong answer
		else{
			$fraction = 0;
			$this->automatic_feedback = get_string('WA', 'qtype_javaunittest') . "\n\n" . $automatic_feedback;
		}
	}
	// Doesn't compile => wrong answer. We grade the response with 0 point
	else{
		$fraction = 0;
		$this->automatic_feedback = get_string('CE', 'qtype_javaunittest') . "\n\n" . $compileroutput;	
	}

    //after the grade is computed, a feedback is created. The feedback is the compiler output (in the case of compilation error)
    //or the JUnit test output (in the case when the response can be tested) plus some additional information.
    
    //compute the unique id for the feedback. We need it to store the feedback in the database.
    $unique_answerid = ($studentid + $questionid * $attemptid) + ($studentid * $questionid + $attemptid);

    $oldanswers = $DB->get_records('question_answers', array('question' => $unique_answerid));
    $answer = array_shift($oldanswers);
    //if this is the first attempt, we store the fedback in the database
    if (!$answer) {
        $answer = new stdClass();
        $answer->question = $unique_answerid;
        $answer->feedback = $this->automatic_feedback;
	$answer->answer = '';
	$DB->insert_record('question_answers', $answer);
    }
    //update an existing answer if possible. If the student has already answered the question, we have already created
    //and stored the feedback in the database and we simply update it.
    else {
	$answer->answer = '';
	$answer->feedback = $this->automatic_feedback;
	$DB->update_record('question_answers', $answer);
    }
	
    //at this pont the feedback has already stored in the database and the grade is created. We delete the temporary 
    //and return with the coputed fraction of the response.
    $this->delTree($temp_folder);
    return array($fraction, question_state::graded_state_for_fraction($fraction));
    }


     /**
     * compile the student's response
     * @param $studentclass the response of the student
     * @param $temp_folder the temporary folder defined in grade_response() we use to store the data
     * @param $studentsclassname the name of the class which has to be compiled
     * @return $compileroutput the output of the compiler
     */  
    function compile($studentclass, $temp_folder, $studentsclassname) {

        //work out the compile command line
        $compileroutputfile = $temp_folder . '/' . $studentsclassname . '_compileroutput.log';
	touch($compileroutputfile);
			
        $command = PATH_TO_JAVAC . ' -cp ' . PATH_TO_JUNIT . ' ' . $studentclass . ' -Xstdout ' . $compileroutputfile;

	//execute the command
	$output = shell_exec(escapeshellcmd($command));
	
	//get the content of the copiler output
        $compileroutput = file_get_contents($compileroutputfile);

	return $compileroutput;
    }

     /**
     * execute the JUnit test
     * @param $temp_folder the temporary folder defined in grade_response() we use to store the data
     * @param $testFile the JUnit test file
     * @param $testFileName the name of the JUnit test file
     * @param $studentclass the response of the student
     * @param $studentsclassname the name of the class which has to be tested
     * @return $executionoutput the output of the JUnit test
     */
    function execute($temp_folder, $testFile, $testFileName, $studentclass, $studentsclassname){

	//create the log file to store the output of the JUnit test
        $executionoutputfile = $temp_folder. '/' . $studentsclassname . '_executionoutput.log';
	$testFileName = str_replace(".java", "", $testFileName);
	touch($studentclass);

	//work out the compile command line to compile the JUnit test
	$command = PATH_TO_JAVAC . ' -cp ' . PATH_TO_JUNIT . ' -sourcepath ' . $temp_folder . ' ' . $testFile . ' > ' . $executionoutputfile . ' 2>&1';

	//execute the command
	$output = shell_exec($command);	

	//work out the compile command line to execute the JUnit test
	$commandWithSecurity = PATH_TO_JAVA . " -Djava.security.manager=default" . " -Djava.security.policy=". PATH_TO_POLICY . " ";	
	$command = $commandWithSecurity . ' -cp ' . PATH_TO_JUNIT . ':' . $temp_folder . ' junit.textui.TestRunner ' . $testFileName . ' > ' . $executionoutputfile . ' 2>&1';

	//execute the command
	$output = shell_exec($command);

	//get the execution log
	$executionoutput = file_get_contents($executionoutputfile);

	return $executionoutput;
    }



     /**
     * read the content of a file
     * @param $fileinfo the file which content will be readed
     * @return $contents the content of the file
     */     
    function get_file_content($fileinfo) {
    	
	$fs = get_file_storage(); 
	 
	// Get file
	$file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
		              $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
	 
	// Read content
	if ($file) {
	    $contents = $file->get_content();
	} else {
	} 
	return $contents;
    } 


     /**
     * create a file
     */ 
    function mkdir_recursive($folder, $mode='') {
        if(is_dir($folder)) {
            return true;
        }
        if ($mode == '') {
            global $CFG;
            $mode = $CFG->directorypermissions;
        }
        if(!$this->mkdir_recursive(dirname($folder),$mode)) {
            return false;
        }
        return mkdir($folder,$mode);
    }

    /**
     * delete a directory tree
     */ 
    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }


     /**
     * checks the file acces. We do not use this function. 
     */
    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {

        if ($component == 'question' && $filearea == 'response_attachments') {
            // Response attachments visible if the question has them.
            return $this->attachments != 0;

        } else if ($component == 'question' && $filearea == 'response_answer') {
            // Response attachments visible if the question has them.
            return $this->responseformat === 'editorfilepicker';

        } else if ($component == 'qtype_javaunittest' && $filearea == 'graderinfo') {
            return $options->manualcomment;

        } else {
            return parent::check_file_access($qa, $options, $component,
                    $filearea, $args, $forcedownload);
        }
    }

    

}

<?php

/*
* The php configuration file for configuring the question type. In this file the path to java compiler
* and the path to JUnit compiler have to be set properly in order to compile and test java classes on
* the server.
*/


global $CFG;

$cfg_dirroot_backslashes = $CFG->dirroot;
$cfg_dirroot = str_replace("\\", "/", $cfg_dirroot_backslashes); // replace \\ with / (in order to use in windows and linux os)

//define('PATH_TO_JAVAC', 'PathNotSet'); 	//TODO use this for module-package //set the proper javac-path e.g. "/usr/lib/jvm/java-1.5.0-sun-1.5.0.14/bin/javac"
define('PATH_TO_JAVAC', '/usr/lib/jvm/java-6-openjdk/bin/javac'); //TODO delete for module-package
//define('PATH_TO_JAVA', 'PathNotSet'); 		//TODO use this for module-package //set the proper java-path e.g. "C:/Program Files/Java/jdk1.5.0_01/bin/javac.exe"
define('PATH_TO_JAVA', '/usr/lib/jvm/java-6-openjdk/bin/java'); //set the proper java-path e.g. "C:/Program Files/Java/jdk1.5.0_01/bin/java.exe"
define('PATH_TO_JUNIT', '/usr/share/java/junit.jar');
define('PATH_TO_POLICY', dirname(__FILE__) . '/polfile');


?>

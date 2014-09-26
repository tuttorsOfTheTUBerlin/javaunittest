/**
 * This is the remote server for compiling and executing java and
 * the junit tests for the qtype_javaunittest module for moodle.
 *
 * @package 	qtype
 * @subpackage 	javaunittest
 * @author 		Michael Rumler, rumler@ni.tu-berlin.de, Berlin Institute of Technology
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 
 ==========================================================
Todo in order to get this question type running properly:
==========================================================

1. Installation and configuration

	Put the the directory 'javaunittest' and its content into your
	moodle directory: moodle/question/type/.
	
	Decide whether using local compiling and test running or using a remote server.
	
	Edit the config.php and set there the proper local path variables or remote url.
	
	If you chose remote running put the content of the directory
	'moodle_qtype_javaunittest_remoteserver' to your remote machine
	and make it accessable like configured in the clients config.php.
	Furthermore configure the remote server itself by editing 
	moodle_qtype_javaunittest_remoteserver/config.php.
	
	The compiling and test running machine needs beside the webserver with
	php support of course java compiler, java runtime environment and a current
	versions of junit and hamcrest (get them from 
	https://github.com/junit-team/junit/wiki/Download-and-Install).
	
==========================================================

2. JUnit examples

	In the sub directory EXAMPLE_FILES you find some examples and another 
	README file. It explains how to create a question with this question 
	type module.

==========================================================

3. Security Manager

	The java security manager has the task to prevent any evil
	things who could mess up your system. This plugin supports
	the usage of the java security manager. There is a polfile to
	configure things who are allowed. E.g. if you need to grant 
	threading privileges or file i/o edit this polfile.
	Policy files should be stored in the polfiles directory.
	
	Note that the remote server has its own polfiles directory.
	
	You should grant at least the following permissions:
		permission java.lang.RuntimePermission "accessDeclaredMembers";
		permission java.lang.RuntimePermission "getStackTrace";

==========================================================

4. About

	This module is developed by tutors of the TU Berlin.
	
	Original version: Süreç Özcan (sojunit 2008), suerec@darkjade.net
    Main developer: Gergely Bertalan, bertalangeri@freemail.hu
    Maintenance and Updates: Michael Rumler, rumler@ni.tu-berlin.de
    
 	Moodle module page: https://moodle.org/plugins/view.php?plugin=qtype_javaunittest
 	Source: https://github.com/tuttorsOfTheTUBerlin/javaunittest
 	
 	Contact via Moodle module page.
 	Please write us if you find any issues or have feedback.

==========================================================

5. Changelog

	Version 2.00:
		+ plugin now supports remote compiling and test running via
			moodle_qtype_javaunittest_remoteServer
		+ now you can configurate a global timeout for your junittests, 
			timeout will automatically added to test classes
		+ some more display settings added
		+ support for junit4 style (junit3 style still works)
		# changed grading: if the test class does not compile we grade the students
			answer as wrong, not as our fault and give 100%...
			otherwise removing/renaming a required method let the student pass

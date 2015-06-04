/**
 * This is javaunittest Moodle question type plugin.
 *
 * @package     qtype
 * @subpackage  javaunittest
 * @author      Michael Rumler, rumler@ni.tu-berlin.de
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 
 ==========================================================

1. Installation and configuration

    Put the the directory 'javaunittest' and its content into your
    moodle directory: moodle/question/type/.
    
    Decide whether using local compiling and test running or using a remote server.
    If you chose remote running put the content of the directory
    'moodle_qtype_javaunittest_remoteserver' to your remote machine.
    
    Configure the plugin settings via admin settings page.
    Furthermore if necessary configure the remote server by editing the config.php.
    
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

==========================================================

4. About

    This module is developed by tutors of the TU Berlin.
    
    Original version: Süreç Özcan (sojunit 2008), suerec@darkjade.net
        Main developer: Gergely Bertalan, bertalangeri@freemail.hu
        Maintenance and Updates: Michael Rumler, rumler@ni.tu-berlin.de
        Improvements: Martin Gauk, gauk@math.tu-berlin.de
    
     Moodle module page: https://moodle.org/plugins/view.php?plugin=qtype_javaunittest
     Source: https://github.com/tuttorsOfTheTUBerlin/javaunittest
     Remote Server Source: https://github.com/tuttorsOfTheTUBerlin/moodle_qtype_javaunittest_remoteserver
     
     Contact via Moodle module page.
     Please write us if you find any issues or have feedback.

==========================================================

5. Important Note for Usage

    Please remember that any kind of software may have bugs. This also involves the
    Java Compiler, Run Time Enviroment and Security Manager, the Webserver, PHP,
    all the other components, and of course this Moodle plugin too. We made this plugin
    secure to our best of knowledge but we can not guarantee that nothing goes wrong.

==========================================================

6. Changelog

    Version 2.01:
        + added admin panel settings (removed config.php, replaced by settings.php) and
            backup feature, thanks to Martin Gauk
        + a lot of security improvements, again many thanks to Martin Gauk
        + added debug settings
        # 2.8 is supported
        # fixed grading issue (now 0% insteat of 100% if students code combined with
            test class do not compile)
        # code cleanup and rewrite (fixed encoding issues, adaption of Moodle coding
            style rules)
        # changed feedback level settings
            + feedback now adjustable per question
            # compiler errors for student code are shown fully, compiler errors for test
                code are printed as static error message, everything else is arranged by
                feedbacklevel
            # feedback levels: nothing, times, times and counts (tests, failures), all
                junit except stacktrace
        # output looks more fancy now


    Version 2.00:
        + plugin now supports remote compiling and test running via
            moodle_qtype_javaunittest_remoteServer
        + now you can configurate a global timeout for your junittests, 
            timeout will automatically added to test classes
        + some more display settings added
        + support for junit4 style (junit3 style still works)
        # changed grading: if the test class does not compile we grade
            the students answer as wrong, otherwise removing/renaming
            a required method let the student pass
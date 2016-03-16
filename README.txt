/**
 * This is the javaunittest Moodle question type plugin.
 *
 * @package     qtype
 * @subpackage  javaunittest
 * @author      Michael Rumler, rumler@ni.tu-berlin.de
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
==========================================================

1. Installation and Configuration

    Put the the directory 'javaunittest' and its content into your
    moodle directory: moodle/question/type/ or run in the root of your moodle install:
    git clone https://github.com/tuttorsOfTheTUBerlin/javaunittest.git question/type/javaunittest
    
    Optional: Decide whether using local compiling and test running or using a remote server.
    If you chose remote running put the content of the directory
    'moodle_qtype_javaunittest_remoteserver' to your remote machine or go to the www root of your remote server and run:
    git clone https://github.com/tuttorsOfTheTUBerlin/moodle_qtype_javaunittest_remoteserver
    
    Configure the plugin settings via admin settings page in moodle.
    Furthermore if used configure the remote server by editing the config.php in the filesystem.
    
    The compiling and test running machine needs (beside the webserver with
    php support and php modules) a java compiler, java runtime environment and a current
    versions of junit and hamcrest (get them from 
    https://github.com/junit-team/junit/wiki/Download-and-Install).
    
==========================================================

2. JUnit Examples

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
    
    Reference: 
        Süreç Özcan (sojunit 2008), suerec@darkjade.net
    Developer until 2014: 
        Gergely Bertalan, bertalangeri@freemail.hu
    Development, maintenance and updates since 2014: 
        Michael Rumler, rumler@ni.tu-berlin.de
    Improvements: 
        Martin Gauk, gauk@math.tu-berlin.de
    
    Moodle module page: https://moodle.org/plugins/view.php?plugin=qtype_javaunittest
    Source: https://github.com/tuttorsOfTheTUBerlin/javaunittest
    Remote Server Source: https://github.com/tuttorsOfTheTUBerlin/moodle_qtype_javaunittest_remoteserver
     
    Contact via Moodle module page.
    Please write us if you find any issues or have feedback.
    
    Licence: 
        The javaunittest plugin is licensed under GNU GPL v3 or later, 
        see http://www.gnu.org/copyleft/gpl.html
        
        The plugin is using the CodeMirror text editor by Marijn Haverbeke (marijnh@gmail.com)
        and others (see ./LICENCE/CodeMirrorAuthors.txt). 
        CodeMirror is licenced under MIT, see https://codemirror.net/LICENSE
        
        Licences (GNU GPL v3 and MIT) are available in the ./LICENCE directory aswell.

==========================================================

5. Important Note for Usage

    Please remember that any kind of software may have bugs. This also involves the
    Java Compiler, Run Time Enviroment and Security Manager, the Webserver, PHP,
    all the other components, and of course this Moodle plugin too. We made this plugin
    secure to our best of knowledge but we can not guarantee that nothing goes wrong.
    
    There is no warranty for the program, to the extent permitted by applicable law. 
    Except when otherwise stated in writing the copyright holders and/or other parties 
    provide the program “as is” without warranty of any kind, either expressed or implied, 
    including, but not limited to, the implied warranties of merchantability and fitness 
    for a particular purpose. The entire risk as to the quality and performance of the 
    program is with you. Should the program prove defective, you assume the cost of all 
    necessary servicing, repair or correction. (GNU GPL)
    
==========================================================

6. Changelog

    Version 2.03:
        + Moodle 3.0 support
        + PHP 7 support
        + added support for CodeMirror editor and for simple tab usage in code textareas 
                (thanks to Paul P. for the original tab support)
        + added possibility to print junit assert feedback strings, expected and actual 
                value to the feedback
        + added possibility to deposit a sample solution
        + added possibility to deposit the expected signature for student code - after 
                compiling it is matched with the actual javap signature and missmatches are printable
        + multiple classes in student code does not need to have the public one as the first anymore
        + added some more examples
        # feedback: changed feedbacklevel - not hierarchiv anymore, you can now choose each 
                feedback option separate per question
        # added parent directory for temporary files (javaunitest/uid=UID_qid=QID_aid=AID)
        # minor changes for error messages, logging, curl, language strings, ...

    Version 2.02:
        + use moodle $CFG->dirpermissions for creating temporary directories
        + code textareas in formulars use monospace font now
        # changed directory name for temporary files: now javaunittest_uid=UID_qid=QID_aid=AID
        # set java file encoding to UTF-8
        
    Version 2.01:
        + added admin panel settings (removed config.php, replaced by settings.php) and
                backup feature, thanks to Martin Gauk
        + a lot of security improvements, again many thanks to Martin Gauk
        + added debug settings
        # 2.8 and 2.9 are supported
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
            
==========================================================

7. Known Issues / ToDos / Planned Features

    Documentation
        Still missing. Plans for separated student, teacher, admin/dev doc.
        Include nice Examples (work with stdin/out, using reflections or signatures (also inner classes), ...)
            Maybe offer a couple of default questions or even a full set for beginners to import
        Help element on question create/edit page linking to teacher doc
    
    Help Buttons
        More help buttons on question attempt and question feedback page to assist java newbies 
        Help button telling about great CodeMirror keys if CodeMirror is active (F11, CTRL+U/D/Z, ...)
    
    Buttons to verify sample solution and generate expected signature
        Question edit/create page should have a button and result-element to verify sample solution and junit inputs against each other.
        Also there should be a button to generate the expected signature from the sample solution input.
        
    PHP Unit self test
        At the moment all testing is done manually. Some well working PHP Unit tests to verify the plugin would be great. The content in ./test has not been 
                touched for years.
        
    Improve code and style
        Use logging API
        JS as AMD module
            Js is currently not loaded as amd module. See functions in lib.php.
        Renderer
            The feedbackstring is a long htmlfragment generated by hand. This should be splitted, saved separate and gets combined by renderer methods.
        UTF-8
            Sometimes storing UTF-8 in java code delivers '?' insteat of the char when printing it on the feedback page (for compiler UTF-8 works well) 
                    (database problem? enconding setting in moodle? browser fail?).
        Manipulation
            Stdout
                There might be possibilities to print inside the junitoutput to tamper with the rating. At the moment this is out 
                        of scope since on the one hand this is not critical, one the other the user is indentified, and finally if you are skilled enough to do so you won't
                        have needs to exercise with these questions anyway.
            Usage of reflections
                When policy file allows reflections for junit students are allowed aswell. Could be abused to access junitcode and return them via assert expected value
                        if all settings are suitable. Maybe use regex to filter student code? Not a 100% solution. Disallowing regex would be bad as well.
        Exceptions
            When an exception occurs while running junit the tests becomes interupted and 0 rated. Some common expections are printed to the student, based on 
                    regex match with a couple of (in the source itsself deposited) expections. We should cover all java brought expections and give a possibility to add
                    your own ones. Maybe make them editable via settings page.
            Print exception line (first occurance at least, maybe some parts of the stack trace? settings for that?)
        Improve style, fix warnings by moodle-local_codechecker and moodle-local_moodlecheck.
        Rewrite code following all the other coding style guides.
                    
    Stdout
        Think about whether it is wished and possible to print the students what they print on stdout/err. (Redirect stdout/err per automated code manipulation?)
                At the moment this can be done by the teacher in junit, but it is not a handsome method
    
    Import/Export/Backup/Restore
        Moodle XML Import/Export seems to work well, the other ones look really useless - something we can do against?

    Outstanding customer needs
        Think about color blinds... we probably need a different theme for color blinds for CodeMirror? (implement a checkbox, new table with uid and flag, new theme, ...)
        How does the plugin works on mobile phones / tablets?
        
    Other languages and VMs
        At the moment you can use local java compiling and execution or take use of the remote server. This php script runs remote and is doing local java compiling and execution
                where it runs. It is planned to offer an improved remote server (probably not in php written) that takes requests, holds a queue of VMs (a lightweight image
                (maybe stripped with yocto, but that would need maintenance aswell), running on qemu with kvm), let everything get done in the VM and finally greps and 
                returns the results. On the one hand this allows more rights for the students (threads, localhost sockets, file io, ...), on the other it allows forks for 
                languages coming without a sandbox like c/c++.
                
    => You are invited to implement features (before named and others) on your own or join me doing so. You can mail me or offer pull requests on git.
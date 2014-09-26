==========================================================
Todo in order to get this question type running properly:
==========================================================

1. Module Path:
    Put this module into this sub directory: moodle/question/type/

2. Compilation and execution:
    In config.php set the proper 'PATH_TO_JAVAC', 'PATH_TO_JAVA' and 'PATH_TO_JUNIT' !!!
    Note: There is also a security manager which checks for non-proper student-responses. 
	  This way you should not worry about the student messing up the system (polfile-file).

3. EXAMPLE_FILES/readme.txt explains how to create a question with this question type.

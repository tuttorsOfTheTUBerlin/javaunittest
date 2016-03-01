./XML/
    => Contains a Moodle Export with example files. You can import those to get a start point.
        The examples in ./Stdout/ and ./LinkedList/ are included.
        A group of examples (faculty program) with already set student answers demonstrates what happens depending
                on the students answer, covering all cases from compile error to right answer.

./Factorial/
    => Old JUNIT 3 basic example (java code)
    
./HelloWorld/
    => JUNIT 4 basic example (java code)
    
./Reflections_Fieldmodifiercheck/
    => Java example with a field modifier check (java code)
    
./Reverse/
    => Old JUNIT 3 basic example (java code)
    
./Search/
    => Old JUNIT 3 basic example (java code)
    
./Stdout/
    => JUNIT 4 example for stdout/err catching (java code)
    
./LinkedList/
    => complex JUNIT 4 example (java code)
    


In case you have a nice example question showing a common use case or an interesting special case please:
    * Create a directory
    * Add a moodle xml export, the java code or both (preferred)
    * Add a README describing your question, informing about the author (f.e. first name, last name, mail, institute or what ever you wish),
            anything else you like, and a licence note (preferred GNU GPL v3 or later)
    * Pack and mail me or commit as a pull request on github (preferred) (see ./../README.txt for data)
    

Finally there are a couple of screenshots in this directory showing question creation.
These are a little OUT OF TOUCH and will be replaced by a nice documentation as soon as I find time (or anyone else can find some).

    teacher editing view:
        create a new javaunittest question type: 1_1.png and 1_2.png
        1. givencode: copy here the content from Factorial.java
        3. JUnit test class name: FactorialTest ->because the test class in FactorialTest.java has this name
        4. JUnit test code: copy here the content from FactorialTest.java
        NOTE: the test class name has to be the same in 2) and 3) !!!
        
    student editing view:
        without the student's answer: 2_1.png
        with the student's answer: 2_2.png
        
    outputs:
        student's answer wrong, compiler error: 3.1.png
        student's answer partialy correct, JUnit test result: 3.2.png
        
    student's answer correct: 3.3.png
    
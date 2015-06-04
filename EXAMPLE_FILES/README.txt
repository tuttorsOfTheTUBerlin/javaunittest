We make here an example with pictures and create a JUnit qustion type.

We create a question, in which the students have to implement the factorial function.

In directory "Factorial":

Factorial.java        - givencode (interface) by teacher
FactorialTest.java    - the JUnit test code to upload by teacher ("JUnit test code" field on the question editing form)
Correct_Response.java - an possible (correct) response by student

-----------------
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

-----------------

There are other two examples in this directory: Reverse, Search.

Furthermore we added an example for junit 4 style and timeout. See HelloWorld directory.
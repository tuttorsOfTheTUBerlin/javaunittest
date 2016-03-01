// we require having permission java.lang.RuntimePermission "setIO" granted by policy file.
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.PrintStream;

import org.junit.Test;
import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.containsString;

public class HelloWorldTest {
    
    @Test
    public void mainPrintsHelloWorld() {
        ByteArrayOutputStream outContent = new ByteArrayOutputStream();
        PrintStream newStdOut = new PrintStream(outContent);
        System.setOut(newStdOut);
        HelloWorld.main(null);
        assertThat("Your main method is broken...", outContent.toString(), containsString("Hello World!"));
        outContent.reset();
    }
    
    @Test
    public void otherMethod() {
        ByteArrayOutputStream errContent = new ByteArrayOutputStream();
        PrintStream newStdErr = new PrintStream(errContent);
        System.setOut(newStdErr);
        HelloWorld.main(null);
        assertThat("Your notMyDay method is broken...", errContent.toString(), containsString("Hello World!"));
        errContent.reset();
    }
    
}
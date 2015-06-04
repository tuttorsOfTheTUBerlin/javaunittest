import static org.junit.Assert.*;
import static org.junit.matchers.JUnitMatchers.*;

import org.junit.Test;
import org.junit.Rule;
import org.junit.rules.*;
import org.junit.runner.RunWith;
import org.junit.runners.JUnit4;

/**
 * A simple Testclass for junit, testing our HelloWorld.class
 */
public class TestHelloWorld {

    @Rule
    public Timeout globalTimeout = new Timeout(20000); // 20 seconds max per test

    public HelloWorld helloObj = new HelloWorld();

    @Test
    public void thisAssertsEqual() {
        assertEquals("Message: Strings not the same", "HelloWorld",
                helloObj.generateHelloWorld());
    }

    @Test
    public void thisDoesNotRunInfinity() {
        assertEquals("Message: Strings not the same", "foo",
                helloObj.runInfinity()); // will terminate with a timeout error
    }

}
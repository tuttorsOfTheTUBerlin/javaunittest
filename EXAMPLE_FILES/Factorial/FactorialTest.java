import junit.framework.TestCase;
import java.io.*;


public class FactorialTest extends TestCase {

	public FactorialTest() {
		// we do not want the users to print something
		System.setOut(new PrintStream(new OutputStream() {
			public void write(int b) throws IOException { }
		}));
		System.setErr(new PrintStream(new OutputStream() {
			public void write(int b) throws IOException { }
		}));
	}
	
	public void testFactorial() {
		assertEquals(1.0, Factorial.factorial(0), 0.0);
	}

	public void testFactorial2() {
		assertEquals(1.0, Factorial.factorial(1), 0.0);
	}

	public void testFactorial3() {		
		assertEquals(120, Factorial.factorial(5), 0.0);
	}

}
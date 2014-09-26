import junit.framework.TestCase;


public class FactorialTest extends TestCase {
	
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
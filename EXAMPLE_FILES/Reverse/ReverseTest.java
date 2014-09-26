import junit.framework.TestCase;


public class ReverseTest extends TestCase {
	
	public void testReverse() {
		assertEquals("", Reverse.reverse(""));
	}

	public void testReverse2() {
		assertEquals("cba", Reverse.reverse("abc"));
	}

	public void testReverse3() {		
		assertEquals("123456789", Reverse.reverse("987654321"));
	}

}

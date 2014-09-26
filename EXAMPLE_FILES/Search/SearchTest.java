import junit.framework.TestCase;


public class SearchTest extends TestCase {
	
	public void testsearchPosition() {
		int[] a = {1,2,3,4,5,6,7,8,9,10};
		assertEquals(0, Search.searchPosition(a,1));
	}

	public void testsearchPosition2() {
		int[] a = {1,2,3,4,5,6,7,8,9,10};
		assertEquals(9, Search.searchPosition(a,10));
	}

	public void testsearchPosition3() {
		int[] a = {1,2,3,4,5,6,7,8,9,10};
		assertEquals(-1, Search.searchPosition(a,100));
	}

	public void testsearchPosition4() {
		int[] a = {1,2,3,4,5,6,7,8,9,10};
		assertEquals(4, Search.searchPosition(a,5));
	}

}

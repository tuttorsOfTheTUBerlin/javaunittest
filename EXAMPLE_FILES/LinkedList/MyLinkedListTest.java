/**
  * This file contains a junit example for the moodle qtype javaunittest plugin.
  *
  * Note: I have never completely tested this solution, just wrote it down.
  *
  * @package      qtype
  * @subpackage   javaunittest
  * @author       Michael Rumler, rumler@ni.tu-berlin.de
  * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
  * @link         https://github.com/tuttorsOfTheTUBerlin/javaunittest/tree/master/EXAMPLE_FILES/LinkedList/
  */
  
import java.util.*;                      // Iterator
import org.junit.Test;                   // @Test Annotation
import static org.junit.Assert.*;        // assertEquals(), assertNotNull(), ... 
import static org.hamcrest.CoreMatchers.containsString; // Handy for checking stream content

// For Stdout redirecting
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.PrintStream;

// Execution Order
import org.junit.FixMethodOrder;
import org.junit.runners.MethodSorters;

/* Run test cases in order of method names ascending
 * since we want to check constructor first, ...
 * Default order is random.
 */
@FixMethodOrder(MethodSorters.NAME_ASCENDING)

/* For this test you should have granted the following permissions in the policy file:
 *   permission java.lang.RuntimePermission "setIO";         // for testing print()
 *   permission java.lang.RuntimePermission "getStackTrace"; // for feedback in error case
 */

public class MyLinkedListTest {
    
    /* For this implementation: 
     * Points to the last absolved test. No need to run a test behind a test that failed already.
     * (Would procude a lot of output and is nonsense to test addFirst() it the constructor test failed).
     * Note: This is not always usefull. F.e. you may have a couple of entity classes the students have to
     * implement... those can (and probably should be) tested parallel, and should definitly if you do not allow 
     * multiple tries based on the last try (adaptive mode as quiz behavior setting).
     */
    private static char stage = 'A';
    
    /* If we do not place signature to check all members and methods better do not access
     * methods and members direct by call. They might not be there because the student made
     * a mistake and in consequence your junit test class would not compile.
     * So either place the expected signature, or turn on JUnit Testclass Compilerfeedback
     * (both settings below), or use reflections to check that the members and methods exist first.
     * Here we use the expected signature, so we do not need a very first @Test asserting that all
     * tested methods and members are found via reflection.
     */
    
    @Test
    public void A_construct() {
        if (this.stage < 'A') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        assertNotNull("Constructor call did not create a MyLinkedList", l);
        this.stage = 'B';
    }
    
    @Test
    public void B_empty() {
        if (this.stage < 'B') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        assertTrue("New constructed MyLinkedList was not empty", l.empty());
        this.stage = 'C';
    }
    
    @Test
    public void C_addGetFirst() {
        if (this.stage < 'C') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        l.addFirst("Roland");
        assertEquals("Adding and getting first added data does not work as expected", "Roland", l.getFirst());
        l.addFirst("Alain");
        l.addFirst("Cuthbert");
        assertEquals("Adding and getting first added data does not work as expected when adding multiple entrys as first", "Cuthbert", l.getFirst());
        this.stage = 'D';
    }
    
    @Test
    public void D_size() {
        if (this.stage < 'D') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        assertEquals("Size method returns wrong size", 0, l.size());
        l.addFirst("Roland");
        l.addFirst("Alain");
        l.addFirst("Cuthbert");
        assertEquals("Size method returns wrong size after adding some elements as first", 3, l.size());
        this.stage = 'E';
    }
    
    // TODO: test other add and get and remove functions...
    
    @Test
    public void E_toString() {
        if (this.stage < 'E') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        l.addFirst("Roland");
        l.addFirst("Alain");
        l.addFirst("Cuthbert");
        assertEquals("Your toString method does not work as expected...",
                     "MyLinkedList(Cuthbert, Alain, Roland)", 
                     l.toString());
        this.stage = 'F';
    }
    
    @Test
    public void F_print() {
        if (this.stage < 'F') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        l.addFirst("Roland");
        l.addFirst("Alain");
        l.addFirst("Cuthbert");
        ByteArrayOutputStream outContent = new ByteArrayOutputStream();
        PrintStream newStdOut = new PrintStream(outContent);
        System.setOut(newStdOut);
        l.print();
        assertThat("Your print method is broken...", 
                   outContent.toString(), 
                   containsString("MyLinkedList(Cuthbert, Alain, Roland)"));
        outContent.reset();
        this.stage = 'G';
    }
    
    @Test
    public void G_iterator() {
        if (this.stage < 'G') fail("Test skipped because of previous failures");
        MyLinkedList<String> l = new MyLinkedList<String>();
        l.addLast("Roland");
        l.addLast("Cuthbert");
        Iterator itr = l.iterator();
        assertTrue("Iterator hasNext() does not work", itr.hasNext());
        assertEquals("Iterator next() does not work", "Roland", itr.next());
        assertEquals("Iterator next() does not work", "Cuthbert", itr.next());  
        try {
            itr.next();
            fail("Iterator next() did not throw an exception when there was no next");
        } catch (NoSuchElementException e) {
        }
        // Note that you can set a complete @Test method to expect an exception: @Test(expected = NoSuchElementException.class)
        this.stage = 'H';
    }
    
}
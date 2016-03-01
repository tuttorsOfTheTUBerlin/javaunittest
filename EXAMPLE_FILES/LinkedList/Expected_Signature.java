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

public class MyLinkedList<G> implements java.lang.Iterable<G> {
    private MyLinkedList$MyNode<G> head;
    public MyLinkedList();
    public boolean empty();
    public int size();
    public void addFirst(G);
    public G getFirst();
    public G removeFirst();
    public void addLast(G);
    public G getLast();
    public G removeLast();
    public G get(int);
    public G remove(int);
    public G remove(G);
    public void clear();
    public boolean contains(G);
    public java.lang.String toString();
    public java.util.Iterator<G> iterator();
}

class MyLinkedList$MyNode<G> {
    private G data;
    private MyLinkedList$MyNode<G> next;
    public MyLinkedList$MyNode(G, MyLinkedList$MyNode<G>);
}

class MyLinkedList$MyLinkedListIterator implements java.util.Iterator<G> {
    private MyLinkedList$MyNode<G> next;
    public MyLinkedList$MyLinkedListIterator(MyLinkedList);
    public boolean hasNext();
    public G next();
    public void remove();
}
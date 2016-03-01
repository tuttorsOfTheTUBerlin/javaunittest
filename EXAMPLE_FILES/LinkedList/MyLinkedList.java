/**
  * This file contains a junit example for the moodle qtype javaunittest plugin.
  *
  * @package      qtype
  * @subpackage   javaunittest
  * @author       Michael Rumler, rumler@ni.tu-berlin.de
  * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
  * @link         https://github.com/tuttorsOfTheTUBerlin/javaunittest/tree/master/EXAMPLE_FILES/LinkedList/
  */

import java.util.*;

/** 
  * Collection class implementing a single chained list
  */
public class MyLinkedList<G> implements Iterable<G> {
    private MyNode<G> head;

 /**
    * static nested class for list elements
    */
    private static class MyNode<G> {
        private G data;
        private MyNode<G> next;

        public MyNode(G data, MyNode<G> next) {
            this.data = data;
            this.next = next;
        }
    }

 /**
    * Constructor, constructs an empty list
    */
    public MyLinkedList() {
        this.head = null;
    }

 /**
    * Checks whether the list has elements
    * @return boolean true if list is empty
    */
    public boolean empty() {
        return this.head == null;
    }

 /**
    * Returns the size of the list
    * @return int list size
    */
    public int size() {
        // TODO
        return -1;
    }

 /**
    * Inserts data at the beginning of the list
    * @param <G> data the data to insert
    */
    public void addFirst(G data) {
        this.head = new MyNode<G>(data, this.head);
    }

 /**
    * Returns data of the first element in the list
    * @throws NoSuchElementException
    * @return <G> data of the first element
    */
    public G getFirst() {
        if (this.head == null) 
            throw new NoSuchElementException();
        return this.head.data;
    }

 /**
    * Removes the first element in the list
    * @throws NoSuchElementException
    * @return <G> data of the first element
    */
    public G removeFirst() {
        if (this.head == null)
            throw new NoSuchElementException();
        G tmp = getFirst();
        this.head = this.head.next;
        return tmp;
    }

 /**
    * Inserts data to the end of the list.
    * @param <G> data the data to insert
    */
    public void addLast(G data) {
        // TODO
    }

 /**
    * Returns the last element in the list.
    * @throws NoSuchElementException
    * @return <G> data of the last element
    */
    public G getLast() {
        // TODO
        return null;
    }

 /**
    * Removes the last element in the list.
    * @throws NoSuchElementException
    * @return <G> data of the last element
    */
    public G removeLast() {
        // TODO
        return null;
    }

 /**
    * Returns the data at the specified position in the list.
    * @throws IndexOutOfBoundsException
    * @param int pos position
    * @return <G> data at position pos
    */
    public G get(int pos) {
        // TODO
        return null;
    }
     
  /**
     * Removes the data at the specified position in the list.
     * @throws IndexOutOfBoundsException
     * @param int pos position
     * @return <G> data at position pos
     */
     public G remove(int pos) {
        // TODO
        return null;
     }

  /**
     * Removes the given data from the list
     * @throws NoSuchElementException
     * @param String data the data to remove
     * @return <G> data at position pos
     */
     public G remove(G data) {
        // TODO
        return null;
     }
     
 /**
    * Removes all elements from the list
    */
    public void clear() {
        this.head = null;
    }

 /**
    * Returns true if this list contains an element with the given data
    * @return boolean true if data in list
    */
    public boolean contains(G data) {
        for (G tmp : this) // use iterable
            if (tmp.equals(data)) 
                return true;
        return false;
    }

 /**
    * Returns a string representation of the list
    * @return String string representation
    */
    public String toString() {
        // TODO
        return null;
    }
	
 /**
    * Prints a string representation of the list to the stdout
    */
    public void print() {
        System.out.println(toString());
    }

 /**
    * Method to deliver the Iterator for iterable
    */
    public Iterator<G> iterator() {
        return new MyLinkedListIterator();
    }

 /**
    * Inner class for Iterator implementing all Iterator<> declarations
    */
    private class MyLinkedListIterator implements Iterator<G> {
        private MyNode<G> next;

        public MyLinkedListIterator() {
            this.next = head;
        }

        public boolean hasNext() {
            return this.next != null;
        }

        public G next() {
            if (!hasNext()) 
                throw new NoSuchElementException();
            G data = this.next.data;
            this.next = this.next.next;
            return data;
        }

        public void remove() { 
            throw new UnsupportedOperationException(); 
        }
    }

}
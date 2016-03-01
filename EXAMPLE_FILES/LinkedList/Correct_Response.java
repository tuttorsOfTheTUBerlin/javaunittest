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
        int count = 0;
        MyNode<G> tmp = this.head;
        while (tmp != null) {
            count++;
            tmp = tmp.next;
        }
        return count;
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
        if (head == null)
            addFirst(data);
        else {
            MyNode<G> tmp = this.head;
            while (tmp.next != null)
                tmp = tmp.next;
            tmp.next = new MyNode<G>(data, null);
        }
    }

 /**
    * Returns the last element in the list.
    * @throws NoSuchElementException
    * @return <G> data of the last element
    */
    public G getLast() {
        if (this.head == null) 
            throw new NoSuchElementException();
        MyNode<G> tmp = this.head;
        while (tmp.next != null) 
            tmp = tmp.next;
        return tmp.data;
    }

 /**
    * Removes the last element in the list.
    * @throws NoSuchElementException
    * @return <G> data of the last element
    */
    public G removeLast() {
        if (this.head == null) 
            throw new NoSuchElementException();
        if (size() == 1) {
            G data = this.head.data;
            this.head = null;
            return data;
        }
        MyNode<G> tmpPrev = head;
        MyNode<G> tmp = this.head.next;
        while(tmp.next != null) {
            tmpPrev = tmp;
            tmp = tmp.next;

        }
        G data = tmp.data;
        tmpPrev.next = null;
        return tmp.data;
    }

 /**
    * Returns the data at the specified position in the list.
    * @throws IndexOutOfBoundsException
    * @param int pos position
    * @return <G> data at position pos
    */
    public G get(int pos) {
        if (this.head == null) 
            throw new IndexOutOfBoundsException();
        MyNode<G> tmp = this.head;
        for (int i = 0; i < pos; i++) {
            if (tmp.next == null)
                throw new IndexOutOfBoundsException();
            tmp = tmp.next;
        }
        return tmp.data;
    }
     
  /**
     * Removes the data at the specified position in the list.
     * @throws IndexOutOfBoundsException
     * @param int pos position
     * @return <G> data at position pos
     */
     public G remove(int pos) {
          if (this.head == null)
                throw new IndexOutOfBoundsException();
          if (pos == 0) {
                G data = this.head.data;
                this.head = null;
                return data;
          }
          MyNode<G> tmpPrev = head;
          MyNode<G> tmp = this.head.next;
          for (int i = 1; i < pos; i++) {
            if (tmp.next == null)
                     throw new IndexOutOfBoundsException();
                tmpPrev = tmp;
                tmp = tmp.next;
          }
          G data = tmp.data;
          tmpPrev.next = null;
          return tmp.data;
     }

  /**
     * Removes the given data from the list
     * @throws NoSuchElementException
     * @param String data the data to remove
     * @return <G> data at position pos
     */
     public G remove(G data) {
          if (this.head == null)
                throw new NoSuchElementException();
          if (size() == 1)
            if (this.head != data)
                throw new NoSuchElementException();
          MyNode<G> tmpPrev = head;
          MyNode<G> tmp = this.head.next;
          for (int i = 1; i < size(); i++) {
            if (tmp.data == data) {
                  G ret = tmp.data;
                  tmpPrev.next = null;
                  return ret;
            }
            if (tmp.next == null)
                throw new NoSuchElementException();
                tmpPrev = tmp;
                tmp = tmp.next;
          }
        throw new NoSuchElementException();
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
        String result = "MyLinkedList(";
        if (!empty()) {
            for (G tmp : this)
                result += tmp + ", ";
            result = result.substring(0, result.length()-2); // remove last ", "
        }
        return result + ")";
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
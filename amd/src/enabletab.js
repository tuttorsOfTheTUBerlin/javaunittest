/**
 * enables inserting TABs in textareas
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Paul P., paul@easytoedit.com
 * @author     Michael Rumler, rumler@ni.tu-berlin.de
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 OR later
 */

function qtype_javaunittest_enableTab ( selector ) {
    var el = document.querySelectorAll( selector );
    if ( el instanceof NodeList  && elems.item ( elems.length-1 ) != null ) {
        el[el.length-1].onkeydown = function ( e ) {
           if ( e.keyCode === 9 ) {
               var val = this.value,
               start = this.selectionStart,
               end = this.selectionEnd;
       
               this.value = val.substring ( 0, start ) + "\t" + val.substring ( end );
               this.selectionStart = this.selectionEnd = start + 1;
               return false;
           }
       }
    } else {
        console.log ( 'qtype_javaunittest: could not find textarea document.querySelector(' + selector + ')[' + elems.length + ']' );
    }
};

/**
 * loads CodeMirror in textareas
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Michael Rumler, rumler@ni.tu-berlin.de
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 OR later
 */

function qtype_javaunittest_enableCodeMirror ( selector, rows, readonly, nocursor, theme, autorefresh ) {
	var elems = document.querySelectorAll ( selector );
    if ( elems instanceof NodeList && elems.item ( elems.length-1 ) != null ) {
        editor = CodeMirror.fromTextArea (
                elems[elems.length-1], 
                {
                    'mode': "text/x-java",
                    'lineNumbers': true,
                    'indentWithTabs': true,
                    'indentUnit': 4,
                    'smartIndent': true,
                    'matchBrackets' : true,
                    'autofocus': false,
                    'rtlMoveVisually': true,
                    'autoRefresh': autorefresh,
                    'readonly': readonly,
                    'nocursor': nocursor,
                    'theme': theme,
                    'extraKeys': {
                        'F11': function ( cm ) {
                            cm.setOption ( 'fullScreen', !cm.getOption ( 'fullScreen' ) );
                        },
                        'Esc': function ( cm ) {
                            if ( cm.getOption ( 'fullScreen' ) ) 
                            	cm.setOption ( 'fullScreen', false );
                        },
                        "Alt-F": "findPersistent"
                    }
                }
        );
        editor.setSize ( null, 20 * rows );
    } else {
       console.log ( 'qtype_javaunittest: could not find textarea document.querySelector(' + selector + ')[' + elems.length + ']' );
    }
}

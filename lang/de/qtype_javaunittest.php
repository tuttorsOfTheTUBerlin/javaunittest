<?php
/**
 * Strings fuer das Moodle-Modul 'qtype_javaunittest', Sprache 'de'
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @author     Michael Rumler, rumler@ni.tu-berlin.de
 * @author     Martin Gauk, gauk@math.tu-berlin.de
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['graderinfo'] = 'Informationen für Bewertende';
$string['nlines'] = '{$a} Zeilen';
$string['pluginname'] = 'javaunittest';
$string['pluginname_help'] = 'JUnit question type';
$string['pluginname_link'] = 'question/type/javaunittest';
$string['pluginnameadding'] = 'Hinzufügen einer JUnit-Frage';
$string['pluginnameediting'] = 'Editieren einer JUnit-Frage';
$string['pluginnamesummary'] = 'Freitextantworten (Java-Code) werden von selbsgeschriebenen JUnit-Tests evaluiert.';
$string['crontask'] = 'Unittest Feedbacks bereinigen';
$string['responsefieldlines'] = 'Inputbox-Größe';
$string['responseformat'] = 'Antwortformat';
$string['testclassname'] = 'JUnit Testklasse';
$string['testclassname_help'] = 'Anhand der hier hochgeladenen JUnit-Test-Klasse wird der Code bewertet. Die Klasse muss korrekt sein und zu der Frage passen.';
$string['uploadtestclass'] = 'JUnit Testklasse';
$string['uploadtestclass_help'] = 'Bitte hier JUnit-Test-Klasse einfügen';
$string['givencode'] = 'Vorgegebener Code';
$string['givencode_help'] = 'Vorgebebener Code, der zu der gegebenen Antwort hinzugefügt wird.';
$string['loadedtestclassheader'] = 'Lade Test-Datei';

// feedback
$string['feedbacklevel'] = 'Feedback';
$string['feedback_nothing'] = 'Kein Feedback';
$string['feedback_only_times'] = 'Zeiten';
$string['feedback_times_count_of_tests'] = 'Zeiten und Anzahl Tests/Fehler';
$string['feedback_all_except_stacktrace'] = 'alles außer Stacktraces';
$string['CA'] = 'CORRECT ANSWER: Die Aufgabe wurde richtig gelöst.';
$string['PCA'] = 'PARTIALLY CORRECT ANSWER: Die Aufgabe wurde teilweise richtig gelöst.';
$string['WA'] = 'WRONG ANSWER: Die Aufgabe wurde nicht gelöst.';
$string['CE'] = 'COMPILER ERROR: Der eingegebene Code kompiliert nicht. Prüfe ihn bitte auf Fehler.';
$string['JE'] = 'JUNIT TEST FILE ERROR: Test kann nicht ausgeführt werden. Die eingegebene Antwort ist nicht mit der Testklasse kompatibel oder die Testklasse konnte nicht kompiliert werden.';
$string['TO'] = 'TIMEOUT: Die maximale Ausführungszeit wurde überschritten.';
$string['compiling'] = 'kompilieren... [{$a}s]';
$string['running'] = 'ausführen... [{$a}s]';
$string['ioexception'] = 'IOException aufgetreten.';
$string['filenotfoundexception'] = 'FileNotFoundException aufgetreten.';
$string['arrayindexoutofboundexception'] = 'ArrayIndexOutOfBoundException aufgetreten.';
$string['classcastexception'] = 'ClassCastException aufgetreten.';
$string['negativearraysizeexception'] = 'NegativeArraySizeException aufgetreten.';
$string['nullpointerexception'] = 'NullPointerException aufgetreten.';
$string['outofmemoryerror'] = 'OutOfMemoryError aufgetreten.';
$string['stackoverflowerror'] = 'StackOverflowError aufgetreten.';
$string['stringindexoutofboundexception'] = 'StringIndexOutOfBoundException aufgetreten.';
$string['bufferoverflowexception'] = 'BufferOverflowException aufgetreten.';
$string['bufferunderflowexception'] = 'BufferUnderflowError aufgetreten.';
$string['accesscontrolexception'] = 'AccessControlException aufgetreten.';

// settings
$string['limit_heading'] = 'Ressoursenlimits';
$string['memory_xmx'] = 'Speicherlimit (Heap) in MB';
$string['memory_xmx_desc'] = 'Dies setzt die Option -Xmx der Java VM (Limit für Speicherallokationen).';
$string['memory_limit_output'] = 'Speicherlimit (Ausgaben) in KB';
$string['memory_limit_output_desc'] = 'Beschränkt die Größe der Ausgaben während der Ausführung der Tests.';
$string['timeout_real'] = 'Zeitüberschreitung';
$string['timeout_real_desc'] = 'Timeout in Sekunden (Echtzeit) für die Ausführung der Tests.';
$string['remote_execution_heading'] = 'Ausführung auf anderem Server';
$string['remoteserver'] = 'URL zu externem Server';
$string['remoteserver_desc'] = 'URL zu einem anderen Server, auf dem die Tests kompiliert und ausgeführt werden sollen. Leer lassen, falls die Tests auf diesem Server ausgeführt werden sollen. Der andere Server kann die Einstellungen der Speicherlimits und der Zeitüberschreitung überschreiben.  (z.B. http://remoteserver/moodle_qtype_javaunittest/server.php)';
$string['remoteserver_user'] = 'Nutzername';
$string['remoteserver_password'] = 'Kennwort';
$string['local_execution_heading'] = 'Ausführung auf diesem Server';
$string['local_execution_desc'] = 'Wenn die Tests auf diesem Server kompiliert und ausgeführt werden sollen, müssen die folgenden Einstellungen gesetzt werden.';
$string['pathjavac'] = 'Pfad zu javac';
$string['pathjava'] = 'Pfad zu java';
$string['pathjunit'] = 'Pfad zu junit';
$string['pathhamcrest'] = 'Pfad zu hamcrest';
$string['pathpolicy'] = 'Pfad zur Policy-Datei für den Java Security Manager';
$string['precommand'] = 'Kommando vor Test-Ausführung';
$string['precommand_desc'] = 'Dieser Befehl wird auf der Shell vor den Tests ausgeführt. Dies kann genutzt werden, um z.B. mit ulimit die cpu time für die Tests zu begrenzen.';
$string['debug_heading'] = 'Debuginformationen';
$string['debug_heading_desc'] = 'Nur zum testen aktivieren! (nur für lokale Javaausführung)';
$string['debug_logfile'] = 'Speichere Compilerausgabe und JUNIT-Ausgabe im temporären Verzeichnis';
$string['debug_nocleanup'] = 'Temporäre Verzeichnisse und Dateien nicht löschen';
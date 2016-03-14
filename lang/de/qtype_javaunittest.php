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

// general
$string['pluginname'] = 'javaunittest';
$string['pluginname_help'] = 'JUnit question type';
$string['pluginname_link'] = 'question/type/javaunittest';
$string['pluginnameadding'] = 'Hinzufügen einer JUnit-Frage';
$string['pluginnameediting'] = 'Editieren einer JUnit-Frage';
$string['pluginnamesummary'] = 'Freitextantworten (Java-Code) werden von selbsgeschriebenen JUnit-Tests evaluiert.';
$string['crontask'] = 'Unittest Feedbacks bereinigen';

// label strings for question create / edit page
$string['responsefieldlines'] = 'Inputbox-Größe für alle Code-Textareas';
$string['nlines'] = '{$a} Zeilen';
$string['givencode'] = 'Vorgegebener Code';
$string['givencode_help'] = 'Vorgebebener Code, den der Student vervollständigen soll. Der Code wird in einer Textarea gezeigt und kann durch neustarten des Tests auf den vorgegebenen Code zurückgesetzt werden.<br>Es darf nur eine <tt>public</tt>-Klasse existieren, ansonsten dürfen beliebig viele Klassen untereinander stehen.';
$string['testclassname'] = 'JUnit Testklassenbezeichner';
$string['testclassname_help'] = 'Der Testklassenname muss dem im folgenden Programm gewählten Klassennamen entsprechen.';
$string['uploadtestclass'] = 'JUnit Testklasse';
$string['uploadtestclass_help'] = 'Die JUnit-Testklasse evaluiert den Studentencode.<br>Infos und Beispiele zu JUnit in der javaunittest-Dokumentation und auf <a href="http://junit.org/">http://junit.org</a>';

$string['feedbacklevelheader'] = 'Feedback';
$string['feedbacklevel_compilerheader'] = 'Compiler-Feedback';
$string['feedbacklevel_studentcompiler'] = 'Studentencode-Compilerfehler anzeigen';
$string['feedbacklevel_studentcompiler_help'] = 'Zeige die Compilerfehlerrückmeldung, wenn der Studenten-Code nicht kompiliert.';
$string['feedbacklevel_studentsignature'] = 'Signaturunterschiede anzeigen';
$string['feedbacklevel_studentsignature_help'] = 'Zeige die konkreten Signaturunterschiede an, wenn eine erwartete Signatur hinterlegt wurde und diese nicht mit der Signatur des Studentencodes übereinstimmt.';
$string['feedbacklevel_junitcompiler'] = 'JUnit-Testklassen-Compilierfehler anzeigen (Standardwert 0, siehe (?)-Button und Dokumentation!)';
$string['feedbacklevel_junitcompiler_help'] = "Zeige die Compilerfehlerrückmeldung, wenn der JUnit-Testklassen-Code nicht kompiliert.<br>Dies kann primär zwei Gründe haben:<br>- Der JUnit-Code ist fehlerhaft und muss vom Frageersteller korrigiert werden.<br>- Der JUnit-Code erwartet gewisse Schnittstellen zum Studenten-Code (z.B. nutzt direkt eine erwartete Methode im Studentencode), die jedoch nicht da sind. Hier gibt es verschiedene Möglichkeiten, dem zu begegnen:<br>&nbsp;&nbsp;&nbsp;&nbsp;a) Nur Reflections zum arbeiten mit dem Studentencode zu benutzen (umständlich; benötigt entsprechende Rechte in der Policy im Security Manager)<br>&nbsp;&nbsp;&nbsp;&nbsp;b) Die JUnit-Compilerfehlermeldung durch Aktivieren dieser Checkbox dem Feedback hinzuzufügen (Student muss dann diese interpretieren um den Fehler beheben zu können; als Nebeneffekt sieht er Ausschnitte der Testklasse)<br>&nbsp;&nbsp;&nbsp;&nbsp;c) Der Aufgabe in der optionalen Sektion Lösung die erwartete Signatur des Studentencodes hinzufügen. Zwischen dem Kompilieren des Studentencodes und des Testcodes wird geprüft, ob der Studentencode die richtige Struktur hat.";
$string['feedbacklevel_testnumheader'] = 'Testzusammenfassung';
$string['feedbacklevel_times'] = 'Benötigte Zeit anzeigen';
$string['feedbacklevel_times_help'] = 'Zeigt die insgesamt benötigte Zeit zum Kompilieren, Verifizieren und ausführen des JUnit-Tests an.';
$string['feedbacklevel_counttests'] = 'Anzahl Tests, Failures und Errors zeigen';
$string['feedbacklevel_counttests_help'] = 'Zeigt die Anzahl an Tests, Failures und Errors an, die JUnit zurückgibt.';
$string['feedbacklevel_junitheader'] = 'JUnit-Header anzeigen (Standardwert 0)';
$string['feedbacklevel_junitheader_help'] = 'Zeigt den JUnit-Header an. (Version und Tests, Failures, Errors an. Enthält nahezu die gleichen Informationen wie die vorherige Option)';
$string['feedbacklevel_assertheader'] = 'Assert-Methoden';
$string['feedbacklevel_assertstring'] = 'Assert-Strings im Fehlerfall anzeigen';
$string['feedbacklevel_assertstring_help'] = 'Zeigt im Assert-Fehlerfall den Assert-Feedback-String des JUnit-Codes an.<br>Beispiel: <tt>assertEquals("Methode MyMath.add() ist fehlerhaft", "2", Integer.toString(MyMath.add(1,1))</tt><br>Fügt dem Feedback hinzu: <i>Methode MyMath.add() ist fehlerhaft</i>';
$string['feedbacklevel_assertexpected'] = 'Assert-Erwartungswert anzeigen (Standardwert 0)';
$string['feedbacklevel_assertexpected_help'] = 'Zeigt im Assert-Fehlerfall zusätzlich zum Assert-String den Assert-Erwartungswert des JUnit-Codes an.<br>Beispiel: <tt>assertEquals("Methode MyMath.add() ist fehlerhaft", "2", Integer.toString(MyMath.add(1,1))</tt><br>Fügt dem Feedback hinzu: <i>Methode MyMath.add() ist fehlerhaft</i>, Erwartungswert <i>2</i><br>Kombinierbar mit Assert-Tatsächlicher-Wert anzeigen<br>Kann dazu führen, dass Studenten ihre Lösung einfach nur Testspezifisch implementieren.';
$string['feedbacklevel_assertactual'] = 'Assert-Tatsächlicher-Wert anzeigen (Standardwert 0)';
$string['feedbacklevel_assertactual_help'] = 'Zeigt im Assert-Fehlerfall zusätzlich zum Assert-String den Assert-Erwartungswert des JUnit-Codes an.<br>Beispiel: <tt>assertEquals("Methode MyMath.add() ist fehlerhaft", "2", Integer.toString(MyMath.add(1,1))</tt><br>Fügt dem Feedback hinzu: <i>Methode MyMath.add() ist fehlerhaft</i>, Tatsächlicher Wert <i>-17</i><br>Kombinierbar mit Assert-Erwartungswert anzeigen<br><br>Kann dazu führen, dass Studenten ihre Lösung einfach nur Testspezifisch implementieren.<br>Kann in Kombination mit entsprechenden Policy-Einstellungen zur Ausgabe von Systeminformationen über diese Variable führen.';
$string['feedbacklevel_completeheader'] = 'JUnit';
$string['feedbacklevel_junitcomplete'] = 'Komplette JUnit-Rückgabe anzeigen (Standardwert 0, siehe (?)-Button und Dokumentation!)';
$string['feedbacklevel_junitcomplete_help'] = 'Zeigt die komplette JUnit-Rückgabe an.<br>Nützlich zum debuggen, für den Normalbetrieb nicht empfohlen, da Studenten hier irrelevante sowie systemspefizische Informationen entnehmen können.';

$string['solutionheader'] = 'Musterlösung';
$string['solution'] = 'Musterlösung (optional)';
$string['solution_help'] = 'Hier kann eine Musterlösung für den vom Student erwarteten Code hinterlegt werden.<br>Die Musterlösung kann in der Quizvorschau per Button geladen werden, um selbige und die erstellte Testklasse gegeneinander manuell zu verifizieren.<br>Die Musterlösung bei entsprechender Wahl der Quizeinstellungen dem Studenten z.B. nach Beendigung des Tests angezeigt werden.';
$string['signature'] = 'Erwartete Signatur (optional)';
$string['signature_help'] = 'Hier kann die erwartete Signatur für den vom Student zu schreibenden Code hinterlegt werden.<br>Wenn der Studentencode kompiliert, wird anschließend das Kompilat mit dieser Signatur abgeglichen. Dabei muss die Signatur des Kompilats eine Obermenge der hier verlangten Signatur sein. Fehlen der Klasse/den Klassen Elemente, wird der Bewertungsvorgang beendet und 0 Punkte vergeben.<br>Nützlich, um zu vermeiden, dass der JUnit-Testcode nicht kompiliert, weil die Schnittstelle nicht übereinstimmt. (Z.B. Student hat Attributs- oder Methodenbezeichner oder -typen anders als in der Aufgabe vorgegeben gewählt, daher könnte der JUnit-Code nicht kompiliert werden.) Alternativ kann auf dem Studentencode mit Reflections gearbeitet werden oder das mögliche Nichtkompilieren der Testklasse in Kauf genommen werden.<br>Nutzt <tt>javap -p -constants Studentfile.class</tt>.<br>Reihenfolge der Klassen und Methoden egal.<br>Entfernt <b>nicht</b> zusätzliche Whitespaces, die Signatur muss im <tt>javap</tt>-Format sein.<br><br>Beispielsignatur:<tt><br>class Factorial {<br>&nbsp;&nbsp;&nbsp;&nbsp;public static double factorial(int);<br>}<br></tt><br>(Sie können die Musterlösung lokal kompilieren, <tt>javap -p -constants Studentfile.class</tt> ausführen, den Output übernehmen. (Es ist geplant, einen Button zu integrieren, der genau dies automatisch tut.))';

// evaluation strings, used to generate feedback text
$string['compiling'] = 'kompilieren... [{$a}s]';
$string['running'] = 'ausführen... [{$a}s]';

$string['missing_classes_headline'] = 'Fehlende Klassen:';
$string['missing_classes_text1'] = 'Die erwartete Klasse <tt>{$a}</tt>';
$string['missing_classes_text2'] = ' (<tt>{$a}</tt>) fehlt.';
$string['missing_members_headline'] = 'Fehlende Attribute:';
$string['missing_members_text1'] = 'In Klasse <tt>{$a}</tt>';
$string['missing_members_text2'] = ' fehlt das Attribut <tt>{$a}</tt>.';
$string['missing_methods_headline'] = 'Fehlende Methoden:';
$string['missing_methods_text1'] = 'In Klasse <tt>{$a}</tt>';
$string['missing_methods_text2'] = ' fehlt die Methode <tt>{$a}</tt>.';

$string['assertfailures_string'] = 'Fehlerbeschreibung:';
$string['assertfailures_expected'] = 'Erwartetes Ergebnis:';
$string['assertfailures_actual'] = 'Tatsächliches Ergebnis:';
$string['hiddenfails'] = 'Es sind {$a} weitere Tests fehlgeschlagen.'

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

$string['CA'] = 'CORRECT ANSWER: Die Aufgabe wurde richtig gelöst.';
$string['PCA'] = 'PARTIALLY CORRECT ANSWER: Die Aufgabe wurde teilweise richtig gelöst.';
$string['WA'] = 'WRONG ANSWER: Die Aufgabe wurde nicht gelöst.';
$string['CE'] = 'COMPILER ERROR: Der eingegebene Code kompiliert nicht. Prüfen Sie ihn auf Fehler.';
$string['SSM'] = 'SIGNATURE MISSMATCH: Test kann nicht ausgeführt werden. Der eingegebene Code erfüllt nicht die Erwartungen. Prüfen Sie noch einmal alle Attribute und Methoden sowie ihre Bezeichner und Datentypen.';
$string['JE'] = 'JUNIT TEST FILE ERROR: Test kann nicht ausgeführt werden. Die eingegebene Antwort ist nicht mit der Testklasse kompatibel oder die Testklasse konnte nicht kompiliert werden. (Ihr Code kompiliert, passt jedoch nicht zum automatischen Test. Dies liegt wahrscheinlich daran, dass Sie ein Attribut oder eine Methode nicht exakt so gewählt haben, wie die Aufgabenstellung es fordert. Vergleichen Sie noch einmal alle Bezeichner und Typen mit den in der Aufgabenstellung geforderten. Achten Sie dabei auch auf Groß- und Kleinschreibung!)';
$string['TO'] = 'TIMEOUT: Die maximale Ausführungszeit wurde überschritten.';
$string['RSE'] = 'REMOTE SERVER ERROR: Der Auswertungsserver ist nicht erreichbar oder funktioniert nicht.';

$string['solutionannounce'] = 'Musterlösung:';

// settings strings
$string['apperance_heading'] = 'Aussehen';
$string['editor'] = 'Codeeingabefelder';
$string['editor_desc'] = 'Legt das Aussehen der Codeeingabetextfelder fest.<br>CodeMirror: Benutzt den <a href="http://codemirror.net/">CodeMirror-Editor</a>, wenn Javascript aktiviert ist.<br>EnableTab Textarea: Benutzt eine normale Textarea, in der zusätzlich Einrücken per Tabulator möglich ist, wenn Javascript aktiviert ist.<br>Simple Textarea: Benutzt eine normale Textarea ohne weitere Features.';
$string['limit_heading'] = 'Ressoursenlimits';
$string['memory_xmx'] = 'Speicherlimit (Heap) in MB';
$string['memory_xmx_desc'] = 'Dies setzt die Option -Xmx der Java VM (Limit für Speicherallokationen).';
$string['memory_limit_output'] = 'Speicherlimit (Ausgaben) in KB';
$string['memory_limit_output_desc'] = 'Beschränkt die Größe der Ausgaben während der Ausführung der Tests.';
$string['timeout_real'] = 'Zeitüberschreitung';
$string['timeout_real_desc'] = 'Timeout in Sekunden (Echtzeit) für die Ausführung der Tests.';
$string['remote_execution_heading'] = 'Ausführung auf anderem Server';
$string['remoteserver'] = 'URL zu externem Server';
$string['remoteserver_desc'] = 'URL zu einem anderen Server, auf dem die Tests kompiliert und ausgeführt werden sollen. Leer lassen, falls die Tests auf diesem Server ausgeführt werden sollen. Der andere Server kann die Einstellungen der Speicherlimits und der Zeitüberschreitung überschreiben.  (z.B. http://127.0.0.1/moodle_qtype_javaunittest_remoteserver/server.php)';
$string['remoteserver_user'] = 'Nutzername';
$string['remoteserver_password'] = 'Kennwort';
$string['local_execution_heading'] = 'Ausführung auf diesem Server';
$string['local_execution_desc'] = 'Wenn die Tests auf diesem Server kompiliert und ausgeführt werden sollen, müssen die folgenden Einstellungen gesetzt werden.';
$string['pathjavac'] = 'Pfad zu javac';
$string['pathjavap'] = 'Pfad zu javap';
$string['pathjava'] = 'Pfad zu java';
$string['pathjunit'] = 'Pfad zur JUNIT jar';
$string['pathhamcrest'] = 'Pfad zur HAMCREST jar';
$string['pathpolicy'] = 'Pfad zur Policy-Datei für den Java Security Manager';
$string['precommand'] = 'Kommando vor Test-Ausführung';
$string['precommand_desc'] = 'Dieser Befehl wird auf der Shell vor den Tests ausgeführt. Dies kann genutzt werden, um z.B. mit ulimit die cpu time für die Tests zu begrenzen.';
$string['debug_heading'] = 'Debuginformationen';
$string['debug_heading_desc'] = 'Nur zum testen aktivieren! (nur für lokale Javaausführung)';
$string['debug_logfile'] = 'Speichere Compilerausgabe und JUNIT-Ausgabe im temporären Verzeichnis';
$string['debug_nocleanup'] = 'Temporäre Verzeichnisse und Dateien nicht löschen';
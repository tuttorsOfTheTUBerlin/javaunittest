<?php
/**
 * The attempt updater class for this question type.
 *
 * @package    qtype
 * @subpackage javaunittest
 * @author     Gergely Bertalan, bertalangeri@freemail.hu
 * @reference  sojunit 2008, Süreç Özcan, suerec@darkjade.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined ( 'MOODLE_INTERNAL' ) || die ();

/**
 * Class for converting attempt data for javaunittest questions when upgrading attempts to the new question engine. This
 * class is used by the code in question/engine/upgrade/upgradelib.php.
 *
 * @copyright 2010 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_javaunittest_qe2_attempt_updater extends question_qtype_attempt_updater {
    public function right_answer () {
        $myFile = "/home/gbertalan/javaunittestOUT.txt";
        $fh = fopen ( $myFile, 'a' ) or die ( "can't open file" );
        $stringData = "upgradelib: right_answer\n";
        fwrite ( $fh, $stringData );
        fclose ( $fh );
        
        return '';
    }
    public function response_summary ( $state ) {
        $myFile = "/home/gbertalan/javaunittestOUT.txt";
        $fh = fopen ( $myFile, 'a' ) or die ( "can't open file" );
        $stringData = "upgradelib: response_summary\n";
        fwrite ( $fh, $stringData );
        fclose ( $fh );
        
        if ( !empty ( $state->answer ) ) {
            return $this->to_text ( $state->answer );
        } else {
            return null;
        }
    }
    public function was_answered ( $state ) {
        $myFile = "/home/gbertalan/javaunittestOUT.txt";
        $fh = fopen ( $myFile, 'a' ) or die ( "can't open file" );
        $stringData = "upgradelib: was_answered\n";
        fwrite ( $fh, $stringData );
        fclose ( $fh );
        
        return !empty ( $state->answer );
    }
    public function set_first_step_data_elements ( $state, &$data ) {
        $myFile = "/home/gbertalan/javaunittestOUT.txt";
        $fh = fopen ( $myFile, 'a' ) or die ( "can't open file" );
        $stringData = "upgradelib: set_first_step_data_elements\n";
        fwrite ( $fh, $stringData );
        fclose ( $fh );
    }
    public function supply_missing_first_step_data ( &$data ) {
        $myFile = "/home/gbertalan/javaunittestOUT.txt";
        $fh = fopen ( $myFile, 'a' ) or die ( "can't open file" );
        $stringData = "upgradelib: supply_missing_first_step_data\n";
        fwrite ( $fh, $stringData );
        fclose ( $fh );
    }
    public function set_data_elements_for_step ( $state, &$data ) {
        $myFile = "/home/gbertalan/javaunittestOUT.txt";
        $fh = fopen ( $myFile, 'a' ) or die ( "can't open file" );
        $stringData = "upgradelib: set_data_elements_for_step\n";
        fwrite ( $fh, $stringData );
        fclose ( $fh );
        
        if ( !empty ( $state->answer ) ) {
            $data['answer'] = $state->answer;
        }
    }
}
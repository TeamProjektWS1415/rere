<?php

error_reporting(E_ALL);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NoteArrays
 *
 * @author Felix
 */
class NoteArrays {

    protected $marks = array(
        '1.0' => '1.0',
        '1.3' => '1.3',
        '1.7' => '1.7',
        '2.0' => '2.0',
        '2.3' => '2.3',
        '2.7' => '2.7',
        '3.0' => '3.0',
        '3.3' => '3.3',
        '3.7' => '3.7',
        '4.0' => '4.0',
        '5.0' => '5.0'
    );
    protected $schoolMarks = array(
        '1.0' => '1.0',
        '1.5' => '1.5',
        '2.0' => '2.0',
        '2.5' => '2.5',
        '3.0' => '3.0',
        '3.5' => '3.5',
        '4.0' => '4.0',
        '4.5' => '4.5',
        '5.0' => '5.0',
        '5.5' => '5.5',
        '6.0' => '6.0'
    );

    /**
     *
     * Mark array.
     *
     * @return array
     */
    public function getMarks() {
        return $this->marks;
    }

    /**
     * Schools Marks array.
     * @return array
     */
    public function getSchoolMarks() {
        return $this->schoolMarks;
    }

    /**
     * Array für unbenotete.
     * @return array
     */
    public function getUnbenotetMarks() {
        return array(
            'be' => 'be',
            'N' => 'N'
        );
    }

}

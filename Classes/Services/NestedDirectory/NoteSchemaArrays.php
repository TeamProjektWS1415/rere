<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Description of NoteArrays
 *
 * Speichert Die Verschiedenen NotenSysteme für die Notenauswahl bei der Notenvergabe.
 *
 * @author Felix
 */
class NoteSchemaArrays {

    const BITTE = "Bitte wählen";

    /**
     * Array für XYZ Notensystem.
     * @var type array
     */
    protected $marks = array(
        '' => self::BITTE,
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

    /**
     * Array für XYZ NotenSystem.
     * @var type
     */
    protected $schoolMarks = array(
        '' => self::BITTE,
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
     * Array für Unbenotete Leistungen.
     * @var type
     */
    protected $unbenotetMarks = array(
        '' => self::BITTE,
        'be' => 'be',
        'N' => 'N'
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
        return $this->unbenotetMarks;
    }

}

<?php

namespace ReRe\Rere\Tests\Unit\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
 *           Sarah Kieninger <sarah.kieninger@gmail.com>, TeamProjektWS14/15
 *           Tim Wacker, TeamProjektWS14/15
 *           Nejat Balta, TeamProjektWS14/15
 *           Tobias Brockner, TeamProjektWS14/15
 *           Nicolas Tedjadharma, TeamProjektWS14/15
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Test case for class \ReRe\Rere\Domain\Model\Fach.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Felix Hohlwegler <info@felix-hohlwegler.de>
 * @author Sarah Kieninger <sarah.kieninger@gmail.com>
 * @author Tim Wacker
 * @author Nejat Balta
 * @author Tobias Brockner
 * @author Nicolas Tedjadharma
 */
class FachTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    const TEXT = 'Conceived at T3CON10';
    const MATRIKELNR = 'matrikelnr';
    const NOTE = 'note';
    const OBJECTSTORAGE = 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage';
    const DETACH = 'detach';
    const ATTACH = 'attach';

    /**
     * @var \ReRe\Rere\Domain\Model\Fach
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = new \ReRe\Rere\Domain\Model\Fach();
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getFachnrReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getFachnr()
        );
    }

    /**
     * @test
     */
    public function setFachnrForStringSetsFachnr() {
        $this->subject->setFachnr(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'fachnr', $this->subject
        );
    }

    /**
     * @test
     */
    public function getFachnameReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getFachname()
        );
    }

    /**
     * @test
     */
    public function setFachnameForStringSetsFachname() {
        $this->subject->setFachname(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'fachname', $this->subject
        );
    }

    /**
     * @test
     */
    public function getPrueferReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getPruefer()
        );
    }

    /**
     * @test
     */
    public function setPrueferForStringSetsPruefer() {
        $this->subject->setPruefer(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'pruefer', $this->subject
        );
    }

    /**
     * @test
     */
    public function getNotenschemaReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getNotenschema()
        );
    }

    /**
     * @test
     */
    public function setNotenschemaForStringSetsNotenschema() {
        $this->subject->setNotenschema(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'notenschema', $this->subject
        );
    }

    /**
     * @test
     */
    public function getModulnrReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getModulnr()
        );
    }

    /**
     * @test
     */
    public function setModulnrForStringSetsModulnr() {
        $this->subject->setModulnr(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'modulnr', $this->subject
        );
    }

    /**
     * @test
     */
    public function getMatrikelnrReturnsInitialValueForPruefling() {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
                $newObjectStorage, $this->subject->getMatrikelnr()
        );
    }

    /**
     * @test
     */
    public function setMatrikelnrForObjectStorageContainingPrueflingSetsMatrikelnr() {
        $matrikelnr = new \ReRe\Rere\Domain\Model\Pruefling();
        $objectStorageHoldingExactlyOneMatrikelnr = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneMatrikelnr->attach($matrikelnr);
        $this->subject->setMatrikelnr($objectStorageHoldingExactlyOneMatrikelnr);

        $this->assertAttributeEquals(
                $objectStorageHoldingExactlyOneMatrikelnr, self::MATRIKELNR, $this->subject
        );
    }

    /**
     * @test
     */
    public function addMatrikelnrToObjectStorageHoldingMatrikelnr() {
        $matrikelnr = new \ReRe\Rere\Domain\Model\Pruefling();
        $matrikelnrObjectStorageMock = $this->getMock(self::OBJECTSTORAGE, array(self::ATTACH), array(), '', FALSE);
        $matrikelnrObjectStorageMock->expects($this->once())->method(self::ATTACH)->with($this->equalTo($matrikelnr));
        $this->inject($this->subject, self::MATRIKELNR, $matrikelnrObjectStorageMock);

        $this->subject->addMatrikelnr($matrikelnr);
    }

    /**
     * @test
     */
    public function removeMatrikelnrFromObjectStorageHoldingMatrikelnr() {
        $matrikelnr = new \ReRe\Rere\Domain\Model\Pruefling();
        $matrikelnrObjectStorageMock = $this->getMock(self::OBJECTSTORAGE, array(self::DETACH), array(), '', FALSE);
        $matrikelnrObjectStorageMock->expects($this->once())->method(self::DETACH)->with($this->equalTo($matrikelnr));
        $this->inject($this->subject, self::MATRIKELNR, $matrikelnrObjectStorageMock);

        $this->subject->removeMatrikelnr($matrikelnr);
    }

    /**
     * @test
     */
    public function getNoteReturnsInitialValueForNote() {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
                $newObjectStorage, $this->subject->getNote()
        );
    }

    /**
     * @test
     */
    public function setNoteForObjectStorageContainingNoteSetsNote() {
        $note = new \ReRe\Rere\Domain\Model\Note();
        $objectStorageHoldingExactlyOneNote = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneNote->attach($note);
        $this->subject->setNote($objectStorageHoldingExactlyOneNote);

        $this->assertAttributeEquals(
                $objectStorageHoldingExactlyOneNote, self::NOTE, $this->subject
        );
    }

    /**
     * @test
     */
    public function addNoteToObjectStorageHoldingNote() {
        $note = new \ReRe\Rere\Domain\Model\Note();
        $noteObjectStorageMock = $this->getMock(self::OBJECTSTORAGE, array(self::ATTACH), array(), '', FALSE);
        $noteObjectStorageMock->expects($this->once())->method(self::ATTACH)->with($this->equalTo($note));
        $this->inject($this->subject, self::NOTE, $noteObjectStorageMock);

        $this->subject->addNote($note);
    }

    /**
     * @test
     */
    public function removeNoteFromObjectStorageHoldingNote() {
        $note = new \ReRe\Rere\Domain\Model\Note();
        $noteObjectStorageMock = $this->getMock(self::OBJECTSTORAGE, array(self::DETACH), array(), '', FALSE);
        $noteObjectStorageMock->expects($this->once())->method(self::DETACH)->with($this->equalTo($note));
        $this->inject($this->subject, self::NOTE, $noteObjectStorageMock);

        $this->subject->removeNote($note);
    }

}

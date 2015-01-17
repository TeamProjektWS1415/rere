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
 * Test case for class \ReRe\Rere\Domain\Model\Pruefling.
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
class PrueflingTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    const TEXT = 'Conceived at T3CON10';
    const OBJECTSTORAGE = 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage';

    /**
     * @var \ReRe\Rere\Domain\Model\Pruefling
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = new \ReRe\Rere\Domain\Model\Pruefling();
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getMatrikelnrReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getMatrikelnr()
        );
    }

    /**
     * @test
     */
    public function setMatrikelnrForStringSetsMatrikelnr() {
        $this->subject->setMatrikelnr(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'matrikelnr', $this->subject
        );
    }

    /**
     * @test
     */
    public function getVornameReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getVorname()
        );
    }

    /**
     * @test
     */
    public function setVornameForStringSetsVorname() {
        $this->subject->setVorname(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'vorname', $this->subject
        );
    }

    /**
     * @test
     */
    public function getNachnameReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getNachname()
        );
    }

    /**
     * @test
     */
    public function setNachnameForStringSetsNachname() {
        $this->subject->setNachname(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'nachname', $this->subject
        );
    }

    /**
     * @test
     */
    public function getTypo3FEUserReturnsInitialValueForFrontendUser() {

    }

    /**
     * @test
     */
    public function setTypo3FEUserForFrontendUserSetsTypo3FEUser() {

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
                $objectStorageHoldingExactlyOneNote, 'note', $this->subject
        );
    }

    /**
     * @test
     */
    public function addNoteToObjectStorageHoldingNote() {
        $note = new \ReRe\Rere\Domain\Model\Note();
        $noteObjectStorageMock = $this->getMock(self::OBJECTSTORAGE, array('attach'), array(), '', FALSE);
        $noteObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($note));
        $this->inject($this->subject, 'note', $noteObjectStorageMock);

        $this->subject->addNote($note);
    }

    /**
     * @test
     */
    public function removeNoteFromObjectStorageHoldingNote() {
        $note = new \ReRe\Rere\Domain\Model\Note();
        $noteObjectStorageMock = $this->getMock(self::OBJECTSTORAGE, array('detach'), array(), '', FALSE);
        $noteObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($note));
        $this->inject($this->subject, 'note', $noteObjectStorageMock);

        $this->subject->removeNote($note);
    }

}

<?php

namespace ReRe\Rere\Tests\Unit\Domain\Model;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014
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
 * Test case for class \ReRe\Rere\Domain\Model\Note.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class NoteTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \ReRe\Rere\Domain\Model\Note
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = new \ReRe\Rere\Domain\Model\Note();
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getWertReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getWert()
        );
    }

    /**
     * @test
     */
    public function setWertForStringSetsWert() {
        $this->subject->setWert('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'wert', $this->subject
        );
    }

    /**
     * @test
     */
    public function getKommentarReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getKommentar()
        );
    }

    /**
     * @test
     */
    public function setKommentarForStringSetsKommentar() {
        $this->subject->setKommentar('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'kommentar', $this->subject
        );
    }

    /**
     * @test
     */
    public function getFachnrReturnsInitialValueForFach() {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
                $newObjectStorage, $this->subject->getFachnr()
        );
    }

    /**
     * @test
     */
    public function setFachnrForObjectStorageContainingFachSetsFachnr() {
        $fachnr = new \ReRe\Rere\Domain\Model\Fach();
        $objectStorageHoldingExactlyOneFachnr = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFachnr->attach($fachnr);
        $this->subject->setFachnr($objectStorageHoldingExactlyOneFachnr);

        $this->assertAttributeEquals(
                $objectStorageHoldingExactlyOneFachnr, 'fachnr', $this->subject
        );
    }

    /**
     * @test
     */
    public function addFachnrToObjectStorageHoldingFachnr() {
        $fachnr = new \ReRe\Rere\Domain\Model\Fach();
        $fachnrObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
        $fachnrObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($fachnr));
        $this->inject($this->subject, 'fachnr', $fachnrObjectStorageMock);

        $this->subject->addFachnr($fachnr);
    }

    /**
     * @test
     */
    public function removeFachnrFromObjectStorageHoldingFachnr() {
        $fachnr = new \ReRe\Rere\Domain\Model\Fach();
        $fachnrObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
        $fachnrObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($fachnr));
        $this->inject($this->subject, 'fachnr', $fachnrObjectStorageMock);

        $this->subject->removeFachnr($fachnr);
    }

    /**
     * @test
     */
    public function getMatrikelnrReturnsInitialValueForPruefling() {
        $this->assertEquals(
                NULL, $this->subject->getMatrikelnr()
        );
    }

    /**
     * @test
     */
    public function setMatrikelnrForPrueflingSetsMatrikelnr() {
        $matrikelnrFixture = new \ReRe\Rere\Domain\Model\Pruefling();
        $this->subject->setMatrikelnr($matrikelnrFixture);

        $this->assertAttributeEquals(
                $matrikelnrFixture, 'matrikelnr', $this->subject
        );
    }

}

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
 * Test case for class \ReRe\Rere\Domain\Model\Modul.
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
class ModulTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \ReRe\Rere\Domain\Model\Modul
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = new \ReRe\Rere\Domain\Model\Modul();
    }

    protected function tearDown() {
        unset($this->subject);
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
        $this->subject->setModulnr('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'modulnr', $this->subject
        );
    }

    /**
     * @test
     */
    public function getModulnameReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getModulname()
        );
    }

    /**
     * @test
     */
    public function setModulnameForStringSetsModulname() {
        $this->subject->setModulname('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'modulname', $this->subject
        );
    }

    /**
     * @test
     */
    public function getGueltigkeitszeitraumReturnsInitialValueForString() {
        $this->assertSame(
                NULL, $this->subject->getGueltigkeitszeitraum()
        );
    }

    /**
     * @test
     */
    public function setGueltigkeitszeitraumForStringSetsGueltigkeitszeitraum() {
        $this->subject->setGueltigkeitszeitraum('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'gueltigkeitszeitraum', $this->subject
        );
    }

    /**
     * @test
     */
    public function getFachReturnsInitialValueForFach() {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
                $newObjectStorage, $this->subject->getFach()
        );
    }

    /**
     * @test
     */
    public function setFachForObjectStorageContainingFachSetsFach() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();
        $objectStorageHoldingExactlyOneFach = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFach->attach($fach);
        $this->subject->setFach($objectStorageHoldingExactlyOneFach);

        $this->assertAttributeEquals(
                $objectStorageHoldingExactlyOneFach, 'fach', $this->subject
        );
    }

    /**
     * @test
     */
    public function addFachToObjectStorageHoldingFach() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();
        $fachObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
        $fachObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($fach));
        $this->inject($this->subject, 'fach', $fachObjectStorageMock);

        $this->subject->addFach($fach);
    }

    /**
     * @test
     */
    public function removeFachFromObjectStorageHoldingFach() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();
        $fachObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
        $fachObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($fach));
        $this->inject($this->subject, 'fach', $fachObjectStorageMock);

        $this->subject->removeFach($fach);
    }

}

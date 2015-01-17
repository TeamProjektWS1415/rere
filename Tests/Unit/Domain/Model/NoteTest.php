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
 * Test case for class \ReRe\Rere\Domain\Model\Note.
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
class NoteTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    const TEXT = 'Conceived at T3CON10';

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
        $this->subject->setWert(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'wert', $this->subject
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
        $this->subject->setKommentar(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'kommentar', $this->subject
        );
    }

    /**
     * @test
     */
    public function getFachReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getFach()
        );
    }

    /**
     * @test
     */
    public function setFachForStringSetsFach() {
        $this->subject->setFach(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'fach', $this->subject
        );
    }

    /**
     * @test
     */
    public function getPrueflingReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getPruefling()
        );
    }

    /**
     * @test
     */
    public function setPrueflingForStringSetsPruefling() {
        $this->subject->setPruefling(self::TEXT);

        $this->assertAttributeEquals(
                self::TEXT, 'pruefling', $this->subject
        );
    }

}

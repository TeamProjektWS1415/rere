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
 * Test case for class \ReRe\Rere\Domain\Model\Pruefling.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PrueflingTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

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
        $this->subject->setMatrikelnr('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'matrikelnr', $this->subject
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
        $this->subject->setVorname('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'vorname', $this->subject
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
        $this->subject->setNachname('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'nachname', $this->subject
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

}

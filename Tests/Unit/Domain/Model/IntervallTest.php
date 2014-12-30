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
 * Test case for class \ReRe\Rere\Domain\Model\Intervall.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IntervallTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \ReRe\Rere\Domain\Model\Interval
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = new \ReRe\Rere\Domain\Model\Intervall();
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getTypeReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getType()
        );
    }

    /**
     * @test
     */
    public function setTypeForStringSetsType() {
        $this->subject->setType('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'type', $this->subject
        );
    }

    /**
     * @test
     */
    public function getAktuellReturnsInitialValueForString() {
        $this->assertSame(
                '', $this->subject->getAktuell()
        );
    }

    /**
     * @test
     */
    public function setAktuellForStringSetsAktuell() {
        $this->subject->setAktuell('Conceived at T3CON10');

        $this->assertAttributeEquals(
                'Conceived at T3CON10', 'aktuell', $this->subject
        );
    }

}

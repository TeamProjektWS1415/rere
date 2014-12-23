<?php

namespace Rere\Rere\Tests\Unit\Domain\Model;

/***************************************************************
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
 ***************************************************************/

/**
 * Test case for class \Rere\Rere\Domain\Model\Fach.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FachTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Rere\Rere\Domain\Model\Fach
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Rere\Rere\Domain\Model\Fach();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getFachnrReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getFachnr()
		);
	}

	/**
	 * @test
	 */
	public function setFachnrForStringSetsFachnr() {
		$this->subject->setFachnr('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'fachnr',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getFachnameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getFachname()
		);
	}

	/**
	 * @test
	 */
	public function setFachnameForStringSetsFachname() {
		$this->subject->setFachname('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'fachname',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPrueferReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPruefer()
		);
	}

	/**
	 * @test
	 */
	public function setPrueferForStringSetsPruefer() {
		$this->subject->setPruefer('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'pruefer',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNotenschemaReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getNotenschema()
		);
	}

	/**
	 * @test
	 */
	public function setNotenschemaForStringSetsNotenschema() {
		$this->subject->setNotenschema('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'notenschema',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getModulnrReturnsInitialValueForModul() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getModulnr()
		);
	}

	/**
	 * @test
	 */
	public function setModulnrForObjectStorageContainingModulSetsModulnr() {
		$modulnr = new \Rere\Rere\Domain\Model\Modul();
		$objectStorageHoldingExactlyOneModulnr = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneModulnr->attach($modulnr);
		$this->subject->setModulnr($objectStorageHoldingExactlyOneModulnr);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneModulnr,
			'modulnr',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addModulnrToObjectStorageHoldingModulnr() {
		$modulnr = new \Rere\Rere\Domain\Model\Modul();
		$modulnrObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$modulnrObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($modulnr));
		$this->inject($this->subject, 'modulnr', $modulnrObjectStorageMock);

		$this->subject->addModulnr($modulnr);
	}

	/**
	 * @test
	 */
	public function removeModulnrFromObjectStorageHoldingModulnr() {
		$modulnr = new \Rere\Rere\Domain\Model\Modul();
		$modulnrObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$modulnrObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($modulnr));
		$this->inject($this->subject, 'modulnr', $modulnrObjectStorageMock);

		$this->subject->removeModulnr($modulnr);

	}

	/**
	 * @test
	 */
	public function getMatrikelnrReturnsInitialValueForPruefling() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getMatrikelnr()
		);
	}

	/**
	 * @test
	 */
	public function setMatrikelnrForObjectStorageContainingPrueflingSetsMatrikelnr() {
		$matrikelnr = new \Rere\Rere\Domain\Model\Pruefling();
		$objectStorageHoldingExactlyOneMatrikelnr = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneMatrikelnr->attach($matrikelnr);
		$this->subject->setMatrikelnr($objectStorageHoldingExactlyOneMatrikelnr);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneMatrikelnr,
			'matrikelnr',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addMatrikelnrToObjectStorageHoldingMatrikelnr() {
		$matrikelnr = new \Rere\Rere\Domain\Model\Pruefling();
		$matrikelnrObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$matrikelnrObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($matrikelnr));
		$this->inject($this->subject, 'matrikelnr', $matrikelnrObjectStorageMock);

		$this->subject->addMatrikelnr($matrikelnr);
	}

	/**
	 * @test
	 */
	public function removeMatrikelnrFromObjectStorageHoldingMatrikelnr() {
		$matrikelnr = new \Rere\Rere\Domain\Model\Pruefling();
		$matrikelnrObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$matrikelnrObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($matrikelnr));
		$this->inject($this->subject, 'matrikelnr', $matrikelnrObjectStorageMock);

		$this->subject->removeMatrikelnr($matrikelnr);

	}
}

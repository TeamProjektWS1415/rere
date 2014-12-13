<?php
namespace ReRe\Rere\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
 *  			Sarah Kieninger <sarah.kieninger@gmail.com>, TeamProjektWS14/15
 *  			Tim Wacker , TeamProjektWS14/15
 *  			Nejat Balta , TeamProjektWS14/15
 *  			Tobias Brockner , TeamProjektWS14/15
 *  			Nicolas Tedjadharma , TeamProjektWS14/15
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
 * Test case for class ReRe\Rere\Controller\FachController.
 *
 * @author Felix Hohlwegler <info@felix-hohlwegler.de>
 * @author Sarah Kieninger <sarah.kieninger@gmail.com>
 * @author Tim Wacker 
 * @author Nejat Balta 
 * @author Tobias Brockner 
 * @author Nicolas Tedjadharma 
 */
class FachControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \ReRe\Rere\Controller\FachController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('ReRe\\Rere\\Controller\\FachController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllFachesFromRepositoryAndAssignsThemToView() {

		$allFaches = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$fachRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\FachRepository', array('findAll'), array(), '', FALSE);
		$fachRepository->expects($this->once())->method('findAll')->will($this->returnValue($allFaches));
		$this->inject($this->subject, 'fachRepository', $fachRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('faches', $allFaches);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenFachToView() {
		$fach = new \ReRe\Rere\Domain\Model\Fach();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('fach', $fach);

		$this->subject->showAction($fach);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenFachToView() {
		$fach = new \ReRe\Rere\Domain\Model\Fach();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newFach', $fach);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($fach);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenFachToFachRepository() {
		$fach = new \ReRe\Rere\Domain\Model\Fach();

		$fachRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\FachRepository', array('add'), array(), '', FALSE);
		$fachRepository->expects($this->once())->method('add')->with($fach);
		$this->inject($this->subject, 'fachRepository', $fachRepository);

		$this->subject->createAction($fach);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenFachToView() {
		$fach = new \ReRe\Rere\Domain\Model\Fach();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('fach', $fach);

		$this->subject->editAction($fach);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenFachInFachRepository() {
		$fach = new \ReRe\Rere\Domain\Model\Fach();

		$fachRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\FachRepository', array('update'), array(), '', FALSE);
		$fachRepository->expects($this->once())->method('update')->with($fach);
		$this->inject($this->subject, 'fachRepository', $fachRepository);

		$this->subject->updateAction($fach);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenFachFromFachRepository() {
		$fach = new \ReRe\Rere\Domain\Model\Fach();

		$fachRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\FachRepository', array('remove'), array(), '', FALSE);
		$fachRepository->expects($this->once())->method('remove')->with($fach);
		$this->inject($this->subject, 'fachRepository', $fachRepository);

		$this->subject->deleteAction($fach);
	}
}

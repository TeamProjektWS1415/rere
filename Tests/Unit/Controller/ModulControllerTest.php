<?php

namespace ReRe\Rere\Tests\Unit\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014
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
 * Test case for class ReRe\Rere\Controller\ModulController.
 *
 */
class ModulControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \ReRe\Rere\Controller\ModulController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock('ReRe\\Rere\\Controller\\ModulController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllModulsFromRepositoryAndAssignsThemToView() {

        $allModuls = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

        $modulRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\ModulRepository', array('findAll'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('findAll')->will($this->returnValue($allModuls));
        $this->inject($this->subject, 'modulRepository', $modulRepository);

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $view->expects($this->once())->method('assign')->with('moduls', $allModuls);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenModulToView() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method('assign')->with('modul', $modul);

        $this->subject->showAction($modul);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenModulToView() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $view->expects($this->once())->method('assign')->with('newModul', $modul);
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($modul);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenModulToModulRepository() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $modulRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\ModulRepository', array('add'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('add')->with($modul);
        $this->inject($this->subject, 'modulRepository', $modulRepository);

        $this->subject->createAction($modul);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenModulToView() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method('assign')->with('modul', $modul);

        $this->subject->editAction($modul);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenModulInModulRepository() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $modulRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\ModulRepository', array('update'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('update')->with($modul);
        $this->inject($this->subject, 'modulRepository', $modulRepository);

        $this->subject->updateAction($modul);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenModulFromModulRepository() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $modulRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\ModulRepository', array('remove'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('remove')->with($modul);
        $this->inject($this->subject, 'modulRepository', $modulRepository);

        $this->subject->deleteAction($modul);
    }

}

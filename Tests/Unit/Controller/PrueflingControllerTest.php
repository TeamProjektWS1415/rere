<?php

namespace ReRe\Rere\Tests\Unit\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
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
 * ************************************************************* */

/**
 * Test case for class ReRe\Rere\Controller\PrueflingController.
 *
 * @author Felix Hohlwegler <info@felix-hohlwegler.de>
 * @author Sarah Kieninger <sarah.kieninger@gmail.com>
 * @author Tim Wacker
 * @author Nejat Balta
 * @author Tobias Brockner
 * @author Nicolas Tedjadharma
 */
class PrueflingControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    const VIEWINTERFACE = 'TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface';
    const ASSIGN = "assign";
    const PRUEFLINGSREPOSITORY = 'ReRe\\Rere\\Domain\\Repository\\PrueflingRepository';
    const PRUEFLINGSREPO = 'prueflingRepository';

    /**
     * @var \ReRe\Rere\Controller\PrueflingController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock('ReRe\\Rere\\Controller\\PrueflingController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllPrueflingsFromRepositoryAndAssignsThemToView() {

        $allPrueflings = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
        $allFeUserGroups = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
        $modul = NULL;
        $fach = NULL;
        
        $fachRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\FachRepository',array('findByUid'), array(), '', FALSE);
        $fachRepository->expects($this->once())->method('findByUid')->will($this->returnValue($fach));
        $this->inject($this->subject, 'fachRepository', $fachRepository);
        
        $modulRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\ModulRepository',array('findByUid'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('findByUid')->will($this->returnValue($modul));
        $this->inject($this->subject, 'modulRepository', $modulRepository);
        
        $prueflingRepository = $this->getMock(self::PRUEFLINGSREPOSITORY, array('findAll'), array(), '', FALSE);
        $prueflingRepository->expects($this->once())->method('findAll')->will($this->returnValue($allPrueflings));
        $this->inject($this->subject, self::PRUEFLINGSREPO, $prueflingRepository);
        
        $FrontendUserGroupRepository = $this->getMock(self::PRUEFLINGSREPOSITORY, array('findAll'), array(), '', FALSE);
        $FrontendUserGroupRepository->expects($this->once())->method('findAll')->will($this->returnValue($allFeUserGroups));
        $this->inject($this->subject, 'FrontendUserGroupRepository', $FrontendUserGroupRepository);

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method('assignMultiple')->with('prueflings', $allPrueflings);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPrueflingToView() {
        $pruefling = new \ReRe\Rere\Domain\Model\Pruefling();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('pruefling', $pruefling);

        $this->subject->showAction($pruefling);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenPrueflingToView() {
        $pruefling = new \ReRe\Rere\Domain\Model\Pruefling();
        $allFeUserGroups = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
        
        $FrontendUserGroupRepository = $this->getMock(self::PRUEFLINGSREPOSITORY, array('findAll'), array(), '', FALSE);
        $FrontendUserGroupRepository->expects($this->once())->method('findAll')->will($this->returnValue($allFeUserGroups));
        $this->inject($this->subject, 'FrontendUserGroupRepository', $FrontendUserGroupRepository);
        
        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method('assignMultiple')->with('newPruefling', $pruefling);
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($pruefling);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenPrueflingToPrueflingRepository() {
        $pruefling = new \ReRe\Rere\Domain\Model\Pruefling();

        $prueflingRepository = $this->getMock(self::PRUEFLINGSREPOSITORY, array('add'), array(), '', FALSE);
        $prueflingRepository->expects($this->once())->method('add')->with($pruefling);
        $this->inject($this->subject, self::PRUEFLINGSREPO, $prueflingRepository);

        $this->subject->createAction($pruefling);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenPrueflingToView() {
        $pruefling = new \ReRe\Rere\Domain\Model\Pruefling();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('pruefling', $pruefling);

        $this->subject->editAction($pruefling);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenPrueflingInPrueflingRepository() {
        $pruefling = new \ReRe\Rere\Domain\Model\Pruefling();

        $prueflingRepository = $this->getMock(self::PRUEFLINGSREPOSITORY, array('update'), array(), '', FALSE);
        $prueflingRepository->expects($this->once())->method('update')->with($pruefling);
        $this->inject($this->subject, self::PRUEFLINGSREPO, $prueflingRepository);

        $this->subject->updateAction($pruefling);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenPrueflingFromPrueflingRepository() {
        $pruefling = new \ReRe\Rere\Domain\Model\Pruefling();

        $prueflingRepository = $this->getMock(self::PRUEFLINGSREPOSITORY, array('remove'), array(), '', FALSE);
        $prueflingRepository->expects($this->once())->method('remove')->with($pruefling);
        $this->inject($this->subject, self::PRUEFLINGSREPO, $prueflingRepository);

        $this->subject->deleteAction($pruefling);
    }

}

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
 * Test case for class ReRe\Rere\Controller\ModulController.
 *
 * @author Felix Hohlwegler <info@felix-hohlwegler.de>
 * @author Sarah Kieninger <sarah.kieninger@gmail.com>
 * @author Tim Wacker
 * @author Nejat Balta
 * @author Tobias Brockner
 * @author Nicolas Tedjadharma
 */
class ModulControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    const OBJECTMANAGER = 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager';
    const MODULCONTROLLER = 'ReRe\\Rere\\Controller\\ModulController';
    const MODULREPOSITORY = 'ReRe\\Rere\\Domain\\Repository\\ModulRepository';
    const INTERVALLREPOSITORY = 'ReRe\\Rere\\Domain\\Repository\\IntervallRepository';
    const SETTINGSREPOSITORY = 'ReRe\\Rere\\Domain\\Repository\\SettingsRepository';
    const MODULREPO = 'modulRepository';
    const INTERVALLREPO = 'intervallRepository';
    const SETTINGSREPO = 'settingsRepository';
    const VIEWINTERFACE = 'TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface';
    const ASSIGN = "assign";
    const ASSIGNMULTIPLE = "assignmultiple";
    const MODULNAME = "modulname";
    const MODULNUMMER = "modulnummer";
    const GUELTIGKEITSZEITRAUM = "gueltigkeitszeitraum";
    const FACHNAME = "fachname";
    const FACHNUMMER = "fachnummer";
    const PRUEFER = "pruefer";
    const DATUM = "datum";
    const REQUEST = "TYPO3\\CMS\\Extbase\\Mvc\\Request";

    /**
     * @var \ReRe\Rere\Controller\ModulController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock(self::MODULCONTROLLER, array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllModulsFromRepositoryAndAssignsThemToView() {

        $allModuls = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
        $modulRepository = $this->getMock(self::MODULREPOSITORY, array('findAll'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('findAll')->will($this->returnValue($allModuls));
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $mail = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Settings', array(), array(), '', FALSE);
        $mail->expects($this->once())->method('setMailAbsender')->with("DEFAULT");

        $settingsRepository = $this->getMock(self::SETTINGSREPOSITORY, array('add'), array(), '', FALSE);
        $settingsRepository->expects($this->once())->method('add')->will($this->returnValue($mail));
        $this->inject($this->subject, self::SETTINGSREPO, $settingsRepository);

        $createdIntervall = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Intervall', array(), array(), '', FALSE);
        $createdIntervall->expects($this->at(0))->method('setAktuell')->with('WS14/15');
        $createdIntervall->expects($this->at(1))->method('setType')->with('studienhalbjahr');

        $intervallRepository = $this->getMock(self::INTERVALLREPOSITORY, array('add'), array(), '', FALSE);
        $intervallRepository->expects($this->once())->method('add')->will($this->returnValue($createdIntervall));
        $this->inject($this->subject, self::INTERVALLREPO, $intervallRepository);
        $this->subject->expects($this->once())->method('redirect')->with('list');

        $aktuellesIntervall = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Intervall', array(), array(), '', FALSE);
        $aktuellesIntervall->expects($this->once())->method('getAktuell');
        $intervallType = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Intervall', array(), array(), '', FALSE);
        $intervallType->expects($this->once())->method('getType');

        $objectManager = $this->getMock(SELF::OBJECTMANAGER, array(), array(), '', FALSE);
        $objectManager->expects($this->once())->method('create')->will($this->returnValue($mail));
        $objectManager->expects($this->once())->method('create')->will($this->returnValue($createdIntervall));
        $this->inject($this->subject, 'objectManager', $objectManager);

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method(self::ASSIGNMULTIPLE)->with(array(
            'intervallType' => $intervallType,
            'aktuellintervall' => $aktuellesIntervall,
            'moduls' => $allModuls
        ));
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenModulToView() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('modul', $modul);

        $this->subject->showAction($modul);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenModulToView() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();
        $modulname = NULL;
        $modulnummer = NULL;
        $gueltigkeitszeitraum = NULL;
        $fachname = NULL;
        $fachnummer = NULL;
        $pruefer = NULL;
        $datum = NULL;
        $newModul = NULL;

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);
        $request->expects($this->once())->method('hasArgument')->will($this->returnValue($this->subject));

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method('assignMultiple')->with(array(
            self::MODULNAME => $modulname,
            self::MODULNUMMER => $modulnummer,
            self::GUELTIGKEITSZEITRAUM => $gueltigkeitszeitraum,
            self::FACHNAME => $fachname,
            self::FACHNUMMER => $fachnummer,
            self::PRUEFER => $pruefer,
            self::DATUM => $datum
        ));

        $this->inject($this->subject, 'request', $request);
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($modul);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenModulToModulRepository() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array('add'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('add')->with($modul);
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $this->subject->createAction($modul);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenModulToView() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('modul', $modul);

        $this->subject->editAction($modul);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenModulInModulRepository() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array('update'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('update')->with($modul);
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $this->subject->updateAction($modul);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenModulFromModulRepository() {
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array('remove'), array(), '', FALSE);
        $modulRepository->expects($this->once())->method('remove')->with($modul);
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $this->subject->deleteAction($modul);
    }

}

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

    const FACHCONTROLLER = "ReRe\\Rere\\Controller\\FachController";
    const FACHREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\FachRepository";
    const MODULREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\ModulRepository";
    const PRUEFLINGREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\PrueflingRepository";
    const NOTENREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\NoteRepository";
    const PRUEFREPO = "prueflingRepository";
    const FACHREPO = "fachRepository";
    const NOTENREPO = "noteRepository";
    const VIEWINTERFACE = "TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface";
    const REQUEST = "TYPO3\\CMS\\Extbase\\Mvc\\Request";
    const ASSIGN = "assign";
    const FINDBYUID = "findByUid";
    const FINDALL = "findAll";
    const REQUEST = "request";
    const UPDATE = "update";
    const REMOVE = "remove";
    const REDIRECT = "redirect";

    /**
     * @var \ReRe\Rere\Controller\FachController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock(self::FACHCONTROLLER, array(self::REDIRECT, 'forward', 'addFlashMessage'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllFachesFromRepositoryAndAssignsThemToView() {

        $allFaches = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

        $fachRepository = $this->getMock(self::FACHREPOSITORY, array(self::FINDALL), array(), '', FALSE);
        $fachRepository->expects($this->once())->method(self::FINDALL)->will($this->returnValue($allFaches));
        $this->inject($this->subject, self::FACHREPO, $fachRepository);

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method(self::ASSIGN)->with('faches', $allFaches);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenFachToView() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('fach', $fach);

        $this->subject->showAction($fach);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenFachToView() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);
        $request->expects($this->once())->method('hasArgument')->will($this->returnValue($this->subject));

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $modulRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($modul));
        $this->inject($this->subject, 'modulRepository', $modulRepository);

        $request->expects($this->once())->method('getArgument')->will($this->returnValue($this->subject));
        $this->inject($this->subject, self::REQUEST, $request);

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method('assignMultiple')->with(array(
            'newFach' => $fach,
            'moduluid' => $modul->getUid(),
            'modulname' => $modul->getModulname(),
            'modulnummer' => $modul->getModulnr(),
            'gueltigkeitszeitraum' => $modul->getGueltigkeitszeitraum()
        ));
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($fach);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenFachToFachRepository() {

        $fachname = 'SOTE1';
        $fachnummer = '123';
        $pruefer = 'Johner';
        $notenschema = 'Schulnoten';
        $datum = '19.02.2015';
        $modulnr = '1';
        $creditpoint = '3';

        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);
        $request->expects($this->once())->method('hasArgument')->will($this->returnValue($this->subject));
        $this->inject($this->subject, self::REQUEST, $request);

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $modulRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($modul));
        $this->inject($this->subject, 'modulRepository', $modulRepository);

        $mockFach = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Fach', array(), array(), '', FALSE);

        $objectManager = $this->getMock('TYPO3\\CMS\\Extbase\\Object\\ObjectManager', array(), array(), '', FALSE);
        $objectManager->expects($this->once())->method('create')->will($this->returnValue($mockFach));
        $this->inject($this->subject, 'objectManager', $objectManager);

        $mockFach->setFachname($fachname);
        $mockFach->setFachnr($fachnummer);
        $mockFach->setPruefer($pruefer);
        $mockFach->setNotenschema($notenschema);
        $mockFach->setDatum($datum);
        $mockFach->setModulnr($modulnr);
        $mockFach->setCreditpoints($creditpoint);

        $fachRepository = $this->getMock(self::FACHREPOSITORY, array('add'), array(), '', FALSE);
        $fachRepository->expects($this->once())->method('add')->with($mockFach);
        $this->inject($this->subject, self::FACHREPO, $fachRepository);

        $this->subject->expects($this->once())->method(self::REDIRECT)->with('list', 'Modul');
        $this->subject->createAction($mockFach);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenFachToView() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method(self::ASSIGN)->with('fach', $fach);
        $this->inject($this->subject, 'view', $view);

        $this->subject->editAction($fach);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenFachInFachRepository() {
        $fach = new \ReRe\Rere\Domain\Model\Fach();

        $fachRepository = $this->getMock(self::FACHREPOSITORY, array(self::UPDATE), array(), '', FALSE);
        $fachRepository->expects($this->once())->method(self::UPDATE)->with($fach);
        $this->inject($this->subject, self::FACHREPO, $fachRepository);

        $this->subject->updateAction($fach);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenFachFromFachRepository() {
        $noten = 1;
        $mockFach = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Fach', array(), array(), '', FALSE);
        $mockpruefling = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Pruefling', array(), array(), '', FALSE);
        $mocknote = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Note', array(), array(), '', FALSE);

        $fachRepository = $this->getMock(self::FACHREPOSITORY, array(self::FINDBYUID, self::UPDATE, self::REMOVE), array(), '', FALSE);
        $fachRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($mockFach));

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);
        $request->expects($this->once())->method('getArgument')->will($this->returnValue($this->subject));
        $this->inject($this->subject, self::REQUEST, $request);

        $mockFach->getNote();
        if (is_array($noten)) {
            foreach ($noten as $mocknote) {

                $mockFach->removeNote($mocknote);

                $prueflingRepository = $this->getMock(self::PRUEFLINGREPOSITORY, array(self::FINDBYUID, self::UPDATE), array(), '', FALSE);
                $prueflingRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($mockpruefling));

                $mocknote->getPruefling();
                $mockpruefling->removeNote($mocknote);
                $mockFach->removeMatrikelnr($mockpruefling);

                $prueflingRepository->expects($this->once())->method(self::UPDATE)->will($this->returnValue($mockpruefling));
                $this->inject($this->subject, self::PRUEFREPO, $prueflingRepository);

                $fachRepository->expects($this->once())->method(self::UPDATE)->will($this->returnValue($mockFach));

                $noteRepository = $this->getMock(self::NOTENREPOSITORY, array(self::REMOVE), array(), '', FALSE);
                $noteRepository->expects($this->once())->method(self::REMOVE)->with($mocknote);

                $this->inject($this->subject, self::NOTENREPO, $noteRepository);
            }

            $fachRepository->expects($this->once())->method(self::REMOVE)->with($mockFach);
            $this->inject($this->subject, self::FACHREPO, $fachRepository);

            $this->subject->expects($this->once())->method(self::REDIRECT)->with('list', 'Modul');
            $this->subject->deleteAction($mockFach);
        }
    }

}

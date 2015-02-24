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
 * Test case for class ReRe\Rere\Controller\NoteController.
 *
 * @author Felix Hohlwegler <info@felix-hohlwegler.de>
 * @author Sarah Kieninger <sarah.kieninger@gmail.com>
 * @author Tim Wacker
 * @author Nejat Balta
 * @author Tobias Brockner
 * @author Nicolas Tedjadharma
 */
class NoteControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    const VIEWINTERFACE = 'TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface';
    const ASSIGN = "assign";
    const REQUEST = "request";
    const NOTENREPOSITORY = 'ReRe\\Rere\\Domain\\Repository\\NoteRepository';
    const NOTENREPO = 'noteRepository';
    const FACHCONTROLLER = "ReRe\\Rere\\Controller\\FachController";
    const FACHREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\FachRepository";
    const MODULREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\ModulRepository";
    const MODULREPO = "modulRepository";
    const PRUEFLINGREPOSITORY = "ReRe\\Rere\\Domain\\Repository\\PrueflingRepository";
    const NOTELIST = "\\ReRe\\Rere\\Services\\NestedDirectory\\NoteSchemaArrays";
    const HELPER = "\\ReRe\\Rere\\Services\\NestedDirectory\\NotenVerwaltungHelper";
    const OBJECTMANAGER = 'TYPO3\\CMS\\Extbase\\Object\\ObjectManager';
    const OBJECTSTORAGE = 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage';
    const FACHREPO = "fachRepository";
    const PRUEFREPO = "prueflingRepository";
    const REQUEST = "TYPO3\\CMS\\Extbase\\Mvc\\Request";
    const NOTENCONTROLLER = 'ReRe\\Rere\\Controller\\NoteController';
    const FACH = '\\ReRe\\Rere\\Domain\\Model\\Fach';
    const NOTE = '\\ReRe\\Rere\\Domain\\Model\\Note';
    const MODUL = '\\ReRe\\Rere\\Domain\\Model\\Modul';
    const FINDBYUID = "findByUid";
    const FINDALL = "findAll";

    /**
     * @var \ReRe\Rere\Controller\NoteController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock(self::NOTENCONTROLLER, array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllNotesFromRepositoryAndAssignsThemToView() {
        $angemeldete = 0;
        $mockFach = $this->getMock(self::FACH, array(), array(), '', FALSE);
        $mockModul = $this->getMock(self::MODUL, array(), array(), '', FALSE);
        $mockNote = $this->getMock(self::NOTE, array(), array(), '', FALSE);
        $allNotes = $this->getMock(self::OBJECTSTORAGE, array(), array(), '', FALSE);
        $allOptions = $this->getMock(self::OBJECTSTORAGE, array(), array(), '', FALSE);
        $allCorrectNotes = $this->getMock(self::OBJECTSTORAGE, array(), array(), '', FALSE);


        $fachRepository = $this->getMock(self::FACHREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $fachRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($mockFach));
        $this->inject($this->subject, self::FACHREPO, $fachRepository);

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);

        $request->expects($this->once())->method('getArgument')->will($this->returnValue($this->subject));

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $modulRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($mockModul));
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $request->expects($this->once())->method('getArgument')->will($this->returnValue($this->subject));

        $this->inject($this->subject, self::REQUEST, $request);

        $noteRepository = $this->getMock(self::NOTENREPOSITORY, array(self::FINDALL), array(), '', FALSE);
        $noteRepository->expects($this->once())->method(self::FINDALL)->will($this->returnValue($allNotes));
        $this->inject($this->subject, self::NOTENREPO, $noteRepository);

        foreach ($allNotes as $mockNote) {
            $mockPruefling = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Pruefling', array(), array(), '', FALSE);
            $prueflingRepository = $this->getMock(self::PRUEFLINGREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
            $prueflingRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($mockPruefling));
            $this->inject($this->subject, self::PRUEFREPO, $prueflingRepository);
            $mockNote->getPruefling();

            $notelist = $this->getMock(self::NOTELIST, array('getMarkArray'), array(), '', FALSE);
            $notelist->expects($this->once())->method('getMarkArray')->will($this->returnValue($allOptions));

            $mockFach->getNotenschema();
        }

        $notenverwaltungHelper = $this->getMock(self::HELPER, array('checkIfWertisSet'), array(), '', FALSE);
        $notenverwaltungHelper->expects($this->once())->method('checkIfWertisSet')->will($this->returnValue($allCorrectNotes));
        $this->inject($this->subject, 'helper', $notenverwaltungHelper);


        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method('assignMultiple')->with(array(
            'fach' => $mockFach,
            'modul' => $mockModul,
            'options' => $allOptions,
            'notes' => $allNotes,
            'eingetragen' => $this->helper->checkIfWertisSet($allCorrectNotes),
            'chartarray' => json_encode($this->helper->genArray($allCorrectNotes, $mockFach->getNotenschema())),
            'avg' => $this->helper->calculateAverage($allCorrectNotes),
            'angemeldete' => $angemeldete
        ));
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenNoteToView() {
        $note = new \ReRe\Rere\Domain\Model\Note();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('note', $note);

        $this->subject->showAction($note);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenNoteToView() {
        $note = new \ReRe\Rere\Domain\Model\Note();

        $view = $this->getMock(self::VIEWINTERFACE);
        $view->expects($this->once())->method(self::ASSIGN)->with('newNote', $note);
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($note);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenNoteToNoteRepository() {
        $newNote = new \ReRe\Rere\Domain\Model\Note();
        $fach = new \ReRe\Rere\Domain\Model\Fach();
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $noteRepository = $this->getMock(self::NOTENREPOSITORY, array('add'), array(), '', FALSE);
        $noteRepository->expects($this->once())->method('add')->with($newNote);
        $this->inject($this->subject, self::NOTENREPO, $noteRepository);

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);

        $fachRepository = $this->getMock(self::FACHREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $fachRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($fach));
        $this->inject($this->subject, self::FACHREPO, $fachRepository);

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $modulRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($modul));
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $this->inject($this->subject, self::REQUEST, $request);

        $this->subject->expects($this->once())->method('redirect')->with('list', 'Note', NULL, array('fach' => $fach, 'modul' => $modul));
        $this->subject->createAction($newNote);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenNoteToView() {
        $note = new \ReRe\Rere\Domain\Model\Note();

        $view = $this->getMock(self::VIEWINTERFACE);
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method(self::ASSIGN)->with('note', $note);

        $this->subject->editAction($note);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenNoteInNoteRepository() {
        $note = new \ReRe\Rere\Domain\Model\Note();
        $kommentar = 'Blabla';
        $wert = 'Blabla';
        $fach = new \ReRe\Rere\Domain\Model\Fach();
        $modul = new \ReRe\Rere\Domain\Model\Modul();

        $noteRepository = $this->getMock(self::NOTENREPOSITORY, array(self::FINDBYUID, 'update'), array(), '', FALSE);
        $noteRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($note));

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);

        $note->setKommentar($kommentar);
        $note->setWert($wert);

        $noteRepository->expects($this->once())->method('update')->will($this->returnValue($note));

        $fachRepository = $this->getMock(self::FACHREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $fachRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($fach));
        $this->inject($this->subject, self::FACHREPO, $fachRepository);

        $modulRepository = $this->getMock(self::MODULREPOSITORY, array(self::FINDBYUID), array(), '', FALSE);
        $modulRepository->expects($this->once())->method(self::FINDBYUID)->will($this->returnValue($modul));
        $this->inject($this->subject, self::MODULREPO, $modulRepository);

        $this->inject($this->subject, self::NOTENREPO, $noteRepository);
        $this->inject($this->subject, self::REQUEST, $request);

        $this->subject->expects($this->once())->method('redirect')->with('list', 'Note', NULL, array('fach' => $fach, 'modul' => $modul));
        $this->subject->updateAction($note);
    }

    /**
     * @test
     */
    /*     * public function deleteActionRemovesTheGivenNoteFromNoteRepository() {

      $note = new \ReRe\Rere\Domain\Model\Note();
      $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);
      $request->expects($this->once())->method('getArgument')->will($this->returnValue($this->subject));
      $this->inject($this->subject, 'request', $request);

      $mockModul = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Modul', array(), array(), '', FALSE);
      $modulRepository = $this->getMock(self::MODULREPOSITORY, array('findByUid'), array(), '', FALSE);
      $modulRepository->expects($this->once())->method('findByUid')->will($this->returnValue($mockModul));
      $this->inject($this->subject, 'modulRepository', $modulRepository);

      $objectManager = $this->getMock(SELF::OBJECTMANAGER, array(), array(), '', FALSE);
      $objectManager->expects($this->any())->method('create')->will($this->returnValue($mockModul));

      $mockNote = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Note', array(), array(), '', FALSE);
      $noteRepository = $this->getMock(self::NOTENREPOSITORY, array('findByUid', 'remove'), array(), '', FALSE);
      $noteRepository->expects($this->once())->method('findByUid')->will($this->returnValue($mockNote));

      $objectManager->expects($this->any())->method('create')->will($this->returnValue($mockNote));

      $mockFach = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Fach', array(), array(), '', FALSE);
      $fachRepository = $this->getMock(self::FACHREPOSITORY, array('findByUid', 'update'), array(), '', FALSE);
      $fachRepository->expects($this->once())->method('findByUid')->will($this->returnValue($mockFach));

      $objectManager->expects($this->any())->method('create')->will($this->returnValue($mockFach));

      $this->subject->expects($this->once())->method('redirect')->with('list', 'Modul');

      $mockPruefling = $this->getMock('\\ReRe\\Rere\\Domain\\Model\\Pruefling', array(), array(), '', FALSE);
      $prueflingRepository = $this->getMock(self::PRUEFLINGREPOSITORY, array('findByUid', 'update'), array(), '', FALSE);
      $prueflingRepository->expects($this->once())->method('findByUid')->will($this->returnValue($mockPruefling));

      $note->getPruefling();

      $mockFach->removeNote($mockNote);
      $mockPruefling->removeNote($mockNote);
      $mockFach->removeMatrikelnr($mockPruefling);

      $objectManager->expects($this->any())->method('create')->will($this->returnValue($mockFach));
      $objectManager->expects($this->any())->method('create')->will($this->returnValue($mockPruefling));
      $this->inject($this->subject, 'objectManager', $objectManager);

      $fachRepository->expects($this->once())->method('update')->will($this->returnValue($this->subject));
      $prueflingRepository->expects($this->once())->method('update')->will($this->returnValue($this->subject));
      $noteRepository->expects($this->once())->method('remove')->will($this->returnValue($this->subject));

      $this->inject($this->subject, self::FACHREPO, $fachRepository);
      $this->inject($this->subject, self::PRUEFREPO, $prueflingRepository);
      $this->inject($this->subject, self::NOTENREPO, $noteRepository);

      $this->subject->deleteAction($mockNote);
      } */
}

<?php

namespace ReRe\Rere\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
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
 *  the Free Software Foundation; either version 3 of the License, or
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
 * NoteController
 */
class NoteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const MODUL = 'modul';
    const FACH = 'fach';

    /**
     * Klassen variable für die Notenlisten.
     * @var type
     */
    private $noteList;

    /**
     * Klassen variable für die Hilfsklassen.
     * @var type
     */
    private $helper;

    /**
     * Konstruktor.
     */
    public function __construct() {
        // Instanz der Array Klasse.
        $this->noteList = new \ReRe\Rere\Services\NestedDirectory\NoteSchemaArrays();
        $this->helper = new \ReRe\Rere\Services\NestedDirectory\NotenVerwaltungHelper();
    }

    /**
     * noteRepository
     *
     * @var \ReRe\Rere\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    /**
     * prueflingRepository
     *
     * @var \ReRe\Rere\Domain\Repository\PrueflingRepository
     * @inject
     */
    protected $prueflingRepository = NULL;

    /**
     * modulRepository
     *
     * @var \ReRe\Rere\Domain\Repository\ModulRepository
     * @inject
     */
    protected $modulRepository = NULL;

    /**
     * fachRepository
     *
     * @var \ReRe\Rere\Domain\Repository\FachRepository
     * @inject
     */
    protected $fachRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        // Holt FachObjekt
        $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        // Holt Modul Objekt
        $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
        // Ausgabe aller eingetragener noten
        $notes = $this->noteRepository->findAll();

        $options = $this->noteList->getMarkArray($fach->getNotenschema());

        $this->view->assignMultiple(array(self::FACH => $fach, self::MODUL => $modul, 'options' => $options, 'notes' => $notes, 'eingetragen' => $this->helper->checkIfWertisSet($notes), 'chartarray' => $this->helper->genArray($notes), 'avg' => $this->helper->calculateAverage($notes)));
    }

    /**
     * action show
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Note $note) {
        $this->view->assign('note', $note);
    }

    /**
     * action new
     *
     * @param \ReRe\Rere\Domain\Model\Note $newNote
     * @ignorevalidation $newNote
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Note $newNote = NULL) {
        $this->view->assign('newNote', $newNote);
    }

    /**
     * action create
     *
     * @param \ReRe\Rere\Domain\Model\Note $newNote
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Note $newNote) {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->noteRepository->add($newNote);
        $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
        $this->redirect('list', 'Note', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

    /**
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @ignorevalidation $note
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Note $note) {
        echo 'TEST';
        $this->view->assign('note', $note);
    }

    /**
     * action update
     *
     * @return void
     */
    public function updateAction() {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        // Holt die NotenUid vom Request
        $noteuid = $this->request->getArgument('noteuid');
        // Holt das Noten-Objekt
        $note = $this->noteRepository->findByUid($noteuid);
        // Setzt die neuen Werte für die Note
        $note->setKommentar($this->request->getArgument('kommentar'));
        $note->setWert($this->request->getArgument('wert'));
        // Update der Note
        $this->noteRepository->update($note);
        $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
        $this->redirect('list', 'Note', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

    /**
     * action delete
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Note $note) {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->noteRepository->remove($note);
        $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
        $this->redirect('list', 'Note', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

}

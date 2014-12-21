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

    /**
     * noteRepository
     *
     * @var \ReRe\Rere\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {

        // Ausgabe aller eingetragener noten
        $notes = $this->noteRepository->findAll();


        // Instanz der Array Klasse.
        $notesList = new \ReRe\Rere\Services\NestedDirectory\NoteSchemaArrays();
        $helper = new \ReRe\Rere\Services\NestedDirectory\NotenVerwaltungHelper();


        // Übergibt die Notenlisten
        $this->view->assign('options', $notesList->getMarks());
        $this->view->assign('notes', $notes);
        $this->view->assign('chartarray', $helper->genArray($notes));
        $this->view->assign('avg', $helper->calculateAverage($notes));
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
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @ignorevalidation $note
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Note $note) {
        $this->view->assign('note', $note);
    }

    /**
     * action update
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Note $note) {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->noteRepository->update($note);
        $this->redirect('list');
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
        $this->redirect('list');
    }

}

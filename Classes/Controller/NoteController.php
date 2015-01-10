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
 * Die Klasse NoteController verwaltet die Noten.
 * Sie stellt Methoden zum Anlegen, Anzeigen, Editieren und Löschen von Noten bereit.
 */
class NoteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const MODUL = 'modul';
    const FACH = 'fach';

    /**
     * Private Klassenvariable für die Notenlisten wird mit NULL initialisiert.
     *
     * @var type
     */
    private $noteList = NULL;

    /**
     * Private Klassenvariable für die Hilfsklassen wird mit NULL initialisiert.
     *
     * @var type
     */
    private $helper = NULL;

    /**
     * Protected Variable helper wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    /**
     * Protected Variable prueflingRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\PrueflingRepository
     * @inject
     */
    protected $prueflingRepository = NULL;

    /**
     * Protected Variable modulRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\ModulRepository
     * @inject
     */
    protected $modulRepository = NULL;

    /**
     * Protected Variable fachRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\FachRepository
     * @inject
     */
    protected $fachRepository = NULL;

    /**
     * Im Konstruktor des NoteControllers wird eine Instanz der Array-Klasse und des Notenverwaltungs-Helpers erzeugt.
     */
    public function __construct() {
        $this->noteList = new \ReRe\Rere\Services\NestedDirectory\NoteSchemaArrays();
        $this->helper = new \ReRe\Rere\Services\NestedDirectory\NotenVerwaltungHelper();
    }

    /**
     * In dieser Methode werden alle eingetragenen Noten zu einem bestimmten Fach/Modul geholt.
     *
     * @return void
     */
    public function listAction() {
        // Holt Fach-Objekt
        $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        $angemeldete = 0;
        // Holt Modul-Objekt
        $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
        // Ausgabe aller eingetragener Noten
        $notes = $this->noteRepository->findAll();
        $correctnotes = array();
        $publisharray = array();
        foreach ($notes as $note) {
            if ($note->getFach() == $fach->getUid()) {
                array_push($correctnotes, $note);
                // Holt den Prüfling, dem die Note zugewiesen wurde
                $pruefling = $this->prueflingRepository->findByUid($note->getPruefling());
                // Generiert Ausgabe-Array mit Prüfling- und Noten-Daten
                array_push($publisharray, array('prueflingvorname' => $pruefling->getVorname(), 'matrikelnr' => $pruefling->getMatrikelnr(), 'prueflingnachname' => $pruefling->getNachname(), 'uid' => $note->getUid(), 'wert' => $note->getWert(), 'kommentar' => $note->getKommentar()));
                $angemeldete++;
            }
        }
        // holt das passende Notenschema.
        $options = $this->noteList->getMarkArray($fach->getNotenschema());
        $this->view->assignMultiple(array(self::FACH => $fach, self::MODUL => $modul, 'options' => $options, 'notes' => $publisharray, 'eingetragen' => $this->helper->checkIfWertisSet($correctnotes), 'chartarray' => $this->helper->genArray($correctnotes, $fach->getNotenschema()), 'avg' => $this->helper->calculateAverage($correctnotes), 'angemeldete' => $angemeldete));
    }

    /**
     * Diese Methode dient dem Anzeigen einer einzelnen Note.
     * Sie wird in der aktuellen Version jedoch nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Note $note) {
        $this->view->assign('note', $note);
    }

    /**
     * Mit dieser Methode wird eine neue Note erzeugt und mit NULL initialisiert.
     *
     * @param \ReRe\Rere\Domain\Model\Note $newNote
     * @ignorevalidation $newNote
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Note $newNote = NULL) {
        $this->view->assign('newNote', $newNote);
    }

    /**
     * Mit dieser Methode wird die neu erzeugte Note im noteRepository gespeichert und das Fach und das Modul zugewiesen.
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
     * Diese Methode dient dem Editieren einer Note.
     * Sie wird in der aktuellen Version jedoch so nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Note $note
     * @ignorevalidation $note
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Note $note) {
        $this->view->assign('note', $note);
    }

    /**
     * In dieser Methode wird ein Noten-Objekt mit neuen Werten belegt.
     *
     * @return void
     */
    public function updateAction() {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        // Holt das Noten-Objekt über die NotenUid vom Request
        $note = $this->noteRepository->findByUid($this->request->getArgument('noteuid'));
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
     * Diese Methode dient dem Löschen einer Note, gleichzeitig wird der Prüfling vom Fach abgemeldet.
     *
     * @return void
     */
    public function deleteAction() {
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        if ($this->request->hasArgument(self::MODUL) && $this->request->hasArgument("note") && $this->request->getArgument(self::FACH)) {
            $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
            $note = $this->noteRepository->findByUid($this->request->getArgument("note"));
            $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        } else {
            $this->redirect('list', 'Modul');
        }
        // Prüfling holen
        $pruefling = $this->prueflingRepository->findByUid($note->getPruefling());
        // Note vom Fach und vom Prüfling löschen, Prüfling vom Fach abmelden.
        $fach->removeNote($note);
        $pruefling->removeNote($note);
        $fach->removeMatrikelnr($pruefling);
        // Persistieren
        $persistenceManager->persistAll();
        $this->fachRepository->update($fach);
        // Note entgültig löschen
        $this->noteRepository->remove($note);
        $this->redirect('list', 'Note', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

}

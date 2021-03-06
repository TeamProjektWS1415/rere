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
 * Die Klasse FachController verwaltet die Fächer.
 * Sie stellt Methoden zum Anlegen und Löschen von Fächern, sowie zur Zuordnung von Fächern zu bereits bestehenden Modulen bereit.
 */
class FachController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const MODULUID = 'moduluid';
    const DATUM = "datum";
    const CREDITPOINTS = "creditpoints";

    /**
     * Protected Variable fachRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\FachRepository
     * @inject
     */
    protected $fachRepository = NULL;

    /**
     * Protected Variable modulRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\ModulRepository
     * @inject
     */
    protected $modulRepository = NULL;

    /**
     * Protected Variable noteRepository wird mit NULL initialisiert.
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
     * Protected Variable dataMapper wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper
     * @inject
     */
    protected $dataMapper = NULL;

    /**
     * Protected Variable objectManager wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager = NULL;

    /**
     * Diese Methode übergibt alle vorhandenen Fächer als Array an die View.
     *
     * @return void
     */
    public function listAction() {
        $faches = $this->fachRepository->findAll();
        $this->view->assign('faches', $faches);
    }

    /**
     * Diese Methode übergibt ein bestimmtes Fach an die View.
     *
     * @param \ReRe\Rere\Domain\Model\Fach $fach
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Fach $fach) {
        $this->view->assign('fach', $fach);
    }

    /**
     * In dieser Methode wird mit der übergebenen Modulnummer das Modul aus dem Repository geholt, dem das neu erzeugte Fach (new.html) zugeordnet werden soll.
     * Anschließend wird der View ein Array mit dem leeren Fach und den Daten des Moduls übergeben.
     *
     * @param \ReRe\Rere\Domain\Model\Fach $newFach
     * @ignorevalidation $newFach
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Fach $newFach = NULL) {
        // Holt die übergebene Modulnummer
        if ($this->request->hasArgument('modul')) {
            // Holt das Modul-Objekt aus dem Repository
            $modul = $this->modulRepository->findByUid($this->request->getArgument('modul'));
        }
        // Ausgabe in der View
        $this->view->assignMultiple(array(
            'newFach' => $newFach, self::MODULUID => $modul->getUid(), 'modulname' => $modul->getModulname(), 'modulnummer' => $modul->getModulnr(), 'gueltigkeitszeitraum' => $modul->getGueltigkeitszeitraum()
        ));
    }

    /**
     * In dieser Methode wird dem neu erzeugten Fach (new.html) die Daten aus dem Eingabeformular zugewiesen.
     * Das Fach wird dem aktuellen Modul zugeordnet.
     *
     * @return void
     */
    public function createAction() {
        // Holt die Modulnummer vom Request und dann das Modul objekt
        if ($this->request->hasArgument(self::MODULUID)) {
            $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODULUID));
        }
        $fach = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Fach');
        // Fach Werte setzen
        $fach->setFachname($this->request->getArgument('fachname'));
        $fach->setFachnr($this->request->getArgument('fachnummer'));
        $fach->setPruefer($this->request->getArgument('pruefer'));
        $fach->setNotenschema($this->request->getArgument('notenschema'));
        $fach->setDatum($this->request->getArgument(self::DATUM));
        $fach->setCreditpoints($this->request->getArgument(self::CREDITPOINTS));
        // Fach einem Modul zuordnen
        $fach->setModulnr($modul->getUid());
        $this->fachRepository->add($fach);
        $modul->addFach($fach);
        $this->redirect('list', 'Modul');
    }

    /**
     * Diese Methode dient dem Editieren eines Fachs.
     * Sie wird in der aktuellen Version jedoch nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Fach $fach
     * @ignorevalidation $fach
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Fach $fach) {
        $this->view->assign('fach', $fach);
    }

    /**
     * Mit dieser Methode wird das Fach im fachRepository auf den neusten Stand gebracht.
     * Methode wird in der aktuellen Version nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Fach $fach
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Fach $fach) {
        $this->fachRepository->update($fach);
        $this->redirect('list');
    }

    /**
     * Mit dieser Methode wird ein Fach aus dem Repository gelöscht.
     * Danach wird auf die Result Repository-Startseite umgeleitet.
     *
     * @return void
     */
    public function deleteAction() {
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $fach = $this->fachRepository->findByUid($this->request->getArgument('fach'));
        $noten = $fach->getNote();
        foreach ($noten as $note) {
            if ($note->getFach() == $fach->getUid()) {
                $fach->removeNote($note);
                $pruefling = $this->prueflingRepository->findByUid($note->getPruefling());
                $pruefling->removeNote($note);
                $fach->removeMatrikelnr($pruefling);
                $persistenceManager->persistAll();
                $this->prueflingRepository->update($pruefling);
                $this->fachRepository->update($fach);
                $this->noteRepository->remove($note);
            }
        }
        $persistenceManager->persistAll();

        // Fach Löschen
        $this->fachRepository->remove($fach);
        $this->redirect('list', 'Modul');
    }

}

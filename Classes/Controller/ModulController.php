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
 * Die Klasse ModulController verwaltet die Module.
 * Sie stellt Methoden zum Anlegen, Anzeigen und Löschen von Modulen, sowie zur Zuordnung von Fächern zu Modulen bereit.
 */
class ModulController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const RETURNMODUL = "returnModul";
    const MODULNAME = "modulname";
    const MODULNUMMER = "modulnummer";
    const GUELTIGKEITSZEITRAUM = "gueltigkeitszeitraum";
    const FACHNAME = "fachname";
    const FACHNUMMER = "fachnummer";
    const PRUEFER = "pruefer";
    const NEWSTRING = "new";

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
     * Protected Variable intervallRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\IntervallRepository
     * @inject
     */
    protected $intervallRepository = NULL;

    /**
     * Protected Variable objectManager wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager = NULL;

    /**
     * Mit dieser Methode werden alle Module des aktuell ausgewählten Intervalls angezeigt.
     *
     * @return void
     */
    public function listAction() {
        $moduls = $this->modulRepository->findAll();
        $intervall = $this->intervallRepository->findByUid(1);
        $filteredmoduls = array();
        // Prüfen, ob die Tabelle wirklich einen Wert hat (also ob ein Intervall gesetzt wurde).
        if ($intervall == Null) {
            // wenn Intervall noch nicht gesetzt ist, wird ein Intervall-Objekt erzeugt
            $createdIntervall = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Intervall');
            $createdIntervall->setAktuell('WS14/15');
            $createdIntervall->setType('studienhalbjahr');
            $this->intervallRepository->add($createdIntervall);
            $this->redirect('list');
        }
        if ($intervall != Null) {
            // wenn Intervall gesetzt ist, wird es geholt.
            $akteullesintervall = $intervall->getAktuell();
            $intervallType = $intervall->getType();
        }
        // Alle Module des aktuellen Intervalls holen
        foreach ($moduls as $modul) {
            if ($modul->getGueltigkeitszeitraum() == $akteullesintervall) {
                array_push($filteredmoduls, $modul);
            }
        }
        // Ausgabe an View
        $this->view->assignMultiple(array(
            'aktuellintervall' => $akteullesintervall,
            'intervallType' => $intervallType,
            'moduls' => $filteredmoduls
        ));
        return $this->view->render();
    }

    /**
     * Diese Methode zeigt ein bestimmtes Modul an.
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->view->assign('modul', $modul);
    }

    /**
     * Mit dieser Methode wird ein neues (leeres) Modul (new.html) erzeugt und mit dem aktuellen Gültigkeitszeitraum vorbelegt.
     *
     * @param \ReRe\Rere\Domain\Model\Modul $newModul
     * @ignorevalidation $newModul
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Modul $newModul = NULL) {
        if ($this->request->hasArgument(self::RETURNMODUL)) {
            $this->view->assignMultiple(array(self::MODULNAME => $this->request->getArgument(self::RETURNMODUL),
                self::MODULNUMMER => $this->request->getArgument(self::MODULNUMMER),
                self::GUELTIGKEITSZEITRAUM => $this->request->getArgument(self::GUELTIGKEITSZEITRAUM),
                self::FACHNAME => $this->request->getArgument(self::FACHNAME),
                self::FACHNUMMER => $this->request->getArgument(self::FACHNUMMER),
                self::PRUEFER => $this->request->getArgument(self::PRUEFER)));
        } else {
            $this->view->assignMultiple(array('newModul' => $newModul, self::GUELTIGKEITSZEITRAUM => $this->request->getArgument(self::GUELTIGKEITSZEITRAUM)));
        }
    }

    /**
     * Wird aufgerufen, wenn Formular (Modul/new.html) abgeschickt wird.
     *
     * In dieser Methode wird ein neues Fach angelegt.
     * Hierbei werden die Daten aus dem Eingabeformular dem Fach zugewiesen und anschließend das Fach dem neuen Modul zugewiesen.
     *
     * @param \ReRe\Rere\Domain\Model\Modul $newModul
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Modul $newModul) {
        $intervall = $this->intervallRepository->findByUid(1);

        // Prüfen ob der Gültigkeitszeitraum korrekt ist.
        if ($intervall->getType() == "studienhalbjahr") {
            $pregResult = preg_match('/^([S][S][0-9]{2})$|^([W][S][0-9]{2}\/[0-9]{2})$/', $newModul->getGueltigkeitszeitraum());
        } else {
            $pregResult = preg_match('/^(Schuljahr)$^(\d{2}\/\d{2})$/', $newModul->getGueltigkeitszeitraum());
        }

        if ($pregResult != 1) {
            $this->addFlashMessage('Guelitigkeitszeitrum falsch gewählt es ist nur SS00-SS99 zuässlig sowie WS00/01-WS99/00 oder Sschuljahr00/01 - Schuljahr 99/00', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect(self::NEWSTRING, "Modul", Null, array(self::RETURNMODUL => $newModul->getModulname(),
                self::MODULNUMMER => $newModul->getModulnr(),
                self::GUELTIGKEITSZEITRAUM => $newModul->getGueltigkeitszeitraum(),
                self::FACHNAME => $this->request->getArgument(self::FACHNAME),
                self::FACHNUMMER => $this->request->getArgument(self::FACHNUMMER),
                self::PRUEFER => $this->request->getArgument(self::PRUEFER)));
        }

        $this->modulRepository->add($newModul);
        // Erzeugt ein leeres Fach
        $fach = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Fach');
        // Fach-Werte setzen
        if ($this->request->hasArgument('fachname') && $this->request->hasArgument('fachnummer') && $this->request->hasArgument('pruefer') && $this->request->hasArgument('notenschema')) {
            $fach->setFachname($this->request->getArgument('fachname'));
            $fach->setFachnr($this->request->getArgument('fachnummer'));
            $fach->setPruefer($this->request->getArgument('pruefer'));
            $fach->setNotenschema($this->request->getArgument('notenschema'));
        }
        // Fach einem Modul zuordnen
        $fach->setModulnr($newModul->getUid());
        // Fach speichern
        $this->fachRepository->add($fach);
        $newModul->addFach($fach);

        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);

        $this->redirect('list');
    }

    /**
     * Diese Methode dient dem Editieren eines Moduls.
     * Sie wird in der aktuellen Version jedoch nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @ignorevalidation $modul
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->view->assign('modul', $modul);
    }

    /**
     * Mit dieser Methode wird das Modul im modulRepository auf den neusten Stand gebracht.
     * Methode wird in der aktuellen Version nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->modulRepository->update($modul);
        $this->redirect('list');
    }

    /**
     * Diese Methode dient dem Löschen eines Moduls.
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->modulRepository->remove($modul);
        $this->redirect('list');
    }

}

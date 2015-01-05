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
            'newFach' => $newFach, 'moduluid' => $modul->getUid(), 'modulname' => $modul->getModulname(), 'modulnummer' => $modul->getModulnr(), 'gueltigkeitszeitraum' => $modul->getGueltigkeitszeitraum()
        ));
    }

    /**
     * In dieser Methode wird dem neu erzeugten Fach (new.html) die Daten aus dem Eingabeformular zugewiesen.
     * Das Fach wird dem aktuellen Modul zugeordnet.
     *
     * @return void
     */
    public function createAction() {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        // Holt die Modulnummer vom Request und dann das Modul objekt
        if ($this->request->hasArgument('moduluid')) {
            $modul = $this->modulRepository->findByUid($this->request->getArgument('moduluid'));
        }
        $fach = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Fach');
        // Fach Werte setzen
        $fach->setFachname($this->request->getArgument('fachname'));
        $fach->setFachnr($this->request->getArgument('fachnummer'));
        $fach->setPruefer($this->request->getArgument('pruefer'));
        $fach->setNotenschema($this->request->getArgument('notenschema'));
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
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->fachRepository->update($fach);
        $this->redirect('list');
    }

    /**
     * Mit dieser Methode wird ein Fach aus dem Repository gelöscht.
     * Danach wird auf die Result Repository-Startseite umgeleitet.
     *
     * @param \ReRe\Rere\Domain\Model\Fach $fach
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Fach $fach) {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->fachRepository->remove($fach);
        $this->redirect('list', 'Modul');
    }

}

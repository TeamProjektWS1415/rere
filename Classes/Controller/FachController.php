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
 * FachController
 */
class FachController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * fachRepository
     *
     * @var \ReRe\Rere\Domain\Repository\FachRepository
     * @inject
     */
    protected $fachRepository = NULL;

    /**
     * modulRepository
     *
     * @var \ReRe\Rere\Domain\Repository\ModulRepository
     * @inject
     */
    protected $modulRepository = NULL;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper
     * @inject
     */
    protected $dataMapper = NULL;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $faches = $this->fachRepository->findAll();
        $this->view->assign('faches', $faches);
    }

    /**
     * @param int $uid
     * @return type
     */
    public function listFaecherFromModul(int $uid) {
        $query = $this->createQuery();
        $query->in('modulnr', $uid);
        return $this->dataMapper->map(`\\ReRe\\Rere\\Domain\\Model\\Fach}`, $query->execute());
    }

    /**
     * action show
     *
     * @param \ReRe\Rere\Domain\Model\Fach $fach
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Fach $fach) {
        $this->view->assign('fach', $fach);
    }

    /**
     * action new
     *
     * @param \ReRe\Rere\Domain\Model\Fach $newFach
     * @ignorevalidation $newFach
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Fach $newFach = NULL) {
        // Holt die übergebene Modulnummer
        $modulUID = $this->request->getArgument('modul');
        // Holt das Modul-Objekt aus dem Repository
        $modul = $this->modulRepository->findByUid($modulUID);
        // Ausgabe in der View
        $this->view->assign('newFach', $newFach);
        $this->view->assign('modulname', $modul->getModulname());
        $this->view->assign('modulnummer', $modul->getModulnr());
        $this->view->assign('gueltigkeitszeitraum', $modul->getGueltigkeitszeitraum());
        $this->view->assign('moduluid', $modul->getUid());
    }

    /**
     * action create
     *
     * @return void
     */
    public function createAction() {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        // Holt die Modulnummer vom Request
        $modulUID = $this->request->getArgument('moduluid');
        $modul = $this->modulRepository->findByUid($modulUID);
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
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Fach $fach
     * @ignorevalidation $fach
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Fach $fach) {
        $this->view->assign('fach', $fach);
    }

    /**
     * action update
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
     * action delete
     * Leitet nach dem Löschen auf die Result Repository Startseite um.
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

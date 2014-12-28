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
 * ModulController
 */
class ModulController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $moduls = $this->modulRepository->findAll();
        $this->view->assign('moduls', $moduls);
        return $this->view->render();
    }

    /**
     * action show
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->view->assign('modul', $modul);
    }

    /**
     * action new
     *
     * @param \ReRe\Rere\Domain\Model\Modul $newModul
     * @ignorevalidation $newModul
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Modul $newModul = NULL) {
        $this->view->assign('newModul', $newModul);
    }

    /**
     * action create
     *
     * @param \ReRe\Rere\Domain\Model\Modul $newModul
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Modul $newModul) {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->modulRepository->add($newModul);
        // Erzeugt ein Leeres Fach

        $fach = $this->objectManager->create('\ReRe\Rere\Domain\Model\Fach');

        // Fach Werte setzen
        $fach->setFachname($this->request->getArgument('fachname'));
        $fach->setFachnr($this->request->getArgument('fachnummer'));
        $fach->setPruefer($this->request->getArgument('pruefer'));
        $fach->setNotenschema($this->request->getArgument('notenschema'));
        // Fach einem Modul zuordnen
        $fach->setModulnr($newModul->getUid());

        // Fach speichern
        $this->fachRepository->add($fach);

        $newModul->addFach($fach);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @ignorevalidation $modul
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->view->assign('modul', $modul);
    }

    /**
     * action update
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
     * action delete
     *
     * @param \ReRe\Rere\Domain\Model\Modul $modul
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Modul $modul) {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->modulRepository->remove($modul);
        $this->redirect('list');
    }

}

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
 * PrueflingController
 */
class PrueflingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
     * FrontendUserRepositoryRepository
     *
     * @var \Typo3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $FrontendUserRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        // Liest die FachUid Aus
        $fachUID = $this->request->getArgument('fach');
        // Holt FachObjekt
        $fach = $this->fachRepository->findByUid($fachUID);
        // Liest die ModulUid aus
        $modulUid = $this->request->getArgument('modul');
        // Holt Modul Objekt
        $modul = $this->modulRepository->findByUid($modulUid);
        $prueflings = $this->prueflingRepository->findAll();
        $this->view->assign('prueflings', $prueflings);
        // Ausgabe des Fachnamens und des Modulnamens
        $this->view->assign('fach', $fach->getFachname());
        $this->view->assign('modul', $modul->getModulname());
        $this->view->assign('semester', $modul->getGueltigkeitszeitraum());
    }

    /**
     * action show
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @return void
     */
    public function showAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
        $this->view->assign('pruefling', $pruefling);
    }

    /**
     * action new
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $newPruefling
     * @ignorevalidation $newPruefling
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Pruefling $newPruefling = NULL) {
        $this->view->assign('newPruefling', $newPruefling);
    }

    /**
     * action create
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $newPruefling
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Pruefling $newPruefling) {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->prueflingRepository->add($newPruefling);
        $typ = $this->request->getArgument('speichern');

        // Instanzen der Helper Functions
        $passfunctions = new \ReRe\Rere\Services\NestedDirectory\PasswordFunctions();
        $userfunctions = new \ReRe\Rere\Services\NestedDirectory\UserFunctions();
        $mailfunctions = new \ReRe\Rere\Services\NestedDirectory\ReReMailer();

        // Instanz eines neuen Users
        $newUser = new \Typo3\CMS\Extbase\Domain\Model\FrontendUser();


        // Neuen TYPO3 FE_User anlegen
        $newUser->setUsername($userfunctions->genuserName($newPruefling->getVorname(), $newPruefling->getNachname()));

        // Passwort generierung -> Random und dann -> Salt
        $randomPW = $passfunctions->genpassword();
        $saltedPW = $passfunctions->hashPassword($randomPW);

        $newUser->setPassword($saltedPW);
        $newUser->setName($newPruefling->getNachname());
        $newUser->setFirstName($newPruefling->getVorname());
        $newUser->setLastName($newPruefling->getNachname());
        $newUser->setEmail($this->request->getArgument('email'));

        $this->FrontendUserRepository->add($newUser);

        $newPruefling->setTypo3FEUser($newUser);

        $mailerg = $mailfunctions->newUserMail($newUser->getEmail(), $newUser->getUsername, $newPruefling->getNachname(), $newPruefling->getVorname(), $randomPW);
        $this->addFlashMessage($mailerg);

        if ($typ == 'speichernundzurueck') {
            $this->redirect('list', 'Modul');
        } else {
            $this->redirect('new');
        }
    }

    /**
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @ignorevalidation $pruefling
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
        $this->view->assign('pruefling', $pruefling);
    }

    /**
     * action update
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->prueflingRepository->update($pruefling);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->prueflingRepository->remove($pruefling);
        $this->redirect('list');
    }

}

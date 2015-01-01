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

    const MODUL = 'modul';
    const FACH = 'fach';

    private $passfunctions = NULL;
    private $userfunctions = NULL;
    private $mailfunctions = NULL;

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
     * FrontendUserRepository
     *
     * @var \Typo3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $FrontendUserRepository = NULL;

    /**
     * FrontendUserGroupRepository
     *
     * @var \Typo3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $FrontendUserGroupRepository = NULL;

    /**
     * noteRepository
     *
     * @var \ReRe\Rere\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    public function __construct() {
        // Instanzen der Helper Functions
        $this->passfunctions = new \ReRe\Rere\Services\NestedDirectory\PasswordFunctions();
        $this->userfunctions = new \ReRe\Rere\Services\NestedDirectory\UserFunctions();
        $this->mailfunctions = new \ReRe\Rere\Services\NestedDirectory\ReReMailer();
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        // Liest die FachUid Aus
        $fachUID = $this->request->getArgument(self::FACH);
        // Holt FachObjekt
        $fach = $this->fachRepository->findByUid($fachUID);
        // Liest die ModulUid aus
        $modulUid = $this->request->getArgument(self::MODUL);
        // Holt Modul Objekt
        $modul = $this->modulRepository->findByUid($modulUid);
        $prueflings = $this->prueflingRepository->findAll();
        $feUserGroups = $this->FrontendUserGroupRepository->findAll();
        $prueflingsarray = array();
        foreach ($prueflings as $pruefling) {
            array_push($prueflingsarray, $pruefling->getMatrikelnr(), $pruefling->getUid());
        }
        $prueflingsarrayJson = json_encode($prueflingsarray);

        $this->view->assignMultiple(array(
            'prueflings' => $prueflingsarrayJson, 'feusergroups' => $feUserGroups, self::FACH => $fach, self::MODUL => $modul, 'semester' => $modul));
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
        // Instanz eines neuen Users
        $newUser = new \Typo3\CMS\Extbase\Domain\Model\FrontendUser();
        // Neuen TYPO3 FE_User anlegen
        $newUser->setUsername($this->userfunctions->genuserName($newPruefling->getVorname(), $newPruefling->getNachname()));
        // Passwort generierung -> Random und dann -> Salt
        $randomPW = $this->passfunctions->genpassword();
        $saltedPW = $this->passfunctions->hashPassword($randomPW);
        $newUser->setPassword($saltedPW);
        $newUser->setName($newPruefling->getNachname());
        $newUser->setFirstName($newPruefling->getVorname());
        $newUser->setLastName($newPruefling->getNachname());
        $newUser->setEmail($this->request->getArgument('email'));
        $this->FrontendUserRepository->add($newUser);
        $newPruefling->setTypo3FEUser($newUser);
        $mailerg = $this->mailfunctions->newUserMail($newUser->getEmail(), $newUser->getUsername(), $newPruefling->getNachname(), $newPruefling->getVorname(), $randomPW);
        $this->addFlashMessage($mailerg);
        if ($this->request->getArgument('speichern') == 'speichernundzurueck') {
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

    /**
     * Weißt einen Prüfling einem Fach zu. Oder löst die Zuweisung wieder.
     */
    public function setPrueflingAction() {
        // Holt FachObjekt
        if ($this->request->hasArgument(self::FACH)) {
            $fachUID = $this->request->getArgument(self::FACH);
            $fach = $this->fachRepository->findByUid($fachUID);
        }
        // Holt Modul Objekt
        if ($this->request->hasArgument(self::MODUL)) {
            $modulUid = $this->request->getArgument(self::MODUL);
            $modul = $this->modulRepository->findByUid($modulUid);
        }
        // Holt den Prüfling
        if ($this->request->hasArgument('matrikelnr')) {
            $matrikelnr = $this->request->getArgument('matrikelnr');
            $pruefling = $this->prueflingRepository->findOneByMatrikelnr($matrikelnr);
        }
        if ($pruefling == NULL) {
            $this->addFlashMessage('Wählen Sie einen existierenden Prüfling (Grüne Lupe)', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        } else {
            // Prüfling einem Fach zuweisen oder entfernen
            if ($this->request->hasArgument('remove')) {
                // Bezieung setzen
                $fach->removeMatrikelnr($pruefling);
            } else {
                $note = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Note');
                $note->setWert(0);
                $this->noteRepository->add($note);
                // Bezieung setzen
                $fach->addMatrikelnr($pruefling);
                $fach->addNote($note);
                $pruefling->addNote($note);
            }
            $this->fachRepository->add($fach);
        }
        // Weiterleitung auf die selbe Seite.
        $this->redirect('list', 'Pruefling', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

}

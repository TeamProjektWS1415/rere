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
 * Die Klasse PrueflingController verwaltet die Prüflinge.
 * Sie stellt Methoden zum Anlegen, Ändern und Löschen von Prüflingen, der Zuweisung eines Prfülings zu einem FE-User,
 * sowie zum Zuweisen eines Prüflings zu einem Fach bereit.
 *
 */
class PrueflingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const MODUL = 'modul';
    const FACH = 'fach';
    const EMAIL = 'email';
    const VORNAME = 'vorname';
    const NAME = 'name';
    const USRGROUP = 'usergroup';
    const MATRIKELNR = 'matrikelnr';
    const PRUEFLING = 'Pruefling';

    private $passfunctions = NULL;
    private $userfunctions = NULL;
    private $mailfunctions = NULL;

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
     * Protected Variable FrontendUserRepository wird mit NULL initialisiert.
     *
     * @var \Typo3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $FrontendUserRepository = NULL;

    /**
     * Protected Variable FrontendUserGroupRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $FrontendUserGroupRepository = NULL;

    /**
     * Protected Variable noteRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;

    /**
     * Im Konstruktor des PrueflingControllers werden Instanzen der Helper-Functions erzeugt.
     */
    public function __construct() {
        $this->passfunctions = new \ReRe\Rere\Services\NestedDirectory\PasswordFunctions();
        $this->userfunctions = new \ReRe\Rere\Services\NestedDirectory\UserFunctions();
        $this->mailfunctions = new \ReRe\Rere\Services\NestedDirectory\ReReMailer();
    }

    /**
     * Die List-Methode stellt die Informationen zum Rendern der Seite PrueflingZuweisen bereit.
     *
     * @return void
     */
    public function listAction() {
        // Holt Fach-Objekt
        $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
        $fachprueflinge = $fach->getMatrikelnr();
        // Holt Modul-Objekt
        $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
        $prueflings = $this->prueflingRepository->findAll();
        $feUserGroups = $this->FrontendUserGroupRepository->findAll();
        //alle vorhandenen Prüflinge werden in Array gespeichert
        $prueflingsArray = array();
        foreach ($prueflings as $pruefling) {
            array_push($prueflingsArray, $pruefling->getMatrikelnr(), $pruefling->getUid());
        }
        //alle bereits zu diesem Fach zugeordneten Prüflinge werden in Array gespeichert
        $fachprueflingsArray = array();
        foreach ($fachprueflinge as $fachpruefling) {
            array_push($fachprueflingsArray, $fachpruefling->getMatrikelnr(), $fachpruefling->getUid());
        }
        $this->view->assignMultiple(array(
            'prueflings' => json_encode($prueflingsArray), 'feusergroups' => $feUserGroups, self::FACH => $fach, self::MODUL => $modul, 'semester' => $modul, 'fachprueflinge' => json_encode($fachprueflingsArray)
        ));
    }

    /**
     * Einzelner Prüfling wird angezeigt.
     *
     * @return void
     */
    public function showAction() {
        $momentanerPruefling = $this->prueflingRepository->findByUid(1);


        //Suchen der Fächer für die der Student zur Prüfung eingetragen wurde
        $fachPrueflingsArray = array();
        $fachlisteArray = $this->fachRepository->findAll();
        foreach ($fachlisteArray as $fach) {
            $matrikelnummerArray = $fach->getMatrikelnr();
            foreach ($matrikelnummerArray as $matrikel) {
                if ($matrikel->getUid() == $momentanerPruefling->getUid()) {
                    array_push($fachPrueflingsArray, $fach);
                }
            }
        }
        $fachPrueflingsArray = array_reverse($fachPrueflingsArray);


        //Suchen der zum Fach gehörenden Noten
        $aktuelleNote = null;
        $notenArray = $this->noteRepository->findAll();
        foreach ($notenArray as $note) {
            //liefert Prüfling Uid
            $pruefling = $note->getPruefling();
            if ($pruefling == $momentanerPruefling->getUid()) {
                if ($note->getFach() == $fachPrueflingsArray[0]->getUid()) {
                    $aktuelleNote = $note;
                }
            }
        }
        $this->view->assignMultiple(array('fachliste' => $fachPrueflingsArray, 'test' => $test, 'note' => $aktuelleNote));
    }

    /**
     * In dieser Methode wird ein neuer Prüfling erzeugt und sofern vorhanden werden die Attribute aus dem Eingabeformular übernommen.
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $newPruefling
     * @ignorevalidation $newPruefling
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Pruefling $newPruefling = NULL) {
        $feUserGroups = $this->FrontendUserGroupRepository->findAll();

        // Bei Fehleingaben werden die Felder wieder mit den vorherigen Werten vorbelegt.
        $name = '';
        $vorname = '';
        $email = '';
        $matrikelnr = '';
        if ($this->request->hasArgument(self::NAME) && $this->request->hasArgument(self::VORNAME) && $this->request->hasArgument(self::EMAIL)) {
            $name = $this->request->getArgument(self::NAME);
            $vorname = $this->request->getArgument(self::VORNAME);
            $email = $this->request->getArgument(self::EMAIL);
        }

        if ($feUserGroups == Null || $feUserGroups == "") {
            $this->addFlashMessage('Bitte zuerst eine UserGroup anlegen', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }

        if ($this->request->hasArgument(self::MATRIKELNR)) {
            $matrikelnr = $this->request->getArgument(self::MATRIKELNR);
        }
        $this->view->assignMultiple(array(
            'newPruefling' => $newPruefling, self::NAME => $name, self::VORNAME => $vorname, self::EMAIL => $email, self::MATRIKELNR => $matrikelnr, 'usergroups' => $feUserGroups
        ));
    }

    /**
     * In dieser Methode wird der Prüfling als tatsächlicher Frontend-User angelegt, sofern die Matrikelnummer noch nicht vergeben ist.
     * Außerdem wird der Versand einer Bestätigungs-E-Mail an den Prüfling angestoßen.
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $newPruefling
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Pruefling $newPruefling) {
        // Prüft, ob diese MatrikelNr bereits vorhanden ist. Prüfling wird nur angelegt, wenn die MatrikelNr noch nicht verwendet wird!
        if ($this->prueflingRepository->findBymatrikelnr($newPruefling->getMatrikelnr())->toArray() == Null) {

            // Prüfen ob usergroup vorhanden
            if ($this->request->hasArgument(self::USRGROUP)) {
                $usergroup = $this->FrontendUserGroupRepository->findByUid($this->request->getArgument(self::USRGROUP));
            }

            $this->prueflingRepository->add($newPruefling);
            // Instanz eines neuen Users
            $newFEUser = new \Typo3\CMS\Extbase\Domain\Model\FrontendUser();
            // Neuen TYPO3 FE_User anlegen
            $newFEUser->setUsername($this->userfunctions->genuserNAME($newPruefling->getVorname(), $newPruefling->getNachname()));
            // Passwort-Generierung -> Random und dann -> Salt
            $randomPW = $this->passfunctions->genpassword();
            $saltedPW = $this->passfunctions->hashPassword($randomPW);
            $newFEUser->setPassword($saltedPW);
            $newFEUser->setNAME($randomPW);
            $newFEUser->setFirstNAME($newPruefling->getVorname());
            $newFEUser->setLastNAME($newPruefling->getNachname());
            $newFEUser->setEmail($this->request->getArgument(self::EMAIL));

            // Wenn Usergroup vorhanden dann wird diese gesetzt.
            $newFEUser->addUsergroup($usergroup);

            $this->FrontendUserRepository->add($newFEUser);
            $newPruefling->setTypo3FEUser($newFEUser);
            $mailerg = $this->mailfunctions->newUserMail($newFEUser->getEmail(), $newFEUser->getUsername(), $newPruefling->getNachname(), $newPruefling->getVorname(), $randomPW);
            $this->addFlashMessage($mailerg);
            if ($this->request->getArgument('speichern') == 'speichernundzurueck') {
                $this->redirect('list', 'Modul');
            } else {
                $this->redirect('new');
            }
        } else {
            $this->addFlashMessage('Diese Matrikel-Nummer wird bereits verwendet. (' . $newPruefling->getMatrikelnr() . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('new', self::PRUEFLING, Null, array(self::NAME => $newPruefling->getNachname(), self::VORNAME => $newPruefling->getVorname(), self::EMAIL => $this->request->getArgument(self::EMAIL), self::USRGROUP => $this->request->getArgument(self::USRGROUP)));
        }
    }

    /**
     * Diese Methode dient dem Editieren eines Prüflings.
     * Sie wird in der aktuellen Version jedoch so nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @ignorevalidation $pruefling
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
        $this->view->assign('pruefling', $pruefling);
    }

    /**
     * Diese Methode dient dem Aktualisieren eines Prüflings.
     * Sie wird in der aktuellen Version jedoch so nicht verwendet.
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
     * Diese Methode dient dem Löschen eines Prüflings.
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
     * Weist einen Prüfling einem Fach zu oder löst die Zuweisung wieder auf.
     */
    public function setPrueflingAction() {
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        // Holt Fach-Objekt, Modul-Objekt und den Prüfling
        if ($this->request->hasArgument(self::FACH) && $this->request->hasArgument(self::MODUL) && $this->request->hasArgument(self::MATRIKELNR)) {
            $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
            $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
            $pruefling = $this->prueflingRepository->findOneByMatrikelnr($this->request->getArgument(self::MATRIKELNR));
        }
        if ($pruefling == NULL) {
            $this->addFlashMessage('Wählen Sie einen existierenden Prüfling (Grüne Lupe)', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        } else {
            // Prüfling einem Fach zuweisen oder entfernen
            if ($this->request->hasArgument('remove')) {

                $noten = $fach->getNote();
                foreach ($noten as $note) {
                    if ($note->getPruefling() == $pruefling->getUid()) {
                        $requestedNote = $note;
                    }
                }
                $fach->removeNote($requestedNote);
                $pruefling->removeNote($requestedNote);
                // Beziehung setzen
                $fach->removeMatrikelnr($pruefling);
                $this->fachRepository->update($fach);
                $persistenceManager->persistAll();
                $this->noteRepository->remove($requestedNote);
            } else {
                $note = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Note');
                $note->setWert(0);
                $this->noteRepository->add($note);
                // Beziehung setzen
                $fach->addMatrikelnr($pruefling);
                $fach->addNote($note);
                $pruefling->addNote($note);
            }
            $this->fachRepository->add($fach);
        }
        // Weiterleitung auf die selbe Seite.
        $this->redirect('list', self::PRUEFLING, Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

    /**
     * Diese Funktion weißt eine ganze UserGruppe dem Fach zu. Ein Prüfling kann einem Fach nur 1x Zugewiesen werden.
     */
    public function userGroupZuweisenAction() {
        // Persistenz Manager
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');

        // Prüft ob alle nötigen Argumente vorhanden sind.
        if ($this->request->hasArgument(self::FACH) && $this->request->hasArgument(self::MODUL) && $this->request->hasArgument(self::USRGROUP)) {
            $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
            $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
            $userGroup = $this->FrontendUserGroupRepository->findByUid($this->request->getArgument(self::USRGROUP));
        } else {
            $this->addFlashMessage('UserGroup auswählen', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('list', self::PRUEFLING, Null, array(self::FACH => $fach, self::MODUL => $modul));
        }

        $feusers = $this->FrontendUserRepository->findAll();
        $prueflinge = $this->prueflingRepository->findAll();
        foreach ($feusers as $feuser) {
            // Wenn die UserGroup des FEUsers = der Ausgewählten Usergroup
            if ((int) $feuser->getUsergroup() == (int) $userGroup) {
                foreach ($prueflinge as $pruefling) {
                    // Prüft ob der Prüfling bereits zugewiesen wurde
                    $checkList = $this->userfunctions->checkMatrikelNr($fach->getMatrikelnr(), $pruefling->getMatrikelnr());
                    $checkVar = "TYPO3\CMS\Extbase\Domain\Model\FrontendUser:" . $feuser->getUid();
                    if ($pruefling->getTypo3FEUser() == $checkVar && $checkList == 1) {
                        //echo $this->userfunctions->checkMatrikelNr($matrikelNummern, $pruefling->getMatrikelNr());
                        $note = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Note');
                        $note->setWert(0);
                        $this->noteRepository->add($note);
                        // Beziehung setzen
                        $fach->addMatrikelnr($pruefling);
                        $fach->addNote($note);
                        $pruefling->addNote($note);
                        $this->fachRepository->add($fach);
                        // Persistieren aller Losen objekte.
                        $persistenceManager->persistAll();
                    }
                }
            }
        }
        // Weiterleitung auf die selbe Seite.
        $this->redirect('list', self::PRUEFLING, Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

}

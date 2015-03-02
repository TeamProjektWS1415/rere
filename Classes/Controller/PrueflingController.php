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
 * Die Klasse PrueflingController verwaltet die PrÃ¼flinge.
 * Sie stellt Methoden zum Anlegen, Ã„ndern und LÃ¶schen von PrÃ¼flingen, der Zuweisung eines PrfÃ¼lings zu einem FE-User,
 * sowie zum Zuweisen eines PrÃ¼flings zu einem Fach bereit.
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
    const FACHID = "fachid";
    const ERR = "err";

    private $passfunctions = NULL;
    private $userfunctions = NULL;
    private $mailfunctions = NULL;

    /**
     * Private Klassenvariable fÃ¼r die Notenlisten wird mit NULL initialisiert.
     *
     * @var type
     */
    private $noteList = NULL;

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
     * Protected Variable settingsRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\SettingsRepository
     * @inject
     */
    protected $settingsRepository = NULL;

    /**
     * Private Klassenvariable fÃ¼r die Hilfsklassen wird mit NULL initialisiert.
     *
     * @var type
     */
    private $helper = NULL;

    /**
     * @var Tx_Extbase_Service_CacheService
     * @inject
     */
    protected $cacheService;

    /**
     * Im Konstruktor des PrueflingControllers werden Instanzen der Helper-Functions erzeugt.
     */
    public function __construct() {
	$this->passfunctions = new \ReRe\Rere\Services\NestedDirectory\PasswordFunctions();
	$this->userfunctions = new \ReRe\Rere\Services\NestedDirectory\UserFunctions();
	$this->mailfunctions = new \ReRe\Rere\Services\NestedDirectory\ReReMailer();
	$this->noteList = new \ReRe\Rere\Services\NestedDirectory\NoteSchemaArrays();
	$this->helper = new \ReRe\Rere\Services\NestedDirectory\NotenVerwaltungHelper();
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
	//alle vorhandenen PrÃ¼flinge werden in Array gespeichert
	$prueflingsArray = array();
	foreach ($prueflings as $pruefling) {
	    array_push($prueflingsArray, $pruefling->getMatrikelnr(), $pruefling->getUid());
	}
	//alle bereits zu diesem Fach zugeordneten PrÃ¼flinge werden in Array gespeichert
	$fachprueflingsArray = array();
	foreach ($fachprueflinge as $fachpruefling) {
	    array_push($fachprueflingsArray, $fachpruefling->getMatrikelnr(), $fachpruefling->getUid());
	}
	$this->view->assignMultiple(array(
	    'prueflings' => json_encode($prueflingsArray), 'feusergroups' => $feUserGroups, self::FACH => $fach, self::MODUL => $modul, 'semester' => $modul, 'fachprueflinge' => json_encode($fachprueflingsArray)
	));
    }

    /**
     * Error.
     *
     * @return void
     */
    public function errAction() {
	$this->view->assign('error', $this->request->getArgument(self::ERR));
    }

    /**
     * Einzelner Pruefling wird angezeigt.
     *
     * @return void
     */
    public function showAction() {

	//Cache leeren damit View richtig angezeigt wird
	$pageUid = $GLOBALS['TSFE']->id;
	$this->cacheService->clearPageCache($pageUid);

	$querySettings = $this->prueflingRepository->createQuery()->getQuerySettings();
	// don't add the pid constraint
	$querySettings->setRespectStoragePage(FALSE);
	$this->prueflingRepository->setDefaultQuerySettings($querySettings);

	//Aktuellen FE-User und zugehoeriges Prueflingobjekt holen
	$momentanerUserUID = $GLOBALS['TSFE']->fe_user->user['uid'];

	// Prüfen ob eingeloggt
	if ($momentanerUserUID == null || $momentanerUserUID == "") {
	    $this->redirect('err', 'Pruefling', null, array(self::ERR => "login"));
	}

	// Holt den Prüfling der mit dem FEUser verknüpft ist
	$momentanerPruefling = $this->prueflingRepository->findOneBytypo3FEUser($momentanerUserUID);

	//Suchen der Faecher für die der gewählte Student zur Pruefung eingetragen wurde
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

	// Meldung falls der Prüfling noch kener Prüfung zugewiesen wurde
	if (count($fachPrueflingsArray) == 0) {
	    $this->redirect('err', 'Pruefling', null, array(self::ERR => "keinepruefung"));
	}

	// Berechnet den Gesamtdurchschnitt eines Prüflings
	$gesamtDurchschnitt = $this->genAVG($momentanerPruefling->getUid());

	// Array mit Modulen + fächern
	$liste = array();
	$module = $this->modulRepository->findAll();
	$faecher = $this->fachRepository->findAll();

	$checkvar = false;

	// fächer durchlafen
	foreach ($module as $modul) {
	    $fachtemp = array();
	    // Module durchlaufen
	    foreach ($faecher as $fach) {
		// Fach in Modul prüfen
		if ($fach->getModulnr() == $modul->getUid()) {

		    // Prüfen ob Student dafür angemeldte ist
		    $matrikelnummerArray = $fach->getMatrikelnr();
		    foreach ($matrikelnummerArray as $matrikel) {
			if ($matrikel->getUid() == $momentanerPruefling->getUid()) {
			    if (!$checkvar) {
				$checkvar = true;
			    }

			    // Holt die Note des Prüflings
			    $notenArray = $this->noteRepository->findAll();
			    foreach ($notenArray as $note) {
				//liefert Pruefling Uid
				if ($note->getPruefling() == $momentanerPruefling->getUid() && $note->getFach() == $fach->getUid()) {
				    $aktuelleNote = $note;
				}
			    }

			    // Array mit den Fach Details
			    $fachDetails = $this->getDetailsInfos($fach);

			    $fachtotransmit = array(
				"fachuid" => $fach->getUid(),
				"pruefer" => $fach->getPruefer(),
				"fachname" => $fach->getFachname(),
				"creditpoints" => $fach->getCreditpoints(),
				"note" => $aktuelleNote->getWert(),
				"kommentar" => $aktuelleNote->getKommentar(),
				"details" => $fachDetails);

			    array_push($fachtemp, $fachtotransmit);
			}
		    }
		}
	    }


	    // Wenn er Prüfungen in diesem Modul hat werden diese hinzugefügt.
	    if ($checkvar) {
		$modul = array("modulname" => $modul->getModulname(), "modulnr" => $modul->getModulnr(), "gueltigkeitszeitraum" => $modul->getGueltigkeitszeitraum(), "faecher" => $fachtemp);
		array_push($liste, $modul);
	    }

	    $checkvar = false;
	}

	$liste = array_reverse($liste);

	$this->view->assignMultiple(array('gesamtDurchschnitt' => $gesamtDurchschnitt, "module" => $liste, 'pruefling' => $momentanerPruefling, 'note' => $aktuelleNote));
    }

    /**
     * Generiert die Infos zum Jeweiligen Fach
     * @param type $fach Fach Objekt
     * @return type array
     */
    protected function getDetailsInfos($fach) {

	//Suchen der zum Fach gehoerenden Noten
	$notenZuFachArray = array();
	$notenArray = $this->noteRepository->findAll();
	foreach ($notenArray as $note) {
	    //sammelt sämtliche Noten des gesuchten Faches
	    if ($note->getFach() == $fach->getUid()) {
		array_push($notenZuFachArray, $note);
	    }
	}

	//Notenschema des gewaehlten fachs
	$notenListeArray = $this->noteList->getMarkArray($fach->getNotenschema());
	unset($notenListeArray[0]);

	//Verteilung der verschiedenen Noten zaehlen
	$notenVorkommnisseArray = null;
	$notenVorkommnisseArray = $this->helper->genArray($notenZuFachArray, $fach->getNotenschema());

	//Zusammenfuehren von Bezeichnung und Anzahl der Notenvorkommen
	$notenVerteilungArray = array();
	$counter = -1;
	$temp = array();
	foreach ($notenVorkommnisseArray as $wert) {
	    array_push($temp, $wert);
	}

	foreach ($notenListeArray as $notenWert) {
	    $counter++;
	    array_push($notenVerteilungArray, array(notenname => $notenWert, wert => $temp[$counter]));
	}

	//Statistische Auswertung des Fachs
	$anzahlPrueflinge = count($notenZuFachArray);
	$durchschnitt = $this->helper->calculateAverage($notenZuFachArray);

	//Notevorkommnisse fuers Javascript lesbar machen
	$notenVorkommnisseCharArrayJson = json_encode($notenVorkommnisseArray);

	return array('notenVerteilungArray' => $notenVerteilungArray, 'durchschnitt' => $durchschnitt, 'anzahlPrueflinge' => $anzahlPrueflinge, 'chartArray' => $notenVorkommnisseCharArrayJson);
    }

    /**
     * Methode um den Gesamtdurchschnitt eines Prüflings über alle seine Prüfungen hinweg zu berechnen.
     * @param type $pruefling Uid
     * @return type Double
     */
    protected function genAVG($pruefling) {
	$noten = $this->noteRepository->findAll();
	$counter = 0;
	$sum = 0;
	foreach ($noten as $note) {
	    if ($pruefling == $note->getPruefling() && $note->getWert() != NULL && $note->getWert() != " " && $note->getWert() != 0) {
		$sum = $sum + $note->getWert();
		$counter++;
	    }
	}
	return round($sum / $counter, 2);
    }

    /**
     * In dieser Methode wird ein neuer PrÃ¼fling erzeugt und sofern vorhanden werden die Attribute aus dem Eingabeformular Ã¼bernommen.
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
     * Außerdem wird der Versand einer Bestätigungs-E-Mail an den Pruefling angestossen.
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $newPruefling
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Pruefling $newPruefling) {
	$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
	// Prueft, ob diese MatrikelNr bereits vorhanden ist. Pruefling wird nur angelegt, wenn die MatrikelNr noch nicht verwendet wird!
	if ($this->prueflingRepository->findBymatrikelnr($newPruefling->getMatrikelnr())->toArray() == Null) {

	    // Pruefen ob usergroup vorhanden
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
	    $newFEUser->setNAME($newPruefling->getNachname());
	    $newFEUser->setFirstNAME($newPruefling->getVorname());
	    $newFEUser->setLastNAME($newPruefling->getNachname());
	    $newFEUser->setEmail($this->request->getArgument(self::EMAIL));
	    $newFEUser->setPID($usergroup->getPid());

	    // Wenn Usergroup vorhanden dann wird diese gesetzt.
	    $newFEUser->addUsergroup($usergroup);

	    $absender = $this->settingsRepository->findByUid(1)->getMailAbsender();

	    $this->FrontendUserRepository->add($newFEUser);
	    $newPruefling->setTypo3FEUser($newFEUser);

	    $persistenceManager->persistAll();

	    $mailerg = $this->mailfunctions->newUserMail($newFEUser->getEmail(), $newFEUser->getUsername(), $newPruefling->getNachname(), $newPruefling->getVorname(), $randomPW, $absender);
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
     * Diese Methode dient dem Editieren eines Prueflings.
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
     * Diese Methode dient dem Aktualisieren eines Prueflings.
     * Sie wird in der aktuellen Version jedoch so nicht verwendet.
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
	$this->prueflingRepository->update($pruefling);
	$this->redirect('list');
    }

    /**
     * Diese Methode dient dem LÃ¶schen eines PrÃ¼flings.
     *
     * @param \ReRe\Rere\Domain\Model\Pruefling $pruefling
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Pruefling $pruefling) {
	$this->prueflingRepository->remove($pruefling);
	$this->redirect('list');
    }

    /**
     * Weist einen PrÃ¼fling einem Fach zu oder lÃ¶st die Zuweisung wieder auf.
     */
    public function setPrueflingAction() {
	$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
	// Holt Fach-Objekt, Modul-Objekt und den PrÃ¼fling
	if ($this->request->hasArgument(self::FACH) && $this->request->hasArgument(self::MODUL) && $this->request->hasArgument(self::MATRIKELNR)) {
	    $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
	    $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
	    $pruefling = $this->prueflingRepository->findOneByMatrikelnr($this->request->getArgument(self::MATRIKELNR));
	}
	if ($pruefling == NULL) {
	    $this->addFlashMessage('Wählen Sie einen existierenden Prüfling (Grüne Lupe)', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
	    $this->redirect('list', self::PRUEFLING, Null, array(self::FACH => $fach, self::MODUL => $modul));
	}
	// Pruefling einem Fach zuweisen oder entfernen
	if ($this->request->hasArgument('remove')) {
	    $noten = $fach->getNote();
	    foreach ($noten as $note) {
		if ($note->getPruefling() == $pruefling->getUid()) {
		    $requestedNote = $note;
		}
	    }
	    $fach->removeNote($requestedNote);
	    $pruefling->removeNote($requestedNote);
	    $this->prueflingRepository->update($pruefling);
	    // Beziehung setzen
	    $fach->removeMatrikelnr($pruefling);
	    $this->fachRepository->update($fach);
	    $persistenceManager->persistAll();
	    $this->noteRepository->remove($requestedNote);
	} else {
	    $note = $this->genNote();
	    // Beziehung setzen
	    $fach->addMatrikelnr($pruefling);
	    $fach->addNote($note);
	    $pruefling->addNote($note);
	}
	$this->fachRepository->add($fach);

	// Weiterleitung auf die selbe Seite.
	$this->redirect('list', self::PRUEFLING, Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

    /**
     * Diese Funktion weisst eine ganze UserGruppe dem Fach zu. Ein Pruefling kann einem Fach nur 1x Zugewiesen werden.
     */
    public function userGroupZuweisenAction() {
	// Persistenz Manager
	$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');

	// PrÃ¼ft ob alle nÃ¶tigen Argumente vorhanden sind.
	if ($this->request->hasArgument(self::FACH) && $this->request->hasArgument(self::MODUL) && $this->request->hasArgument(self::USRGROUP)) {
	    $fach = $this->fachRepository->findByUid($this->request->getArgument(self::FACH));
	    $modul = $this->modulRepository->findByUid($this->request->getArgument(self::MODUL));
	    $userGroup = $this->FrontendUserGroupRepository->findByUid($this->request->getArgument(self::USRGROUP));
	} else {
	    $this->addFlashMessage('UserGroup auswaehlen', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
	    $this->redirect('list', self::PRUEFLING, Null, array(self::FACH => $fach, self::MODUL => $modul));
	}

	$querySettings = $this->FrontendUserRepository->createQuery()->getQuerySettings();
	// don't add the pid constraint
	$querySettings->setRespectStoragePage(FALSE);
	$this->FrontendUserRepository->setDefaultQuerySettings($querySettings);

	$feusers = $this->FrontendUserRepository->findAll();
	$prueflinge = $this->prueflingRepository->findAll();
	foreach ($feusers as $feuser) {
	    // Wenn die UserGroup des FEUsers = der Ausgewählten Usergroup
	    if ((int) $feuser->getUsergroup() == (int) $userGroup) {
		foreach ($prueflinge as $pruefling) {
		    // Prueft ob der Pruefling bereits zugewiesen wurde
		    $checkList = $this->userfunctions->checkMatrikelNr($fach->getMatrikelnr(), $pruefling->getMatrikelnr());
		    $checkVar = "TYPO3\CMS\Extbase\Domain\Model\FrontendUser:" . $feuser->getUid();
		    if ($pruefling->getTypo3FEUser() == $checkVar && $checkList == 1) {
			echo "true";
			$note = $this->genNote();
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

    /**
     * Diese Methode Legt eine neue Note an und speichert diese im Repository.
     * @return type
     */
    protected function genNote() {
	$note = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Note');
	$note->setWert(0);
	$this->noteRepository->add($note);
	return $note;
    }

}

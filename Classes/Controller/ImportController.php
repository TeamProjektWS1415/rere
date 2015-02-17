<?php

namespace ReRe\Rere\Controller;

/**

 * Der ImportController enthält alle Funktionen zum Importieren von Daten.
 *
 * @author Felix
 */
class ImportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const TITLE = 'title';
    const LABLE = 'lable';
    const IMPORT = "Import";
    const IMPORTKLEIN = "import";
    const ERRORLIST = "errorlist";

    private $passfunctions = NULL;
    private $userfunctions = NULL;
    private $mailfunctions = NULL;
    private $persistenceManager = NULL;
    protected $notImported = NULL;

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
     * Protected Variable settingsRepository wird mit NULL initialisiert.
     *
     * @var \ReRe\Rere\Domain\Repository\SettingsRepository
     * @inject
     */
    protected $settingsRepository = NULL;

    /**
     * Protected Variable objectManager wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager = NULL;

    /**
     * Im Konstruktor des ImportControllers werden Instanzen der Helper-Functions erzeugt.
     */
    public function __construct() {
        $this->passfunctions = new \ReRe\Rere\Services\NestedDirectory\PasswordFunctions();
        $this->userfunctions = new \ReRe\Rere\Services\NestedDirectory\UserFunctions();
        $this->mailfunctions = new \ReRe\Rere\Services\NestedDirectory\ReReMailer();
        $this->persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
    }

    /**
     * View-Rendering für Import
     */
    public function newAction() {
        if ($this->request->hasArgument('type')) {
            $type = $this->request->getArgument('type');

            // Prüfung, um welchen Import-Typ es sich handelt.
            if ($type == "prueflinge") {

                if ($this->request->hasArgument(self::ERRORLIST)) {
                    $errorlist = $this->request->getArgument(self::ERRORLIST);
                } else {
                    $errorlist = "";
                }

                $usergroups = $this->FrontendUserGroupRepository->findAll();
                $this->view->assignMultiple(array(self::TITLE => 'Import Prüflinge', self::LABLE => 'CSV-Datei mit Prüflingen', type => $type, usergroups => $usergroups, errorlist => $errorlist));
            } elseif ($type == "backup") {
                $this->view->assignMultiple(array(self::TITLE => 'Import Backup', self::LABLE => 'SQL-Backup', type => $type));
            } else {
                $this->view->assignMultiple(array(self::TITLE => 'Import Fach', self::LABLE => 'Fach Import', type => $type));
            }
        }
    }

    /**
     * This method imports Students oder Schoolmates from an CSV file.
     * @return void
     */
    public function importPrueflingeAction() {
        // Holt alle Usergroups
        $usergroup = $this->request->getArgument("usergroup");
        $usergroups = $this->FrontendUserGroupRepository->findAll();
        if ($this->request->hasArgument(self::IMPORTKLEIN) && $_FILES[self::IMPORTKLEIN]['error'] == 0) {
            // Holt die Datei
            $file = $this->request->getArgument(self::IMPORTKLEIN);
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            // Prüfung ob die Dateiendung korrekt ist.
            if ($ext != "csv") {
                $this->addFlashMessage('Falsche Dateiendung, es sind nur CSV-Dateien gültig.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                $this->view->assignMultiple(array(self::TITLE => 'Import Prüflinge', self::LABLE => 'CSV-Datei mit Prüflingen', type => $this->request->getArgument('type'), usergroups => $usergroups));
            }
            $this->parseCSV($file["tmp_name"], $usergroup);
        } else {
            $this->addFlashMessage('Keine Datei gewählt', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
        $this->redirect('new', 'Import', Null, array(self::TITLE => 'Import Prüflinge', self::LABLE => 'CSV-Datei mit Prüflingen', type => $this->request->getArgument('type'), usergroups => $usergroups, errorlist => "$this->notImported"));
    }

    /**
     * @return void
     */
    public function importBackupAction() {
        $this->redirect(self::IMPORT);
    }

    /**
     * Parst eine CSV Datei.
     * @param type $file
     */
    protected function parseCSV($file, $usergroup) {
        // Zählen der Zeilen - Wird benötit um die letzte zeile zu ignorieren.
        $csvFileForLines = fopen($file, "r");
        $numberOfLines = 0;
        while (($data = fgetcsv($csvFileForLines, 2000, ";")) !== FALSE) {
            $numberOfLines ++;
        }
        fclose($csvFileForLines);

        // Parsen der Datei
        $csvFile = fopen($file, "r");
        $row = 1;

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            $num = count($data);
            $row++;
            $pruefling = array();
            // Überspringen der ersten 4 Zeilen
            if ($row > 5 && $numberOfLines >= $row) {
                for ($c = 0; $c < $num; $c++) {
                    array_push($pruefling, $data[$c]);
                }
            }
            $this->createPruefling($pruefling, $usergroup);
        }
        fclose($csvFile);
    }

    /**
     * Pruefling und FEUser werden angelegt.
     * @param type $prueflingInfos Beinhaltet den ausgelesenen Prüfling
     * @param type $usergroupIN Usergruppe der der User zugewiesen werden soll
     */
    protected function createPruefling($prueflingInfos, $usergroupIN) {
        // Erzeugen des Prüflings
        $pruefling = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Pruefling');
        $pruefling->setVorname($prueflingInfos[2]);
        $pruefling->setNachname($prueflingInfos[1]);
        $pruefling->setMatrikelnr($prueflingInfos[0]);

        // Alle Prüflinge holen
        $allPrueflinge = $this->prueflingRepository->findAll();
        $status = true;

        // Prüfen die Matrikel Nummer bereits vergeben ist.
        foreach ($allPrueflinge as $p) {
            if ($p->getMatrikelnr() == $pruefling->getMatrikelnr()) {
                $status = false;
                break;
            }
        }

        // Prueft, ob diese MatrikelNr bereits vorhanden ist. Pruefling wird nur angelegt, wenn die MatrikelNr noch nicht verwendet wird!
        if ($status && $pruefling->getMatrikelnr() != NULL && $pruefling->getMatrikelnr() != "") {
            // Prüfling persistieren
            $this->prueflingRepository->add($pruefling);
            $usergroup = $this->FrontendUserGroupRepository->findByUid($usergroupIN);
            // Instanz eines neuen Users
            $newFEUser = new \Typo3\CMS\Extbase\Domain\Model\FrontendUser();
            // Neuen TYPO3 FE_User anlegen
            $username = $this->userfunctions->genuserNAME($pruefling->getVorname(), $pruefling->getNachname());
            $newFEUser->setUsername($username);
            // Passwort-Generierung -> Random und dann -> Salt
            $randomPW = $this->passfunctions->genpassword();
            $saltedPW = $this->passfunctions->hashPassword($randomPW);
            $newFEUser->setPassword($saltedPW);
            $newFEUser->setNAME($pruefling->getNachname());
            $newFEUser->setFirstNAME($pruefling->getVorname());
            $newFEUser->setLastNAME($pruefling->getNachname());

            if ($prueflingInfos[7] == "" | $prueflingInfos[7] == Null) {
                $empfaengerMail = $$username . $this->settingsRepository->findByUid(1)->getEmpfaengerEmail();
            } else {
                $empfaengerMail = $prueflingInfos[7];
            }

            $newFEUser->setEmail($empfaengerMail);
            $newFEUser->setPID($usergroup->getPid());

            // Wenn Usergroup vorhanden dann wird diese gesetzt.
            $newFEUser->addUsergroup($usergroup);
            $absender = $this->settingsRepository->findByUid(1)->getMailAbsender();

            // FE User Persistieren und Zuwesen des FEUseres zum Pruefling
            $this->FrontendUserRepository->add($newFEUser);
            $pruefling->setTypo3FEUser($newFEUser);
            $this->persistenceManager->persistAll();
            $this->prueflingRepository->update($pruefling);

            // Mail an den Prüfling versenden
            $this->mailfunctions->newUserMail($newFEUser->getEmail(), $newFEUser->getUsername(), $pruefling->getNachname(), $pruefling->getVorname(), $randomPW, $absender);
        } else {
            if ($prueflingInfos[0] != Null || $prueflingInfos[0] != "") {
                // Wenn Ein Matrikel-Nummer bereits vorhanden war wird diese in die Rückgabeliste gespeichert
                $this->notImported = $this->notImported . " " . $prueflingInfos[0] . ": " . $prueflingInfos[2] . ", " . $prueflingInfos[1] . " | ";
            }
        }
    }

}

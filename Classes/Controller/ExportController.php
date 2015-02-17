<?php

namespace ReRe\Rere\Controller;

/**
 *
 * Beinhaltet alle Funktionen für den Export von Prüflingen, Modulen und Fächern.
 *
 * @author Felix
 */
class ExportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    const MODUL = 'modul';
    const FACH = 'fach';

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
     * Private Klassenvariable für die Hilfsklassen wird mit NULL initialisiert.
     *
     * @var type
     */
    private $exportHelper = NULL;

    /**
     * Protected Variable FrontendUserRepository wird mit NULL initialisiert.
     *
     * @var \Typo3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $FrontendUserRepository = NULL;

    /**
     * Im Konstruktor des ExportControllers wird eine Instanz der ExportHelperKlasse erzeugt.
     */
    public function __construct() {
        $this->exportHelper = new \ReRe\Rere\Services\NestedDirectory\ExportHelper();
    }

    /**
     * @return void
     */
    public function exportPrueflingeAction() {
        $preuflinge = $this->prueflingRepository->findAll();
        $out = array();
        foreach ($preuflinge as $pruefling) {
            // Generiert Ausgabe-Array mit Prüfling- und Noten-Daten
            $feUser = $pruefling->getTypo3FEUser();
            array_push($out, array('matrikelnr' => $pruefling->getMatrikelnr(), 'prueflingvorname' => $pruefling->getVorname(), 'prueflingnachname' => $pruefling->getNachname(), 'mail' => $feUser->getEmail(), 'username' => $feUser->getUsername(), 'pass' => $feUser->getPassword()));
        }

        // Export wird gestartet
        $this->exportHelper->genCSV($out, "Prueflinge.csv");
        return false;
    }

    /**
     * Exportiert alle Modulle und alle Fächer
     * @return void
     */
    public function exportModuleUndFaecherAction() {
        $fachs = $this->fachRepository->findAll();
        $out = array();
        foreach ($fachs as $fach) {
            array_push($out, array('FachNr' => $fach->getFachnr(), 'Fachname' => $fach->getFachname(),
                'pruefer' => $fach->getPruefer(), 'Notenschema' => $fach->getNotenschema(), 'ModulUid' => $fach->getModulnr(),
                'ModulNr' => $this->modulRepository->findByUid($fach->getModulnr())->getModulnr(),
                'ModulName' => $this->modulRepository->findByUid($fach->getModulnr())->getModulname(),
                'Gueltigkeitszeitraum' => $this->modulRepository->findByUid($fach->getModulnr())->getGueltigkeitszeitraum()));
        }

        // Export wird gestartet
        $this->exportHelper->genCSV($out, "ModuleUndFaecher.csv");
        return false;
    }

    /**
     * Exportiert alle Noten eines Faches.
     * @return void Description
     */
    public function exportFachAction() {
        if ($this->request->hasArgument('fachuid')) {
            $fach = $this->fachRepository->findByUid($this->request->getArgument('fachuid'));
        }

        // Holen aller eingetragener Noten
        $notes = $this->noteRepository->findAll();
        $publisharray = array();
        foreach ($notes as $note) {
            if ($note->getFach() == $fach->getUid()) {
                // Holt den Prüfling, dem die Note zugewiesen wurde
                $pruefling = $this->prueflingRepository->findByUid($note->getPruefling());
                // Generiert Ausgabe-Array mit Prüfling- und Noten-Daten
                array_push($publisharray, array('matrikelnr' => $pruefling->getMatrikelnr(), 'prueflingvorname' => $pruefling->getVorname(), 'prueflingnachname' => $pruefling->getNachname(), 'wert' => $note->getWert(), 'kommentar' => $note->getKommentar()));
            }
        }

        // Export wird gestartet
        $this->exportHelper->genCSV($publisharray, "FachExport.csv");
        return false;
    }

}

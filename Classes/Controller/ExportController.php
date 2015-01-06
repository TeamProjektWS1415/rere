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
    }

    /**
     * @return void
     */
    public function exportModuleUndFaecherAction() {


        if ($this->request->hasArgument('modul')) {
            $modul = $this->modulRepository->findByUid($this->request->getArgument('modul'));
        }

        $this->redirect('list', 'Modul');
    }

    /**
     * Exportiert alle Noten eines Faches.
     * @return void Description
     */
    public function exportFachAction() {
        if ($this->request->hasArgument('fachuid')) {
            $fach = $this->fachRepository->findByUid($this->request->getArgument('fachuid'));
        }
        if ($this->request->hasArgument('modul')) {
            $modul = $this->modulRepository->findByUid($this->request->getArgument('modul'));
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
        //$this->redirect('list', 'Note', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

}

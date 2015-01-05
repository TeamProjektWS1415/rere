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
     * Im Konstruktor des ExportControllers wird eine Instanz der ExportHelperKlasse erzeugt.
     */
    public function __construct() {
        $this->exportHelper = new \ReRe\Rere\Services\NestedDirectory\ExportHelper();
    }

    /**
     * @return void
     */
    public function exportPrueflingeAction() {
        $this->redirect('list', 'Modul');
    }

    /**
     * @return void
     */
    public function exportModuleUndFaecherAction() {
        $this->redirect('list', 'Modul');
    }

    /**
     * Exportiert alle Noten eines Faches.
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
                array_push($publisharray, array('prueflingvorname' => $pruefling->getVorname(), 'matrikelnr' => $pruefling->getMatrikelnr(), 'prueflingnachname' => $pruefling->getNachname(), 'uid' => $note->getUid(), 'wert' => $note->getWert(), 'kommentar' => $note->getKommentar()));
            }
        }

        // Export wird gestartet
        $this->exportHelper->genCSV($publisharray, "FachExport.csv");

        //$this->redirect('list', 'Note', Null, array(self::FACH => $fach, self::MODUL => $modul));
    }

}

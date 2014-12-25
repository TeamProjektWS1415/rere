<?php

namespace ReRe\Rere\Controller;

/**
 * Description of ExportController

 * Beinhaltet alle Funktionen für den Export von Prüflingen und Modulen und Fächern.
 *
 * @author Felix
 */
class ExportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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
        $this->redirect('list', 'Note');
    }

}

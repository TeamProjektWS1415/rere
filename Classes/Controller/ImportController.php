<?php

namespace ReRe\Rere\Controller;

/**
 * Description of ImportController
 *
 * Alle Funktionen um Daten zu Importieren
 *
 * @author Felix
 */
class ImportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * View Rendering für Import
     */
    public function newAction() {

        $type = $this->request->getArgument('type');

        // Prüfung um welchen Import Typ es sich handelt.
        if ($type == "prueflinge") {
            $this->view->assign('title', 'Import Prüflinge');
            $this->view->assign('lable', 'XML-Datei mit Prüflingen');
        } elseif ($type == "backup") {
            $this->view->assign('title', 'Import Backup');
            $this->view->assign('lable', 'SQL-Backup');
        } else {
            $this->view->assign('title', 'Import Fach');
            $this->view->assign('lable', 'Fach Import');
        }
    }

    /**
     * @return void
     */
    public function importPrueflingeAction() {
        $this->redirect('import');
    }

    /**
     * @return void
     */
    public function importBackupAction() {
        $this->redirect('import');
    }

}

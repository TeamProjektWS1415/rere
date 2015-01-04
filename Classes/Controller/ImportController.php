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
    const IMPORT = "import";

    /**
     * View-Rendering für Import
     */
    public function newAction() {
        if ($this->request->hasArgument('type')) {
            $type = $this->request->getArgument('type');

            // Prüfung, um welchen Import-Typ es sich handelt.
            if ($type == "prueflinge") {
                $this->view->assign(self::TITLE, 'Import Prüflinge');
                $this->view->assign(self::LABLE, 'XML-Datei mit Prüflingen');
            } elseif ($type == "backup") {
                $this->view->assign(self::TITLE, 'Import Backup');
                $this->view->assign(self::LABLE, 'SQL-Backup');
            } else {
                $this->view->assign(self::TITLE, 'Import Fach');
                $this->view->assign(self::LABLE, 'Fach Import');
            }
        }
    }

    /**
     * @return void
     */
    public function importPrueflingeAction() {
        $this->redirect(self::IMPORT);
    }

    /**
     * @return void
     */
    public function importBackupAction() {
        $this->redirect(self::IMPORT);
    }

}

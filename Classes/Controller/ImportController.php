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
     * View-Rendering für Import
     */
    public function newAction() {
        if ($this->request->hasArgument('type')) {
            $type = $this->request->getArgument('type');

            // Prüfung, um welchen Import-Typ es sich handelt.
            if ($type == "prueflinge") {
                $usergroups = $this->FrontendUserGroupRepository->findAll();
                $this->view->assignMultiple(array(self::TITLE => 'Import Prüflinge', self::LABLE => 'XML-Datei mit Prüflingen', type => $type, usergroups => $usergroups));
            } elseif ($type == "backup") {
                $this->view->assignMultiple(array(self::TITLE => 'Import Backup', self::LABLE => 'SQL-Backup', type => $type));
            } else {
                $this->view->assignMultiple(array(self::TITLE => 'Import Fach', self::LABLE => 'Fach Import', type => $type));
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

<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ReRe.' . $_EXTKEY, 'Rerefrontend', array(
    'Modul' => 'list, show, new, newFach, create, edit, update, delete',
    'Fach' => 'list, show, new, create, edit, update, delete',
    'Note' => 'list, show, new, create, edit, update, delete',
    'Pruefling' => 'setPruefling, list, show, new, create, edit, update, delete',
    'Intervall' => 'new, create, edit, update',
    'Export' => 'exportPrueflinge, exportModuleUndFaecher, exportFach',
    'Import' => 'new, importPrueflinge, importBackUp',
    'Ajax' => 'searchPruefling'
        ),
        // non-cacheable actions
        array(
    'Modul' => 'list, show, new, newFach, create, edit, update, delete',
    'Fach' => 'list, show, new, create, edit, update, delete',
    'Note' => 'list, show, new, create, edit, update, delete',
    'Pruefling' => 'setPruefling, list, show, new, create, edit, update, delete',
    'Intervall' => 'new, create, edit, update',
    'Export' => 'exportPrueflinge, exportModuleUndFaecher, exportFach',
    'Import' => 'new, importPrueflinge, importBackUp',
    'Ajax' => 'searchPruefling'
        )
);

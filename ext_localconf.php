<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ReRe.' . $_EXTKEY, 'rerebackend', array(
    'Modul' => 'list, show, new, newFach, create, edit, update, delete',
    'Note' => 'list, show, new, create, edit, update, delete',
    'Fach' => 'list, show, new, create, edit, update, delete',
    'Pruefling' => 'setPruefling, list, show, new, create, edit, update, delete',
    'Export' => 'exportPrueflinge, exportModuleUndFaecher, exportFach',
    'Import' => 'new, importPrueflinge, importBackUp',
    'Ajax' => 'searchPruefling',
    'Intervall' => 'new, create, edit, update'
        ),
        // non-cacheable actions
        array(
    'Modul' => 'create, update, delete, newFach',
    'Note' => 'create, update, delete',
    'Fach' => 'create, update, delete',
    'Pruefling' => 'setPruefling, create, createAndNext, update, delete',
    'Export' => 'exportPrueflinge, exportModuleUndFaecher, exportFach',
    'Import' => 'new, importPrueflinge, importBackUp',
    'Ajax' => 'searchPruefling',
    'Intervall' => 'new, create, edit, update'
        )
);

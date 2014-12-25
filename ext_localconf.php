<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ReRe.' . $_EXTKEY, 'rerebackend', array(
    'Modul' => 'list, show, new, newFach, create, edit, update, delete',
    'Note' => 'list, show, new, create, edit, update, delete',
    'Fach' => 'list, show, new, create, edit, update, delete',
    'Pruefling' => 'list, show, new, create, edit, update, delete',
    'Export' => 'exportPrueflinge, exportModuleUndFaecher',
    'Import' => 'new, importPrueflinge, importBackUp',
        ),
        // non-cacheable actions
        array(
    'Modul' => 'create, update, delete, newFach',
    'Note' => 'create, update, delete',
    'Fach' => 'create, update, delete',
    'Pruefling' => 'create, createAndNext, update, delete',
    'Export' => 'exportPrueflinge, exportModuleUndFaecher',
    'Import' => 'new, importPrueflinge, importBackUp',
        )
);

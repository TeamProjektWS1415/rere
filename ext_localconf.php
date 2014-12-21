<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'ReRe.' . $_EXTKEY, 'Notenuebersicht', array(
    'Modul' => 'list, show, new, create, edit, update, delete',
    'Note' => 'list, show, new, create, edit, update, delete',
    'Fach' => 'list, show, new, create, edit, update, delete',
    'Pruefling' => 'list, show, new, create, edit, update, delete',
        ),
        // non-cacheable actions
        array(
    'Modul' => 'create, update, delete',
    'Note' => 'create, update, delete',
    'Fach' => 'create, update, delete',
    'Pruefling' => 'create, update, delete',
        )
);

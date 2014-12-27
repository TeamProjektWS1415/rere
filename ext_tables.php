<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

define("DEFACTIONS", "list, show, new, create, edit, update, delete");

if (TYPO3_MODE === 'BE') {

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            // Make module a submodule of 'user'
            'ReRe.' . $_EXTKEY, 'user',
            // Submodule key
            'rerebackend',
            // Position
            '', array(
        'Modul' => DEFACTIONS, 'Fach' => DEFACTIONS, 'Note' => DEFACTIONS, 'Pruefling' => DEFACTIONS, 'Export' => 'exportPrueflinge, exportModuleUndFaecher, exportFach', 'Import' => 'new, importPrueflinge, importBackUp',
            ), array(
        'access' => 'user,group',
        'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
        'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_rerebackend.xlf',
            )
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Result Repositry');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_modul', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_modul.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_modul');
$GLOBALS['TCA']['tx_rere_domain_model_modul'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_modul',
        'label' => 'modulnr',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'modulnr,modulname,gueltigkeitszeitraum,fach,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Modul.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_modul.gif'
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_fach', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_fach.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_fach');
$GLOBALS['TCA']['tx_rere_domain_model_fach'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach',
        'label' => 'fachnr',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'fachnr,fachname,pruefer,notenschema,modulnr,matrikelnr,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Fach.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_fach.gif'
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_note', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_note.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_note');
$GLOBALS['TCA']['tx_rere_domain_model_note'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_note',
        'label' => 'wert',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'wert,kommentar,fachnr,matrikelnr,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Note.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_note.gif'
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_pruefling', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_pruefling.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_pruefling');
$GLOBALS['TCA']['tx_rere_domain_model_pruefling'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_pruefling',
        'label' => 'matrikelnr',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'matrikelnr,vorname,nachname,typo3_f_e_user,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Pruefling.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_pruefling.gif'
    ),
);

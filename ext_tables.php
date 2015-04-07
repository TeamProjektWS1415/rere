<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY, 'rerefrontend', 'Notenansicht'
);

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
	'Modul' => 'list, show, new, newFach, create, edit, update, delete', 'Fach' => 'list, show, new, create, edit, update, delete', 'Note' => 'list, show, new, create, edit, update, delete', 'Pruefling' => 'err, setPruefling, userGroupZuweisen, list, show, new, create, edit, update, delete', 'Intervall' => 'new, create, edit, update', 'Export' => 'exportPrueflinge, exportModuleUndFaecher, exportFach', 'Import' => 'new, importPrueflinge, importBackUp', 'Settings' => 'edit, update', 'Intervall' => 'new, create, edit, update', 'Masterstudiengang' => 'list, new, create, edit, update, delete'
	    ), array(
	'access' => 'user,group',
	'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
	'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf',
	    )
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Result Repository');

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
	'searchFields' => 'fachnr,fachname,pruefer,notenschema,modulnr,matrikelnr,note,datum,creditpoints',
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
	'searchFields' => 'wert,kommentar,fach,pruefling,',
	'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Note.php',
	'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_note.gif'
    ),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_settings', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_settings.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_settings');
$GLOBALS['TCA']['tx_rere_domain_model_settings'] = array(
    'ctrl' => array(
	'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_settings',
	'label' => 'mail_absender',
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
	'searchFields' => 'mail_absender,mail_empfaenger,',
	'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Settings.php',
	'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_settings.gif'
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
	'searchFields' => 'matrikelnr,vorname,nachname,typo3_f_e_user,note,',
	'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Pruefling.php',
	'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_pruefling.gif'
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_intervall', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_intervall.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_intervall');
$GLOBALS['TCA']['tx_rere_domain_model_intervall'] = array(
    'ctrl' => array(
	'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_intervall',
	'label' => 'type',
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
	'searchFields' => 'type,aktuell,',
	'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Intervall.php',
	'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_intervall.gif'
    ),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rere_domain_model_masterstudiengang', 'EXT:rere/Resources/Private/Language/locallang_csh_tx_rere_domain_model_masterstudiengang.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rere_domain_model_masterstudiengang');
$GLOBALS['TCA']['tx_rere_domain_model_masterstudiengang'] = array(
    'ctrl' => array(
	'title' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_masterstudiengang',
	'label' => 'name',
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
	'searchFields' => 'name,',
	'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Masterstudiengang.php',
	'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_rere_domain_model_masterstudiengang.gif'
    ),
);

if (!isset($GLOBALS['TCA']['fe_groups']['ctrl']['type'])) {
    if (file_exists($GLOBALS['TCA']['fe_groups']['ctrl']['dynamicConfigFile'])) {
	require_once($GLOBALS['TCA']['fe_groups']['ctrl']['dynamicConfigFile']);
    }
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_groups']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumns = array();
    $tempColumns[$GLOBALS['TCA']['fe_groups']['ctrl']['type']] = array(
	'exclude' => 1,
	'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere.tx_extbase_type',
	'config' => array(
	    'type' => 'select',
	    'items' => array(),
	    'size' => 1,
	    'maxitems' => 1,
	)
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_groups', $tempColumns, 1);
}

$GLOBALS['TCA']['fe_groups']['types']['Tx_Rere_FrontendUserGroup']['showitem'] = $TCA['fe_groups']['types']['0']['showitem'];
$GLOBALS['TCA']['fe_groups']['types']['Tx_Rere_FrontendUserGroup']['showitem'] .= ',--div--;LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_frontendusergroup,';
$GLOBALS['TCA']['fe_groups']['types']['Tx_Rere_FrontendUserGroup']['showitem'] .= '';

$GLOBALS['TCA']['fe_groups']['columns'][$TCA['fe_groups']['ctrl']['type']]['config']['items'] = array('LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:fe_groups.tx_extbase_type.Tx_Rere_FrontendUserGroup', 'Tx_Rere_FrontendUserGroup');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_groups', $GLOBALS['TCA']['fe_groups']['ctrl']['type'], '', 'after:' . $TCA['fe_groups']['ctrl']['label']);

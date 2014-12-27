<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

define("MODEL", "tx_rere_domain_model_fach");
define("EXCLUDE", "exclude");

$GLOBALS['TCA'][MODEL] = array(
    'ctrl' => $GLOBALS['TCA'][MODEL]['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, fachnr, fachname, pruefer, notenschema, modulnr, matrikelnr',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, fachnr, fachname, pruefer, notenschema, modulnr, matrikelnr, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            EXCLUDE => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => MODEL,
                'foreign_table_where' => 'AND tx_rere_domain_model_fach.pid=###CURRENT_PID### AND tx_rere_domain_model_fach.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            EXCLUDE => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            EXCLUDE => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'fachnr' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach.fachnr',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'fachname' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach.fachname',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'pruefer' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach.pruefer',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'notenschema' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach.notenschema',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'modulnr' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach.modulnr',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'matrikelnr' => array(
            EXCLUDE => 1,
            'label' => 'LLL:EXT:rere/Resources/Private/Language/locallang_db.xlf:tx_rere_domain_model_fach.matrikelnr',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'tx_rere_domain_model_pruefling',
                'MM' => 'tx_rere_fach_pruefling_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'Edit',
                        'script' => 'wizard_edit.php',
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ),
                    'add' => Array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_rere_domain_model_pruefling',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ),
                        'script' => 'wizard_add.php',
                    ),
                ),
            ),
        ),
        'modul' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        'note' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
    ),
);

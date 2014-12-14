<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'ReRe.' . $_EXTKEY,
	'Notenuebersicht',
	array(
		'Note' => 'list, show, new, create, edit, update, delete',
		'Fach' => 'list, show, new, create, edit, update, delete',
		'Modul' => 'list, show, new, create, edit, update, delete',
		'Pruefling' => 'list, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'Note' => 'create, update, delete',
		'Fach' => 'create, update, delete',
		'Modul' => 'create, update, delete',
		'Pruefling' => 'create, update, delete',
		
	)
);

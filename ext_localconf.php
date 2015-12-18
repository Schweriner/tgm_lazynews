<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TGM.' . $_EXTKEY,
	'Ajax',
	array(
		'News' => 'ajax',
		
	),
	// non-cacheable actions
	array(
		'News' => '',
		
	)
);

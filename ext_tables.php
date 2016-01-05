<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// TODO: Exclude this plugin from default content elements
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Ajax',
	'Lazy News'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TgM Lazy Loading News');


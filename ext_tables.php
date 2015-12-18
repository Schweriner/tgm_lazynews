<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Ajax',
	'Lazy News'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TgM Lazy Loading News');

if (!isset($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'])) {
	if (file_exists($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['dynamicConfigFile'])) {
		require_once($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['dynamicConfigFile']);
	}
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:tgm_lazynews/Resources/Private/Language/locallang_db.xlf:tx_tgmlazynews.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(),
			'size' => 1,
			'maxitems' => 1,
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tempColumns, 1);
}

$GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_TgmLazynews_News']['showitem'] = $TCA['tx_news_domain_model_news']['types']['1']['showitem'];
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_TgmLazynews_News']['showitem'] .= ',--div--;LLL:EXT:tgm_lazynews/Resources/Private/Language/locallang_db.xlf:tx_tgmlazynews_domain_model_news,';
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_TgmLazynews_News']['showitem'] .= '';

$GLOBALS['TCA']['tx_news_domain_model_news']['columns'][$TCA['tx_news_domain_model_news']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:tgm_lazynews/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_extbase_type.Tx_TgmLazynews_News','Tx_TgmLazynews_News');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_news_domain_model_news', $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'],'','after:' . $TCA['tx_news_domain_model_news']['ctrl']['label']);

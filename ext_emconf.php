<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "tgm_lazynews".
 *
 * Auto generated 11-12-2015 11:49
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'TgM Lazy Loading News',
	'description' => 'This extension offers a page type to receive lazy loaded news of versatile news from. See http://blog.teamgeist-medien.de/?p=1162',
	'category' => 'plugin',
	'version' => '0.1.5',
	'state' => 'beta',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => true,
	'author' => 'Paul Beck',
	'author_email' => 'pb@teamgeist-medien.de',
	'author_company' => 'Teamgeist Medien GbR',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '6.2.0-7.6.99',
			'news' => '3.0.0',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);


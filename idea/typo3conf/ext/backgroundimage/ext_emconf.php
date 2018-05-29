<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "backgroundimage".
 *
 * Auto generated 23-09-2014 11:29
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Background Images',
	'description' => 'Enables uploading of an image in page properties, which then is shown on page as background image.',
	'category' => 'fe',
	'version' => '1.1.2',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => true,
	'author' => 'Sven Burkert',
	'author_email' => 'bedienung@sbtheke.de',
	'author_company' => 'SBTheke web development',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '4.5.0-4.7.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);


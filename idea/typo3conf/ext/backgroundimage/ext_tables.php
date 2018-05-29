<?php
if(!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$tempColumns = Array (
	'tx_backgroundimage_background_image' => Array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:backgroundimage/locallang_db.xml:pages.tx_backgroundimage_background_image',		
		'config' => Array (
			'type' => 'group',
			'internal_type' => 'file',
			'allowed' => 'gif,png,jpeg,jpg',	
			'max_size' => 5000,	
			'uploadfolder' => 'uploads/tx_backgroundimage',
			'show_thumbs' => 1,	
			'size' => 1,	
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
);


t3lib_div::loadTCA('pages');
t3lib_extMgm::addTCAcolumns('pages', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('pages', 'tx_backgroundimage_background_image', '', 'after:media');

t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Background images');
?>
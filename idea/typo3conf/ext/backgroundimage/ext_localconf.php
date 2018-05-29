<?php
if(!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// Adding Fields to root line
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',tx_backgroundimage_background_image';
?>
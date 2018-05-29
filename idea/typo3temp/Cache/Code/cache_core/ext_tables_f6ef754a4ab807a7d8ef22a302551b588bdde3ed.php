<?php
/**
 * Compiled ext_tables.php cache file
 */

global $T3_SERVICES, $T3_VAR, $TYPO3_CONF_VARS;
global $TBE_MODULES, $TBE_MODULES_EXT, $TCA;
global $PAGES_TYPES, $TBE_STYLES, $FILEICONS;
global $_EXTKEY;

/**
 * Extension: core
 * File: /var/www/idea/typo3/sysext/core/ext_tables.php
 */

$_EXTKEY = 'core';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/**
 * $GLOBALS['PAGES_TYPES'] defines the various types of pages (field: doktype) the system
 * can handle and what restrictions may apply to them.
 * Here you can set the icon and especially you can define which tables are
 * allowed on a certain pagetype (doktype)
 * NOTE: The 'default' entry in the $GLOBALS['PAGES_TYPES'] array is the 'base' for all
 * types, and for every type the entries simply overrides the entries in the 'default' type!
 */
$GLOBALS['PAGES_TYPES'] = array(
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_LINK => array(),
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SHORTCUT => array(),
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_BE_USER_SECTION => array(
		'type' => 'web',
		'allowedTables' => '*'
	),
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_MOUNTPOINT => array(),
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SPACER => array(
		'type' => 'sys'
	),
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SYSFOLDER => array(
		//  Doktype 254 is a 'Folder' - a general purpose storage folder for whatever you like.
		// In CMS context it's NOT a viewable page. Can contain any element.
		'type' => 'sys',
		'allowedTables' => '*'
	),
	(string) \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_RECYCLER => array(
		// Doktype 255 is a recycle-bin.
		'type' => 'sys',
		'allowedTables' => '*'
	),
	'default' => array(
		'type' => 'web',
		'allowedTables' => 'pages',
		'onlyAllowedTables' => '0'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('sys_category');

/** @var \TYPO3\CMS\Core\Resource\Driver\DriverRegistry $registry */
$registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry');
$registry->addDriversToTCA();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('sys_file_reference');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('sys_file_collection');

/**
 * $TBE_MODULES contains the structure of the backend modules as they are
 * arranged in main- and sub-modules. Every entry in this array represents a
 * menu item on either first (key) or second level (value from list) in the
 * left menu in the TYPO3 backend
 * For information about adding modules to TYPO3 you should consult the
 * documentation found in "Inside TYPO3"
 */
$GLOBALS['TBE_MODULES'] = array(
	'web' => 'list',
	'file' => '',
	'user' => '',
	'tools' => '',
	'system' => '',
	'help' => ''
);


// Register the page tree core navigation component
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addCoreNavigationComponent('web', 'typo3-pagetree');


/**
 * $TBE_STYLES configures backend styles and colors; Basically this contains
 * all the values that can be used to create new skins for TYPO3.
 * For information about making skins to TYPO3 you should consult the
 * documentation found in "Inside TYPO3"
 */
$GLOBALS['TBE_STYLES'] = array(
	'colorschemes' => array(
		'0' => '#E4E0DB,#CBC7C3,#EDE9E5'
	),
	'borderschemes' => array(
		'0' => array('border:solid 1px black;', 5)
	)
);


/**
 * Setting up $TCA_DESCR - Context Sensitive Help (CSH)
 * For information about using the CSH API in TYPO3 you should consult the
 * documentation found in "Inside TYPO3"
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('pages', 'EXT:lang/locallang_csh_pages.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('be_users', 'EXT:lang/locallang_csh_be_users.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('be_groups', 'EXT:lang/locallang_csh_be_groups.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_filemounts', 'EXT:lang/locallang_csh_sysfilem.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_language', 'EXT:lang/locallang_csh_syslang.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_news', 'EXT:lang/locallang_csh_sysnews.xlf');
// General Core
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('xMOD_csh_corebe', 'EXT:lang/locallang_csh_corebe.xlf');
// Extension manager
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_tools_em', 'EXT:lang/locallang_csh_em.xlf');
// Web > Info
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_info', 'EXT:lang/locallang_csh_web_info.xlf');
// Web > Func
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_func', 'EXT:lang/locallang_csh_web_func.xlf');
// Labels for TYPO3 4.5 and greater.
// These labels override the ones set above, while still falling back to the original labels
// if no translation is available.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:lang/locallang_csh_pages.xlf'][] = 'EXT:lang/4.5/locallang_csh_pages.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:lang/locallang_csh_corebe.xlf'][] = 'EXT:lang/4.5/locallang_csh_corebe.xlf';


/**
 * $FILEICONS defines icons for the various file-formats
 */
$GLOBALS['FILEICONS'] = array(
	'txt' => 'txt.gif',
	'pdf' => 'pdf.gif',
	'doc' => 'doc.gif',
	'ai' => 'ai.gif',
	'bmp' => 'bmp.gif',
	'tif' => 'tif.gif',
	'htm' => 'htm.gif',
	'html' => 'html.gif',
	'pcd' => 'pcd.gif',
	'gif' => 'gif.gif',
	'jpg' => 'jpg.gif',
	'jpeg' => 'jpg.gif',
	'mpg' => 'mpg.gif',
	'mpeg' => 'mpeg.gif',
	'exe' => 'exe.gif',
	'com' => 'exe.gif',
	'zip' => 'zip.gif',
	'tgz' => 'zip.gif',
	'gz' => 'zip.gif',
	'php3' => 'php3.gif',
	'php4' => 'php3.gif',
	'php5' => 'php3.gif',
	'php6' => 'php3.gif',
	'php' => 'php3.gif',
	'ppt' => 'ppt.gif',
	'ttf' => 'ttf.gif',
	'pcx' => 'pcx.gif',
	'png' => 'png.gif',
	'tga' => 'tga.gif',
	'class' => 'java.gif',
	'sxc' => 'sxc.gif',
	'sxw' => 'sxw.gif',
	'xls' => 'xls.gif',
	'swf' => 'swf.gif',
	'swa' => 'flash.gif',
	'dcr' => 'flash.gif',
	'wav' => 'wav.gif',
	'mp3' => 'mp3.gif',
	'avi' => 'avi.gif',
	'au' => 'au.gif',
	'mov' => 'mov.gif',
	'3ds' => '3ds.gif',
	'csv' => 'csv.gif',
	'ico' => 'ico.gif',
	'max' => 'max.gif',
	'ps' => 'ps.gif',
	'tmpl' => 'tmpl.gif',
	'fh3' => 'fh3.gif',
	'inc' => 'inc.gif',
	'mid' => 'mid.gif',
	'psd' => 'psd.gif',
	'xml' => 'xml.gif',
	'rtf' => 'rtf.gif',
	't3x' => 't3x.gif',
	't3d' => 't3d.gif',
	'cdr' => 'cdr.gif',
	'dtd' => 'dtd.gif',
	'sgml' => 'sgml.gif',
	'ani' => 'ani.gif',
	'css' => 'css.gif',
	'eps' => 'eps.gif',
	'js' => 'js.gif',
	'wrl' => 'wrl.gif',
	'default' => 'default.gif'
);


/**
 * Backend sprite icon-names
 */
$GLOBALS['TBE_STYLES']['spriteIconApi']['coreSpriteImageNames'] = array(
	'actions-document-close',
	'actions-document-duplicates-select',
	'actions-document-edit-access',
	'actions-document-export-csv',
	'actions-document-export-t3d',
	'actions-document-history-open',
	'actions-document-import-t3d',
	'actions-document-info',
	'actions-document-localize',
	'actions-document-move',
	'actions-document-new',
	'actions-document-open',
	'actions-document-open-read-only',
	'actions-document-paste-after',
	'actions-document-paste-into',
	'actions-document-save',
	'actions-document-save-close',
	'actions-document-save-new',
	'actions-document-save-view',
	'actions-document-select',
	'actions-document-synchronize',
	'actions-document-view',
	'actions-edit-add',
	'actions-edit-copy',
	'actions-edit-copy-release',
	'actions-edit-cut',
	'actions-edit-cut-release',
	'actions-edit-delete',
	'actions-edit-download',
	'actions-edit-hide',
	'actions-edit-insert-default',
	'actions-edit-localize-status-high',
	'actions-edit-localize-status-low',
	'actions-edit-merge-localization',
	'actions-edit-pick-date',
	'actions-edit-rename',
	'actions-edit-restore',
	'actions-edit-undelete-edit',
	'actions-edit-undo',
	'actions-edit-unhide',
	'actions-edit-upload',
	'actions-input-clear',
	'actions-insert-record',
	'actions-insert-reference',
	'actions-markstate',
	'actions-message-error-close',
	'actions-message-information-close',
	'actions-message-notice-close',
	'actions-message-ok-close',
	'actions-message-warning-close',
	'actions-move-down',
	'actions-move-left',
	'actions-move-move',
	'actions-move-right',
	'actions-move-to-bottom',
	'actions-move-to-top',
	'actions-move-up',
	'actions-page-move',
	'actions-page-new',
	'actions-page-open',
	'actions-selection-delete',
	'actions-system-backend-user-emulate',
	'actions-system-backend-user-switch',
	'actions-system-cache-clear',
	'actions-system-cache-clear-impact-high',
	'actions-system-cache-clear-impact-low',
	'actions-system-cache-clear-impact-medium',
	'actions-system-cache-clear-rte',
	'actions-system-extension-configure',
	'actions-system-extension-documentation',
	'actions-system-extension-download',
	'actions-system-extension-import',
	'actions-system-extension-install',
	'actions-system-extension-sqldump',
	'actions-system-extension-uninstall',
	'actions-system-extension-update',
	'actions-system-extension-update-disabled',
	'actions-system-help-open',
	'actions-system-list-open',
	'actions-system-options-view',
	'actions-system-pagemodule-open',
	'actions-system-refresh',
	'actions-system-shortcut-new',
	'actions-system-tree-search-open',
	'actions-system-typoscript-documentation',
	'actions-system-typoscript-documentation-open',
	'actions-template-new',
	'actions-unmarkstate',
	'actions-version-document-remove',
	'actions-version-page-open',
	'actions-version-swap-version',
	'actions-version-swap-workspace',
	'actions-version-workspace-preview',
	'actions-version-workspace-sendtostage',
	'actions-view-go-back',
	'actions-view-go-down',
	'actions-view-go-forward',
	'actions-view-go-up',
	'actions-view-list-collapse',
	'actions-view-list-expand',
	'actions-view-paging-first',
	'actions-view-paging-first-disabled',
	'actions-view-paging-last',
	'actions-view-paging-last-disabled',
	'actions-view-paging-next',
	'actions-view-paging-next-disabled',
	'actions-view-paging-previous',
	'actions-view-paging-previous-disabled',
	'actions-view-table-collapse',
	'actions-view-table-expand',
	'actions-window-open',
	'apps-clipboard-images',
	'apps-clipboard-list',
	'apps-filetree-folder-add',
	'apps-filetree-folder-default',
	'apps-filetree-folder-list',
	'apps-filetree-folder-locked',
	'apps-filetree-folder-media',
	'apps-filetree-folder-news',
	'apps-filetree-folder-opened',
	'apps-filetree-folder-recycler',
	'apps-filetree-folder-temp',
	'apps-filetree-folder-user',
	'apps-filetree-mount',
	'apps-filetree-root',
	'apps-irre-collapsed',
	'apps-irre-expanded',
	'apps-pagetree-backend-user',
	'apps-pagetree-backend-user-hideinmenu',
	'apps-pagetree-collapse',
	'apps-pagetree-drag-copy-above',
	'apps-pagetree-drag-copy-below',
	'apps-pagetree-drag-move-above',
	'apps-pagetree-drag-move-below',
	'apps-pagetree-drag-move-between',
	'apps-pagetree-drag-move-into',
	'apps-pagetree-drag-new-between',
	'apps-pagetree-drag-new-inside',
	'apps-pagetree-drag-place-denied',
	'apps-pagetree-expand',
	'apps-pagetree-folder-contains-approve',
	'apps-pagetree-folder-contains-board',
	'apps-pagetree-folder-contains-fe_users',
	'apps-pagetree-folder-contains-news',
	'apps-pagetree-folder-contains-shop',
	'apps-pagetree-folder-default',
	'apps-pagetree-page-advanced',
	'apps-pagetree-page-advanced-hideinmenu',
	'apps-pagetree-page-advanced-root',
	'apps-pagetree-page-backend-users',
	'apps-pagetree-page-backend-users-hideinmenu',
	'apps-pagetree-page-backend-users-root',
	'apps-pagetree-page-default',
	'apps-pagetree-page-domain',
	'apps-pagetree-page-frontend-user',
	'apps-pagetree-page-frontend-user-hideinmenu',
	'apps-pagetree-page-frontend-user-root',
	'apps-pagetree-page-frontend-users',
	'apps-pagetree-page-frontend-users-hideinmenu',
	'apps-pagetree-page-frontend-users-root',
	'apps-pagetree-page-mountpoint',
	'apps-pagetree-page-mountpoint-hideinmenu',
	'apps-pagetree-page-mountpoint-root',
	'apps-pagetree-page-no-icon-found',
	'apps-pagetree-page-no-icon-found-hideinmenu',
	'apps-pagetree-page-no-icon-found-root',
	'apps-pagetree-page-not-in-menu',
	'apps-pagetree-page-recycler',
	'apps-pagetree-page-shortcut',
	'apps-pagetree-page-shortcut-external',
	'apps-pagetree-page-shortcut-external-hideinmenu',
	'apps-pagetree-page-shortcut-external-root',
	'apps-pagetree-page-shortcut-hideinmenu',
	'apps-pagetree-page-shortcut-root',
	'apps-pagetree-root',
	'apps-pagetree-spacer',
	'apps-tcatree-select-recursive',
	'apps-toolbar-menu-actions',
	'apps-toolbar-menu-cache',
	'apps-toolbar-menu-opendocs',
	'apps-toolbar-menu-search',
	'apps-toolbar-menu-shortcut',
	'apps-toolbar-menu-workspace',
	'mimetypes-compressed',
	'mimetypes-excel',
	'mimetypes-media-audio',
	'mimetypes-media-flash',
	'mimetypes-media-image',
	'mimetypes-media-video',
	'mimetypes-other-other',
	'mimetypes-pdf',
	'mimetypes-powerpoint',
	'mimetypes-text-css',
	'mimetypes-text-csv',
	'mimetypes-text-html',
	'mimetypes-text-js',
	'mimetypes-text-php',
	'mimetypes-text-text',
	'mimetypes-word',
	'mimetypes-x-content-divider',
	'mimetypes-x-content-domain',
	'mimetypes-x-content-form',
	'mimetypes-x-content-form-search',
	'mimetypes-x-content-header',
	'mimetypes-x-content-html',
	'mimetypes-x-content-image',
	'mimetypes-x-content-link',
	'mimetypes-x-content-list-bullets',
	'mimetypes-x-content-list-files',
	'mimetypes-x-content-login',
	'mimetypes-x-content-menu',
	'mimetypes-x-content-multimedia',
	'mimetypes-x-content-page-language-overlay',
	'mimetypes-x-content-plugin',
	'mimetypes-x-content-script',
	'mimetypes-x-content-table',
	'mimetypes-x-content-template',
	'mimetypes-x-content-template-extension',
	'mimetypes-x-content-template-static',
	'mimetypes-x-content-text',
	'mimetypes-x-content-text-picture',
	'mimetypes-x-sys_action',
	'mimetypes-x-sys_category',
	'mimetypes-x-sys_language',
	'mimetypes-x-sys_news',
	'mimetypes-x-sys_workspace',
	'mimetypes-x_belayout',
	'status-dialog-error',
	'status-dialog-information',
	'status-dialog-notification',
	'status-dialog-ok',
	'status-dialog-warning',
	'status-overlay-access-restricted',
	'status-overlay-deleted',
	'status-overlay-hidden',
	'status-overlay-icon-missing',
	'status-overlay-includes-subpages',
	'status-overlay-locked',
	'status-overlay-scheduled',
	'status-overlay-scheduled-future-end',
	'status-overlay-translated',
	'status-status-checked',
	'status-status-current',
	'status-status-edit-read-only',
	'status-status-icon-missing',
	'status-status-locked',
	'status-status-permission-denied',
	'status-status-permission-granted',
	'status-status-readonly',
	'status-status-reference-hard',
	'status-status-reference-soft',
	'status-status-sorting-asc',
	'status-status-sorting-desc',
	'status-status-sorting-light-asc',
	'status-status-sorting-light-desc',
	'status-status-workspace-draft',
	'status-system-extension-required',
	'status-user-admin',
	'status-user-backend',
	'status-user-frontend',
	'status-user-group-backend',
	'status-user-group-frontend',
	'status-version-1',
	'status-version-2',
	'status-version-3',
	'status-version-4',
	'status-version-5',
	'status-version-6',
	'status-version-7',
	'status-version-8',
	'status-version-9',
	'status-version-10',
	'status-version-11',
	'status-version-12',
	'status-version-13',
	'status-version-14',
	'status-version-15',
	'status-version-16',
	'status-version-17',
	'status-version-18',
	'status-version-19',
	'status-version-20',
	'status-version-21',
	'status-version-22',
	'status-version-23',
	'status-version-24',
	'status-version-25',
	'status-version-26',
	'status-version-27',
	'status-version-28',
	'status-version-29',
	'status-version-30',
	'status-version-31',
	'status-version-32',
	'status-version-33',
	'status-version-34',
	'status-version-35',
	'status-version-36',
	'status-version-37',
	'status-version-38',
	'status-version-39',
	'status-version-40',
	'status-version-41',
	'status-version-42',
	'status-version-43',
	'status-version-44',
	'status-version-45',
	'status-version-46',
	'status-version-47',
	'status-version-48',
	'status-version-49',
	'status-version-50',
	'status-version-no-version',
	'status-warning-in-use',
	'status-warning-lock',
	'treeline-blank',
	'treeline-join',
	'treeline-joinbottom',
	'treeline-jointop',
	'treeline-line',
	'treeline-minus',
	'treeline-minusbottom',
	'treeline-minusonly',
	'treeline-minustop',
	'treeline-plus',
	'treeline-plusbottom',
	'treeline-plusonly',
	'treeline-stopper',
	'empty-icon'
);


$GLOBALS['TBE_STYLES']['spriteIconApi']['spriteIconRecordOverlayPriorities'] = array(
	'deleted',
	'hidden',
	'starttime',
	'endtime',
	'futureendtime',
	'fe_group',
	'protectedSection'
);


$GLOBALS['TBE_STYLES']['spriteIconApi']['spriteIconRecordOverlayNames'] = array(
	'hidden' => 'status-overlay-hidden',
	'fe_group' => 'status-overlay-access-restricted',
	'starttime' => 'status-overlay-scheduled',
	'endtime' => 'status-overlay-scheduled',
	'futureendtime' => 'status-overlay-scheduled-future-end',
	'readonly' => 'status-overlay-locked',
	'deleted' => 'status-overlay-deleted',
	'missing' => 'status-overlay-missing',
	'translated' => 'status-overlay-translated',
	'protectedSection' => 'status-overlay-includes-subpages'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: sv
 * File: /var/www/idea/typo3/sysext/sv/ext_tables.php
 */

$_EXTKEY = 'sv';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['sv']['services'] = array(
		'title' => 'LLL:EXT:sv/Resources/Private/Language/locallang.xlf:report_title',
		'description' => 'LLL:EXT:sv/Resources/Private/Language/locallang.xlf:report_description',
		'icon' => 'EXT:sv/Resources/Public/Images/tx_sv_report.png',
		'report' => 'TYPO3\\CMS\\Sv\\Report\\ServicesListReport'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: saltedpasswords
 * File: /var/www/idea/typo3/sysext/saltedpasswords/ext_tables.php
 */

$_EXTKEY = 'saltedpasswords';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// Add context sensitive help (csh) for scheduler task
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_txsaltedpasswords', 'EXT:' . $_EXTKEY . '/locallang_csh_saltedpasswords.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: recordlist
 * File: /var/www/idea/typo3/sysext/recordlist/ext_tables.php
 */

$_EXTKEY = 'recordlist';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'web_list',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'web',
		'list',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
	);

	// Register element browser wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_element_browser',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/ElementBrowserWizard/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: lang
 * File: /var/www/idea/typo3/sysext/lang/ext_tables.php
 */

$_EXTKEY = 'lang';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE == 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
		// Registers a Backend Module
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'tools', // Make module a submodule of 'tools'
		'language', // Submodule key
		'after:extensionmanager', // Position
		array(
				// An array holding the controller-action-combinations that are accessible
			'Language' => 'index, updateLanguageSelection, updateTranslation'
		),
		array(
			'access' => 'admin',
			'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_language.xlf',
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: extbase
 * File: /var/www/idea/typo3/sysext/extbase/ext_tables.php
 */

$_EXTKEY = 'extbase';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE == 'BE') {
	// register Extbase dispatcher for modules
	$TBE_MODULES['_dispatcher'][] = 'TYPO3\\CMS\\Extbase\\Core\\ModuleRunnerInterface';
}
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['extbase'][] = 'TYPO3\\CMS\\Extbase\\Utility\\ExtbaseRequirementsCheckUtility';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['TYPO3\\CMS\\Extbase\\Scheduler\\Task'] = array(
	'extension' => $_EXTKEY,
	'title' => 'LLL:EXT:extbase/Resources/Private/Language/locallang_db.xlf:task.name',
	'description' => 'LLL:EXT:extbase/Resources/Private/Language/locallang_db.xlf:task.description',
	'additionalFields' => 'TYPO3\\CMS\\Extbase\\Scheduler\\FieldProvider'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['checkFlexFormValue'][] = 'TYPO3\CMS\Extbase\Hook\DataHandler\CheckFlexFormValue';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: fluid
 * File: /var/www/idea/typo3/sysext/fluid/ext_tables.php
 */

$_EXTKEY = 'fluid';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Fluid: (Optional) default ajax configuration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: install
 * File: /var/www/idea/typo3/sysext/install/ext_tables.php
 */

$_EXTKEY = 'install';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	// Register report module additions
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['typo3'][] = 'TYPO3\\CMS\\Install\\Report\\InstallStatusReport';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['system'][] = 'TYPO3\\CMS\\Install\\Report\\EnvironmentStatusReport';

	// Register backend module
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'system',
		'install', '', array(
			'BackendModule' => 'index, showEnableInstallToolButton, enableInstallTool',
		),
		array(
			'access' => 'admin',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Images/Icon/BackendModule.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/BackendModule.xlf',
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: cms
 * File: /var/www/idea/typo3/sysext/cms/ext_tables.php
 */

$_EXTKEY = 'cms';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE == 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule('web', 'layout', 'top', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'layout/');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_layout', 'EXT:cms/locallang_csh_weblayout.xlf');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_info', 'EXT:cms/locallang_csh_webinfo.xlf');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction('web_info', 'tx_cms_webinfo_page', NULL, 'LLL:EXT:cms/locallang_tca.xlf:mod_tx_cms_webinfo_page');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction('web_info', 'tx_cms_webinfo_lang', NULL, 'LLL:EXT:cms/locallang_tca.xlf:mod_tx_cms_webinfo_lang');
}
// Add allowed records to pages:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('pages_language_overlay,tt_content,sys_template,sys_domain,backend_layout');

if (!function_exists('user_sortPluginList')) {
	function user_sortPluginList(array &$parameters) {
		usort(
			$parameters['items'],
			function ($item1, $item2) {
				return strcasecmp($GLOBALS['LANG']->sL($item1[0]), $GLOBALS['LANG']->sL($item2[0]));
			}
		);
	}
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: extensionmanager
 * File: /var/www/idea/typo3/sysext/extensionmanager/ext_tables.php
 */

$_EXTKEY = 'extensionmanager';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'tools',
		'extensionmanager', '', array(
			'List' => 'index,unresolvedDependencies,ter,showAllVersions,distributions',
			'Action' => 'toggleExtensionInstallationState,installExtensionWithoutSystemDependencyCheck,removeExtension,downloadExtensionZip,downloadExtensionData',
			'Configuration' => 'showConfigurationForm,save',
			'Download' => 'checkDependencies,installFromTer,installExtensionWithoutSystemDependencyCheck,installDistribution,updateExtension,updateCommentForUpdatableVersions',
			'UpdateScript' => 'show',
			'UpdateFromTer' => 'updateExtensionListFromTer',
			'UploadExtensionFile' => 'form,extract',
			'Distribution' => 'show'
		),
		array(
			'access' => 'admin',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/module.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
		)
	);

	// Register extension status report system
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['Extension Manager'][] =
		'TYPO3\\CMS\\Extensionmanager\\Report\\ExtensionStatus';
}

// Register specific icon for update script button
\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(
	array(
		'update-script' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Icons/ExtensionUpdateScript.png'
	),
	$_EXTKEY
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: cshmanual
 * File: /var/www/idea/typo3/sysext/cshmanual/ext_tables.php
 */

$_EXTKEY = 'cshmanual';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'help',
		'cshmanual',
		'top',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: backend
 * File: /var/www/idea/typo3/sysext/backend/ext_tables.php
 */

$_EXTKEY = 'backend';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	// Register record history module
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'record_history',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/RecordHistory/'
	);

	// Register edit wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_edit',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/EditWizard/'
	);

	// Register add wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_add',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/AddWizard/'
	);

	// Register list wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_list',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/ListWizard/'
	);

	// Register table wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_table',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/TableWizard/'
	);

	// Register forms wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_forms',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/FormsWizard/'
	);

	// Register rte wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_rte',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/RteWizard/'
	);

	// Register colorpicker wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_colorpicker',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/ColorpickerWizard/'
	);

	// Register backend_layout wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_backend_layout',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/BackendLayoutWizard/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: wizard_sortpages
 * File: /var/www/idea/typo3/sysext/wizard_sortpages/ext_tables.php
 */

$_EXTKEY = 'wizard_sortpages';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_func',
		'TYPO3\\CMS\\WizardSortpages\\View\\SortPagesWizardModuleFunction',
		NULL,
		'LLL:EXT:wizard_sortpages/locallang.xlf:wiz_sort',
		'wiz'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		'_MOD_web_func',
		'EXT:wizard_sortpages/locallang_csh.xlf'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: wizard_crpages
 * File: /var/www/idea/typo3/sysext/wizard_crpages/ext_tables.php
 */

$_EXTKEY = 'wizard_crpages';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_func',
		'TYPO3\\CMS\\WizardCrpages\\Controller\\CreatePagesWizardModuleFunctionController',
		NULL,
		'LLL:EXT:wizard_crpages/locallang.xlf:wiz_crMany',
		'wiz'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		'_MOD_web_func',
		'EXT:wizard_crpages/locallang_csh.xlf'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: viewpage
 * File: /var/www/idea/typo3/sysext/viewpage/ext_tables.php
 */

$_EXTKEY = 'viewpage';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	// Module Web->View
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'web',
		'view',
		'after:layout',
		array(
			'ViewModule' => 'show'
		),
		array(
			'icon' => 'EXT:viewpage/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
			'access' => 'user,group'
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: tstemplate
 * File: /var/www/idea/typo3/sysext/tstemplate/ext_tables.php
 */

$_EXTKEY = 'tstemplate';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'web',
		'ts',
		'',
		$extensionPath . 'ts/'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_ts',
		'TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateConstantEditorModuleFunctionController',
		NULL,
		'LLL:EXT:tstemplate/ts/locallang.xlf:constantEditor'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_ts',
		'TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateInformationModuleFunctionController',
		NULL,
		'LLL:EXT:tstemplate/ts/locallang.xlf:infoModify'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_ts',
		'TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateObjectBrowserModuleFunctionController',
		NULL,
		'LLL:EXT:tstemplate/ts/locallang.xlf:objectBrowser'
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_ts',
		'TYPO3\\CMS\\Tstemplate\\Controller\\TemplateAnalyzerModuleFunctionController',
		NULL,
		'LLL:EXT:tstemplate/ts/locallang.xlf:templateAnalyzer'
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: t3skin
 * File: /var/www/idea/typo3/sysext/t3skin/ext_tables.php
 */

$_EXTKEY = 't3skin';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE == 'BE' || TYPO3_MODE == 'FE' && isset($GLOBALS['BE_USER'])) {
	global $TBE_STYLES;
	// Register as a skin
	$TBE_STYLES['skins'][$_EXTKEY] = array(
		'name' => 't3skin'
	);
	// Support for other extensions to add own icons...
	$presetSkinImgs = is_array($TBE_STYLES['skinImg']) ? $TBE_STYLES['skinImg'] : array();
	$TBE_STYLES['skins'][$_EXTKEY]['stylesheetDirectories']['sprites'] = 'EXT:t3skin/stylesheets/sprites/';
	/** Setting up backend styles and colors */
	$TBE_STYLES['mainColors'] = array(
		// Always use #xxxxxx color definitions!
		'bgColor' => '#FFFFFF',
		// Light background color
		'bgColor2' => '#FEFEFE',
		// Steel-blue
		'bgColor3' => '#F1F3F5',
		// dok.color
		'bgColor4' => '#E6E9EB',
		// light tablerow background, brownish
		'bgColor5' => '#F8F9FB',
		// light tablerow background, greenish
		'bgColor6' => '#E6E9EB',
		// light tablerow background, yellowish, for section headers. Light.
		'hoverColor' => '#FF0000',
		'navFrameHL' => '#F8F9FB'
	);
	$TBE_STYLES['colorschemes'][0] = '-|class-main1,-|class-main2,-|class-main3,-|class-main4,-|class-main5';
	$TBE_STYLES['colorschemes'][1] = '-|class-main11,-|class-main12,-|class-main13,-|class-main14,-|class-main15';
	$TBE_STYLES['colorschemes'][2] = '-|class-main21,-|class-main22,-|class-main23,-|class-main24,-|class-main25';
	$TBE_STYLES['colorschemes'][3] = '-|class-main31,-|class-main32,-|class-main33,-|class-main34,-|class-main35';
	$TBE_STYLES['colorschemes'][4] = '-|class-main41,-|class-main42,-|class-main43,-|class-main44,-|class-main45';
	$TBE_STYLES['colorschemes'][5] = '-|class-main51,-|class-main52,-|class-main53,-|class-main54,-|class-main55';
	$TBE_STYLES['styleschemes'][0]['all'] = 'CLASS: formField';
	$TBE_STYLES['styleschemes'][1]['all'] = 'CLASS: formField1';
	$TBE_STYLES['styleschemes'][2]['all'] = 'CLASS: formField2';
	$TBE_STYLES['styleschemes'][3]['all'] = 'CLASS: formField3';
	$TBE_STYLES['styleschemes'][4]['all'] = 'CLASS: formField4';
	$TBE_STYLES['styleschemes'][5]['all'] = 'CLASS: formField5';
	$TBE_STYLES['styleschemes'][0]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][1]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][2]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][3]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][4]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][5]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][0]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][1]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][2]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][3]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][4]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][5]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][0]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][1]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][2]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][3]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][4]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][5]['select'] = 'CLASS: select';
	$TBE_STYLES['borderschemes'][0] = array('', '', '', 'wrapperTable');
	$TBE_STYLES['borderschemes'][1] = array('', '', '', 'wrapperTable1');
	$TBE_STYLES['borderschemes'][2] = array('', '', '', 'wrapperTable2');
	$TBE_STYLES['borderschemes'][3] = array('', '', '', 'wrapperTable3');
	$TBE_STYLES['borderschemes'][4] = array('', '', '', 'wrapperTable4');
	$TBE_STYLES['borderschemes'][5] = array('', '', '', 'wrapperTable5');
	// Setting the relative path to the extension in temp. variable:
	$temp_eP = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);
	// Alternative dimensions for frameset sizes:
	// Left menu frame width
	$TBE_STYLES['dims']['leftMenuFrameW'] = 190;
	// Top frame height
	$TBE_STYLES['dims']['topFrameH'] = 42;
	// Default navigation frame width
	$TBE_STYLES['dims']['navFrameWidth'] = 280;
	// Setting roll-over background color for click menus:
	// Notice, this line uses the the 'scriptIDindex' feature to override another value in this array (namely $TBE_STYLES['mainColors']['bgColor5']), for a specific script "typo3/alt_clickmenu.php"
	$TBE_STYLES['scriptIDindex']['typo3/alt_clickmenu.php']['mainColors']['bgColor5'] = '#dedede';
	// Setting up auto detection of alternative icons:
	$TBE_STYLES['skinImgAutoCfg'] = array(
		'absDir' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'icons/',
		'relDir' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'icons/',
		'forceFileExtension' => 'gif',
		// Force to look for PNG alternatives...
		'iconSizeWidth' => 16,
		'iconSizeHeight' => 16
	);
	// Changing icon for filemounts, needs to be done here as overwriting the original icon would also change the filelist tree's root icon
	$TCA['sys_filemounts']['ctrl']['iconfile'] = '_icon_ftp_2.gif';
	// Adding flags to sys_language
	$TCA['sys_language']['ctrl']['typeicon_column'] = 'flag';
	$TCA['sys_language']['ctrl']['typeicon_classes'] = array(
		'default' => 'mimetypes-x-sys_language',
		'mask' => 'flags-###TYPE###'
	);
	$flagNames = array(
		'multiple',
		'ad',
		'ae',
		'af',
		'ag',
		'ai',
		'al',
		'am',
		'an',
		'ao',
		'ar',
		'as',
		'at',
		'au',
		'aw',
		'ax',
		'az',
		'ba',
		'bb',
		'bd',
		'be',
		'bf',
		'bg',
		'bh',
		'bi',
		'bj',
		'bm',
		'bn',
		'bo',
		'br',
		'bs',
		'bt',
		'bv',
		'bw',
		'by',
		'bz',
		'ca',
		'catalonia',
		'cc',
		'cd',
		'cf',
		'cg',
		'ch',
		'ci',
		'ck',
		'cl',
		'cm',
		'cn',
		'co',
		'cr',
		'cs',
		'cu',
		'cv',
		'cx',
		'cy',
		'cz',
		'de',
		'dj',
		'dk',
		'dm',
		'do',
		'dz',
		'ec',
		'ee',
		'eg',
		'eh',
		'england',
		'er',
		'es',
		'et',
		'europeanunion',
		'fam',
		'fi',
		'fj',
		'fk',
		'fm',
		'fo',
		'fr',
		'ga',
		'gb',
		'gd',
		'ge',
		'gf',
		'gh',
		'gi',
		'gl',
		'gm',
		'gn',
		'gp',
		'gq',
		'gr',
		'gs',
		'gt',
		'gu',
		'gw',
		'gy',
		'hk',
		'hm',
		'hn',
		'hr',
		'ht',
		'hu',
		'id',
		'ie',
		'il',
		'in',
		'io',
		'iq',
		'ir',
		'is',
		'it',
		'jm',
		'jo',
		'jp',
		'ke',
		'kg',
		'kh',
		'ki',
		'km',
		'kn',
		'kp',
		'kr',
		'kw',
		'ky',
		'kz',
		'la',
		'lb',
		'lc',
		'li',
		'lk',
		'lr',
		'ls',
		'lt',
		'lu',
		'lv',
		'ly',
		'ma',
		'mc',
		'md',
		'me',
		'mg',
		'mh',
		'mk',
		'ml',
		'mm',
		'mn',
		'mo',
		'mp',
		'mq',
		'mr',
		'ms',
		'mt',
		'mu',
		'mv',
		'mw',
		'mx',
		'my',
		'mz',
		'na',
		'nc',
		'ne',
		'nf',
		'ng',
		'ni',
		'nl',
		'no',
		'np',
		'nr',
		'nu',
		'nz',
		'om',
		'pa',
		'pe',
		'pf',
		'pg',
		'ph',
		'pk',
		'pl',
		'pm',
		'pn',
		'pr',
		'ps',
		'pt',
		'pw',
		'py',
		'qa',
		'qc',
		're',
		'ro',
		'rs',
		'ru',
		'rw',
		'sa',
		'sb',
		'sc',
		'scotland',
		'sd',
		'se',
		'sg',
		'sh',
		'si',
		'sj',
		'sk',
		'sl',
		'sm',
		'sn',
		'so',
		'sr',
		'st',
		'sv',
		'sy',
		'sz',
		'tc',
		'td',
		'tf',
		'tg',
		'th',
		'tj',
		'tk',
		'tl',
		'tm',
		'tn',
		'to',
		'tr',
		'tt',
		'tv',
		'tw',
		'tz',
		'ua',
		'ug',
		'um',
		'us',
		'uy',
		'uz',
		'va',
		'vc',
		've',
		'vg',
		'vi',
		'vn',
		'vu',
		'wales',
		'wf',
		'ws',
		'ye',
		'yt',
		'za',
		'zm',
		'zw'
	);
	foreach ($flagNames as $flagName) {
		$TCA['sys_language']['columns']['flag']['config']['items'][] = array($flagName, $flagName, 'EXT:t3skin/images/flags/' . $flagName . '.png');
	}
	// Manual setting up of alternative icons. This is mainly for module icons which has a special prefix:
	$TBE_STYLES['skinImg'] = array_merge($presetSkinImgs, array(
		'gfx/ol/blank.gif' => array('clear.gif', 'width="18" height="16"'),
		'MOD:web/website.gif' => array($temp_eP . 'icons/module_web.gif', 'width="24" height="24"'),
		'MOD:web_layout/layout.gif' => array($temp_eP . 'icons/module_web_layout.gif', 'width="24" height="24"'),
		'MOD:web_view/view.gif' => array($temp_eP . 'icons/module_web_view.png', 'width="24" height="24"'),
		'MOD:web_list/list.gif' => array($temp_eP . 'icons/module_web_list.gif', 'width="24" height="24"'),
		'MOD:web_info/info.gif' => array($temp_eP . 'icons/module_web_info.png', 'width="24" height="24"'),
		'MOD:web_perm/perm.gif' => array($temp_eP . 'icons/module_web_perms.png', 'width="24" height="24"'),
		'MOD:web_func/func.gif' => array($temp_eP . 'icons/module_web_func.png', 'width="24" height="24"'),
		'MOD:web_ts/ts1.gif' => array($temp_eP . 'icons/module_web_ts.gif', 'width="24" height="24"'),
		'MOD:web_modules/modules.gif' => array($temp_eP . 'icons/module_web_modules.gif', 'width="24" height="24"'),
		'MOD:web_txversionM1/cm_icon.gif' => array($temp_eP . 'icons/module_web_version.gif', 'width="24" height="24"'),
		'MOD:file/file.gif' => array($temp_eP . 'icons/module_file.gif', 'width="22" height="24"'),
		'MOD:file_list/list.gif' => array($temp_eP . 'icons/module_file_list.gif', 'width="22" height="24"'),
		'MOD:file_images/images.gif' => array($temp_eP . 'icons/module_file_images.gif', 'width="22" height="22"'),
		'MOD:user/user.gif' => array($temp_eP . 'icons/module_user.gif', 'width="22" height="22"'),
		'MOD:user_task/task.gif' => array($temp_eP . 'icons/module_user_taskcenter.gif', 'width="22" height="22"'),
		'MOD:user_setup/setup.gif' => array($temp_eP . 'icons/module_user_setup.gif', 'width="22" height="22"'),
		'MOD:user_doc/document.gif' => array($temp_eP . 'icons/module_doc.gif', 'width="22" height="22"'),
		'MOD:user_ws/sys_workspace.gif' => array($temp_eP . 'icons/module_user_ws.gif', 'width="22" height="22"'),
		'MOD:tools/tool.gif' => array($temp_eP . 'icons/module_tools.gif', 'width="25" height="24"'),
		'MOD:tools_em/em.gif' => array($temp_eP . 'icons/module_tools_em.png', 'width="24" height="24"'),
		'MOD:tools_em/install.gif' => array($temp_eP . 'icons/module_tools_em.gif', 'width="24" height="24"'),
		'MOD:tools_txphpmyadmin/thirdparty_db.gif' => array($temp_eP . 'icons/module_tools_phpmyadmin.gif', 'width="24" height="24"'),
		'MOD:tools_isearch/isearch.gif' => array($temp_eP . 'icons/module_tools_isearch.gif', 'width="24" height="24"'),
		'MOD:system_dbint/db.gif' => array($temp_eP . 'icons/module_system_dbint.gif', 'width="25" height="24"'),
		'MOD:system_beuser/beuser.gif' => array($temp_eP . 'icons/module_system_user.gif', 'width="24" height="24"'),
		'MOD:system_install/install.gif' => array($temp_eP . 'icons/module_system_install.gif', 'width="24" height="24"'),
		'MOD:system_config/config.gif' => array($temp_eP . 'icons/module_system_config.gif', 'width="24" height="24"'),
		'MOD:system_log/log.gif' => array($temp_eP . 'icons/module_system_log.gif', 'width="24" height="24"'),
		'MOD:help/help.gif' => array($temp_eP . 'icons/module_help.gif', 'width="23" height="24"'),
		'MOD:help_about/info.gif' => array($temp_eP . 'icons/module_help_about.gif', 'width="25" height="24"'),
		'MOD:help_aboutmodules/aboutmodules.gif' => array($temp_eP . 'icons/module_help_aboutmodules.gif', 'width="24" height="24"'),
		'MOD:help_cshmanual/about.gif' => array($temp_eP . 'icons/module_help_cshmanual.gif', 'width="25" height="24"'),
		'MOD:help_txtsconfighelpM1/moduleicon.gif' => array($temp_eP . 'icons/module_help_ts.gif', 'width="25" height="24"')
	));
	// Logo at login screen
	$TBE_STYLES['logo_login'] = $temp_eP . 'images/login/typo3logo-white-greyback.gif';
	// extJS theme
	$TBE_STYLES['extJS']['theme'] = $temp_eP . 'extjs/xtheme-t3skin.css';
	// Adding HTML template for login screen
	$TBE_STYLES['htmlTemplates']['EXT:backend/Resources/Private/Templates/login.html'] = 'sysext/t3skin/Resources/Private/Templates/login.html';
	$GLOBALS['TBE_STYLES']['stylesheets']['admPanel'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('t3skin') . 'stylesheets/standalone/admin_panel.css';
	$flagIcons = array();
	foreach ($flagNames as $flagName) {
		$flagIcons[] = 'flags-' . $flagName;
		$flagIcons[] = 'flags-' . $flagName . '-overlay';
	}
	\TYPO3\CMS\Backend\Sprite\SpriteManager::addIconSprite($flagIcons);
	unset($flagNames, $flagName, $flagIcons);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: t3editor
 * File: /var/www/idea/typo3/sysext/t3editor/ext_tables.php
 */

$_EXTKEY = 't3editor';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	// Register AJAX handlers:
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler('T3Editor::saveCode', 'TYPO3\\CMS\\T3editor\\T3editor->ajaxSaveCode');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler('T3Editor::getPlugins', 'TYPO3\\CMS\\T3editor\\T3editor->getPlugins');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler('T3Editor_TSrefLoader::getTypes', 'TYPO3\\CMS\\T3editor\\TypoScriptReferenceLoader->processAjaxRequest');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler('T3Editor_TSrefLoader::getDescription', 'TYPO3\\CMS\\T3editor\\TypoScriptReferenceLoader->processAjaxRequest');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler('CodeCompletion::loadTemplates', 'TYPO3\\CMS\\T3editor\\CodeCompletion->processAjaxRequest');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: sys_note
 * File: /var/www/idea/typo3/sysext/sys_note/ext_tables.php
 */

$_EXTKEY = 'sys_note';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('sys_note');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_note', 'EXT:sys_note/Resources/Private/Language/locallang_csh_sysnote.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: setup
 * File: /var/www/idea/typo3/sysext/setup/ext_tables.php
 */

$_EXTKEY = 'setup';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'user',
		'setup',
		'after:task',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod/'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		'_MOD_user_setup',
		'EXT:setup/locallang_csh_mod.xlf'
	);

	$GLOBALS['TYPO3_USER_SETTINGS'] = array(
		'ctrl' => array(
			'dividers2tabs' => 1
		),
		'columns' => array(
			'realName' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:beUser_realName',
				'table' => 'be_users',
				'csh' => 'beUser_realName'
			),
			'email' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:beUser_email',
				'table' => 'be_users',
				'csh' => 'beUser_email'
			),
			'emailMeAtLogin' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:emailMeAtLogin',
				'csh' => 'emailMeAtLogin'
			),
			'password' => array(
				'type' => 'password',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:newPassword',
				'table' => 'be_users',
				'csh' => 'newPassword',
			),
			'password2' => array(
				'type' => 'password',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:newPasswordAgain',
				'table' => 'be_users',
				'csh' => 'newPasswordAgain',
			),
			'lang' => array(
				'type' => 'select',
				'itemsProcFunc' => 'TYPO3\\CMS\\Setup\\Controller\\SetupModuleController->renderLanguageSelect',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:language',
				'csh' => 'language'
			),
			'startModule' => array(
				'type' => 'select',
				'itemsProcFunc' => 'TYPO3\\CMS\\Setup\\Controller\\SetupModuleController->renderStartModuleSelect',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:startModule',
				'csh' => 'startModule'
			),
			'thumbnailsByDefault' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:showThumbs',
				'csh' => 'showThumbs'
			),
			'titleLen' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:maxTitleLen',
				'csh' => 'maxTitleLen'
			),
			'edit_RTE' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:edit_RTE',
				'csh' => 'edit_RTE'
			),
			'edit_docModuleUpload' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:edit_docModuleUpload',
				'csh' => 'edit_docModuleUpload'
			),
			'showHiddenFilesAndFolders' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:showHiddenFilesAndFolders',
				'csh' => 'showHiddenFilesAndFolders'
			),
			'copyLevels' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:copyLevels',
				'csh' => 'copyLevels'
			),
			'recursiveDelete' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:recursiveDelete',
				'csh' => 'recursiveDelete'
			),
			'simulate' => array(
				'type' => 'select',
				'itemsProcFunc' => 'TYPO3\\CMS\\Setup\\Controller\\SetupModuleController->renderSimulateUserSelect',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:simulate',
				'csh' => 'simuser'
			),
			'resetConfiguration' => array(
				'type' => 'button',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:resetConfiguration',
				'buttonlabel' => 'LLL:EXT:setup/mod/locallang.xlf:resetConfigurationShort',
				'csh' => 'reset',
				'onClick' => 'if (confirm(\'%s\')) { document.getElementById(\'setValuesToDefault\').value = 1; this.form.submit(); }',
				'onClickLabels' => array(
					'LLL:EXT:setup/mod/locallang.xlf:setToStandardQuestion'
				)
			),
			'clearSessionVars' => array(
				'type' => 'button',
				'access' => 'admin',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:clearSessionVars',
				'buttonlabel' => 'LLL:EXT:setup/mod/locallang.xlf:clearSessionVarsShort',
				'csh' => 'reset',
				'onClick' => 'if (confirm(\'%s\')) { document.getElementById(\'clearSessionVars\').value = 1; this.form.submit(); }',
				'onClickLabels' => array(
					'LLL:EXT:setup/mod/locallang.xlf:clearSessionVarsQuestion'
				)
			),
			'resizeTextareas' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:resizeTextareas',
				'csh' => 'resizeTextareas'
			),
			'resizeTextareas_Flexible' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:resizeTextareas_Flexible',
				'csh' => 'resizeTextareas_Flexible'
			),
			'resizeTextareas_MaxHeight' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:flexibleTextareas_MaxHeight',
				'csh' => 'flexibleTextareas_MaxHeight'
			),
			'debugInWindow' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:setup/mod/locallang.xlf:debugInWindow',
				'access' => 'admin'
			)
		),
		'showitem' => '--div--;LLL:EXT:setup/mod/locallang.xlf:personal_data,realName,email,emailMeAtLogin,password,password2,lang,
				--div--;LLL:EXT:setup/mod/locallang.xlf:opening,startModule,thumbnailsByDefault,titleLen,
				--div--;LLL:EXT:setup/mod/locallang.xlf:editFunctionsTab,edit_RTE,edit_docModuleUpload,showHiddenFilesAndFolders,resizeTextareas,resizeTextareas_Flexible,resizeTextareas_MaxHeight,copyLevels,recursiveDelete,resetConfiguration,clearSessionVars,
				--div--;LLL:EXT:setup/mod/locallang.xlf:adminFunctions,simulate,debugInWindow'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: rtehtmlarea
 * File: /var/www/idea/typo3/sysext/rtehtmlarea/ext_tables.php
 */

$_EXTKEY = 'rtehtmlarea';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Add static template for Click-enlarge rendering
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'static/clickenlarge/', 'Clickenlarge Rendering');
// Add configuration of soft references on image tags in RTE content
require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'hooks/softref/ext_tables.php';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rtehtmlarea_acronym');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rtehtmlarea_acronym', 'EXT:' . $_EXTKEY . '/locallang_csh_abbreviation.xlf');
// Add contextual help files
$htmlAreaRteContextHelpFiles = array(
	'General' => 'EXT:' . $_EXTKEY . '/locallang_csh.xlf',
	'Acronym' => 'EXT:' . $_EXTKEY . '/extensions/Acronym/locallang_csh.xlf',
	'EditElement' => 'EXT:' . $_EXTKEY . '/extensions/EditElement/locallang_csh.xlf',
	'Language' => 'EXT:' . $_EXTKEY . '/extensions/Language/locallang_csh.xlf',
	'MicrodataSchema' => 'EXT:' . $_EXTKEY . '/extensions/MicrodataSchema/locallang_csh.xlf',
	'PlainText' => 'EXT:' . $_EXTKEY . '/extensions/PlainText/locallang_csh.xlf',
	'RemoveFormat' => 'EXT:' . $_EXTKEY . '/extensions/RemoveFormat/locallang_csh.xlf',
	'TableOperations' => 'EXT:' . $_EXTKEY . '/extensions/TableOperations/locallang_csh.xlf'
);
foreach ($htmlAreaRteContextHelpFiles as $key => $file) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_' . $key, $file);
}
unset($htmlAreaRteContextHelpFiles);
// Extend TYPO3 User Settings Configuration
if (TYPO3_MODE === 'BE' && \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('setup') && is_array($GLOBALS['TYPO3_USER_SETTINGS'])) {
	$GLOBALS['TYPO3_USER_SETTINGS']['columns'] = array_merge($GLOBALS['TYPO3_USER_SETTINGS']['columns'], array(
		'rteWidth' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:rtehtmlarea/locallang.xlf:rteWidth',
			'csh' => 'xEXT_rtehtmlarea_General:rteWidth'
		),
		'rteHeight' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:rtehtmlarea/locallang.xlf:rteHeight',
			'csh' => 'xEXT_rtehtmlarea_General:rteHeight'
		),
		'rteResize' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:rtehtmlarea/locallang.xlf:rteResize',
			'csh' => 'xEXT_rtehtmlarea_General:rteResize'
		),
		'rteMaxHeight' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:rtehtmlarea/locallang.xlf:rteMaxHeight',
			'csh' => 'xEXT_rtehtmlarea_General:rteMaxHeight'
		),
		'rteCleanPasteBehaviour' => array(
			'type' => 'select',
			'label' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xlf:rteCleanPasteBehaviour',
			'items' => array(
				'plainText' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xlf:plainText',
				'pasteStructure' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xlf:pasteStructure',
				'pasteFormat' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xlf:pasteFormat'
			),
			'csh' => 'xEXT_rtehtmlarea_PlainText:behaviour'
		)
	));
	$GLOBALS['TYPO3_USER_SETTINGS']['showitem'] .= ',--div--;LLL:EXT:rtehtmlarea/locallang.xlf:rteSettings,rteWidth,rteHeight,rteResize,rteMaxHeight,rteCleanPasteBehaviour';
}
if (TYPO3_MODE === 'BE') {
	// Register RTE element browser wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'rtehtmlarea_wizard_element_browser',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod3/'
	);

	// Register RTE wizard_select_image
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'rtehtmlarea_wizard_select_image',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod4/'
	);

	// Register RTE wizard_user
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'rtehtmlarea_wizard_user',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod5/'
	);

	// Register RTE wizard_user
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'rtehtmlarea_wizard_parse_html',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod6/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: reports
 * File: /var/www/idea/typo3/sysext/reports/ext_tables.php
 */

$_EXTKEY = 'reports';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'system',
		'txreportsM1',
		'',
		array(
			'Report' => 'index,detail'
		), array(
			'access' => 'admin',
			'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf'
		)
	);
	$statusReport = array(
		'title' => 'LLL:EXT:reports/reports/locallang.xlf:status_report_title',
		'description' => 'LLL:EXT:reports/reports/locallang.xlf:status_report_description',
		'report' => 'TYPO3\\CMS\\Reports\\Report\\Status\\Status'
	);
	if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'])) {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'] = array();
	}
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'] = array_merge($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'], $statusReport);
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['typo3'][] = 'TYPO3\\CMS\\Reports\\Report\\Status\\Typo3Status';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['system'][] = 'TYPO3\\CMS\\Reports\\Report\\Status\\SystemStatus';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['security'][] = 'TYPO3\\CMS\\Reports\\Report\\Status\\SecurityStatus';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['configuration'][] = 'TYPO3\\CMS\\Reports\\Report\\Status\\ConfigurationStatus';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['fal'][] = 'TYPO3\\CMS\\Reports\\Report\\Status\\FalStatus';
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: perm
 * File: /var/www/idea/typo3/sysext/perm/ext_tables.php
 */

$_EXTKEY = 'perm';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'web',
		'perm',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler('PermissionAjaxController::dispatch', 'TYPO3\\CMS\\Perm\\Controller\\PermissionAjaxController->dispatch');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: lowlevel
 * File: /var/www/idea/typo3/sysext/lowlevel/ext_tables.php
 */

$_EXTKEY = 'lowlevel';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'system',
		'dbint',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'dbint/'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'system',
		'config',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'config/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: info_pagetsconfig
 * File: /var/www/idea/typo3/sysext/info_pagetsconfig/ext_tables.php
 */

$_EXTKEY = 'info_pagetsconfig';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_info',
		'TYPO3\CMS\InfoPagetsconfig\Controller\InfoPageTyposcriptConfigController',
		NULL,
		'LLL:EXT:info_pagetsconfig/locallang.xlf:mod_pagetsconfig'
	);
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_info', 'EXT:info_pagetsconfig/locallang_csh_webinfo.xlf');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: info
 * File: /var/www/idea/typo3/sysext/info/ext_tables.php
 */

$_EXTKEY = 'info';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'web',
		'info',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: impexp
 * File: /var/www/idea/typo3/sysext/impexp/ext_tables.php
 */

$_EXTKEY = 'impexp';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'TYPO3\\CMS\\Impexp\\Clickmenu',
	);
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['taskcenter']['impexp']['tx_impexp_task'] = array(
		'title' => 'LLL:EXT:impexp/locallang_csh.xlf:.alttitle',
		'description' => 'LLL:EXT:impexp/locallang_csh.xlf:.description',
		'icon' => 'EXT:impexp/export.gif'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('xMOD_tx_impexp', 'EXT:impexp/locallang_csh.xlf');
	// CSH labels for TYPO3 4.5 and greater.  These labels override the ones set above, while still falling back to the original labels if no translation is available.
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:impexp/locallang_csh.xml'][] = 'EXT:impexp/locallang_csh_45.xlf';
	// Special context menu actions for the import/export module
	$importExportActions = '
		9000 = DIVIDER

		9100 = ITEM
		9100 {
			name = exportT3d
			label = LLL:EXT:impexp/app/locallang.xlf:export
			spriteIcon = actions-document-export-t3d
			callbackAction = exportT3d
		}

		9200 = ITEM
		9200 {
			name = importT3d
			label = LLL:EXT:impexp/app/locallang.xlf:import
			spriteIcon = actions-document-import-t3d
			callbackAction = importT3d
		}
	';
	// Context menu user default configuration
	$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUserTSconfig'] .= '
		options.contextMenu.table {
			virtual_root.items {
				' . $importExportActions . '
			}

			pages_root.items {
				' . $importExportActions . '
			}

			pages.items.1000 {
				' . $importExportActions . '
			}
		}
	';
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath('xMOD_tximpexp', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'app/');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: func_wizards
 * File: /var/www/idea/typo3/sysext/func_wizards/ext_tables.php
 */

$_EXTKEY = 'func_wizards';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_func',
		'TYPO3\\CMS\\FuncWizards\\Controller\\WebFunctionWizardsBaseController',
		NULL,
		'LLL:EXT:func_wizards/locallang.xlf:mod_wizards'
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('_MOD_web_func', 'EXT:func_wizards/locallang_csh.xlf');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: func
 * File: /var/www/idea/typo3/sysext/func/ext_tables.php
 */

$_EXTKEY = 'func';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'web',
		'func',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: form
 * File: /var/www/idea/typo3/sysext/form/ext_tables.php
 */

$_EXTKEY = 'form';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	// Register wizard
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModulePath(
		'wizard_form',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Modules/Wizards/FormWizard/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: filelist
 * File: /var/www/idea/typo3/sysext/filelist/ext_tables.php
 */

$_EXTKEY = 'filelist';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
		'file',
		'list',
		'',
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'mod1/'
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: extra_page_cm_options
 * File: /var/www/idea/typo3/sysext/extra_page_cm_options/ext_tables.php
 */

$_EXTKEY = 'extra_page_cm_options';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'TYPO3\\CMS\\ExtraPageCmOptions\\ExtraPageContextMenuOptions',
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: documentation
 * File: /var/www/idea/typo3/sysext/documentation/ext_tables.php
 */

$_EXTKEY = 'documentation';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	// Registers a Backend Module
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'help',
		'documentation',
		'top',
		array(
			'Document' => 'list, download, fetch',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: context_help
 * File: /var/www/idea/typo3/sysext/context_help/ext_tables.php
 */

$_EXTKEY = 'context_help';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('fe_groups', 'EXT:context_help/locallang_csh_fe_groups.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('fe_users', 'EXT:context_help/locallang_csh_fe_users.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('pages', 'EXT:context_help/locallang_csh_pages.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('pages_language_overlay', 'EXT:context_help/locallang_csh_pageslol.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('static_template', 'EXT:context_help/locallang_csh_statictpl.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_domain', 'EXT:context_help/locallang_csh_sysdomain.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_file_storage', 'EXT:context_help/locallang_csh_sysfilestorage.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('sys_template', 'EXT:context_help/locallang_csh_systmpl.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tt_content', 'EXT:context_help/locallang_csh_ttcontent.xlf');
// Labels for TYPO3 4.5 and greater.  These labels override the ones set above, while still falling back to the original labels if no translation is available.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:context_help/locallang_csh_pages.xlf'][] = 'EXT:context_help/4.5/locallang_csh_pages.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:context_help/locallang_csh_ttcontent.xlf'][] = 'EXT:context_help/4.5/locallang_csh_ttcontent.xlf';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: beuser
 * File: /var/www/idea/typo3/sysext/beuser/ext_tables.php
 */

$_EXTKEY = 'beuser';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
if (TYPO3_MODE === 'BE') {
	// Module Admin > Backend Users
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'system',
		'tx_Beuser',
		'top',
		array(
			'BackendUser' => 'index, addToCompareList, removeFromCompareList, compare, online, terminateBackendUserSession'
		),
		array(
			'access' => 'admin',
			'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf'
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: belog
 * File: /var/www/idea/typo3/sysext/belog/ext_tables.php
 */

$_EXTKEY = 'belog';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// Register backend modules, but not in frontend or within upgrade wizards
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	// Module Web->Info->Log
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_info',
		'TYPO3\\CMS\\Belog\\Module\\BackendLogModuleBootstrap',
		NULL,
		'Log'
	);

	// Module Tools->Log
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'system',
		'log',
		'',
		array(
			'Tools' => 'index',
			'WebInfo' => 'index',
		),
		array(
			'access' => 'admin',
			'icon' => 'EXT:belog/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: aboutmodules
 * File: /var/www/idea/typo3/sysext/aboutmodules/ext_tables.php
 */

$_EXTKEY = 'aboutmodules';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Avoid that this block is loaded in frontend or within upgrade wizards
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'help',
		'aboutmodules',
		'after:about',
		array(
			'Modules' => 'index'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:aboutmodules/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf'
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: about
 * File: /var/www/idea/typo3/sysext/about/ext_tables.php
 */

$_EXTKEY = 'about';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Avoid that this block is loaded in frontend or within upgrade wizards
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.CMS.' . $_EXTKEY,
		'help',
		'about',
		'top',
		array('About' => 'index'),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:about/ext_icon.gif',
			'labels' => 'LLL:EXT:lang/locallang_mod_help_about.xlf'
		)
	);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: jfmulticontent
 * File: /var/www/idea/typo3conf/ext/jfmulticontent/ext_tables.php
 */

$_EXTKEY = 'jfmulticontent';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}



// get extension configuration
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jfmulticontent']);



$tempColumns = array(
	'tx_jfmulticontent_view' => array(
		'exclude' => 1,
		'onChange' => 'reload',
		'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view',
		'config' => array (
			'type' => 'select',
			'size' => 1,
			'maxitems' => 1,
			'default' => 'content',
			'items' => array(
				array('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view.I.0', 'content'),
				array('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view.I.1', 'page'),
				array('LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.view.I.2', 'irre'),
			),
			'itemsProcFunc' => 'EXT:jfmulticontent/lib/class.tx_jfmulticontent_itemsProcFunc.php:&tx_jfmulticontent_itemsProcFunc->getViews',
		)
	),
	'tx_jfmulticontent_pages' => array(
		'exclude' => 1,
		'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:page',
		'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.pages',
		'config' => array (
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'pages',
			'size' => 12,
			'minitems' => 0,
			'maxitems' => 1000,
			'wizards' => array(
				'suggest' => array(
					'type' => 'suggest',
				),
			),
		)
	),
	'tx_jfmulticontent_irre' => Array (
		'exclude' => 1,
		'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:irre',
		'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.irre',
		'config' => array (
			'type' => 'inline',
			'foreign_table' => 'tt_content',
			'foreign_field' => 'tx_jfmulticontent_irre_parentid',
			'foreign_sortby' => 'sorting',
			'foreign_label' => 'header',
			'maxitems' => 1000,
			'appearance' => array(
				'showSynchronizationLink' => FALSE,
				'showAllLocalizationLink' => FALSE,
				'showPossibleLocalizationRecords' => FALSE,
				'showRemovedLocalizationRecords' => FALSE,
				'expandSingle' => TRUE,
				'newRecordLinkAddTitle' => TRUE,
				'useSortable' => TRUE,
			),
			'behaviour' => array(
				'localizeChildrenAtParentLocalization' => 1,
				'localizationMode' => 'select',
			),
		)
	),
);



if ($confArr["useStoragePidOnly"]) {
	$tempColumns['tx_jfmulticontent_contents'] = array(
		'exclude' => 1,
		'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:,content',
		'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents',
		'config' => array (
			'type' => 'select',
			'foreign_table' => 'tt_content',
			'foreign_table_where' => 'AND tt_content.pid=###STORAGE_PID### AND tt_content.hidden=0 AND tt_content.deleted=0 AND tt_content.sys_language_uid IN (0,-1) ORDER BY tt_content.uid',
			'size' => 12,
			'minitems' => 0,
			'maxitems' => 1000,
			'wizards' => array(
				'_PADDING'  => 2,
				'_VERTICAL' => 1,
				'add' => array(
					'type'   => 'script',
					'title'  => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_add',
					'icon'   => 'add.gif',
					'script' => 'wizard_add.php',
					'params' => array(
						'table'    => 'tt_content',
						'pid'      => '###STORAGE_PID###',
						'setValue' => 'prepend'
					),
				),
				'list' => array(
					'type'   => 'script',
					'title'  => 'List',
					'icon'   => 'list.gif',
					'script' => 'wizard_list.php',
					'params' => array(
						'table' => 'tt_content',
						'pid'   => '###STORAGE_PID###',
					),
				),
				'edit' => array(
					'type'   => 'popup',
					'title'  => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_edit',
					'icon'   => 'edit2.gif',
					'script' => 'wizard_edit.php',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=600,width=800,status=0,menubar=0,scrollbars=1',
				),
			),
		)
	);
} else {
	$tempColumns['tx_jfmulticontent_contents'] = array(
		'exclude' => 1,
		'displayCond' => 'FIELD:tx_jfmulticontent_view:IN:,content',
		'label' => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents',
		'config' => array (
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tt_content',
			'size' => 12,
			'minitems' => 0,
			'maxitems' => 1000,
			'wizards' => array(
				'_PADDING'  => 2,
				'_VERTICAL' => 1,
				'add' => array(
					'type'   => 'script',
					'title'  => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_add',
					'icon'   => 'add.gif',
					'script' => 'wizard_add.php',
					'params' => array(
						'table'    => 'tt_content',
						'pid'      => '###STORAGE_PID###',
						'setValue' => 'prepend'
					),
				),
				'list' => array(
					'type'   => 'script',
					'title'  => 'List',
					'icon'   => 'list.gif',
					'script' => 'wizard_list.php',
					'params' => array(
						'table' => 'tt_content',
						'pid'   => '###STORAGE_PID###',
					),
				),
				'edit' => array(
					'type'   => 'popup',
					'title'  => 'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.tx_jfmulticontent.contents_edit',
					'icon'   => 'edit2.gif',
					'script' => 'wizard_edit.php',
					'popup_onlyOpenIfSelected' => 1,
					'JSopenParams' => 'height=600,width=800,status=0,menubar=0,scrollbars=1',
				),
			),
		)
	);
}


t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns, 1);
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1'] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] = 'tx_jfmulticontent_view,tx_jfmulticontent_pages,tx_jfmulticontent_contents,tx_jfmulticontent_irre,pi_flexform';
// Add reload field to tt_content
$TCA['tt_content']['ctrl']['requestUpdate'] .= ($TCA['tt_content']['ctrl']['requestUpdate'] ? ',' : ''). 'tx_jfmulticontent_view';

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:jfmulticontent/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds.xml');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_jfmulticontent_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_jfmulticontent_pi1_wizicon.php';
	if (! isset($TCA['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']])) {
		// Add the new colPos to the array, only if the ID does not exist...
		$TCA['tt_content']['columns']['colPos']['config']['items'][$confArr['colPosOfIrreContent']] = array ($_EXTKEY, $confArr['colPosOfIrreContent']);
	}
}


t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Multi content');



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: realurl
 * File: /var/www/idea/typo3conf/ext/realurl/ext_tables.php
 */

$_EXTKEY = 'realurl';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
//	t3lib_extMgm::addModule('tools','txrealurlM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');

	// Add Web>Info module:
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_realurl_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY) . 'modfunc1/class.tx_realurl_modfunc1.php',
		'LLL:EXT:realurl/locallang_db.xml:moduleFunction.tx_realurl_modfunc1',
		'function',
		'online'
	);
}

if (version_compare(TYPO3_branch, '6.1', '<')) {
	t3lib_div::loadTCA('pages');
}
$TCA['pages']['columns'] += array(
	'tx_realurl_pathsegment' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_pathsegment',
		'displayCond' => 'FIELD:tx_realurl_exclude:!=:1',
		'exclude' => 1,
		'config' => array (
			'type' => 'input',
			'max' => 255,
			'eval' => 'trim,nospace,lower'
		),
	),
	'tx_realurl_pathoverride' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_path_override',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', '')
			)
		)
	),
	'tx_realurl_exclude' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_exclude',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', '')
			)
		)
	),
	'tx_realurl_nocache' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_nocache',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', ''),
			),
		),
	)
);

$TCA['pages']['ctrl']['requestUpdate'] .= ',tx_realurl_exclude';

$TCA['pages']['palettes']['137'] = array(
	'showitem' => 'tx_realurl_pathoverride'
);

if (t3lib_div::compat_version('4.3')) {
	t3lib_extMgm::addFieldsToPalette('pages', '3', 'tx_realurl_nocache', 'after:cache_timeout');
}
if (t3lib_div::compat_version('4.2')) {
	// For 4.2 or new add fields to advanced page only
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '1', 'after:nav_title');
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '4,199,254', 'after:title');
}
else {
	// Put it for standard page
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '2', 'after:nav_title');
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '1,5,4,199,254', 'after:title');
}

t3lib_extMgm::addLLrefForTCAdescr('pages','EXT:realurl/locallang_csh.xml');

$TCA['pages_language_overlay']['columns'] += array(
	'tx_realurl_pathsegment' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_pathsegment',
		'exclude' => 1,
		'config' => array (
			'type' => 'input',
			'max' => 255,
			'eval' => 'trim,nospace,lower'
		),
	),
);

t3lib_extMgm::addToAllTCAtypes('pages_language_overlay', 'tx_realurl_pathsegment', '', 'after:nav_title');



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: bootstrap_package
 * File: /var/www/idea/typo3conf/ext/bootstrap_package/ext_tables.php
 */

$_EXTKEY = 'bootstrap_package';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if(!defined('TYPO3_MODE')){
    die('Access denied.');
}


/***************
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Bootstrap Package');


/***************
 * BackendLayoutDataProvider
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['BackendLayoutDataProvider'][$_EXTKEY] = 'BK2K\BootstrapPackage\Hooks\Options\BackendLayoutDataProvider';


/***************
 * DataHandler Hook
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'BK2K\BootstrapPackage\Hooks\DataHandler';


/***************
 * Adding tt_content menu - news content element specific tca
 */
$TCA['tt_content']['types']['menu']['subtypes_excludelist']['news'] = "selected_categories, category_field";


/***************
 * Bootstrap Palettes
 */
$TCA['tt_content']['palettes']['bootstrap_package_header'] = array(
    'canNotCollapse' => 1,
    'showitem' => '
        header;LLL:EXT:cms/locallang_ttc.xlf:header_formlabel,
        --linebreak--, 
        subheader;LLL:EXT:cms/locallang_ttc.xlf:subheader_formlabel,
        --linebreak--, 
        header_layout;LLL:EXT:cms/locallang_ttc.xlf:header_layout_formlabel,
        --linebreak--, 
        header_link;LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel
    '
);
$TCA['tt_content']['palettes']['bootstrap_package_headersimple'] = array(
    'canNotCollapse' => 1,
    'showitem' => '
        header;LLL:EXT:cms/locallang_ttc.xlf:header_formlabel,
        --linebreak--, 
        header_layout;LLL:EXT:cms/locallang_ttc.xlf:header_layout_formlabel
    '
);
$TCA['tt_content']['palettes']['bootstrap_package_icons'] = array(
    'canNotCollapse' => 1,
    'showitem' => '
        icon_position, icon_type, icon_size, --linebreak--,
        icon_color, icon_background, --linebreak--,
        icon
    '
);


/***************
 * Add Content Elements to List
 */
$backupCTypeItems = $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'] = array(
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:theme_name',
        '--div--'
    ),
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:content_element.texticon',
        'bootstrap_package_texticon',
        'i/tt_content_header.gif'
    ),
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:content_element.carousel',
        'bootstrap_package_carousel',
        'i/tt_content_header.gif'
    ),
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:content_element.accordion',
        'bootstrap_package_accordion',
        'i/tt_content_header.gif'
    ),
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:content_element.panel',
        'bootstrap_package_panel',
        'i/tt_content_header.gif'
    ),
    array(
        'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:content_element.listgroup',
        'bootstrap_package_listgroup',
        'i/tt_content_header.gif'
    )
);
foreach($backupCTypeItems as $key => $value){
    $GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = $value;
}
unset($key);
unset($value);
unset($backupCTypeItems);


/***************
 * Text Icon
 */
$TCA['tt_content']['ctrl']['requestUpdate'] .= ',icon_type';
$TCA['tt_content']['ctrl']['typeicons']['bootstrap_package_texticon'] = 'tt_content_header.gif';
$TCA['tt_content']['types']['bootstrap_package_texticon'] = $TCA['tt_content']['types']['text'];
$texticon_columns = array(
    'icon' => array(
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon',
        'config' => array(
            'type' => 'select',
            'selicon_cols' => 14,
            'items' => array(
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.none',0,'EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/none.jpg'),
                array('asterisk','asterisk','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0000_asterisk.jpg'),
                array('plus','plus','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0001_plus.jpg'),
                array('euro','euro','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0002_euro.jpg'),
                array('minus','minus','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0003_minus.jpg'),
                array('cloud','cloud','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0004_cloud.jpg'),
                array('envelope','envelope','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0005_envelope.jpg'),
                array('pencil','pencil','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0006_pencil.jpg'),
                array('glass','glass','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0007_glass.jpg'),
                array('music','music','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0008_music.jpg'),
                array('search','search','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0009_search.jpg'),
                array('heart','heart','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0010_heart.jpg'),
                array('star','star','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0011_star.jpg'),
                array('star-empty','star-empty','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0012_star-empty.jpg'),
                array('user','user','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0013_user.jpg'),
                array('film','film','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0014_film.jpg'),
                array('th-large','th-large','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0015_th-large.jpg'),
                array('th','th','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0016_th.jpg'),
                array('th-list','th-list','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0017_th-list.jpg'),
                array('ok','ok','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0018_ok.jpg'),
                array('remove','remove','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0019_remove.jpg'),
                array('zoom-in','zoom-in','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0020_zoom-in.jpg'),
                array('zoom-out','zoom-out','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0021_zoom-out.jpg'),
                array('off','off','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0022_off.jpg'),
                array('signal','signal','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0023_signal.jpg'),
                array('cog','cog','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0024_cog.jpg'),
                array('trash','trash','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0025_trash.jpg'),
                array('home','home','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0026_home.jpg'),
                array('file','file','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0027_file.jpg'),
                array('time','time','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0028_time.jpg'),
                array('road','road','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0029_road.jpg'),
                array('download-alt','download-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0030_download-alt.jpg'),
                array('download','download','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0031_download.jpg'),
                array('upload','upload','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0032_upload.jpg'),
                array('inbox','inbox','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0033_inbox.jpg'),
                array('play-circle','play-circle','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0034_play-circle.jpg'),
                array('repeat','repeat','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0035_repeat.jpg'),
                array('refresh','refresh','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0036_refresh.jpg'),
                array('list-alt','list-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0037_list-alt.jpg'),
                array('lock','lock','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0038_lock.jpg'),
                array('flag','flag','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0039_flag.jpg'),
                array('headphones','headphones','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0040_headphones.jpg'),
                array('volume-off','volume-off','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0041_volume-off.jpg'),
                array('volume-down','volume-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0042_volume-down.jpg'),
                array('volume-up','volume-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0043_volume-up.jpg'),
                array('qrcode','qrcode','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0044_qrcode.jpg'),
                array('barcode','barcode','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0045_barcode.jpg'),
                array('tag','tag','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0046_tag.jpg'),
                array('tags','tags','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0047_tags.jpg'),
                array('book','book','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0048_book.jpg'),
                array('bookmark','bookmark','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0049_bookmark.jpg'),
                array('print','print','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0050_print.jpg'),
                array('camera','camera','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0051_camera.jpg'),
                array('font','font','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0052_font.jpg'),
                array('bold','bold','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0053_bold.jpg'),
                array('italic','italic','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0054_italic.jpg'),
                array('text-height','text-height','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0055_text-height.jpg'),
                array('text-width','text-width','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0056_text-width.jpg'),
                array('align-left','align-left','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0057_align-left.jpg'),
                array('align-center','align-center','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0058_align-center.jpg'),
                array('align-right','align-right','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0059_align-right.jpg'),
                array('align-justify','align-justify','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0060_align-justify.jpg'),
                array('list','list','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0061_list.jpg'),
                array('indent-left','indent-left','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0062_indent-left.jpg'),
                array('indent-right','indent-right','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0063_indent-right.jpg'),
                array('facetime-video','facetime-video','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0064_facetime-video.jpg'),
                array('picture','picture','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0065_picture.jpg'),
                array('map-marker','map-marker','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0066_map-marker.jpg'),
                array('adjust','adjust','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0067_adjust.jpg'),
                array('tint','tint','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0068_tint.jpg'),
                array('edit','edit','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0069_edit.jpg'),
                array('share','share','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0070_share.jpg'),
                array('check','check','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0071_check.jpg'),
                array('move','move','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0072_move.jpg'),
                array('step-backward','step-backward','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0073_step-backward.jpg'),
                array('fast-backward','fast-backward','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0074_fast-backward.jpg'),
                array('backward','backward','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0075_backward.jpg'),
                array('play','play','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0076_play.jpg'),
                array('pause','pause','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0077_pause.jpg'),
                array('stop','stop','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0078_stop.jpg'),
                array('forward','forward','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0079_forward.jpg'),
                array('fast-forward','fast-forward','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0080_fast-forward.jpg'),
                array('step-forward','step-forward','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0081_step-forward.jpg'),
                array('eject','eject','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0082_eject.jpg'),
                array('chevron-left','chevron-left','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0083_chevron-left.jpg'),
                array('chevron-right','chevron-right','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0084_chevron-right.jpg'),
                array('plus-sign','plus-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0085_plus-sign.jpg'),
                array('minus-sign','minus-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0086_minus-sign.jpg'),
                array('remove-sign','remove-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0087_remove-sign.jpg'),
                array('ok-sign','ok-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0088_ok-sign.jpg'),
                array('question-sign','question-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0089_question-sign.jpg'),
                array('info-sign','info-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0090_info-sign.jpg'),
                array('screenshot','screenshot','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0091_screenshot.jpg'),
                array('remove-circle','remove-circle','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0092_remove-circle.jpg'),
                array('ok-circle','ok-circle','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0093_ok-circle.jpg'),
                array('ban-circle','ban-circle','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0094_ban-circle.jpg'),
                array('arrow-left','arrow-left','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0095_arrow-left.jpg'),
                array('arrow-right','arrow-right','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0096_arrow-right.jpg'),
                array('arrow-up','arrow-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0097_arrow-up.jpg'),
                array('arrow-down','arrow-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0098_arrow-down.jpg'),
                array('share-alt','share-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0099_share-alt.jpg'),
                array('resize-full','resize-full','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0100_resize-full.jpg'),
                array('resize-small','resize-small','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0101_resize-small.jpg'),
                array('exclamation-sign','exclamation-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0102_exclamation-sign.jpg'),
                array('gift','gift','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0103_gift.jpg'),
                array('leaf','leaf','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0104_leaf.jpg'),
                array('fire','fire','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0105_fire.jpg'),
                array('eye-open','eye-open','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0106_eye-open.jpg'),
                array('eye-close','eye-close','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0107_eye-close.jpg'),
                array('warning-sign','warning-sign','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0108_warning-sign.jpg'),
                array('plane','plane','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0109_plane.jpg'),
                array('calendar','calendar','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0110_calendar.jpg'),
                array('random','random','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0111_random.jpg'),
                array('comment','comment','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0112_comment.jpg'),
                array('magnet','magnet','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0113_magnet.jpg'),
                array('chevron-up','chevron-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0114_chevron-up.jpg'),
                array('chevron-down','chevron-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0115_chevron-down.jpg'),
                array('retweet','retweet','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0116_retweet.jpg'),
                array('shopping-cart','shopping-cart','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0117_shopping-cart.jpg'),
                array('folder-close','folder-close','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0118_folder-close.jpg'),
                array('folder-open','folder-open','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0119_folder-open.jpg'),
                array('resize-vertical','resize-vertical','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0120_resize-vertical.jpg'),
                array('resize-horizontal','resize-horizontal','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0121_resize-horizontal.jpg'),
                array('hdd','hdd','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0122_hdd.jpg'),
                array('bullhorn','bullhorn','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0123_bullhorn.jpg'),
                array('bell','bell','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0124_bell.jpg'),
                array('certificate','certificate','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0125_certificate.jpg'),
                array('thumbs-up','thumbs-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0126_thumbs-up.jpg'),
                array('thumbs-down','thumbs-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0127_thumbs-down.jpg'),
                array('hand-right','hand-right','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0128_hand-right.jpg'),
                array('hand-left','hand-left','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0129_hand-left.jpg'),
                array('hand-up','hand-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0130_hand-up.jpg'),
                array('hand-down','hand-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0131_hand-down.jpg'),
                array('circle-arrow-right','circle-arrow-right','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0132_circle-arrow-right.jpg'),
                array('circle-arrow-left','circle-arrow-left','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0133_circle-arrow-left.jpg'),
                array('circle-arrow-up','circle-arrow-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0134_circle-arrow-up.jpg'),
                array('circle-arrow-down','circle-arrow-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0135_circle-arrow-down.jpg'),
                array('globe','globe','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0136_globe.jpg'),
                array('wrench','wrench','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0137_wrench.jpg'),
                array('tasks','tasks','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0138_tasks.jpg'),
                array('filter','filter','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0139_filter.jpg'),
                array('briefcase','briefcase','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0140_briefcase.jpg'),
                array('fullscreen','fullscreen','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0141_fullscreen.jpg'),
                array('dashboard','dashboard','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0142_dashboard.jpg'),
                array('paperclip','paperclip','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0143_paperclip.jpg'),
                array('heart-empty','heart-empty','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0144_heart-empty.jpg'),
                array('link','link','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0145_link.jpg'),
                array('phone','phone','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0146_phone.jpg'),
                array('pushpin','pushpin','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0147_pushpin.jpg'),
                array('usd','usd','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0148_usd.jpg'),
                array('gbp','gbp','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0149_gbp.jpg'),
                array('sort','sort','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0150_sort.jpg'),
                array('sort-by-alphabet','sort-by-alphabet','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0151_sort-by-alphabet.jpg'),
                array('sort-by-alphabet-alt','sort-by-alphabet-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0152_sort-by-alphabet-alt.jpg'),
                array('sort-by-order','sort-by-order','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0153_sort-by-order.jpg'),
                array('sort-by-order-alt','sort-by-order-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0154_sort-by-order-alt.jpg'),
                array('sort-by-attributes','sort-by-attributes','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0155_sort-by-attributes.jpg'),
                array('sort-by-attributes-alt','sort-by-attributes-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0156_sort-by-attributes-alt.jpg'),
                array('unchecked','unchecked','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0157_unchecked.jpg'),
                array('expand','expand','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0158_expand.jpg'),
                array('collapse-down','collapse-down','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0159_collapse-down.jpg'),
                array('collapse-up','collapse-up','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0160_collapse-up.jpg'),
                array('log-in','log-in','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0161_log-in.jpg'),
                array('flash','flash','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0162_flash.jpg'),
                array('log-out','log-out','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0163_log-out.jpg'),
                array('new-window','new-window','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0164_new-window.jpg'),
                array('record','record','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0165_record.jpg'),
                array('save','save','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0166_save.jpg'),
                array('open','open','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0167_open.jpg'),
                array('saved','saved','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0168_saved.jpg'),
                array('import','import','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0169_import.jpg'),
                array('export','export','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0170_export.jpg'),
                array('send','send','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0171_send.jpg'),
                array('floppy-disk','floppy-disk','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0172_floppy-disk.jpg'),
                array('floppy-saved','floppy-saved','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0173_floppy-saved.jpg'),
                array('floppy-remove','floppy-remove','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0174_floppy-remove.jpg'),
                array('floppy-save','floppy-save','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0175_floppy-save.jpg'),
                array('floppy-open','floppy-open','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0176_floppy-open.jpg'),
                array('credit-card','credit-card','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0177_credit-card.jpg'),
                array('transfer','transfer','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0178_transfer.jpg'),
                array('cutlery','cutlery','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0179_cutlery.jpg'),
                array('header','header','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0180_header.jpg'),
                array('compressed','compressed','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0181_compressed.jpg'),
                array('earphone','earphone','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0182_earphone.jpg'),
                array('phone-alt','phone-alt','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0183_phone-alt.jpg'),
                array('tower','tower','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0184_tower.jpg'),
                array('stats','stats','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0185_stats.jpg'),
                array('sd-video','sd-video','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0186_sd-video.jpg'),
                array('hd-video','hd-video','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0187_hd-video.jpg'),
                array('subtitles','subtitles','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0188_subtitles.jpg'),
                array('sound-stereo','sound-stereo','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0189_sound-stereo.jpg'),
                array('sound-dolby','sound-dolby','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0190_sound-dolby.jpg'),
                array('sound-5-1','sound-5-1','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0191_sound-5-1.jpg'),
                array('sound-6-1','sound-6-1','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0192_sound-6-1.jpg'),
                array('sound-7-1','sound-7-1','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0193_sound-7-1.jpg'),
                array('copyright-mark','copyright-mark','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0194_copyright-mark.jpg'),
                array('registration-mark','registration-mark','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0195_registration-mark.jpg'),
                array('cloud-download','cloud-download','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0196_cloud-download.jpg'),
                array('cloud-upload','cloud-upload','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0197_cloud-upload.jpg'),
                array('tree-conifer','tree-conifer','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0198_tree-conifer.jpg'),
                array('tree-deciduous','tree-deciduous','EXT:'.$_EXTKEY.'/Resources/Public/Images/Icons/icon-shapes_0199_tree-deciduous.jpg'),
            ),
        ),
    ),
    'icon_position' => array(
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon_position',
        'config' => array(
            'type' => 'select',
            'items' => array(
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.left', 'left'),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.right', 'right'),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.top', 'top'),
            ),
        ),
    ),
    'icon_type' => array(
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon_type',
        'config' => array(
            'type' => 'select',
            'default' => '0',
            'items' => array(
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.default', 0),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.square', 1),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.circle', 2),
            ),
        ),
    ),
    'icon_size' => array(
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon_size',
        'config' => array(
            'type' => 'select',
            'items' => array(
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.default', 0),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.medium', 1),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.large', 2),
                array('LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:option.awesome', 3),
            ),
        ),
    ),
    'icon_color' => array(
        'displayCond' => 'FIELD:icon_type:!=:0',
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon_color',
        'config' => array(
            'type' => 'input',
            'size' => 10,
            'eval' => 'trim',
            'default' => '#FFFFFF',
            'wizards' => array(
                'colorChoice' => array(
                     'type' => 'colorbox',
                     'title' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:colorpicker',
                     'script' => 'wizard_colorpicker.php',
                     'dim' => '20x20',
                     'JSopenParams' => 'height=600,width=380,status=0,menubar=0,scrollbars=1',
                 ),
            ),
        ),
    ),
    'icon_background' => array(
        'displayCond' => 'FIELD:icon_type:!=:0',
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon_background',
        'config' => array(
            'type' => 'input',
            'size' => 10,
            'eval' => 'trim',
            'default' => '#333333',
            'wizards' => array(
                'colorChoice' => array(
                     'type' => 'colorbox',
                     'title' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:colorpicker',
                     'script' => 'wizard_colorpicker.php',
                     'dim' => '20x20',
                     'JSopenParams' => 'height=600,width=380,status=0,menubar=0,scrollbars=1',
                 ),
            ),
        ),
    ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$texticon_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:field.icon;bootstrap_package_icons,',
    'bootstrap_package_texticon',
    'after:header'
);
unset($texticon_columns);


/***************
 * Panel
 */
$TCA['tt_content']['ctrl']['typeicons']['bootstrap_package_panel'] = 'tt_content_header.gif';
$TCA['tt_content']['types']['bootstrap_package_panel']['showitem'] = "
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.headers;bootstrap_package_headersimple,
    bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext_formlabel;;richtext:rte_transform[flag=rte_enabled|mode=ts_css], 
    rte_enabled;LLL:EXT:cms/locallang_ttc.xlf:rte_enabled_formlabel,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
    --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
    categories
";

/***************
 * List Group
 */
$TCA['tt_content']['ctrl']['typeicons']['bootstrap_package_listgroup'] = 'tt_content_header.gif';
$TCA['tt_content']['types']['bootstrap_package_listgroup']['showitem'] = "
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.headers;bootstrap_package_header,
    bodytext;LLL:EXT:cms/locallang_ttc.xlf:bodytext.ALT.bulletlist_formlabel;;nowrap,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
    --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
    categories
";


/***************
 * Carousel and Carousel Item
 */
$carousel_columns = array(
    'tx_bootstrappackage_carousel_item' => array(
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:carousel_item',
        'config' => array(
            'type' => 'inline',
            'foreign_table' => 'tx_bootstrappackage_carousel_item',
            'foreign_field' => 'tt_content',
            'appearance' => array(
                'useSortable' => TRUE,
                'showSynchronizationLink' => TRUE,
                'showAllLocalizationLink' => TRUE,
                'showPossibleLocalizationRecords' => TRUE,
                'showRemovedLocalizationRecords' => FALSE,
                'expandSingle' => TRUE,
                'enabledControls' => array (
                    'localize' => TRUE,
                ),
            ),
            'behaviour' => array(
                'localizationMode' => 'select',
                'mode' => 'select',
                'localizeChildrenAtParentLocalization' => TRUE,
            ),
        ),
    ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$carousel_columns);
unset($carousel_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrappackage_carousel_item');
$TCA['tx_bootstrappackage_carousel_item'] = array(
    'ctrl' => array(
        'label' => 'header',
        'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
        'title'	=> 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:carousel_item',
        'type' => 'item_type',
		'delete' => 'deleted',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'hideAtCopy' => FALSE,
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xlf:LGL.prependAtCopy',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'languageField' => 'sys_language_uid',
        'dividers2tabs' => TRUE,
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'typeicons' => array(
            'header' => 'tt_content_header.gif',
            'html' => 'tt_content_html.gif',
            'textandimage' => 'tt_content_textpic.gif',
        ),
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/CarouselItem.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/bootstrap_package_item_teaser.gif'
    ),
);
$TCA['tt_content']['types']['bootstrap_package_carousel']['showitem'] = "
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.headers;bootstrap_package_header,
    tx_bootstrappackage_carousel_item,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
    --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
    categories
";


/***************
 * Accordion and Accordion Item
 */
$accordion_columns = array(
    'tx_bootstrappackage_accordion_item' => array(
        'label' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:accordion_item',
        'config' => array(
            'type' => 'inline',
            'foreign_table' => 'tx_bootstrappackage_accordion_item',
            'foreign_field' => 'tt_content',
            'appearance' => array(
                'useSortable' => TRUE,
                'showSynchronizationLink' => TRUE,
                'showAllLocalizationLink' => TRUE,
                'showPossibleLocalizationRecords' => TRUE,
                'showRemovedLocalizationRecords' => FALSE,
                'expandSingle' => TRUE,
                'enabledControls' => array (
                    'localize' => TRUE,
                ),
            ),
            'behaviour' => array(
                'localizationMode' => 'select',
                'mode' => 'select',
                'localizeChildrenAtParentLocalization' => TRUE,
            ),
        ),
    ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$accordion_columns);
unset($accordion_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrappackage_accordion_item');
$TCA['tx_bootstrappackage_accordion_item'] = array(
    'ctrl' => array(  
        'label' => 'header',
		'label_alt' => 'bodytext',
		'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'title' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/Backend.xlf:accordion_item',
		'delete' => 'deleted',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'hideAtCopy' => FALSE,
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xlf:LGL.prependAtCopy',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'languageField' => 'sys_language_uid',
        'dividers2tabs' => TRUE,
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/AccordionItem.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/bootstrap_package_item_accordion.gif'
    ),
);
$TCA['tt_content']['types']['bootstrap_package_accordion']['showitem'] = "
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.headers;bootstrap_package_header,
    tx_bootstrappackage_accordion_item,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
    --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
    --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
    categories
";


/***************
 * Backend Module
 */
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {

    $mainModuleName = 'bootstrappackage';

    /***************
     * Register Main Module
     */
    if (!isset($TBE_MODULES[$mainModuleName])) {
        $temp_TBE_MODULES = array();
        foreach ($TBE_MODULES as $key => $val) {
            if ($key == 'web') {
                $temp_TBE_MODULES[$key] = $val;
                $temp_TBE_MODULES[$mainModuleName] = '';
            } else {
                $temp_TBE_MODULES[$key] = $val;
            }
        }
        $TBE_MODULES = $temp_TBE_MODULES;
    }
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'BK2K.'.$_EXTKEY,
        $mainModuleName,
        '',
        '',
        array()
    );
    $TBE_MODULES['_configuration'][$mainModuleName]['access'] = 'user,group';
    $TBE_MODULES['_configuration'][$mainModuleName]['icon'] = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/bootstrap_package_module_style.gif';
    $TBE_MODULES['_configuration'][$mainModuleName]['labels'] = 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/MainModule.xlf';

    /***************
     * Register Settings Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'BK2K.'.$_EXTKEY,
        $mainModuleName,
        'SettingsStyle',
        '',
        array(
            'SettingsStyle' => 'settings,save',
        ),
        array(
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/bootstrap_package_module_style.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModSettings.xlf',
        )
    );

    /***************
     * Backend Forms Style
     */
    $TCA['__bootstrappackage_form_style'] = array(
        'ctrl' => array(
            'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ThemeSettings.xlf:theme.settings.style',
            'hideTable' => true,
            'canNotCollapse' => true,
            'dividers2tabs' => true,
            'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Forms/SettingsStyle.php',
            'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
        ),
    );

}


/***************
 * Backend Styling
 */
if (TYPO3_MODE == 'BE') {
    $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
    if(!isset($settings['Logo'])){
        $settings['Logo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Backend/TopBarLogo@2x.png';
    }
    if(!isset($settings['LoginLogo'])){
        $settings['LoginLogo'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Images/Backend/LoginLogo.png';
    }
    $GLOBALS['TBE_STYLES']['logo'] = $settings['Logo'];
    $GLOBALS['TBE_STYLES']['logo_login'] = $settings['LoginLogo'];
    $GLOBALS['TBE_STYLES']['htmlTemplates']['EXT:backend/Resources/Private/Templates/login.html'] = 'EXT:bootstrap_package/Resources/Private/Templates/Backend/Login.html';
    unset($settings);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

/**
 * Extension: formhandler
 * File: /var/www/idea/typo3conf/ext/formhandler/ext_tables.php
 */

$_EXTKEY = 'formhandler';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


/**
 * ext tables config file for ext: "formhandler"
 *
 * @author Reinhard Führicht <rf@typoheads.at>

 * @package	Tx_Formhandler
 */

if (!defined ('TYPO3_MODE')) die ('Access denied.');

if (TYPO3_MODE === 'BE') {

	// dynamic flexform
	include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . '/Resources/PHP/class.tx_dynaflex.php');

	\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');

	$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi1'] = 'layout,select_key,pages';

	// Add flexform field to plugin options
	$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';

	$file = 'FILE:EXT:' . $_EXTKEY . '/Resources/XML/flexform_ds.xml';

	// Add flexform DataStructure
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY . '_pi1', $file);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule('web', 'txformhandlermoduleM1', '', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/Module/');
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_formhandler_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/PHP/class.tx_formhandler_wizicon.php';
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/Settings/', 'Example Configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array('Formhandler', $_EXTKEY . '_pi1'), 'list_type');

$TCA['tx_formhandler_log'] = array (
	'ctrl' => array (
		'title' => 'LLL:EXT:formhandler/Resources/Language/locallang_db.xml:tx_formhandler_log',
		'label' => 'uid',
		'default_sortby' => 'ORDER BY crdate DESC',
		'crdate' => 'crdate',
		'tstamp' => 'tstamp',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'tca.php',
		'adminOnly' => 1
	)
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_formhandler_log');

$TCA['pages']['columns']['module']['config']['items'][] = array(
	'LLL:EXT:' . $_EXTKEY . '/Resources/Language/locallang.xml:title',
	'formlogs',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
);
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-formlogs', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Images/pagetreeicon.png');



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::loadNewTcaColumnsConfigFiles();

#
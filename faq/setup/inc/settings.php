<?php
/* *************************************************************************
 Id: settings.php

osFaq install/upgrade settings and course error handling.
This file is required by the installer and the upgrader.


Tim Gall
Copyright (c) 2009-2017 osfaq.oz-devworx.com.au - All Rights Reserved.
http://osfaq.oz-devworx.com.au

This file is part of osFaq.

Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

//trigger ouput buffering for redirections
ob_start("bufferOutput");
function bufferOutput($buffer){
	return $buffer;
}


// allow system error messages during install
$error_reporting = E_ALL ^ E_NOTICE;
if (defined('E_STRICT')) # 5.4.0
	$error_reporting &= ~E_STRICT;
if (defined('E_DEPRECATED')) # 5.3.0
	$error_reporting &= ~(E_DEPRECATED | E_USER_DEPRECATED);

error_reporting($error_reporting);
ini_set('magic_quotes_gpc', 0);
ini_set('session.use_trans_sid', 0);
ini_set('session.cache_limiter', 'nocache');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

session_start();


// sql
define('FAQS_SQL_FILE', 'inc/osfaq-130ST.sql');
define('FAQS_SQL_UP_FILE_2', 'inc/osfaq-10rc2-to-130ST.sql');
define('FAQS_SQL_UP_FILE_3', 'inc/osfaq-10rc3-to-130ST.sql');
define('FAQS_SQL_UP_FILE_4', 'inc/osfaq-10rc4-to-130ST.sql');
define('FAQS_SQL_UP_FILE_5', 'inc/osfaq-10rc5-to-130ST.sql');
define('FAQS_SQL_UP_FILE_6', 'inc/osfaq-10rc6-to-130ST.sql');
define('FAQS_SQL_UP_FILE_7', 'inc/osfaq-10ST-to-130ST.sql');
define('FAQS_SQL_UP_FILE_8', 'inc/osfaq-11ST-to-130ST.sql');
define('FAQS_SQL_UP_FILE_9', 'inc/osfaq-12RC-to-130ST.sql');
define('FAQS_SQL_UP_FILE_10', 'inc/osfaq-12ST-to-130ST.sql');
define('FAQS_SQL_UP_FILE_11', 'inc/osfaq-121ST-to-130ST.sql');
define('FAQS_SQL_UP_FILE_12', 'inc/osfaq-122ST-to-130ST.sql');

// configs
define('ROOT_PATH', '../../');
define('INCLUDE_DIR', '../../include/');//osticket
define('OSFAQ_INCLUDE_DIR', '../include/');//osfaq

// external faq files. EG: outside the faq folder containing this installer (2 directories up).
define('FILE_FAQ_ADMIN', 'scp/osfaq_admin.php');
define('FILE_FAQ_ADMIN_ASSIST', 'scp/osfaq_assist.php');
define('FILE_FAQ', 'osfaq.php');
define('FILE_FAQ_FEED', 'osfaq_feed.php');
define('FILE_FAQ_SUBMIT', 'osfaq_submit.php');


//error flag and message holder
$abortError = false;
$errorMessage = '';

if(isset($_SESSION['osf_lang'])){
	define('SETUP_LANG_DIR', './inc/language/' . $_SESSION['osf_lang']);
}else{
	define('SETUP_LANG_DIR', './inc/language/english');
}
require (SETUP_LANG_DIR . '/common.lang.php');


/*
 * Make sure the required config/settings files
* are located in the correct place in relation to this installer.
*
* If the osTicket and osFaq main config files cant be loaded
* we abort the installation untill everything appears to be in place.
*/

/// load osTicket config info
if (file_exists(ROOT_PATH . 'ostconfig.php')){ //Old installs prior to v 1.6 RC5
	require (ROOT_PATH . 'ostconfig.php');
}elseif (file_exists(INCLUDE_DIR . 'settings.php')){ //Old installs of v 1.6 RC5
	require (INCLUDE_DIR . 'settings.php');
}elseif (file_exists(INCLUDE_DIR . 'ost-config.php')){ //Installs of >= v 1.6 ST (Stable)
	require (INCLUDE_DIR . 'ost-config.php');
}else{
	$abortError = true;
	$errorMessage .= ERROR_OST_SETTINGS . '<br />';
}

/// load osFaq config info
if (file_exists(ROOT_PATH . 'faq/include/main.faq.php')){
	define('_OSFAQ_INSTALL_ACTIVE_', true);

	require ('../include/OsFaqAdapter.class.php');
	$osfAdapter = new OsFaqAdapter(false);

	require (ROOT_PATH . 'faq/include/main.faq.php');
	define('DIR_FS_BASE', OSF_DOC_ROOT.DIR_FS_WEB_ROOT);


	///Get osTicket version. We cant just require the files so it needs to be parsed.
	if(is_file(ROOT_PATH . 'bootstrap.php')){
		$ostInc = file_get_contents(ROOT_PATH . 'bootstrap.php');
		preg_match("/define\('THIS_VERSION',([ \'a-z0-9\.\s\-\+]+)'\);/i", $ostInc, $matches);
	}else{
		$ostInc = file_get_contents(ROOT_PATH . 'main.inc.php');
		preg_match("/define\('THIS_VERSION',([ \'a-z0-9\.\s\-\+]+)'\);/i", $ostInc, $matches);
	}


	$ostVer = substr(trim($matches[1]), 1);
	define('OSTICKET_VERSION', $ostVer);

	$tempostver = ltrim(OSTICKET_VERSION, 'v');
	define('OSTICKET_CHECK_VER', substr($tempostver, 0, 3));

}else{
	$abortError = true;
	$errorMessage .= ERROR_OSF_SETTINGS . '<br />';
}

// allow paths to be manually editted by the installee
// if they cant be determined dynamically
if(isset($_GET['savepath']) || !is_file(DIR_FS_BASE.'faq/setup/images/docroot_found.png')){

	define('PAGE_HEADING', OSFI_MANUAL_PATHS);

	require('inc/header.inc.php');
	require('inc/static_path.inc.php');
	require('inc/footer.inc.php');
	exit();
}


// Copied from osTicket 1.7.1.4
require_once(INCLUDE_DIR.'class.misc.php');
?>
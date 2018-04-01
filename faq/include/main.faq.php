<?php
/* *************************************************************************
  Id: main.faq.php

  Contains required setup functionality and vars for the osFaq system.


  Tim Gall
  Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('FAQ_VERSION','1.4.0 ST');//don't change this. Changes from version to version.
define('FAQ_CK_VERSION', '4_8_0');//ckeditor path constant.

define('DIR_PATH_ADMIN', 'scp/');// your admin folder (with trailing /)

// see: faq/include/OsFaqAdapter.class.php for details
if($osfAdapter){
	$osf_isClient = $osfAdapter->is_client();
}

//gzdecode is only available in PHP >= 6.0.0
if(!function_exists('gzdecode')){
	function gzdecode($string) {
		$string = substr($string, 10);//strip out gzip encode header
		return gzinflate($string);
	}
}

/**
 * Path cleaner mainly for cross platform path stability.
 *
 * @param string $pathString a file path. Can be relative or absolute.
 * @return string A path with web style separators
 */
function osfMain_cleanPath($pathString){
  //change windows seperators
  if(false !== strpos($pathString, "\\")){
    $pathString = preg_replace('/(\\\\+)/', '/', $pathString);
  }
  if(substr($pathString, -1)!='/') $pathString .= '/';

  return $pathString;
}

// get the current page being viewed relative to document root.
$osfConf_PHP_SELF = $_SERVER['PHP_SELF'];
if(empty($osfConf_PHP_SELF)){
  $osfConf_PHP_SELF = $_SERVER['SCRIPT_NAME'];
  if(empty($osfConf_PHP_SELF)){
    $osfConf_PHP_SELF = $_SERVER['ORIG_SCRIPT_NAME'];
  }
}

$osfConf_rootDir = dirname(dirname(dirname(__FILE__)));
$osfConf_DocRootDir = osfMain_cleanPath($osfConf_rootDir);

// public file system. relative to document root
$osfConf_WRDir = osfMain_cleanPath(dirname($osfConf_PHP_SELF));

//cleanup web-root path
if(substr($osfConf_WRDir, -strlen(DIR_PATH_ADMIN)) == DIR_PATH_ADMIN){
  $osfConf_WRDir = substr($osfConf_WRDir, 0, -strlen(DIR_PATH_ADMIN));
}elseif(defined('_OSFAQ_INSTALL_ACTIVE_') && (substr($osfConf_WRDir, -strlen('faq/setup/')) == 'faq/setup/')){
  $osfConf_WRDir = substr($osfConf_WRDir, 0, -strlen('faq/setup/'));
}

/* the servers DOCUMENT_ROOT file system path.
 * This is done manually since some server setups don't contain
 * accurate DOCUMENT_ROOT info in relation to the website.
 */
if(substr($osfConf_DocRootDir, -strlen($osfConf_WRDir)) == $osfConf_WRDir){
  $osfConf_DocRootDir = substr($osfConf_DocRootDir, 0, -strlen($osfConf_WRDir));
}


////DEBUG: debugging stuff. Uncomment to enable.
//echo '<pre>';
//echo "\$osfConf_PHP_SELF   = $osfConf_PHP_SELF".PHP_EOL;
//echo "\$osfConf_rootDir    = $osfConf_rootDir".PHP_EOL;
//echo "\$osfConf_DocRootDir = $osfConf_DocRootDir".PHP_EOL;
//echo "\$osfConf_WRDir      = $osfConf_WRDir".PHP_EOL;
//echo '</pre>';
//exit();


require('config.faq.php');
//cleanup temp stuff
unset($osfConf_rootDir,$osfConf_DocRootDir,$osfConf_WRDir,$osfConf_PHP_SELF);

if(!defined('_OSFAQ_INSTALL_ACTIVE_')){
  /// these config constants come from the database. Allows settings to be editted on the fly.
  $faqConfigQuery = db_query('select key_name, key_value, field_type from '.TABLE_FAQ_SETTINGS.';');
  while ($faqConfig = db_fetch_array($faqConfigQuery)) {
    if(!defined($faqConfig['key_name']) && $faqConfig['field_type']!='heading'){
      define($faqConfig['key_name'], $faqConfig['key_value']);
    }
  }

  if(!defined('OSFDB_DEFAULT_LANG'))
  	define('OSFDB_DEFAULT_LANG', 'english');

  require_once(DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/_localization.php');

  // if OSF_TZ is set in the active _localisation file it will be used.
  // Otherwise the value set in osFaq-admin-settings will be used.
  date_default_timezone_set((OSF_TZ=='') ? OSFDB_TIMEZONE : OSF_TZ);
  $osf_langDirection = '<style type="text/css" media="all">body{direction:' . OSF_LANG_DIRECTION . '; unicode-bidi:embed;}</style>' . PHP_EOL;
}
?>
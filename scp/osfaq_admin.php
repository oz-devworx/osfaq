<?php
/* *************************************************************************
 Id: osfaq_admin.php

 Core FAQ administration code.
 Displayable content is contained in the directory: /faq/include/staff/


 Tim Gall
 Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
 http://osfaq.oz-devworx.com.au

 This file is part of osFaq.

 Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
 For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

 ************************************************************************* */

require ('../faq/include/OsFaqAdapter.class.php');
$osfAdapter = new OsFaqAdapter();

define('DIR_WS_REL_ROOT', "../");

/// CONFIGS
$osfAdapter->init_admin();
require (DIR_WS_REL_ROOT . 'faq/include/main.faq.php'); // !important

// see: faq/include/OsFaqAdapter.class.php for details
$osf_isAdmin = $osfAdapter->is_admin();


/// DEFAULT LANGUAGE FILE.
require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_admin.lang.php');

require (DIR_FAQ_INCLUDES . 'FaqFuncs.php');
require (DIR_FAQ_INCLUDES . 'FaqMessage.php');
require (DIR_FAQ_INCLUDES . 'FaqForm.php');

require_once (DIR_FAQ_INCLUDES . 'FaqArrayData.php');
require_once (DIR_FAQ_INCLUDES . 'FaqTable.php');
require_once (DIR_FAQ_INCLUDES . 'FaqSQLExt.php');


/// ADMIN FILES
define('FILE_FAQ_ADMIN', 'osfaq_admin.php'); //this file (master)
define('FILE_FAQ_ASSIST', 'osfaq_assist.php');

define('FILE_FAQ_ADMIN_WORKER', 'faq_admin_worker.inc.php');
define('FILE_FAQ_ADMIN_INC', 'faq_admin_ui.inc.php');
define('FILE_FAQ_UNUSED_INC', 'faq_upload_man.inc.php');
define('FILE_FAQ_SETTINGS', 'faq_settings.inc.php');
define('FILE_FAQ_MAPPER', 'faq_map_ui.inc.php');
define('FILE_FAQ_MAP_BUILDER', 'faq_map_builder.inc.php');
define('FILE_FAQ_NOT_AUTHORISED', 'faq_not_authorised.inc.php');
define('FILE_FAQ_VERSION_CHECK', 'faq_version_check.inc.php');
define('FILE_FAQ_MIGRATE', 'faq_migrate.inc.php');


/// TABLE AND BUTTON ICONS - Font-Awesome
define('OSF_ICON_FOLDER', 'icon-folder-close icon-large');
define('OSF_ICON_FOLDER_OPEN', 'icon-folder-open icon-large');
define('OSF_ICON_PREVIEW', 'icon-file icon-large');
define('OSF_ICON_PREVIEW_ALT', 'icon-file-alt icon-large');

define('OSF_ICON_INFO', 'icon-info-sign icon-large');
define('OSF_ICON_EDIT', 'icon-edit icon-large');
define('OSF_ICON_ARROW_RIGHT', 'icon-arrow-right icon-large');
define('OSF_ICON_ARROW_LEFT', 'icon-circle-arrow-left icon-large');

define('OSF_ICON_CHECKED', 'icon-check icon-large');
define('OSF_ICON_CHECK_EMPTY', 'icon-check-empty icon-large');

define('OSF_ICON_CHANGE', 'icon-pencil');
define('OSF_ICON_COPY', 'icon-copy');
define('OSF_ICON_MOVE', 'icon-signout');//icon-exchange
define('OSF_ICON_DELETE', 'icon-remove-sign');//icon-remove
define('OSF_ICON_CANCEL', 'icon-ban-circle');
define('OSF_ICON_SAVE', 'icon-save');
define('OSF_ICON_BACK', 'icon-circle-arrow-left');
define('OSF_ICON_CREATE', 'icon-cogs');
define('OSF_ICON_USER', 'icon-user');


// prep some classes
$messageHandler = new FaqMessage;
$faqForm = new FaqForm;
$sqle = new FaqSQLExt;


/// important system warnings
// check if the docs directory exists and is writable
if (is_dir(DIR_FS_DOC)) {
  if (!is_writeable(DIR_FS_DOC))
  $messageHandler->add(OSF_WARN_DOC_DIR_WRITE, FaqMessage::$error);
} else {
  $messageHandler->add(OSF_WARN_DOC_DIR_EXIST, FaqMessage::$error);
}
// check if the images directory exists and is writable
if (is_dir(DIR_FS_IMAGES)) {
  if (!is_writeable(DIR_FS_IMAGES))
  $messageHandler->add(OSF_WARN_IMG_DIR_WRITE, FaqMessage::$error);
} else {
  $messageHandler->add(OSF_WARN_IMG_DIR_EXIST, FaqMessage::$error);
}
// check if the setup directory exists and nag if it does
if (is_dir(OSF_DOC_ROOT . DIR_FS_WEB_ROOT . 'faq/setup/')) {
  $messageHandler->add(OSF_WARN_SETUP_DIR, FaqMessage::$warning);
}
// make sure the file and database versions match
if(!isset($_SESSION['DB_FAQ_VERSION']) || $_SESSION['DB_FAQ_VERSION']!=FAQ_VERSION){
  $result = db_query("SELECT key_value FROM " . TABLE_FAQ_ADMIN . " WHERE key_name LIKE 'DB_FAQ_VERSION';");
  if ($temp_data = db_fetch_array($result)) {
    $_SESSION['DB_FAQ_VERSION']=$temp_data['key_value'];
    if($_SESSION['DB_FAQ_VERSION']!=FAQ_VERSION){
      $messageHandler->add(sprintf(OSF_WARN_DB_VERSION, FAQ_VERSION, $_SESSION['DB_FAQ_VERSION']), FaqMessage::$error);
    }
  }
}
// make sure admin knows when the client side is offline
if(OSFDB_DISABLE_CLIENT=='true'){
  $messageHandler->add(OSF_CLIENT_DISABLED, FaqMessage::$warning);
}

// build the page output
$inc = $osfAdapter->build_admin_navigation();

// AJAX call
if( ($inc === FILE_FAQ_ADMIN_INC) && isset($_GET['flag']) && ( isset($_GET['cID']) || isset($_GET['fID']) ) ){
	require_once (DIR_FAQ_INCLUDES . 'staff/' . $inc);
	exit();
}

$osf_external_info = $osfAdapter->build_admin_xtra_headers();

$osfAdapter->get_admin_page_header();
echo $osf_external_info;// fallback method for adding styles & js
require_once (DIR_FAQ_INCLUDES . 'staff/' . $inc);
$osfAdapter->get_admin_page_footer();
?>
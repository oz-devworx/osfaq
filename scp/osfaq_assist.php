<?php
/* *************************************************************************
 Id: osfaq_assist.php

 Handles supplying IFramed pages to the admin area while still
 maintaining security for the supplied files.


 Tim Gall
 Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
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
require (DIR_FAQ_INCLUDES . 'FaqFuncs.php');
require (DIR_FAQ_INCLUDES . 'FaqForm.php');

// prep classes
$faqForm = new FaqForm;

if(isset($_GET['img_browse'])){
  require (DIR_FAQ_INCLUDES . 'FaqPaginator.php');

  require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_admin_ui.lang.php');
  require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_paginator.lang.php');

  $pages = new FaqPaginator('osfaq_assist.php', 'img_browse=true&list_images=true');

  require(DIR_FAQ_INCLUDES . 'staff/faq_img_browser.php');
}else{
  //ajax upload script
  require(DIR_FAQ_INCLUDES . 'staff/faq_upload.php');
}
?>
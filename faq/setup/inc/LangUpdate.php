<?php
/* *************************************************************************
  Id: LangUpdate.php

  Language update function/s for updating the osFaq settings table
  with the correct language and presetting the
  default language osFaq will use.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

class LangUpdate{

  private function __construct(){

  }

  /**
   * Get current language; find DB translation for selected lang;
   * validate translation entries are correct and insert into database;
   * Also update osFaq's default language setting.
   */
  public static function lang_update(){

    //make sure the main language directory exists (faq/includes/languages/...)
    //default to english if not.
    $schema_lang_name = ((isset($_SESSION['osf_lang']) && !empty($_SESSION['osf_lang']) && is_dir(OSFAQ_INCLUDE_DIR . 'language/' . $_SESSION['osf_lang'])) ? $_SESSION['osf_lang'] : 'english');
    $schema_lang_dir = OSFAQ_INCLUDE_DIR . 'language/' . $schema_lang_name . '/';

    require_once($schema_lang_dir . 'faq_settings.lang.php');
    require_once(OSFAQ_INCLUDE_DIR . 'FaqLangUpdate.php');
    FaqLangUpdate::updateDbLang($schema_lang_name, OSFAQ_INCLUDE_DIR . 'language/');

    // preset osFaq to use the current active language
    db_query("UPDATE ".TABLE_FAQ_SETTINGS." SET key_value='{$schema_lang_name}' WHERE key_name='OSFDB_DEFAULT_LANG';");
  }
}
?>
<?php
/* *************************************************************************
  Id: schema.inc.php

  Install the FAQ database tables using the current osTicket table prefix.


  Tim Gall
  Copyright (c) 2009-2017 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require (SETUP_LANG_DIR . '/schema.lang.php');
?>
<h3><?php echo OSFI_INS_TITLE; ?></h3>
<?php
if(isset($_GET['install_db']) && $_GET['install_db']=='true'){
  /// Connect to the database
  //require_once (ROOT_PATH . 'include/mysql.php');// osTicket file
  if (extension_loaded('mysqli'))
    require_once(ROOT_PATH . 'include/mysqli.php');
  else
    require_once(ROOT_PATH . 'include/mysql.php');

  $errorMsg = '';
  $faq_error = false;

  if (!db_connect(DBHOST, DBUSER, DBPASS) || !db_select_database(DBNAME)) {
    $errorMsg .= ERROR_CONNECTION . '<br />';
    $faq_error = true;
  }

  /// Load the install/upgrade SQL schema file
  if (!file_exists(FAQS_SQL_FILE) || !($schema = file_get_contents(FAQS_SQL_FILE))) {
    $errorMsg .= ERROR_BROKEN . '<br />';
    $faq_error = true;
  }

  if (!$faq_error && !empty($schema)) {

    $queries = explode(';', str_replace('%TABLE_PREFIX%', TABLE_PREFIX, $schema));

    if (!empty($queries) && count($queries) > 0) {
      foreach ($queries as $sql) {

        $insSql = trim($sql);
        if (!empty($insSql)) {
          if (!db_query($insSql . ';')) {
            $errorMsg .= ERROR_QUERY . '<br />';
            $errorMsg .= $insSql . ';<hr />';

            // break out on errors
            break;
          }
        }
      }
    } else {
      $errorMsg .= ERROR_BAD_FORMAT;
    }
  } else {
    $errorMsg .= ERROR_EMPTY_SCHEMA;
  }


  /* Load the settings-translation SQL schema file/s
   * This is only done if the main schema file was inserted without errors
   */
  require_once(OSFAQ_INCLUDE_DIR . 'FaqFuncs.php');
  require (OSFAQ_INCLUDE_DIR . 'FaqMessage.php');
  $messageHandler = new FaqMessage;

  if(empty($errorMsg)){
    require('./inc/LangUpdate.php');
    LangUpdate::lang_update();
  }
?>
<h3><?php echo OSFI_INS_TABLES; ?></h3>
<p>
<?php
  if(empty($errorMsg)){
    $messageHandler->add(OK_SCHEMA_SUCCESS, FaqMessage::$success);
  }else{
    $messageHandler->add($errorMsg, FaqMessage::$error);
  }

  // output system messages
  $messageHandler->session_to_stack();
  echo $messageHandler->output() . '<hr />';

?>
</p>
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo sprintf(OSFI_STEP, '2'); ?>" />
</form>
<?php



}else{

  // advise the user to take precautions if resintalling
  if(isset($_GET['reinstall'])){
?>
<div class="messageHandlerError"><img src="images/error.gif" />
<?php
    /// TRANSLATION FILE
    require (SETUP_LANG_DIR . '/intro.lang.php');

    // "FULL reinstall" message to the installee
    echo sprintf(OSFI_INTRO_ALREADY_INSTALLED, FAQ_VERSION, DBNAME);
?>
</div>
<?php
  }

  echo '<h3>'.OSFI_INS_READY_TITLE.'</h3>';
  echo OSFI_INS_READY_TEXT;
?>
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="submit" value="<?php echo OSFI_INS_COMPLETE_STEP; ?>" />
</form>
<br />
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo OSFI_SKIP_FOR_NOW; ?>" />
</form>
<?php
}
?>
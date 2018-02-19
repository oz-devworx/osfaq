<?php
/* *************************************************************************
  Id: schema_up.inc.php

  Upgrade the FAQ database tables using the current osTicket table prefix.


  Tim Gall
  Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require (SETUP_LANG_DIR . '/schema.lang.php');
?>
<h3><?php echo OSFI_UPG_TITLE; ?></h3>
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

  if($_GET['rc_version']=='10RC2-to-CURRENT'){
    /// Load SQL schema file 1.0RC2 to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_2) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_2))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='10RC3-to-CURRENT'){
    /// Load SQL schema file 1.0RC3 to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_3) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_3))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='10RC4-to-CURRENT'){
    /// Load SQL schema file 1.0RC4 to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_4) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_4))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='10RC5-to-CURRENT'){
    /// Load SQL schema file 1.0RC5 to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_5) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_5))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='10RC6-to-CURRENT'){
    /// Load SQL schema file 1.0RC6 to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_6) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_6))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='10ST-to-CURRENT'){
    /// Load SQL schema file 1.0ST to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_7) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_7))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='11ST-to-CURRENT'){
    /// Load SQL schema file 1.1ST to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_8) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_8))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='12RC-to-CURRENT'){
    /// Load SQL schema file 1.2RC to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_9) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_9))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='12ST-to-CURRENT'){
    /// Load SQL schema file 1.2ST to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_10) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_10))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='121ST-to-CURRENT'){
    /// Load SQL schema file 1.2.1ST to CURRENT
    if (!file_exists(FAQS_SQL_UP_FILE_11) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_11))) {
      $errorMsg .= ERROR_BROKEN . '<br />';
      $faq_error = true;
    }
  }elseif($_GET['rc_version']=='122ST-to-CURRENT'){
  	/// Load SQL schema file 1.2.2ST to CURRENT
  	if (!file_exists(FAQS_SQL_UP_FILE_12) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_12))) {
  		$errorMsg .= ERROR_BROKEN . '<br />';
  		$faq_error = true;
  	}
  }elseif($_GET['rc_version']=='130ST-to-CURRENT'){
  	/// Load SQL schema file 1.3.0ST to CURRENT
  	if (!file_exists(FAQS_SQL_UP_FILE_13) || !($schema = file_get_contents(FAQS_SQL_UP_FILE_13))) {
  		$errorMsg .= ERROR_BROKEN . '<br />';
  		$faq_error = true;
  	}
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
<h3><?php echo OSFI_UPG_TABLES; ?></h3>
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
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo sprintf(OSFI_STEP, '2'); ?>" />
</form>
<?php



}else{


  echo '<h3>'.OSFI_UPG_READY_TITLE.'</h3>';
  echo OSFI_UPG_READY_TEXT;


  if($_SESSION['upgrade_rc']==13){
  	?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="130ST-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.3.0-ST', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==12){
  	?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="122ST-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.2.2-ST', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==11){
  	?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="121ST-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.2.1-ST', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==10){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="12ST-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.2-ST', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==9){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="12RC-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.2-RC', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==8){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="11ST-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.1-ST', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==7){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="10ST-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.0-ST', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==6){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="10RC6-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.0-RC6', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==5){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="10RC5-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.0-RC5', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==4){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="10RC4-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.0-RC4', FAQ_VERSION); ?>" />
</form>
<?php
  }elseif($_SESSION['upgrade_rc']==3){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="10RC3-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.0-RC3', FAQ_VERSION); ?>" />
</form>
<?php

  }elseif($_SESSION['upgrade_rc']==2){
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="install_db" value="true" />
  <input type="hidden" name="rc_version" value="10RC2-to-CURRENT" />
  <input type="submit" value="<?php echo sprintf(OSFI_UPG_FROM_TO, '1.0-RC2', FAQ_VERSION); ?>" />
</form>
<?php
  }
?>
<br />
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo OSFI_SKIP_FOR_NOW; ?>" />
</form>
<?php
}
?>
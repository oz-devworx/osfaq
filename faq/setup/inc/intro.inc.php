<?php
/* *************************************************************************
  Id: intro.inc.php

  Welcome the user and a brief explanation on whats happening.

  If the osTicket or osFaq settings/config files are not presant
  the user is advised and the install is halted until these 2 files are
  presant in the locations we expected them in (relative to the installer).


  Tim Gall
  Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

/**
 * Locate and identify existing installations based on the database structure
 * (and for newer versions the osFaq database version number)
 *
 * @return int - the existing osFaq versions installer value
 * or 0 if not installed
 * and -1 for downgrades
 */
function find_old_versions() {

	$old_version = 0;// not installed

	// ALL versions from 1.2 RC and up have this table
	$result = @db_query("SHOW TABLES FROM " . DBNAME . " LIKE '" . TABLE_FAQS . "';");
	if (db_num_rows($result)>0) {

		$result = db_query("SELECT key_value FROM " . TABLE_FAQ_ADMIN . " WHERE key_name LIKE 'DB_FAQ_VERSION';");
		if ($temp_data = db_fetch_array($result)) {
			if($temp_data['key_value']=='1.4.0 ST'){
				// version 1.4.0 ST
				$old_version = 15;

			}elseif($temp_data['key_value']=='1.3.1 ST'){
				// version 1.3.1 ST
				$old_version = 14;

			}elseif($temp_data['key_value']=='1.3.0 ST'){
				// version 1.3.0 ST
				$old_version = 13;

			}elseif($temp_data['key_value']=='1.2.2 ST'){
				// version 1.2.2 ST
				$old_version = 12;

			}elseif($temp_data['key_value']=='1.2.1 ST'){
				// version 1.2.1 ST
				$old_version = 11;

			}elseif($temp_data['key_value']=='1.2 ST'){
				// version 1.2 ST
				$old_version = 10;
			}elseif($temp_data['key_value']=='1.2 RC'){
				// version 1.2 RC
				$old_version = 9;
			}else{
				// this installer is probably older than the installed version
				$old_version = -1;
			}
		}

	}else{

		// ALL versions below 1.2 RC have this table
		$result = @db_query("SHOW TABLES FROM " . DBNAME . " LIKE '" . TABLE_PREFIX . "faqs" . "';");
		if (db_num_rows($result)>0) {

			// versions 1.0 RC4 and above have this table
			$result = @db_query("SHOW TABLES FROM " . DBNAME . " LIKE '" . TABLE_PREFIX . "faq_admin" . "';");
			if (db_num_rows($result)>0) {

				$result = db_query("SELECT key_value FROM " . TABLE_PREFIX . "faq_admin" . " WHERE key_name LIKE 'DB_FAQ_VERSION';");
				if ($temp_data = db_fetch_array($result)) {
					if($temp_data['key_value']=='1.1 ST'){
						// version 1.1 ST
						$old_version = 8;
					}elseif($temp_data['key_value']=='1.0 ST'){
						// version 1.0 ST
						$old_version = 7;
					}elseif($temp_data['key_value']=='1.0 RC6'){
						// version 1.0 RC6
						$old_version = 6;
					}elseif($temp_data['key_value']=='1.0 RC5'){
						// version 1.0 RC5
						$old_version = 5;
					}elseif($temp_data['key_value']=='1.0 RC4'){
						// version 1.0 RC4
						$old_version = 4;
					}else{
						// custom old version ???
						$old_version = -1;
					}
				}
			}else{
				// versions 1.0 RC3 and above DO-NOT have this column
				$result = @db_query("SHOW COLUMNS FROM " . TABLE_PREFIX . "faqs" . " LIKE 'category_id';");
				if(db_num_rows($result) == 0){
					// version 1.0 RC3
					$old_version = 3;
				}else{
					// version 1.0 RC2
					$old_version = 2;
				}
			}
		}


	}

	return $old_version;
}

/**
 *
 * @return multitype:string |boolean -
 * if any required permissions are not set, the
 * returned string array will contain the permissions
 * not currently granted to the current user.<br />
 * false is returned if all permissions are set.<br />
 * Using is_array() or return===false are the preferred
 * methods for checking results from this function.
 */
function osf_check_permissions(){

	$result = @db_query("SHOW GRANTS FOR CURRENT_USER();");
	$temp_data = db_fetch_array($result);

	$permissions_required_array = array('INSERT', 'UPDATE', 'DELETE', 'CREATE', 'DROP', 'ALTER');
	$permissions_missing_array = array();
	$permissions_array = array();

	// cleanup results
	foreach($temp_data as $key=>$value){
		$values = explode(',', $value);

		$i = 1;
		$n = count($values);

		foreach($values as $key2=>$value2){
			if($i == 1)
				$value2 = str_ireplace('GRANT ', '', $value2);

			if($i == $n)
				$value2 = substr($value2, 0, stripos($value2, ' ON '));

			$i++;
			$permissions_array[] = trim($value2);
		}
	}

	if(trim($permissions_array[0]) == 'ALL PRIVILEGES')
		return false;

	foreach($permissions_required_array as $value){
		if(!in_array($value, $permissions_array))
			$permissions_missing_array[] = $value;
	}

	if(count($permissions_missing_array) > 0)
		return $permissions_missing_array;

	return false;
}





/// TRANSLATION FILE
require (SETUP_LANG_DIR . '/intro.lang.php');

/// Connect to the database
//require_once (ROOT_PATH . 'include/mysql.php');// osTicket file
if (extension_loaded('mysqli'))
	require_once(ROOT_PATH . 'include/mysqli.php');
else
	require_once(ROOT_PATH . 'include/mysql.php');

// $oldver will tell the installer what options to display
if (db_connect(DBHOST, DBUSER, DBPASS) && db_select_database(DBNAME)) {
  $oldver = find_old_versions();

  // check database permissions as well
  $install_perms = osf_check_permissions();
  $install_perms_string = '';
  if(is_array($install_perms)){
  	foreach($install_perms as $value){
  		$install_perms_string .= $value . '<br />' . PHP_EOL;
  	}
  }
}



if(isset($_GET['reset_lang']) && $_GET['reset_lang']=='true'){
  unset($_SESSION['osf_lang']);
  //load the page again so the user can select a different language
  header('Location: ' . OSF_PHP_SELF);
  exit();
}
// before we start, we need a language
if(isset($_GET['lang']) && preg_match('/^([a-z0-9]|\-|\.|\,)+$/ui', $_GET['lang'])){
  $_SESSION['osf_lang'] = $_GET['lang'];
  //load the page again using the selected language
  header('Location: ' . OSF_PHP_SELF);
  exit();
}
if(!isset($_SESSION['osf_lang'])){

  $lang_directory = './inc/language/';
  $osf_languages = array();
  $osf_lang_dir = dir($lang_directory);
  while (false !== ($osf_lang_file = $osf_lang_dir->read())) {
    if ( (substr($osf_lang_file, 0, 1)!='.') && (substr($osf_lang_file, 0, 1)!='_') && is_dir($lang_directory . $osf_lang_file) ){
      $osf_languages[] = array('id' => $osf_lang_file, 'text' => $osf_lang_file);
    }
  }
?>
<form action="index.php" method="get" enctype="text/plain">
  <?php echo OSFI_INTRO_LANG; ?>: <select name="lang" id="lang">
<?php
  foreach($osf_languages as $key_val_pair){
    echo '    <option value="'.$key_val_pair['id'].'">'.$key_val_pair['text'].'</option>' . "\n";
  }
?>
  </select>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="submit" value="<?php echo OSFI_CONTINUE; ?>" />
</form>
<?php




// now we have a language, its cool to continue
}else{


?>
<h3><?php echo OSFI_INTRO_INTRO; ?></h3><img src="images/osfaq_logo.png" alt="<?php echo OSFI_INTRO_LOGO; ?>" style="float:left; margin:10px 10px 10px 10px;" />
<?php echo sprintf(OSFI_INTRO_WELCOME, FAQ_VERSION); ?>
<hr />






<table width="100%" border="0" cellspacing="1" cellpadding="10">
  <tr>
    <th width="40%"><?php echo OSFI_INTRO_PARAM; ?></th>
    <th width="60%"><?php echo OSFI_INTRO_VAL; ?></th>
  </tr>

	<tr>
    <td class="rowalt"><strong><?php echo OSFI_INTRO_LANG; ?></strong></td>
    <td class="rowalt"><?php echo $_SESSION['osf_lang']; ?>
      <form action="index.php" method="get" enctype="text/plain" style="display:inline;">
        <input type="hidden" name="reset_lang" value="true" />
        <input type="submit" value="<?php echo OSFI_INTRO_LANG_RESET; ?>" />
      </form>
    </td>
	</tr>

  <tr>
    <td class="row"><strong><?php echo OSFI_INTRO_INST_TYPE; ?></strong></td>
    <td class="row">


<?php
//// START INSTALL TYPE

// upgrade advice
if($oldver > 0){
?>
<p><?php echo sprintf(OSFI_INTRO_ADVICE_1, DBNAME); ?></p>
<?php
}


switch($oldver){
  case -1:
?>
<div class="messageHandlerError"><img src="images/error.gif" />
<?php
  	// bail out with an error message
    echo sprintf(OSFI_INTRO_OLD_INSTALLER, DBNAME, (TABLE_PREFIX . 'faq'));
?>
</div>
<?php
  break;

  case 2:
    // enable rc2 to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.0 RC2'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="2" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.0.rc2', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 3:
    // enable rc3 to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.0 RC3'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="3" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.0.rc3', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 4:
    // enable rc4 to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.0 RC4'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="4" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.0.rc4', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 5:
    // enable rc5 to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.0 RC5'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="5" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.0.rc5', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 6:
    // enable rc6 to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.0 RC6'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="6" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.0.rc6', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 7:
    // enable 1.0st to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.0 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="7" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.0.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 8:
    // enable 1.1st to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.1 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="8" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.1.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 9:
    // enable 1.2rc to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.2 RC'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="9" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.2.rc', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 10:
    // enable 1.2st to current upgrade
?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.2 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="10" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.2.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 11:
  	// enable 1.2.1st to current upgrade
  	?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.2.1 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="11" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.2.1.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 12:
	// enable 1.2.2st to current upgrade
	?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.2.2 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="12" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.2.2.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 13:
	// enable 1.3.0st to current upgrade
	?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.3.0 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="13" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.3.0.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

case 14:
	// enable 1.3.1st to current upgrade
	?>
<h3><?php echo sprintf(OSFI_INTRO_V_DETECTED, 'osFaq v1.3.1 ST'); ?></h3>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="1" />
  <input type="hidden" name="upgrade_rc" value="14" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_UPG_TO, '1.3.1.st', FAQ_VERSION); ?>" />
</form>
<?php
  break;

  case 15:
?>
<div class="messageHandlerError"><img src="images/error.gif" alt="<?php echo OSFI_WARNING; ?>" />
<?php
    // "FULL reinstall" message to the installee
    echo sprintf(OSFI_INTRO_ALREADY_INSTALLED, FAQ_VERSION, DBNAME);
    $hidden_reinstall_field = '<input type="hidden" name="reinstall" value="1" />';
?>
</div>
<?php
  case 0:
  default:
    // install only
?>
<form action="install.php" method="get" enctype="text/plain">
  <?php echo $hidden_reinstall_field; ?>
  <input type="hidden" name="faq_step" value="1" />
  <input type="submit" value="<?php echo sprintf(OSFI_INTRO_INSTALL_V, FAQ_VERSION); ?>" />
</form>
<?php
  break;
}
//// END INSTALL TYPE




switch(OSTICKET_CHECK_VER){
	case '1.6':
	case '1.7':
	case '1.8':
	case '1.9':
	case '1.10':
		$integration_icon = '<img src="images/success.gif" title="' . OSFI_OST_SUPPORTED . '" alt="' . OSFI_OK . '" />';
		$integration_txt = OSFI_OST_SUPPORTED;
	break;

	default:
		$integration_icon = '<img src="images/warning.gif" title="' . OSFI_OST_NOT_SUPPORTED . '" alt="' . OSFI_WARNING . '" />';
		$integration_txt = OSFI_OST_NOT_SUPPORTED;
	break;
}

?></td>
  </tr>
  <tr>
    <td class="rowalt"><strong><?php echo OSFI_INSTALLER_FOR; ?></strong></td>
    <td class="rowalt"><b><?php echo sprintf(OSFI_VERSION, FAQ_VERSION); ?></b></td>
  </tr>
  <tr>
    <td class="row"><strong><?php echo OSFI_OST_INSTALLER_FOR; ?></strong></td>
    <td class="row"><?php echo $integration_icon; ?> <b><?php echo sprintf(OSFI_OST_VERSION, OSTICKET_VERSION); ?></b><br /><?php echo $integration_txt; ?></td>
  </tr>
  <tr>
    <td class="rowalt"><strong><?php echo OSFI_DATABASE; ?></strong></td>
    <td class="rowalt"><?php echo DBNAME; ?></td>
  </tr>
  <tr>
    <td class="row"><strong><?php echo OSFI_DB_PREFIX; ?></strong></td>
    <td class="row"><?php echo TABLE_PREFIX; ?></td>
  </tr>
<!--
  <tr>
    <td class="rowalt"><strong><?php echo OSFI_DB_PERMISSIONS; ?></strong></td>
    <td class="rowalt"><?php echo ( (strlen($install_perms_string)==0) ? '<img src="images/success.gif" title="' . OSFI_OK . '" alt="' . OSFI_OK . '" />' : '<img src="images/error.gif" title="' . OSFI_MISSING_PERMS . '" alt="' . OSFI_ERROR . '" /><br />' . $install_perms_string ); ?></td>
  </tr>
 -->
  <tr>
    <td class="row"><strong><?php echo OSFI_DOMAIN; ?></strong></td>
    <td class="row"><?php echo SERVER_DOMAIN; ?></td>
  </tr>
  <tr>
    <td class="rowalt"><a href="index.php?savepath=false"><img src="images/application_edit.png" alt="<?php echo OSFI_EDIT_DOC_ROOT; ?>" title="<?php echo OSFI_EDIT_DOC_ROOT; ?>" /></a> <strong><?php echo OSFI_DOC_ROOT; ?></strong></td>
    <td class="rowalt">
<?php
  if(false===realpath(OSF_DOC_ROOT)){
    echo OSFI_ROOT_PATH_NF;
  }else{
    echo '<img src="' . DIR_FS_WEB_ROOT . 'faq/setup/images/docroot_found_small.png" alt="'.OSFI_IMAGE.'" />';
  }
  echo ' [ ' . OSF_DOC_ROOT . ' ]';
?></td>
  </tr>
  <tr>
    <td class="row"><a href="index.php?savepath=false"><img src="images/application_edit.png" alt="<?php echo OSFI_EDIT_WEB_ROOT; ?>" title="<?php echo OSFI_EDIT_WEB_ROOT; ?>" /></a> <strong><?php echo OSFI_WEB_ROOT; ?></strong></td>
    <td class="row"><?php echo '<img src="' . DIR_FS_WEB_ROOT . 'faq/setup/images/webroot_found_small.png" alt="'.OSFI_IMAGE.'" /> [ ' . DIR_FS_WEB_ROOT . ' ]'; ?></td>
  </tr>
</table>

<?php
}
?>

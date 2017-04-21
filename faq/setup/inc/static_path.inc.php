<?php
/* *************************************************************************
  Id: static_path.inc.php

  Allows the installee to use static paths instead of dynamic ones.

  This is usefull for some server configurations where the DOCUMENT_ROOT
  variable does not reflect the web site root location.
  This seems to happen on some shared hosting and virtual hosting setups,
  particularly when combined with subdomains.


  Tim Gall
  Copyright (c) 2009-2017 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require (SETUP_LANG_DIR . '/static_path.lang.php');

function cleanPathStr($string){
  $clean_string = str_replace(array("'","\"",'`'), '', $string);
  $clean_string = str_replace(array('\\\\\\\\','\\\\','\\'), '\\', $string);
  return addslashes($clean_string);
}


$sperror = false;
if(!is_writable('../include/config.faq.php')){
  echo OSFI_ERROR_CONFIG_WRITE;
  $sperror = true;


}elseif(isset($_GET['savepath']) && $_GET['savepath']=='true'){

  if(false === ($osf_confFile = file_get_contents('../include/config.faq.php', FILE_BINARY))){
    echo OSFI_ERROR_CONFIG_READ;
    $sperror = true;
  }else{

    //no security here.
    //Its presumed the installee is a trusted person.
    $drVar = cleanPathStr($_GET['doc_root']);
    $wrVar = $_GET['web_root'];

    if(strpos($osf_confFile, "define('OSF_DOC_ROOT', \$osfConf_DocRootDir);") > -1){
      $osfDRString = "define('OSF_DOC_ROOT', \$osfConf_DocRootDir);";
    }else{
      $osfDRString = "define('OSF_DOC_ROOT', '".addslashes(OSF_DOC_ROOT)."');";
    }

    if(strpos($osf_confFile, "define('DIR_FS_WEB_ROOT', \$osfConf_WRDir);") > -1){
      $osfWRString = "define('DIR_FS_WEB_ROOT', \$osfConf_WRDir);";
    }else{
      $osfWRString = "define('DIR_FS_WEB_ROOT', '".DIR_FS_WEB_ROOT."');";
    }

    if(isset($_GET['savepathreset']) && $_GET['savepathreset'] == 'true'){
      $osf_confFile = str_replace($osfDRString, "define('OSF_DOC_ROOT', \$osfConf_DocRootDir);", $osf_confFile);
      $osf_confFile = str_replace($osfWRString, "define('DIR_FS_WEB_ROOT', \$osfConf_WRDir);", $osf_confFile);
    }else{
      $osf_confFile = str_replace($osfDRString, "define('OSF_DOC_ROOT', '$drVar');", $osf_confFile);
      $osf_confFile = str_replace($osfWRString, "define('DIR_FS_WEB_ROOT', '$wrVar');", $osf_confFile);
    }

    if(false === file_put_contents('../include/config.faq.php', $osf_confFile)){
      echo OSFI_ERROR_CONFIG_SAVE;
      $sperror = true;
    }else{
      echo isset($_GET['savepathreset']) ? '<h2>'.OSFI_SP_PATHS_RESTORED.'</h2>' : '<h2>'.OSFI_SP_PATHS_SAVED.'</h2>';
      echo OSFI_CONFIG_PROTECT;
      $sperror = true;
    }
  }
}

if($sperror){
?>
<br />
<form action="index.php" method="get" enctype="text/plain">
  <input type="hidden" name="savepath" value="false" />
  <input type="submit" value="<?php echo OSFI_REFRESH; ?>" />
</form>
<?php

}else{

  $sperror = false;
?>
<form action="index.php" method="get" enctype="text/plain" style="display:inline">
  <input type="hidden" name="savepath" value="true" />
  <?php
  if(false===realpath(OSF_DOC_ROOT)){
    echo '<h2><b style="color:red;">'.OSFI_SP_ROOT_PATH.' [ <i style="color:#000;">' . OSF_DOC_ROOT . '</i> ]</b></h2>';
    $sperror = true;
  }else{
    echo '<img src="./images/docroot_found.png" alt="'.OSFI_IMAGE.'" />';
  }
  ?>
  <div class="desc">
    <?php echo OSFI_SP_PATH_DESCRIPTION; ?>
  </div>
  <br />
  <label for="doc_root"><strong><?php echo OSFI_SP_DOCROOT; ?></strong>
  <input name="doc_root" type="text" value="<?php echo OSF_DOC_ROOT; ?>" size="64" maxlength="254" />
  </label>

  <br /><br />
  <hr />


  <?php
  /*
   * work-around for open_base_dir resriction
   */
  $_wrTemp = explode('/', DIR_FS_WEB_ROOT);

  $_wrTempRel = '../../';// faq/setup
  foreach($_wrTemp as $val)
    if($val!= null && trim($val)!='')
      $_wrTempRel .= '../';// base_dir subfolders

  $_wrTempRel = substr($_wrTempRel, 0, -1);

  if(!is_dir($_wrTempRel.DIR_FS_WEB_ROOT.'faq/setup')){
    echo '<h2><b style="color:red;">'.OSFI_SP_WEB_PATH.' [ <i style="color:#000;">' . (DIR_FS_WEB_ROOT) . '</i> ]</b></h2>';
    $sperror = true;
  }else{
    echo '<img src="' . DIR_FS_WEB_ROOT . 'faq/setup/images/webroot_found.png" alt="'.OSFI_IMAGE.'" />';
  }
  ?>
  <div class="desc">
    <?php echo OSFI_SP_SEE_IMAGE; ?>
  </div>
  <br />
  <label for="web_root"><strong><?php echo OSFI_SP_WEBROOT; ?></strong>
  <input name="web_root" type="text" value="<?php echo DIR_FS_WEB_ROOT; ?>" size="64" maxlength="254" />
  </label>
  <br /><br />
  <hr />
  <input type="submit" name="save" id="save" value="<?php echo OSFI_SP_SAVE_PATHS; ?>" />
</form>

<form action="index.php" method="get" enctype="text/plain" style="display:inline">
  <input type="hidden" name="savepath" value="true" />
  <input type="hidden" name="savepathreset" value="true" />
  <input type="submit" name="reset" id="reset" value="<?php echo OSFI_SP_RESET_PATHS; ?>" />
</form>
<?php
  if(!$sperror){
?>
<br /><br />
<form action="index.php" method="get" enctype="text/plain">
  <input type="submit" value="<?php echo OSFI_SP_CONTINUE_INSTALL; ?>" />
</form>
<?php
  }
}
?>
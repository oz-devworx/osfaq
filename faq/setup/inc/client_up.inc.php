<?php
/* *************************************************************************
  Id: client.inc.php

  Upgrade. Checks for the client side FAQ integration files and code.
  Advises the user on where to upload missing files to and how to integrate
  missing code.
  If the files and integration code are presant the installer
  will proceed to the next step.


  Tim Gall
  Copyright (c) 2009-2017 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require (SETUP_LANG_DIR . '/client.lang.php');

// check files for the appropriate text
$faqExists = is_file(DIR_FS_BASE . FILE_FAQ);
$faqSubmitExists = is_file(DIR_FS_BASE . FILE_FAQ_SUBMIT);
$faqFeedExists = is_file(DIR_FS_BASE . FILE_FAQ_FEED);

$headerIncModd = ($file=file_get_contents(DIR_FS_BASE . 'include/client/header.inc.php')) && preg_match('/<link rel="stylesheet" href="\.\/faq\/styles\/faq\.css" media="screen">/i',$file);

$pageModd = ($file=file_get_contents(DIR_FS_BASE . 'index.php')) && preg_match('/<\?php require\(ROOT_DIR\.\'faq\/include\/client\/faq_external\.php\'\);([a-zA-Z0-9\s\/]+)\?>/',$file);


?>
<h3><?php echo OSFI_INS_TITLE; ?></h3>
<?php

// cleanup notice
$old_faq_exists = is_file(DIR_FS_BASE . 'faq.php');

$old_faq_submit_exists = is_file(DIR_FS_BASE . 'faq_submit.php');

$old_faq_feed_exists = is_file(DIR_FS_BASE . 'faq_feed.php');

if($old_faq_exists || $old_faq_submit_exists || $old_faq_feed_exists){

	echo '<div class="messageHandlerWarning">';

	if($old_faq_exists){
		echo '<p>';
		echo sprintf(OSFI_CLIENT_DELETE, '<br /><code>' . DIR_FS_BASE . '<u>' . 'faq.php' . '</u></code>');
		echo '</p>';
	}
	if($old_faq_submit_exists){
		echo '<p>';
		echo sprintf(OSFI_CLIENT_DELETE, '<br /><code>' . DIR_FS_BASE . '<u>' . 'faq_submit.php' . '</u></code>');
		echo '</p>';
	}
	if($old_faq_feed_exists){
		echo '<p>';
		echo sprintf(OSFI_CLIENT_DELETE, '<br /><code>' . DIR_FS_BASE . '<u>' . 'faq_feed.php' . '</u></code>');
		echo '</p>';
	}
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo OSFI_CHECK_AGAIN; ?>" />
</form>
<?php
	echo '</div>';
}


if($faqExists && $faqSubmitExists && $faqFeedExists && $headerIncModd && $pageModd){
  echo OSFI_CLIENT_COMPLETE;
?>
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="3" />
  <input type="submit" value="<?php echo sprintf(OSFI_STEP, '3'); ?>" />
</form>
<?php


}else{

  echo OSFI_CLIENT_INTRO;
?>
<hr />
<?php

  echo '<p>';
  if($faqExists){
    echo '1) ' . FAQ_GOOD . sprintf(OSFI_FAQ_CLIENT_OK, '<code>' . FILE_FAQ . '</code>');
  }else{
    echo '1) ' . FAQ_BAD . sprintf(OSFI_FAQ_CLIENT_MISSING, '<br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ . '</u></code>');
  }
  echo '</p>';



  echo '<p>';
  if($faqSubmitExists){
    echo  '2) ' . FAQ_GOOD . sprintf(OSFI_FAQ_CLIENT_OK, '<code>' . FILE_FAQ_SUBMIT . '</code>');
  }else{
    echo  '2) ' . FAQ_BAD . sprintf(OSFI_FAQ_CLIENT_MISSING, '<br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_SUBMIT . '</u></code>');
  }
  echo '</p>';



  echo '<p>';
  if($faqSubmitExists){
    echo  '3) ' . FAQ_GOOD . sprintf(OSFI_FAQ_CLIENT_OK, '<code>' . FILE_FAQ_FEED . '</code>');
  }else{
    echo  '3) ' . FAQ_BAD . sprintf(OSFI_FAQ_CLIENT_MISSING, '<br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_FEED . '</u></code>');
  }
  echo '</p>';



  echo  '<p>';
  if($headerIncModd){
    echo  '4) ' . FAQ_GOOD . OSFI_STYLES_OK;
  }else{
    echo  '4) ' . FAQ_BAD . OSFI_STYLES_MISSING . '<br /><input size="100" type="text" readonly="readonly" value=\'<link rel="stylesheet" href="./faq/styles/faq.css" media="screen">\' />';
  }
  echo  '</p>';


  echo  '<p>';
  if($pageModd){
    echo  '5) ' . FAQ_GOOD . OSFI_REQUIRE_OK;
  }else{
    echo  '5) ' . FAQ_BAD . OSFI_REQUIRE_MISSING . '<br /><input size="100" type="text" readonly="readonly" value="&lt;?php require(ROOT_DIR.\'faq/include/client/faq_external.php\'); ?&gt;" />';
?>
<br /><br />
<b><?php echo OSFI_EXAMPLE_IMPLEMENTATION; ?></b>
        <textarea name="textarea" cols="83" rows="6" readonly="readonly" wrap="off">

&lt;?php require(ROOT_DIR.'faq/include/client/faq_external.php');// osFaq integration ?&gt;

&lt;?php require(CLIENTINC_DIR.'footer.inc.php'); ?&gt;

</textarea>
<?php
  }
  echo  '</p>';



?>
<hr />
<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo OSFI_CHECK_AGAIN; ?>" />
</form>

<form action="upgrade.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="3" />
  <input type="submit" value="<?php echo OSFI_IGNORE_AND_PROCEED; ?>" />
</form>
<?php
}
?>
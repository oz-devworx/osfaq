<?php
/* *************************************************************************
  Id: staff_old.inc.php

  Checks for the staff side FAQ integration files and code.
  Advises the user on where to upload missing files to and how to integrate
  missing code.
  If the files and integration code are presant the installer
  will proceed to the next step. This file is for old osTicket 1.5 - 1.6


  Tim Gall
  Copyright (c) 2009-2017 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require (SETUP_LANG_DIR . '/staff.lang.php');
require (SETUP_LANG_DIR . '/staff_old.lang.php');

// check if files are physically present
$faqAdminExists = is_file(DIR_FS_BASE . FILE_FAQ_ADMIN);

$faqAdmin2Exists = is_file(DIR_FS_BASE . FILE_FAQ_ADMIN_ASSIST);


// check files for the appropriate text
$navModd = ($file=file_get_contents(DIR_FS_BASE . 'include/class.nav.php')) && preg_match("/$tabs\['osfaq'\]=array\('desc'=\>'osFAQ','href'=\>'osfaq_admin\.php','title'=\>'Frequently Asked Questions'\)\;/i",$file);


?>
<h3><?php echo OSFI_STAFF_TITLE; ?></h3>
<?php

// cleanup notice
$old_admin_exists = is_file(DIR_FS_BASE . 'scp/faq_admin.php');

$old_assist_exists = is_file(DIR_FS_BASE . 'scp/faq_assist.php');

if($old_admin_exists || $old_assist_exists){

	echo '<div class="messageHandlerWarning">';

	if($old_admin_exists){
		echo '<p>';
		echo sprintf(OSFI_ADMIN_DELETE, '<br /><code>' . DIR_FS_BASE . '<u>' . 'scp/faq_admin.php' . '</u></code>');
		echo '</p>';
	}
	if($old_assist_exists){
		echo '<p>';
		echo sprintf(OSFI_ADMIN_DELETE, '<br /><code>' . DIR_FS_BASE . '<u>' . 'scp/faq_assist.php' . '</u></code>');
		echo '</p>';
	}
?>
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo OSFI_CHECK_AGAIN; ?>" />
</form>
<?php
	echo '</div>';
}



if($faqAdminExists && $faqAdmin2Exists && $navModd){
  echo OSFI_STAFF_COMPLETE
?>
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="3" />
  <input type="submit" value="<?php echo sprintf(OSFI_STEP, '3'); ?>" />
</form>
<?php


}else{

  echo OSFI_STAFF_INTRO;
?>
<hr />
<?php
  echo '<p>';
  if($faqAdminExists){
    echo '1) ' . FAQ_GOOD . sprintf(OSFI_FAQ_ADMIN_OK, '<code>' . FILE_FAQ_ADMIN . '</code>');
  }else{
    echo '1) ' . FAQ_BAD . sprintf(OSFI_FAQ_ADMIN_MISSING, '<br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_ADMIN . '</u></code>');
  }
  echo '</p>';


  echo '<p>';
  if($faqAdmin2Exists){
  	echo '2) ' . FAQ_GOOD . sprintf(OSFI_FAQ_ADMIN_OK, '<code>' . FILE_FAQ_ADMIN_ASSIST . '</code>');
  }else{
  	echo '2) ' . FAQ_BAD . sprintf(OSFI_FAQ_ADMIN_MISSING, '<br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_ADMIN_ASSIST . '</u></code>');
  }
  echo '</p>';


  echo  '<p>';
  if($navModd){
    echo  '3) ' . FAQ_GOOD . OSFI_NAV_MOD_OK_OLD;
  }else{
    echo  '3) ' . FAQ_BAD . OSFI_NAV_MOD_MISSING_OLD . ' <input size="100" type="text" readonly="readonly" value="$tabs[\'osfaq\']=array(\'desc\'=>\'osFAQ\',\'href\'=>\'osfaq_admin.php\',\'title\'=>\'Frequently Asked Questions\');" />.';
?>
<br /><br />
<b><?php echo OSFI_STAFF_ONCE_INTEGRATED_OLD; ?></b>
<br />

<textarea cols="83" rows="24" wrap="OFF" readonly="readonly">
    function StaffNav($pagetype='staff'){
        global $thisuser;

        $this->ptype=$pagetype;
        $tabs=array();
        if($thisuser->isAdmin() && strcasecmp($pagetype,'admin')==0) {
            $tabs['dashboard']=array('desc'=>'Dashboard','href'=>'admin.php?t=dashboard','title'=>'Admin Dashboard');
            $tabs['settings']=array('desc'=>'Settings','href'=>'admin.php?t=settings','title'=>'System Settings');
            $tabs['emails']=array('desc'=>'Emails','href'=>'admin.php?t=email','title'=>'Email Settings');
            $tabs['topics']=array('desc'=>'Help Topics','href'=>'admin.php?t=topics','title'=>'Help Topics');
            $tabs['staff']=array('desc'=>'Staff','href'=>'admin.php?t=staff','title'=>'Staff Members');
            $tabs['depts']=array('desc'=>'Departments','href'=>'admin.php?t=depts','title'=>'Departments');
        }else {
            $tabs['tickets']=array('desc'=>'Tickets','href'=>'tickets.php','title'=>'Ticket Queue');
            if($thisuser && $thisuser->canManageKb()){
             $tabs['kbase']=array('desc'=>'Knowledge Base','href'=>'kb.php','title'=>'Knowledge Base: Premade');
            }
            $tabs['directory']=array('desc'=>'Directory','href'=>'directory.php','title'=>'Staff Directory');
            $tabs['profile']=array('desc'=>'My Account','href'=>'profile.php','title'=>'My Profile');

            $tabs['osfaq']=array('desc'=>'osFAQ','href'=>'osfaq_admin.php','title'=>'Frequently Asked Questions');
        }
        $this->tabs=$tabs;
    }</textarea>


<?php
  }
  echo  '</p>';


?>
<hr />
<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="2" />
  <input type="submit" value="<?php echo OSFI_CHECK_AGAIN; ?>" />
</form>

<form action="install.php" method="get" enctype="text/plain">
  <input type="hidden" name="faq_step" value="3" />
  <input type="submit" value="<?php echo OSFI_IGNORE_AND_PROCEED; ?>" />
</form>
<?php
}
?>
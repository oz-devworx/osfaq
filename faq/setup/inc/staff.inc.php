<?php
/* *************************************************************************
  Id: staff.inc.php

  Checks for the staff side FAQ integration files and code.
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

require (SETUP_LANG_DIR . '/staff.lang.php');

// check if files are physically present
$faqAdminExists = is_file(DIR_FS_BASE . FILE_FAQ_ADMIN);

$faqAdmin2Exists = is_file(DIR_FS_BASE . FILE_FAQ_ADMIN_ASSIST);


// check files for the appropriate text
$navModd_1 = ($file=file_get_contents(DIR_FS_BASE . 'include/class.nav.php')) &&
	preg_match("/$this\->tabs\['osfaq'\]=array\('desc'=>'osFAQ','href'=>'osfaq_admin\.php','title'=>'Frequently Asked Questions', 'class'=>'no-pjax'\)\;/i", $file);

$navModd_2 = ($file=file_get_contents(DIR_FS_BASE . 'include/class.nav.php')) &&
	preg_match("/$navs\['osfaq'\]=array\('desc'=>'FAQs','href'=>'osfaq\.php','title'=>'Frequently Asked Questions'\)\;/i", $file);


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



if($faqAdminExists && $faqAdmin2Exists && $navModd_1 && $navModd_2){
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



  if($navModd_1){
    echo  '3) ' . FAQ_GOOD . OSFI_NAV_MOD_OK;
  }else{
    echo  '3) ' . FAQ_BAD . OSFI_NAV_MOD_MISSING . '<br /><input size="100" type="text" readonly="readonly" value="$this->tabs[\'osfaq\']=array(\'desc\'=>\'osFAQ\',\'href\'=>\'osfaq_admin.php\',\'title\'=>\'Frequently Asked Questions\', \'class\'=>\'no-pjax\');" />.';

?>
<br /><br />
<b><?php echo sprintf(OSFI_STAFF_ONCE_INTEGRATED, 'getTabs()'); ?></b>
<br />

<textarea cols="83" rows="20" wrap="OFF" readonly="readonly">
    function getTabs(){
        global $thisstaff;

        if(!$this->tabs) {
            $this->tabs = array();
            $this->tabs['dashboard'] = array(
                'desc'=>__('Dashboard'),'href'=>'dashboard.php','title'=>__('Agent Dashboard'), "class"=>"no-pjax"
            );
            if ($thisstaff->hasPerm(User::PERM_DIRECTORY)) {
                $this->tabs['users'] = array(
                    'desc' => __('Users'), 'href' => 'users.php', 'title' => __('User Directory')
                );
            }
            $this->tabs['tasks'] = array('desc'=>__('Tasks'), 'href'=>'tasks.php', 'title'=>__('Task Queue'));
            $this->tabs['tickets'] = array('desc'=>__('Tickets'),'href'=>'tickets.php','title'=>__('Ticket Queue'));

            $this->tabs['kbase'] = array('desc'=>__('Knowledgebase'),'href'=>'kb.php','title'=>__('Knowledgebase'));

            // osFaq integration
            $this->tabs['osfaq']=array('desc'=>'osFAQ','href'=>'osfaq_admin.php','title'=>'Frequently Asked Questions', 'class'=>'no-pjax');

            if (count($this->getRegisteredApps()))
                $this->tabs['apps']=array('desc'=>__('Applications'),'href'=>'apps.php','title'=>__('Applications'));
        }

        return $this->tabs;
    }</textarea>


<?php
  }
?>
<br /><br />
<?php
  if($navModd_2){
    echo  '4) ' . FAQ_GOOD . OSFI_NAV_MOD_OK;
  }else{
    echo  '4) ' . FAQ_BAD . OSFI_NAV_MOD2_MISSING . ' <input size="100" type="text" readonly="readonly" value="$navs[\'osfaq\']=array(\'desc\'=>\'FAQs\',\'href\'=>\'osfaq.php\',\'title\'=>\'Frequently Asked Questions\');" />.';
?>
<br /><br />
<b><?php echo sprintf(OSFI_STAFF_ONCE_INTEGRATED, 'getNavLinks()'); ?></b>
<br />

<textarea cols="83" rows="35" wrap="OFF" readonly="readonly">
    function getNavLinks(){
        global $cfg;

        //Paths are based on the root dir.
        if(!$this->navs){

            $navs = array();
            $user = $this->user;
            $navs['home']=array('desc'=>__('Support Center Home'),'href'=>'index.php','title'=>'');
            if($cfg && $cfg->isKnowledgebaseEnabled())
                $navs['kb']=array('desc'=>__('Knowledgebase'),'href'=>'kb/index.php','title'=>'');

            // Show the "Open New Ticket" link unless BOTH client
            // registration is disabled and client login is required for new
            // tickets. In such a case, creating a ticket would not be
            // possible for web clients.
            if ($cfg->getClientRegistrationMode() != 'disabled'
                    || !$cfg->isClientLoginRequired())
                $navs['new']=array('desc'=>__('Open a New Ticket'),'href'=>'open.php','title'=>'');
            if($user && $user->isValid()) {
                if(!$user->isGuest()) {
                    $navs['tickets']=array('desc'=>sprintf(__('Tickets (%d)'),$user->getNumTickets($user->canSeeOrgTickets())),
                                           'href'=>'tickets.php',
                                            'title'=>__('Show all tickets'));
                } else {
                    $navs['tickets']=array('desc'=>__('View Ticket Thread'),
                                           'href'=>sprintf('tickets.php?id=%d',$user->getTicketId()),
                                           'title'=>__('View ticket status'));
                }
            } else {
                $navs['status']=array('desc'=>__('Check Ticket Status'),'href'=>'view.php','title'=>'');
            }

            // osFaq integration
            $navs['osfaq']=array('desc'=>'FAQs','href'=>'osfaq.php','title'=>'Frequently Asked Questions');

            $this->navs=$navs;
        }

        return $this->navs;
    }</textarea>


<?php
  }



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
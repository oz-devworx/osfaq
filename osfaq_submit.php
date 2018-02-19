<?php
/* *************************************************************************
  Id: osfaq_submit.php

  Client side FAQ suggestion page.
  Suggested FAQs are not displayed to the public until approved by a staff member.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require ('./faq/include/OsFaqAdapter.class.php');
$osfAdapter = new OsFaqAdapter();

/// CONFIG
$osfAdapter->init_client();
require('./faq/include/main.faq.php'); // !important

// must be after configs are loaded
if(OSFDB_DISABLE_CLIENT=='true' || OSFDB_USER_SUBMITS_ALLOW=='false' || (OSFDB_USER_ANON=='false' && !$osf_isClient)){
  header('Location: ./' . FILE_FAQ);
  exit();
}

require(DIR_FAQ_INCLUDES . 'FaqFuncs.php');
require(DIR_FAQ_INCLUDES . 'FaqMessage.php');
require(DIR_FAQ_INCLUDES . 'FaqForm.php');

require_once(DIR_FAQ_INCLUDES . 'FaqCrumb.php');

/// DEFAULT LANGUAGE FILE.
require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_submit.lang.php');






/// INTERNAL PHP
$messageHandler = new FaqMessage;
$faqForm = new FaqForm;

$error = false;

if(OSFDB_RECAPTCHA_ENABLE=='true'){

  // run simillar checks to the old recaptchalib so we can use a system message
  if(!defined('OSFDB_RECAPTCHA_PUBLIC_KEY') || OSFDB_RECAPTCHA_PUBLIC_KEY == null || OSFDB_RECAPTCHA_PUBLIC_KEY == ''
  || !defined('OSFDB_RECAPTCHA_PRIVATE_KEY') || OSFDB_RECAPTCHA_PRIVATE_KEY == null || OSFDB_RECAPTCHA_PRIVATE_KEY == '') {

    $messageHandler->add(sprintf(OSFR_TO_USE_RECAPTCHA, '<a href="https://www.google.com/recaptcha/admin/create?domains='.SERVER_DOMAIN.'&app=osfaq" target="_blank">https://www.google.com/recaptcha/admin/create</a>'), FaqMessage::$warning);
    $error = true;
    $hide_recaptcha = true;
  }else{
  	require_once(DIR_FAQ_INCLUDES . 'Recaptcha.php');

  	$ost->addExtraHeader( RecaptchaV2Lib::get_recaptcha_js(true) );
  }
}


$error = false;
if (isset($_GET['action']) && ($_GET['action'] == 'send') && (OSFDB_USER_SUBMITS_ALLOW=='true')) {
  /// user details
  $name = db_input(strip_tags($_POST['name']), false);
  $country_id = db_input(strip_tags($_POST['country']), false);
  $email = db_input(strip_tags($_POST['email']), false);
  $phone = db_input(strip_tags($_POST['phone']), false);
  /// faq details
  $faq_question = db_input(strip_tags($_POST['faq_question']), false);
  // preserve basic formatting tags
  $faq_answer = db_input(strip_tags($_POST['faq_answer'], '<p><a><b><i><u><s><sub><sup><ul><ol><li><pre><br><hr>'), false);



//   // validate email address
//  $regexp = "/^[^@]+@[^@]+$/";// Super basic. Avoids false positives with new TLD's (Edit: Tim Gall, 2017-04-20)
//
//   if(!preg_match($regexp, $email)) {
//     $error = true;
//     $messageHandler->add(OSF_CHECK_EMAIL);
//   }
//
//   if(strlen(trim($name)) < 2) {
//     $error = true;
//     $messageHandler->add(OSF_CHECK_NAME);
//   }

  //TODO: add admin option to allow empty question
  if(!FaqFuncs::not_null($faq_question) && !FaqFuncs::not_null($faq_answer)) {
    $error = true;
    $messageHandler->add(OSF_CHECK_QUESTION);
  }

  if(OSFDB_RECAPTCHA_ENABLE=='true'){
    $error = RecaptchaV2Lib::validate_recaptcha_response();
  }

  if(!$error) {

  	if(isset($_POST['faq_category_new']) && FaqFuncs::not_null($_POST['faq_category_new'])) {
      /// insert new category for approval or removal at admins convenience
      $faq_category = db_input(strip_tags($_POST['faq_category_new']), false);

      // check for existing disabled categories
      $catExistsQry = db_query("select id from ".TABLE_FAQCATS." where category LIKE '" . $faq_category . "';");
      if(db_num_rows($catExistsQry) > 0){
        $catExists = db_fetch_array($catExistsQry);
        $faq_category_id = (int)$catExists['id'];
      }else{
        db_query("insert into ".TABLE_FAQCATS." (parent_id, category, category_status, client_entry, date_added) values ('0', '".$faq_category."', '0', '1', now())");
        $faq_category_id = db_insert_id();
      }

    } else {
      $faq_category_id = db_input(strip_tags($_POST['faq_category']), false);
      $cat_name_query = db_query("select category from ".TABLE_FAQCATS." where id = '".(int)$faq_category_id."'");
      $cat_name = db_fetch_array($cat_name_query);
      $faq_category = $cat_name['category'];
    }


    // insert form info into faq database tables
    db_query("insert into ".TABLE_FAQS." (question, answer, faq_active, name, email, phone, client_entry, date_added) values ('".$faq_question."', '".$faq_answer."', '0', '".$name."', '".$email."', '".$phone."', '1', now())");
    $last_faq_id = db_insert_id();

    db_query("insert into ".TABLE_FAQS2FAQCATS." (faq_id, faqcategory_id) values ('" .(int)$last_faq_id. "', '".(int)$faq_category_id."')");

    $_GET['action'] = 'success';
  }
}

$FaqCrumb = new FaqCrumb;

$FaqCrumb->add(OSF_LINK, FaqFuncs::format_url(FILE_FAQ));
$FaqCrumb->add(OSF_TITLE, FaqFuncs::format_url(FILE_FAQ_SUBMIT));











/// OUTPUT PAGE
$osfAdapter->get_client_page_header();


if ($messageHandler->size() > 0) echo $messageHandler->output() . '<br />';

echo $FaqCrumb->get(' &raquo; ');
?>
  <div class="clear"></div>
<?php

if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><?php echo OSF_SUCCESS; ?></h1></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo OSF_TEXT_SUCCESS; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><?php echo '<a href="'.FILE_FAQ.'">'.OSF_BACK_TO_FAQ.'</a>'; ?></td>
  </tr>
</table>
<?php







}else{







?>
<div id="faqs">
<?php echo $faqForm->form_open('suggest_faq', FILE_FAQ_SUBMIT . '?action=send'); ?>

<?php echo '<h1>'.OSF_YOUR_DETAILS.'</h1>'; ?>
<hr />
<table border="0" width="100%" cellspacing="3" cellpadding="0" style="padding-left:10px;">
  <tr>
    <td><?php echo OSF_ENTRY_NAME; ?></td>
  </tr>
  <tr>
    <td><?php echo $faqForm->input_field('name', db_input($_POST['name'], false), 'style="width:285px"', true); ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_TELEPHONE; ?></td>
  </tr>
  <tr>
    <td><?php echo $faqForm->input_field('phone', db_input($_POST['phone'], false), 'style="width:285px"', false); ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_ENTRY_EMAIL; ?></td>
  </tr>
  <tr>
    <td><?php echo $faqForm->input_field('email', db_input($_POST['email'], false), 'style="width:285px"', true); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
</table>



<?php echo '<h1>'.OSF_FAQ_SUGGESTION.'</h1>'; ?>
<hr />
<table border="0" width="100%" cellspacing="3" cellpadding="0" style="padding-left:10px;">
<?php
	$fc_values_data = array();
	$result = db_query("SELECT * FROM ".TABLE_FAQCATS." WHERE category_status = 1 ORDER BY category");
	while ($row = db_fetch_array($result)) {
	  $fc_values_data[] = array('id'=>$row['id'],'text'=>$row['category']);
	}
	$fc_values_data[] = array('id'=>'0','text'=>OSF_LIST_NEW);
?>
  <tr>
    <td><?php echo OSF_CHOOSE; ?></td>
  </tr>
  <tr>
    <td><?php echo $faqForm->pulldown_menu('faq_category', $fc_values_data, $_POST['faq_category'], 'style="width:290px"'); ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_SUGGEST_NEW; ?></td>
  </tr>
  <tr>
    <td><?php echo $faqForm->input_field('faq_category_new', $_POST['faq_category_new'], 'style="width:285px"'); ?></td>
  </tr>
  <tr>
    <td><br /><b><?php echo OSF_SUGGEST_Q; ?></b></td>
  </tr>
  <tr>
    <td><?php echo $faqForm->input_field('faq_question', $_POST['faq_question'], 'style="width:585px"', true); ?></td>
  </tr>
  <tr>
    <td><br /><b><?php echo OSF_SUGGEST_A; ?></b></td>
  </tr>
  <tr>
    <td>
<?php
if(OSFDB_WYSIWYG_CLIENT=='true' && is_dir(OSF_DOC_ROOT . DIR_FS_WEB_ROOT . 'faq/ckeditor/')){
	$faqForm->editor_field('faq_answer', '640', '300', $_POST['faq_answer'], 'Client', false, OSFDB_WYS_CLIENT_THEME);
}else{
	echo $faqForm->textarea_field('faq_answer', 'soft', '48', '8', $_POST['faq_answer'], '', false);
}
?>
	</td>
  </tr>
  <tr>
    <td>
<?php
// Dont show a broken box if the public or private key is not defined.
if( (OSFDB_RECAPTCHA_ENABLE=='true') && !$hide_recaptcha ){
  RecaptchaV2Lib::draw_recaptcha_box(OSFDB_RECAPTCHA_THEME);
}
?>
    </td>
  </tr>
  <tr>
    <td><?php echo $faqForm->submit_css(OSF_BTN_SUBMIT); ?></td>
  </tr>

</table>
<script type="text/javascript">document.getElementById('name').focus();</script>
<?php echo $faqForm->form_close(); ?>
</div>
<?php
}
?>
<?php $osfAdapter->get_client_page_footer(); ?>
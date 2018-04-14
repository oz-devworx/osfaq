<?php
/* *************************************************************************
  Id: faq_admin_ui.inc.php

  The main FAQ admin display page.
  Variables and functionality for this file
  are mainly handled by faq_admin_worker.inc.php


  Tim Gall
  Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

/// LANGUAGE FILE
require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_admin_ui.lang.php');
/// FUNCTIONALITY
require_once (DIR_FAQ_INCLUDES . 'FaqPaginator.php');
require_once (DIR_FAQ_INCLUDES . 'FaqUpload.php');
require_once (DIR_FAQ_INCLUDES . 'FaqCrumb.php');
require_once (DIR_FAQ_INCLUDES . 'FaqAdmin.php');

$FaqCrumb = new FaqCrumb;
$faqAdmin = new FaqAdmin;
$pages = new FaqPaginator(FILE_FAQ_ADMIN);


require_once (DIR_FAQ_INCLUDES . 'staff/' . FILE_FAQ_ADMIN_WORKER);

// AJAX status/featured js
echo '<script src="' . DIR_FAQ_INCLUDES . 'js/status.js?ver=1.0.0"></script>';

/// OUTPUT
// At the moment this only verifies categories.
// FAQs are checked via php.
require_once (DIR_FAQ_INCLUDES . 'js/faq_verify.js.php');

// create file upload handler
// added admin options for file types and size limits
switch ($action) {
	case 'new_faq':
	case 'new_faq_preview':
		$doc_file_types_tmp = explode(',', OSFDB_UPLOAD_EXTENSIONS);
		$doc_file_types = array();
		foreach($doc_file_types_tmp as $d_type){

			$d_type = strtolower($d_type);

			if(FaqFuncs::not_null($d_type) && !in_array($d_type, $doc_file_types))
				$doc_file_types[] = trim($d_type);
		}
		unset($doc_file_types_tmp);

		$docup = new FileUpload("new_faq", 1, $doc_file_types, (int)OSFDB_UPLOAD_SIZE, DIR_FS_DOC, DIR_WS_DOC, OSF_DOCUMENT);

		// TODO: need to add checks incase the user is running suPHP
		// and correct accordingly. Also check other mentions of file perms.
		//
		$docup->permissions = 0755; //should allow deletion. Must be an octal integer with leading 0 (not a string).

		if($action == 'new_faq_preview'){
			$docup->processFiles();
		}

		// image extensions
		$extensions = array('jpg','png','jpeg','gif');
		break;
	default:
		break;
}


// output system messages first
if ($messageHandler->size() > 0) echo $messageHandler->output() . '<br />';




// display a FaqCrumb menu for faq admin
echo '<div class="osf_bc">';
$faqAdmin->show_bc_menu();
echo '</div>';
echo '<div class="horizontal_rule"></div>';





///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/// new faq category / edit faq category
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
if ($action == 'new_category' || $action == 'edit_category') {
	if (($_GET['cID']) && (!$_POST)) {
		$categories_query = db_query("select id, parent_id, category, category_status, featured, date_added, last_modified from " . TABLE_FAQCATS . " where id = '" . $_GET['cID'] . "' order by category");
		$category_data = db_fetch_array($categories_query);
		$cInfo = new FaqArrayData($category_data);
	} elseif ($_POST) {
		$cInfo = new FaqArrayData($_POST);
		$cInfo->parent_id=$current_faq_cat_id;
	} else {
		$cInfo = new FaqArrayData(array());
		$cInfo->parent_id=$current_faq_cat_id;
	}
	$text_new_or_edit = ($action == 'new_category') ? OSF_HEAD_INFO_NEW_CATEGORY : OSF_HEAD_INFO_EDIT_CATEGORY;
?>
<?php
	$form_action = ($_GET['cID']) ? 'update_category' : 'insert_category';
	echo $faqForm->form_open('new_category', FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'fID', 'action')) . 'fcPath=' . $fcPath . '&action=' . $form_action, 'post', 'onsubmit="return verify_cat();"');
?>
<table cellpadding="5" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo sprintf($text_new_or_edit, $faqAdmin->get_output_cat_path($current_faq_cat_id)); ?></h1></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

<?php
	if($form_action=='update_category'){
?>
  <tr>
    <td>
    <?php echo sprintf(OSF_TEXT_MOVE, $cInfo->category) . '<br />' . $faqForm->pulldown_menu('parent_id', $faqAdmin->get_tree(0, '', $cInfo->id), $cInfo->parent_id); ?></td>
  </tr>
<?php
	}else{
?>
  <tr>
    <td><b><?php echo OSF_CAT_PARENT; ?></b><br />
    <?php echo $faqForm->pulldown_menu('parent_id', $faqAdmin->get_tree(0, '', $cInfo->id), $cInfo->parent_id); ?></td>
  </tr>
<?php
	}
?>

  <tr>
    <td><b><?php echo OSF_CAT_NAME; ?></b><br />
    <?php echo $faqForm->input_field('category', $cInfo->category, 'style="width:295px;"'); ?></td>
  </tr>

<?php
	// current status value
	if( FaqFuncs::not_null($cInfo->category_status) && ($cInfo->category_status == 1) )
		$fc_status = true;
	elseif( !FaqFuncs::not_null($cInfo->category_status) && (OSFDB_STATUS_DEFAULT == 'true') )
		$fc_status = true;
	else
		$fc_status = false;

	// current featured value
	if( FaqFuncs::not_null($cInfo->featured) && ($cInfo->featured == 1) )
		$featured_status = true;
	elseif( !FaqFuncs::not_null($cInfo->featured) && (OSFDB_FEATURE_DEFAULT == 'true') )
		$featured_status = true;
	else
		$featured_status = false;
?>
  <tr>
    <td><b><?php echo OSF_HEAD_STATUS; ?>:</b><br />
    <?php  echo '&nbsp;<label>' . $faqForm->radio_field('category_status', '1', $fc_status) . '&nbsp;' . OSF_FAQ_AVAILABLE . '</label>&nbsp;<label>' . $faqForm->radio_field('category_status', '0', !$fc_status) . '&nbsp;' . OSF_NOT_AVAILABLE . '</label>'; ?></td>
  </tr>
  <tr>
    <td><b><?php echo OSF_HEAD_FEATURED; ?>:</b><br />
    <?php  echo '&nbsp;<label>' . $faqForm->radio_field('featured', '1', $featured_status) . '&nbsp;' . OSF_FAQ_AVAILABLE . '</label>&nbsp;<label>' . $faqForm->radio_field('featured', '0', !$featured_status) . '&nbsp;' . OSF_NOT_AVAILABLE . '</label>'; ?></td>
  </tr>

  <tr>
    <td align="right"><?php echo $faqForm->hidden_field('categories_date_added', (($cInfo->date_added) ? $cInfo->date_added : date('Y-m-d')));// $faqForm->hidden_field('parent_id', $cInfo->parent_id); ?>
    <?php
	if ($_GET['cID']) {
		echo $faqForm->submit_css(OSF_TIP_UPDATE, OSF_ICON_SAVE);
	} else {
		echo $faqForm->submit_css(OSF_TIP_INSERT, OSF_ICON_SAVE);
	}
	echo '&nbsp;&nbsp;<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'fID', 'action')) . 'fcPath=' . $fcPath) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>'; ?>
    </td>
  </tr>
</table>
<?php
	echo $faqForm->form_close();









///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/// new faq / edit faq
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
} elseif ($action == 'new_faq') {
	$editHeading = OSF_HEAD_NEW_FAQ;

	if (isset($_GET['fID'])) {
		$faq_query = db_query("select id, question, answer, faq_active, featured, date_added, last_modified, name, email, phone, pdfupload, upload_text, client_views, client_entry from " . TABLE_FAQS . " where id = '" . (int)$_GET['fID'] . "'");
		$faq_data = db_fetch_array($faq_query);
		$fInfo = new FaqArrayData($faq_data);
		$editHeading = OSF_EDIT_FAQ;

		if(isset($_POST['question']) || isset($_POST['answer'])){
			$fInfo = new FaqArrayData($_POST);
		}

	} elseif (FaqFuncs::not_null($_POST)) {
		$fInfo = new FaqArrayData($_POST);
	} else {
		$fInfo = new FaqArrayData(array());
	}

	$fInfo->answer = $osfAdapter->fetch_inline_images($fInfo->answer);
?>

<?php echo $faqForm->form_open('new_faq', FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'action')) . 'fcPath=' . $fcPath . '&action=new_faq_preview', 'post', 'enctype="multipart/form-data"'); ?>

<h1><?php echo $editHeading; ?></h1>
<h2><?php echo OSF_HEAD_FAQ_DETAIL; ?></h2>

<table border="0" cellspacing="0" cellpadding="2" width="100%" class="list">
<?php
	// current status value
	if( FaqFuncs::not_null($fInfo->faq_active) && ($fInfo->faq_active == 1) )
		$f_status = true;
	elseif( !FaqFuncs::not_null($fInfo->faq_active) && (OSFDB_STATUS_DEFAULT == 'true') )
		$f_status = true;
	else
		$f_status = false;

	// current featured value
	if( FaqFuncs::not_null($fInfo->featured) && ($fInfo->featured == 1) )
		$f_featured = true;
	elseif( !FaqFuncs::not_null($fInfo->featured) && (OSFDB_FEATURE_DEFAULT == 'true') )
		$f_featured = true;
	else
		$f_featured = false;
?>
  <tr>
    <td width="15%"><?php echo OSF_STATUS; ?></td>
    <td><?php echo '<label>' . $faqForm->radio_field('faq_active', '1', $f_status) . '&nbsp;' . OSF_FAQ_AVAILABLE . '&nbsp;' . '</label><label>' . $faqForm->radio_field('faq_active', '0', !$f_status) . '&nbsp;' . OSF_NOT_AVAILABLE . '</label>'; ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_HEAD_FEATURED; ?></td>
    <td><?php echo '<label>' . $faqForm->radio_field('featured', '1', $f_featured) . '&nbsp;' . OSF_FAQ_AVAILABLE . '&nbsp;' . '</label><label>' . $faqForm->radio_field('featured', '0', !$f_featured) . '&nbsp;' . OSF_NOT_AVAILABLE . '</label>'; ?></td>
  </tr>

  <tr>
    <td><?php echo OSF_CATEGORIES; ?></td>
    <td>
<?php
	if( (isset($fInfo->id) && $fInfo->id > 0) || (isset($fInfo->update_faq) && $fInfo->update_faq == 'true') ){

		if(isset($fInfo->update_faq))
			$fInfo->id = (int)$_POST['fID'];

		$faq_categories_string = '';
		$faq_cats_seperator = ' <i class="icon-circle-arrow-right"></i> ';
		$faq_cats_line_seperator = '<br />';

		$faq_categories = $faqAdmin->get_cat_path_array($fInfo->id, 'faqs');
		for ($i = 0, $n = sizeof($faq_categories); $i < $n; $i++) {

			$osf_cat_checked = false;

			$category_path = '';
			for ($j = 0, $k = sizeof($faq_categories[$i]); $j < $k; $j++) {
				$category_path .= $faq_categories[$i][$j]['text'] . $faq_cats_seperator;
			}
			$category_path = substr($category_path, 0, -strlen($faq_cats_seperator));

			if(isset($_POST['remove_from_cats'])){
				if(in_array($faq_categories[$i][sizeof($faq_categories[$i]) - 1]['id'], $_POST['remove_from_cats']))
					$osf_cat_checked = true;
			}

			$faq_categories_string .= '<label>' . $faqForm->checkbox_field('remove_from_cats[]', $faq_categories[$i][sizeof($faq_categories[$i]) - 1]['id'], $osf_cat_checked) . '&nbsp;' . $category_path . '</label>' . $faq_cats_line_seperator;
		}
		echo '<b>' . OSF_SELECT_TO_REMOVE . '</b><br />';
		echo substr($faq_categories_string, 0, -strlen($faq_cats_line_seperator));

	}else{
		echo $faqForm->pulldown_menu('parent_id', $faqAdmin->get_tree(0, ''), $current_faq_cat_id);
	}
?>
    </td>
  </tr>
</table>


<hr />


<table border="0" cellspacing="0" cellpadding="2" width="100%" class="list">
  <tr>
    <td valign="top"><?php echo OSF_QUESTION; ?></td>
    <td><?php echo $faqForm->input_field('question', $fInfo->question, 'style="width:595px;"'); ?></td>
  </tr>
  <tr>
    <td valign="top"><?php  echo OSF_FAQ_ANSWER; ?></td>
    <td>
<?php
	if(OSFDB_WYSIWYG_STAFF=='true' && is_dir(OSF_DOC_ROOT . DIR_FS_WEB_ROOT . 'faq/ckeditor/')){
		$faqForm->editor_field('answer', '640', '300', (isset($fInfo->answer) ? $fInfo->answer : ''), '', false, OSFDB_WYS_STAFF_THEME);
	}else{
		echo $faqForm->textarea_field('answer', 'soft', '70', '15', (isset($fInfo->answer) ? $fInfo->answer : ''), '', false);
	}
?>
    </td>
  </tr>
</table>


<hr />


<table border="0" cellspacing="0" cellpadding="2" width="100%" class="list">
  <tr>
    <td><?php echo OSF_DOCUMENT_UPLOAD; ?></td>
    <td><?php echo $docup->drawForm() . '<br />' . (!empty($fInfo->pdfupload) ? ' <a href="' . DIR_WS_DOC . $fInfo->pdfupload . '" target="_blank">' . $fInfo->pdfupload . '</a> ' . $faqForm->checkbox_field('remove_pdf', '0', ((isset($_POST['remove_pdf']) && $_POST['remove_pdf'] == '1') ? true : false)) . OSF_REMOVE_DOC . '<br /><br />' : '') . $faqForm->hidden_field('pdfupload', (!empty($docup->file_names[0]) ? $docup->file_names[0] : $fInfo->pdfupload)); ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_DOCUMENT_UPLOAD_TEXT; ?></td>
    <td><?php echo $faqForm->input_field('upload_text', $fInfo->upload_text, 'style="width:595px;"'); ?></td>
  </tr>
</table>


<hr />


<table border="0" cellspacing="0" cellpadding="2" width="100%" class="list">
  <tr>
    <td>
<?php
	echo OSF_IMAGE_UPLOADS . '<br />' . OSF_VALID_TYPES;
	$js_ext = '';
	foreach($extensions as $ext){
		echo $ext . ' ';
		$js_ext .= $ext . '|';
	}
	$js_ext = substr($js_ext, 0, -1);
?>
    </td>
    <td width="60%">

	<script type="text/javascript" src="<?php echo DIR_FAQ_INCLUDES; ?>js/ajax-file-upload/ajaxupload.3.5.js" ></script>
	<link rel="stylesheet" type="text/css" href="<?php echo DIR_FAQ_INCLUDES; ?>js/ajax-file-upload/styles.css" />
	<script type="text/javascript" >
	  $(function(){
	    var btnUpload=$('#upload');
	    var status=$('#status');
	    new AjaxUpload(btnUpload, {
	      action: './<?php echo FILE_FAQ_ASSIST; ?>',
	      name: 'img',
	      onSubmit: function(file, ext){
	        if (! (ext && /^(<?php echo $js_ext; ?>)$/.test(ext))){ // extension is not allowed
	          status.text('<?php echo OSF_TYPES_ALLOWED; ?>');
	          return false;
	        }
	        status.text('<?php echo OSF_UPLOADING; ?>');
	      },
	      onComplete: function(file, response){
	        //On completion clear the status
	        status.text('');
	        //Add uploaded file to list
	        if(response.substring(0, 7)==="success"){
	          $('<li></li>').appendTo('#files').html('<img src="<?php echo DIR_WS_IMAGES; ?>'+file+'" alt="" /><br />'+file).addClass('success');
	        } else{
	          if(response=="error_extension"){
	        	  $('<li></li>').appendTo('#files').html('<?php echo OSF_FAILED; ?>: '+file+'<br /><?php echo OSF_TYPES_ALLOWED; ?>').addClass('error');
	          }else{
	        	  $('<li></li>').appendTo('#files').html('<?php echo OSF_FAILED; ?>: '+file).addClass('error');
	          }
	        }
	      }
	    });
	  });
	</script>
	<div id="upload"><span><?php echo OSF_TEXT_IMAGES; ?></span></div><span id="status"></span>
	<ul id="files"></ul>
	<iframe frameborder="0" style="width:100%; border:none; outline:none;" src="./<?php echo FILE_FAQ_ASSIST; ?>?img_browse=true"></iframe>

    </td>
  </tr>
</table>


<hr />


<h2><?php echo (($fInfo->client_entry == '1') ? '<i class="'.OSF_ICON_USER.' icon-large" title="'.OSF_TIP_CLIENT_ENTRY.'"></i> ' : '') . OSF_HEAD_AUTHOR_DETAIL; ?></h2>
<table border="0" cellspacing="0" cellpadding="2" width="100%" class="list">
  <tr>
    <td><?php echo OSF_FAQ_AUTHOR; ?></td>
    <td><?php echo $faqForm->input_field('name', $fInfo->name, 'style="width:295px;"') . OSF_TEXT_PUBLIC; ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_FAQ_EMAIL; ?></td>
    <td><?php echo $faqForm->input_field('email', $fInfo->email, 'style="width:295px;"') . OSF_TEXT_PRIVATE; ?></td>
  </tr>
  <tr>
    <td><?php echo OSF_FAQ_PHONE; ?></td>
    <td><?php echo $faqForm->input_field('phone', $fInfo->phone, 'style="width:295px;"') . OSF_TEXT_PRIVATE; ?></td>
  </tr>
</table>


<hr />


<div align="right"><?php echo $faqForm->hidden_field('date_added', $fInfo->date_added) . $faqForm->submit_css(OSF_TIP_PREVIEW, OSF_ICON_PREVIEW) . '&nbsp;&nbsp;<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'action')) . 'fcPath=' . $fcPath) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL . ' icon-large') . '</a>'; ?></div>


<?php
	echo $faqForm->form_close();








///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/// faq preview
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
} elseif ($action == 'new_faq_preview') {

	$needs_reposting = false;// validation flag

	if(isset($_POST['question'])){
		$fInfo = new FaqArrayData($_POST);
		if (!FaqFuncs::not_null($fInfo->date_added)) $fInfo->date_added = date(OSF_DATE_FMT_STD, mktime());

		// form validation (added: 2010-02-11)
		if(!FaqFuncs::not_null($fInfo->question) || !FaqFuncs::not_null($fInfo->answer)){
			$needs_reposting = true;

			if(strlen($fInfo->question) < 1){
				$fInfo->question = '<span style="color:red;font-weight:bold">' . OSF_WARN_QUESTION_EMPTY . '</span>';
			}
			if(strlen($fInfo->answer) < 1){
				$fInfo->answer = '<span style="color:red;font-weight:bold">' . OSF_WARN_ANSWER_EMPTY . '</span>';
			}
		}

	}else{
		$faq_query = db_query("select id, question, answer, name, email, phone, date_added, pdfupload, upload_text, client_entry from " . TABLE_FAQS . " where id = '" . (int)$_GET['fID'] . "'");
		$faq = db_fetch_array($faq_query);

		$fInfo = new FaqArrayData($faq);
	}


	$form_action = (isset($_GET['fID'])) ? 'update_faq' : 'insert_faq';
	echo $faqForm->form_open($form_action, FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'action')) . 'fcPath=' . $fcPath . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td><h2><?php echo OSF_Q; ?></h2>
    <h3><?php echo $fInfo->question; ?></h3></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="answer"><h2><?php echo OSF_A; ?></h2>
    <?php echo $osfAdapter->fetch_inline_images($fInfo->answer); ?></td>
  </tr>


<?php
  //authors details are only displayed when they exist
	if(FaqFuncs::not_null($fInfo->name) || FaqFuncs::not_null($fInfo->email) || FaqFuncs::not_null($fInfo->phone)){
?>
  <tr>
    <td><hr /><?php echo (($fInfo->client_entry == '1') ? '<h2><i class="'.OSF_ICON_USER.' icon-large" title="'.OSF_TIP_CLIENT_ENTRY.'"></i> ' . OSF_TIP_CLIENT_ENTRY . '</h2>' : ''); ?></td>
  </tr>
<?php
	}
	if(FaqFuncs::not_null($fInfo->name)){
?>
  <tr>
    <td><?php echo '<b>' . OSF_FAQ_AUTHOR . '</b> ' . $fInfo->name; ?></td>
  </tr>
<?php
	}
	if(FaqFuncs::not_null($fInfo->email)){
?>
  <tr>
    <td><?php echo '<b>' . OSF_FAQ_EMAIL . '</b> ' . $fInfo->email; ?></td>
  </tr>
<?php
	}
	if(FaqFuncs::not_null($fInfo->phone)){
?>
  <tr>
    <td><?php echo '<b>' . OSF_FAQ_PHONE . '</b> ' . $fInfo->phone; ?></td>
  </tr>
<?php
	}
?>

  <tr>
    <td>
    <hr />
<?php
	if (FaqFuncs::not_null($docup->file_names[0])) {
		$osf_old_doc = $fInfo->pdfupload;
		$fInfo->pdfupload = $docup->file_names[0];
	}

	if (FaqFuncs::not_null($fInfo->pdfupload)) {
		if (isset($_POST['remove_pdf'])) {
			echo OSF_DOCUMENT . ' <a href="' . DIR_WS_DOC . $osf_old_doc . '" target="_blank">' . $osf_old_doc . '</a> (' .FaqFuncs::display_filesize(filesize(DIR_FS_DOC . $osf_old_doc)) . ')';
			echo ' <i>('.OSF_DOC_FOR_REMOVAL.')</i><br /><br />';
		}

		echo OSF_DOCUMENT . ' <a href="' . DIR_WS_DOC . $fInfo->pdfupload . '" target="_blank">' . $fInfo->pdfupload . '</a> (' .FaqFuncs::display_filesize(filesize(DIR_FS_DOC . $fInfo->pdfupload)) . ')';
		echo '<br /><b>' . OSF_DOCUMENT_UPLOAD_TEXT . ':</b> ' . $fInfo->upload_text;
	}
?>
    </td>
  </tr>
  <tr>
    <td align="center" class="smallText"><?php echo OSF_DATE_ADDED . '<b>' . FaqFuncs::format_date($fInfo->date_added) . '</b>'; ?></td>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
<?php
	if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
		if (isset($_GET['origin'])) {
			$pos_params = strpos($_GET['origin'], '?', 0);
			if ($pos_params != false) {
				$back_url = substr($_GET['origin'], 0, $pos_params);
				$back_url_params = substr($_GET['origin'], $pos_params + 1);
			} else {
				$back_url = $_GET['origin'];
				$back_url_params = FaqFuncs::get_all_get_params(array('fcPath', 'action', 'read', 'origin'));
			}
		} else {
			$back_url = FILE_FAQ_ADMIN;
			$back_url_params = FaqFuncs::get_all_get_params(array('fcPath', 'action', 'read', 'origin')) . 'fcPath=' . $fcPath;
		}
?>
  <tr>
    <td align="right">
<?php
		// back and edit buttons
		echo '<a href="' . FaqFuncs::format_url($back_url, $back_url_params) . '">' . $faqForm->button_css(OSF_TIP_BACK, OSF_ICON_BACK) . '</a> ';
		if(!$needs_reposting)
			echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'read', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo->id . '&action=new_faq') . '">' . $faqForm->button_css(OSF_TIP_EDIT, OSF_ICON_CHANGE) . '</a>';
?>
    </td>
  </tr>
<?php
	} else {
?>
  <tr>
    <td align="right" class="smallText">
<?php
		/* Re-Post all POST variables */
		echo FaqFuncs::get_all_post_params();

		echo $faqForm->hidden_field('pdfupload', stripslashes($fInfo->pdfupload));
		// for the parent category area if back is pressed
		if($form_action == 'update_faq') echo $faqForm->hidden_field('update_faq', 'true');
		// for the FAQ id if back is pressed during an edit session
		if(isset($_GET['fID'])) echo $faqForm->hidden_field('fID', $_GET['fID']);

		// fixed back button. returns to the edit area.
		// added js forms[] wrapper for form name 2013-02-26, Tim Gall
		echo $faqForm->submit_css(OSF_TIP_BACK, OSF_ICON_BACK, 'onclick="document.forms[\''.$form_action.'\'].action=\''.FILE_FAQ_ADMIN . '?' . FaqFuncs::get_all_get_params(array('fcPath', 'action')) . 'fcPath=' . $fcPath . '&action=new_faq'.'\';"') . '&nbsp;&nbsp;';

		if(!$needs_reposting){
			if (isset($_GET['fID'])) {
				echo $faqForm->submit_css(OSF_TIP_UPDATE, OSF_ICON_SAVE);
			} else {
				echo $faqForm->submit_css(OSF_TIP_INSERT, OSF_ICON_SAVE);
			}
		}

		echo '&nbsp;&nbsp;<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'action', 'flag', 'read')) . 'fcPath=' . $fcPath) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>';
?></td>
  </tr>
<?php
	}
?>
</table>
<?php
	echo $faqForm->form_close();









///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/// DEFAULT faq categories and faqs list
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

} else {


//////////////////////////////////
/// Filtering and search forms ///
//////////////////////////////////

	//sort by column header functionality
	if($_GET['direction']=='DESC'){
		$sort_direction = 'DESC';
		$alt_direction = 'ASC';
		$direction_char = ' <i class="icon-sort-up" title="' . OSF_HEAD_SORT_ASC . '"></i>';
	}else{
		$sort_direction = 'ASC';
		$alt_direction = 'DESC';
		$direction_char = ' <i class="icon-sort-down" title="' . OSF_HEAD_SORT_DESC . '"></i>';
	}

	$shd_name = ' <i class="icon-sort"></i>';
	$shd_status = $shd_name;
	$shd_feature = $shd_name;
	$shd_views = $shd_name;
	$shd_can = $shd_name;

	$osf_cat_order = ' order by ';
	$osf_faq_order = ' order by ';
	$sort_by = (isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id');
	switch($sort_by){
		case 'views':
			$osf_cat_order .= 'fc.client_views ' . $sort_direction . ', fc.category ASC';
			$osf_faq_order .= 'f.client_views ' . $sort_direction . ', f.question ASC';
			$shd_views = $direction_char;
			break;
		case 'status':
			$osf_cat_order .= 'fc.category_status ' . $sort_direction . ', fc.category ASC';
			$osf_faq_order .= 'f.faq_active ' . $sort_direction . ', f.question ASC';
			$shd_status = $direction_char;
			break;
		case 'feature':
			$osf_cat_order .= 'fc.featured ' . $sort_direction . ', fc.category ASC';
			$osf_faq_order .= 'f.featured ' . $sort_direction . ', f.question ASC';
			$shd_feature = $direction_char;
			break;

		case 'can':
			$osf_cat_order .= 'fc.category ASC';// no canned status on cats
			$osf_faq_order .= 'f.canned ' . $sort_direction . ', f.question ASC';
			$shd_can = $direction_char;
			break;

		case 'name':
		default:
			$osf_cat_order .= 'fc.category ' . $sort_direction;
			$osf_faq_order .= 'f.question ' . $sort_direction;
			$shd_name = $direction_char;
			break;
	}
	//sort by column header common params
	$sort_params = FaqFuncs::get_all_get_params(array('sort_by', 'direction', 'action', 'page', 'pg'));


	//// Harvest filter triggers
	// nested/flat view filter
	$free_browse = (isset($_GET['free_browse']) && $_GET['free_browse']==OSF_BTN_YES) ? true : false;
	// category/faq only filter
	$cffilter = isset($_GET['cffilter']) ? (int)$_GET['cffilter'] : -1;
	// status filter
	$sfilter = isset($_GET['sfilter']) ? (int)$_GET['sfilter'] : -1;
	// featured filter
	$ffilter = isset($_GET['ffilter']) ? (int)$_GET['ffilter'] : -1;
	// search filter
	if (isset($_GET['search']) && FaqFuncs::not_null($_GET['search'])) {
		$search = trim($_GET['search']);
	}else{
		unset($_GET['search']);
	}


	// cosmetic touches to filter bar
	if( ($cffilter > -1) || ($sfilter > -1) || ($ffilter > -1) || $free_browse ){
		$osf_filter_style = 'osf_filter_box_active';
	}else{
		$osf_filter_style = 'osf_filter_box';
	}
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%"><h1><?php echo OSF_MAIN_TITLE . ' - <i>' . OSF_PAGE_FAQ . '</i>'; ?></h1>
<?php
	// category jump menu
	echo $faqForm->form_open('goto', FILE_FAQ_ADMIN, '', 'get', 'style="margin:0;padding;0;border:0;display:inline"');
	echo OSF_HEAD_TITLE_GOTO . ' ' . $faqForm->pulldown_menu('fcPath', $faqAdmin->get_tree(), $current_faq_cat_id, 'onchange="this.form.submit();"' . ($free_browse ? ' disabled="disabled"':''));
	echo FaqFuncs::get_all_get_params_hidden(array('action', 'fcPath', 'free_browse', 'page', 'pg'));
	echo $faqForm->form_close();
?>

    </td>
    <td align="right" valign="top" class="smallText">
    <div id="<?php echo $osf_filter_style; ?>">
<?php
	if( $osf_filter_style == 'osf_filter_box_active' ){
		echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('search', 'cffilter', 'sfilter', 'ffilter', 'free_browse', 'action', 'page', 'pg'))) . '">' . '<i class="icon-refresh icon-large" title="' . OSF_CLEAR_FILTERS . '"></i>' . '</a>';
		echo '&nbsp;&nbsp;';
	}

	// "category or faq" filter
	$catFaqSet = array(array('id' => -1, 'text' => '-' . OSF_SHOW_BOTH . '-'),
					array('id' => 0, 'text' => OSF_CATS),
					array('id' => 1, 'text' => OSF_FAQS));

	echo $faqForm->form_open('type_filter', FILE_FAQ_ADMIN, '', 'get', 'style="margin:0;padding;0;border:0;display:inline"');
	echo $faqForm->pulldown_menu('cffilter', $catFaqSet, $cffilter, 'onchange="this.form.submit();"');
	echo FaqFuncs::get_all_get_params_hidden(array('action', 'cffilter', 'page', 'pg'));
	echo $faqForm->form_close();


	//spacer between filter subjects
	echo '&nbsp;&nbsp;&nbsp;';


	// flat view OR nested view
	$catFaqSet = array(array('id' => OSF_BTN_NO, 'text' => '-' . OSF_NESTED_VIEW . '-'),
					array('id' => OSF_BTN_YES, 'text' => OSF_FLAT_VIEW));

	echo $faqForm->form_open('view_type', FILE_FAQ_ADMIN, '', 'get', 'style="margin:0;padding;0;border:0;display:inline"');
	echo $faqForm->pulldown_menu('free_browse', $catFaqSet, ($free_browse ? OSF_BTN_YES : OSF_BTN_NO), 'onchange="this.form.submit();"');
	echo FaqFuncs::get_all_get_params_hidden(array('action', 'free_browse', 'page', 'pg'));
	echo $faqForm->form_close();


	//spacer between filter subjects
	echo '&nbsp;&nbsp;&nbsp;';


	// status filter
	$statusSet = array(array('id' => -1, 'text' => '-' . OSF_HEAD_STATUS . '-'),
					array('id' => 0, 'text' => OSF_DISABLED),
					array('id' => 1, 'text' => OSF_ENABLED));

	echo $faqForm->form_open('status_filter', FILE_FAQ_ADMIN, '', 'get', 'style="margin:0;padding;0;border:0;display:inline"');
	echo $faqForm->pulldown_menu('sfilter', $statusSet, $sfilter, 'onchange="this.form.submit();"');
	echo FaqFuncs::get_all_get_params_hidden(array('action', 'sfilter', 'page', 'pg'));
	echo $faqForm->form_close();


	//spacer between filter subjects
	echo '&nbsp;&nbsp;&nbsp;';


	// featured filter
	$featureSet = array(array('id' => -1, 'text' => '-' . OSF_HEAD_FEATURED . '-'),
					array('id' => 0, 'text' => OSF_DISABLED),
					array('id' => 1, 'text' => OSF_ENABLED));

	echo $faqForm->form_open('featured_filter', FILE_FAQ_ADMIN, '', 'get', 'style="margin:0;padding;0;border:0;display:inline"');
	echo $faqForm->pulldown_menu('ffilter', $featureSet, $ffilter, 'onchange="this.form.submit();"');
	echo FaqFuncs::get_all_get_params_hidden(array('action', 'ffilter', 'page', 'pg'));
	echo $faqForm->form_close();
?>
    </div>

    <div class="osf_search">
<?php
	echo $faqForm->form_open('search', FILE_FAQ_ADMIN, '', 'get');
	echo OSF_HEAD_TITLE_SEARCH . '' . $faqForm->input_field('search');
	echo FaqFuncs::get_all_get_params_hidden(array('action', 'fcPath', 'search', 'page'));
	if (FaqFuncs::not_null($search)) {
		echo '<br /><a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('search', 'action', 'page', 'pg'))) . '">'. '<i class="icon-trash"></i> ' . OSF_CLEAR_SEARCH.'</a>';
	}
	echo $faqForm->form_close();
?>
    </div>

    </td>
  </tr>
</table>

<?php
////////////////////////////
/// The rest of the page ///
////////////////////////////
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td valign="top">

<?php
	// summary counters
	$categories_count = 0;
	$faq_count = 0;
	$rows = 0;// for RH box

	//// All filters are now consolidated here
	$osf_faq_filter_sql = '';//filters for faqs
	$osf_cat_filter_sql = '';//filters for categories

	if($sfilter > -1){
		$osf_faq_filter_sql .= ' and f.faq_active = ' . (($sfilter == 0) ? 0:1) . ' ';
		$osf_cat_filter_sql .= ' and fc.category_status = ' . (($sfilter == 0) ? 0:1) . ' ';
	}
	if($ffilter > -1){
		$osf_faq_filter_sql .= ' and f.featured = ' . (($ffilter == 0) ? 0:1) . ' ';
		$osf_cat_filter_sql .= ' and fc.featured = ' . (($ffilter == 0) ? 0:1) . ' ';
	}
	if(!$free_browse){
		$osf_faq_filter_sql .= " and f2f.faqcategory_id = '" . (int)$current_faq_cat_id . "' ";
		$osf_cat_filter_sql .= " and fc.parent_id = '" . (int)$current_faq_cat_id . "' ";
	}
	if (FaqFuncs::not_null($search)) {
		$osf_faq_filter_sql .= " and f.question like '%" . db_input($search, false) . "%' ";
		$osf_cat_filter_sql .= " and fc.category like '%" . db_input($search, false) . "%' ";
	}

	if (FaqFuncs::not_null($osf_cat_filter_sql)) {
		$osf_cat_filter_sql = ' where ' . ltrim($osf_cat_filter_sql, 'and ') . ' ';
	}
	// omit duplicate FAQs in flat-view.
	// MUST be after all other filters are set
	if($free_browse){
		$osf_faq_filter_sql .= ' group by f.id ';
	}


	// reset all pagination counters
	$pages->items_total = 0;
	$osf_cat_limit = 0;
	$osf_faq_limit = 0;

	// faq count
	if($cffilter !== 0){
		$faq_count_query = db_query("select f.id from " . TABLE_FAQS . " f, " . TABLE_FAQS2FAQCATS . " f2f where f.id = f2f.faq_id " . $osf_faq_filter_sql);
		$osf_faq_limit = db_num_rows($faq_count_query);

		$pages->items_total += $osf_faq_limit;
	}

	// category count
	if($cffilter < 1){
		$cat_count_query = db_query("select fc.id from " . TABLE_FAQCATS . " fc " . $osf_cat_filter_sql);
		$osf_cat_limit = db_num_rows($cat_count_query);

		$pages->items_total += $osf_cat_limit;
	}

	$pages->paginate();

	////Work out query limits for faqs and cats. Woohoo!
	$osf_cat_limit_sql = '';
	$osf_faq_limit_sql = '';

	if($pages->items_total > $pages->items_per_page){
		$osf_cat_limit_sql = ' limit 0';
		$osf_faq_limit_sql = ' limit 0';

		if($osf_cat_limit >= $pages->low){

			$osf_cat_low = $pages->low;
			$osf_cat_high = $pages->high;

			$osf_cat_limit_sql = " limit $osf_cat_low, $osf_cat_high";

			$osf_faq_low = 0;
			$osf_faq_high = $pages->low + $pages->high - $osf_cat_limit;

			if($osf_faq_high > 0)
				$osf_faq_limit_sql = " limit $osf_faq_low, $osf_faq_high";

		}else{

			$osf_faq_low = $pages->low - $osf_cat_limit;
			$osf_faq_high = $pages->high;

			$osf_faq_limit_sql = " limit $osf_faq_low, $osf_faq_high";
		}
	}




	// fixes <th> wrapping with some translations
	if(strlen(OSF_HEAD_FEATURED) > 8){
		$osf_th_width = '13%';
	}else{
		$osf_th_width = '11%';
	}


	// pagination controls (if active)
	if($pages->items_total > $pages->items_per_page){
		echo '<div class="paginate_row paginate_top">';
		echo $pages->display_pages(); // page numbers
		echo $pages->display_jump_menu(); // page jump menu
		echo $pages->display_items_per_page(); // items per page menu
		echo '</div>';
	}
?>

      <table class="list">
        <tr>
          <th width="10">&nbsp;</th>
          <th><?php echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $sort_params . 'sort_by=name&direction='.$alt_direction) . '">'.OSF_HEAD_CATS_FAQS.$shd_name.'</a>'; ?></th>
          <th align="center" width="<?php echo $osf_th_width; ?>"><?php echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $sort_params . 'sort_by=status&direction='.$alt_direction) . '">'.OSF_HEAD_STATUS.$shd_status.'</a>'; ?></th>
          <th align="center" width="<?php echo $osf_th_width; ?>"><?php echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $sort_params . 'sort_by=feature&direction='.$alt_direction) . '">'.OSF_HEAD_FEATURED.$shd_feature.'</a>'; ?></th>
          <th align="center" width="<?php echo $osf_th_width; ?>"><?php echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $sort_params . 'sort_by=can&direction='.$alt_direction) . '">'.OSF_HEAD_CAN.$shd_can.'</a>'; ?></th>
          <th align="center" width="<?php echo $osf_th_width; ?>"><?php echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $sort_params . 'sort_by=views&direction='.$alt_direction) . '">'.OSF_HEAD_VIEWS.$shd_views.'</a>'; ?></th>
          <th align="right" width="5%"><?php echo OSF_HEAD_ACTION; ?>&nbsp;</th>
        </tr>
<?php
////////////////////////////////////////////////////////////////////
/// FAQ Categories
////////////////////////////////////////////////////////////////////
	if($cffilter < 1){

		$categories_query = db_query("select fc.id, fc.category, fc.category_status, fc.featured, fc.parent_id, fc.client_views, fc.client_entry, fc.date_added, fc.last_modified from " . TABLE_FAQCATS . " fc " . $osf_cat_filter_sql . $osf_cat_order . $osf_cat_limit_sql);

		while ( $categories = db_fetch_array($categories_query) ) {
			$categories_count++;
			$rows++;

			// Get parent_id for subcategories if search
			if (isset($_GET['search']) && FaqFuncs::not_null($_GET['search'])) $fcPath = $categories['parent_id'];

			if ((!isset($_GET['cID']) && !isset($_GET['fID']) || (isset($_GET['cID']) && ($_GET['cID'] == $categories['id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
				$category_childs = array('childs_count' => $faqAdmin->count_subcats_in_cat($categories['id']));
				$category_faqs = array('faqs_count' => $faqAdmin->count_faqs_in_cat($categories['id']));

				$cInfo_array = array_merge($categories, $category_childs, $category_faqs);
				$cInfo = new FaqArrayData($cInfo_array);
			}
			if (isset($cInfo) && is_object($cInfo) && ($categories['id'] == $cInfo->id)) {
				echo '        <tr class="osf_active">' . "\n";
				$row_link = ' onclick="document.location.href=\'' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'flag', 'pg', 'page')) . $faqAdmin->get_faq_path($categories['id'])) . '\'"';
			} else {
				echo '        <tr>' . "\n";
				$row_link = ' onclick="document.location.href=\'' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'flag', 'pg', 'page')) . 'fcPath=' . $fcPath . '&cID=' . $categories['id']) . '\'"';
			}


// 			$cat_status_color = ($categories['category_status'] == '1') ? OSFDB_ACTIVE_COLOR : OSFDB_INACTIVE_COLOR;
// 			if(FaqFuncs::not_null($cat_status_color)) $cat_status_color = 'class="nohover" style="background-color:' . $cat_status_color . ';"';

// 			$cat_featured_color = ($categories['featured'] == '1') ? OSFDB_ACTIVE_COLOR : OSFDB_INACTIVE_COLOR;
// 			if(FaqFuncs::not_null($cat_featured_color)) $cat_featured_color = 'class="nohover" style="background-color:' . $cat_featured_color . ';"';
?>
          <td>
<?php
			echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'free_browse', 'pg', 'page')) . $faqAdmin->get_faq_path($categories['id'])) . '">';

			if (isset($cInfo) && is_object($cInfo) && ($categories['id'] == $cInfo->id)) {
				$fcIcon = OSF_ICON_FOLDER_OPEN;
			}else{
				$fcIcon = OSF_ICON_FOLDER;
			}

			if($categories['client_entry'] == '1'){

				echo '<span class="icon-stack" title="' . OSF_TIP_FOLDER . ' (' . OSF_TIP_CLIENT_ENTRY . ')" style="width:1em;height:1em;line-height:1em;">';
				echo '<i class="' . $fcIcon . '" style="opacity: 0.5"></i>';
				echo '<i class="' . OSF_ICON_USER . ' icon-small"></i>';
				echo '</span>';

			}else{
				echo '<i class="' . $fcIcon . '" title="' . OSF_TIP_FOLDER . '"></i>';
			}

			echo '</a>';
?></td>
          <td<?php echo $row_link; ?>>
<?php
			echo '&nbsp;<b>' . $categories['category'] . '</b>';

?></td>

          <td align="center"><div id="statusboxc<?php echo $categories['id']; ?>">
<?php
			if ($categories['category_status'] == '1') {
				echo $faqAdmin->draw_status_button(true, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setflag_categories&flag=0&cID=' . $categories['id']), 'fcs' . $categories['id']);
			} else {
				echo $faqAdmin->draw_status_button(false, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setflag_categories&flag=1&cID=' . $categories['id']), 'fcs' . $categories['id']);
			}

?></div></td>

          <td align="center"><div id="featboxc<?php echo $categories['id']; ?>">
<?php
			if ($categories['featured'] == '1') {
				echo $faqAdmin->draw_status_button(true, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setfav_categories&flag=0&cID=' . $categories['id']), 'fcs' . $categories['id']);
			} else {
				echo $faqAdmin->draw_status_button(false, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setfav_categories&flag=1&cID=' . $categories['id']), 'fcs' . $categories['id']);
			}

?></div></td>

          <td align="center">-</td>

          <td align="right"<?php echo $row_link; ?>><?php echo $categories['client_views']; ?></td>

          <td align="right">
<?php
			echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&cID=' . $categories['id'] . '&action=edit_category') . '">';

			if (isset($cInfo) && is_object($cInfo) && ($categories['id'] == $cInfo->id)) {
				echo '<i class="'.OSF_ICON_ARROW_RIGHT.'" title="'.OSF_TIP_EDIT.'"></i>';
			} else {
				echo '<i class="'.OSF_ICON_EDIT.'" title="'.OSF_TIP_EDIT.'"></i>';
			}

			echo '</a>';
?>&nbsp;</td>
        </tr>
<?php
		}
	}





////////////////////////////////////////////////////////////////////
/// FAQs
////////////////////////////////////////////////////////////////////
	if($cffilter !== 0){

		$fInfo_query = db_query("select f.id, f.question, f.answer, f.faq_active, f.featured, f.canned, f.client_views, f.client_entry, f.date_added, f.last_modified, f.name, f.email, f.phone, f.pdfupload, f.upload_text, f2f.faqcategory_id from " . TABLE_FAQS . " f, " . TABLE_FAQS2FAQCATS . " f2f where f.id = f2f.faq_id " . $osf_faq_filter_sql . $osf_faq_order . $osf_faq_limit_sql);

		while ($fInfo_array = db_fetch_array($fInfo_query)) {
			$faq_count++;
			$rows++;

			// Get categories_id for faq if search
			if (isset($_GET['search']) && FaqFuncs::not_null($_GET['search'])) $fcPath = $fInfo_array['faqcategory_id'];

			if ((( !isset($_GET['fID']) && !isset($fInfo) && !isset($cInfo) ) || (isset($_GET['fID']) && ($_GET['fID'] == $fInfo_array['id'])) ) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
				$_GET['fID'] = $fInfo_array['id'];
				$fInfo = new FaqArrayData($fInfo_array);
			}
			if (isset($fInfo) && is_object($fInfo) && ($fInfo_array['id'] == $fInfo->id)) {
				echo '        <tr class="osf_active">' . "\n";
				$row_link = ' onclick="document.location.href=\'' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'flag', 'read')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo_array['id'] . '&action=new_faq_preview&read=only') . '\'"';
			} else {
				echo '        <tr>' . "\n";
				$row_link = ' onclick="document.location.href=\'' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'flag', 'read')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo_array['id']) . '\'"';
			}

// 			$faq_status_color = ($fInfo_array['faq_active'] == '1') ? OSFDB_ACTIVE_COLOR : OSFDB_INACTIVE_COLOR;
// 			if(FaqFuncs::not_null($faq_status_color)) $faq_status_color = 'class="nohover" style="background-color:' . $faq_status_color . ';"';

// 			$faq_featured_color = ($fInfo_array['featured'] == '1') ? OSFDB_ACTIVE_COLOR : OSFDB_INACTIVE_COLOR;
// 			if(FaqFuncs::not_null($faq_featured_color)) $faq_featured_color = 'class="nohover" style="background-color:' . $faq_featured_color . ';"';

?>
          <td<?php echo $row_link; ?>>
<?php
			echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'flag', 'read')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo_array['id'] . '&action=new_faq_preview&read=only') . '">';

			if (isset($fInfo) && is_object($fInfo) && ($fInfo_array['id'] == $fInfo->id)) {
				$fcIcon = OSF_ICON_PREVIEW_ALT;
			}else{
				$fcIcon = OSF_ICON_PREVIEW;
			}

			if($fInfo_array['client_entry'] == '1'){

				echo '<span class="icon-stack" title="' . OSF_TIP_PREVIEW . ' (' . OSF_TIP_CLIENT_ENTRY . ')" style="width:1em;height:1em;line-height:1em;">';
				echo '<i class="' . $fcIcon . '" style="opacity: 0.5"></i>';
				echo '<i class="' . OSF_ICON_USER . ' icon-small"></i>';
				echo '</span>';

			}else{
				echo '<i class="' . $fcIcon . '" title="' . OSF_TIP_PREVIEW . '"></i>';
			}

			echo '</a>';
?>
          <td<?php echo $row_link; ?>>
<?php
			echo '&nbsp;' . $fInfo_array['question'];
?></td>

          <td align="center"><div id="statusbox<?php echo $fInfo_array['id']; ?>">
<?php
			if ($fInfo_array['faq_active'] == '1') {
				echo $faqAdmin->draw_status_button(true, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setflag&flag=0&fID=' . $fInfo_array['id']), 'fs' . $fInfo_array['id']);
			} else {
				echo $faqAdmin->draw_status_button(false, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setflag&flag=1&fID=' . $fInfo_array['id']), 'fs' . $fInfo_array['id']);
			}

?></div></td>

          <td align="center"><div id="featbox<?php echo $fInfo_array['id']; ?>">
<?php
			if ($fInfo_array['featured'] == '1') {
				echo $faqAdmin->draw_status_button(true, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setfav&flag=0&fID=' . $fInfo_array['id']), 'fs' . $fInfo_array['id']);
			} else {
				echo $faqAdmin->draw_status_button(false, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setfav&flag=1&fID=' . $fInfo_array['id']), 'fs' . $fInfo_array['id']);
			}

?></div></td>

          <td align="center"><div id="canbox<?php echo $fInfo_array['id']; ?>">
<?php
			if ($fInfo_array['canned'] == '1') {
				echo $faqAdmin->draw_status_button(true, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setcan&flag=0&fID=' . $fInfo_array['id']), 'fcrs' . $fInfo_array['id']);
			} else {
				echo $faqAdmin->draw_status_button(false, FaqFuncs::format_url(FILE_FAQ_ADMIN, 'action=setcan&flag=1&fID=' . $fInfo_array['id']), 'fcrs' . $fInfo_array['id']);
			}

?></div></td>

          <td align="right"<?php echo $row_link; ?>><?php echo $fInfo_array['client_views']; ?></td>

          <td align="right">&nbsp;
<?php
			echo ' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo_array['id'] . '&action=new_faq') . '">';

			if (isset($fInfo) && is_object($fInfo) && ($fInfo_array['id'] == $fInfo->id)) {
				echo '<i class="'.OSF_ICON_ARROW_RIGHT.'" title="'.OSF_TIP_EDIT.'"></i>';
			} else {
				echo '<i class="'.OSF_ICON_EDIT.'" title="'.OSF_TIP_EDIT.'"></i>';
			}

			echo '</a>';
?>&nbsp;</td>
        </tr>
<?php
		}

	}// if($cffilter !== 0){
?>
      </table>
<?php
	// pagination controls
	echo '<div class="paginate_row paginate_bot">';
	echo $pages->display_pages(); // page numbers
	echo $pages->display_jump_menu(); // page jump menu
	echo $pages->display_items_per_page(); // items per page menu
	echo '</div>';
?>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
          <td class="smallText">
<?php
	// a few stats for listing displays
	$osf_upper_items = ( ($pages->current_page * $pages->items_per_page) > $pages->items_total) ? $pages->items_total : ($pages->current_page * $pages->items_per_page);

	echo OSF_CATEGORIES . ' ' . $categories_count . OSF_OF . $osf_cat_limit;
	echo '<br />' . OSF_FAQS . ' ' . $faq_count . OSF_OF . $osf_faq_limit;
	if($pages->items_total > 0) echo '<br />' . sprintf(OSF_ITEMS_OF_TOTAL, ($pages->low + 1), $osf_upper_items, $pages->items_total);
?>
          </td>
          <td align="right" class="smallText">
<?php
	/// back button
	if (sizeof($fcPath_array) > 0) echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'fID', 'cID', 'action', 'flag', 'read', 'pg', 'page')) . ( (sizeof($fcPath_array)>1) ? 'fcPath='.$fcPath_array[sizeof($fcPath_array)-2] : '' ), 'SSL') . '">' . $faqForm->button_css(OSF_TIP_BACK, OSF_ICON_ARROW_LEFT) . '</a>&nbsp;';

	$btn_params = FaqFuncs::get_all_get_params(array('fcPath', 'fID', 'cID', 'action', 'flag', 'read', 'pg', 'page')) . 'fcPath=' . $fcPath;

	echo '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $btn_params . '&action=new_category') . '">' . $faqForm->button_css(OSF_TIP_NEW_CAT, OSF_ICON_FOLDER) . '</a>';
	echo '&nbsp;<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $btn_params . '&action=new_faq') . '">' . $faqForm->button_css(OSF_TIP_NEW_FAQ, OSF_ICON_PREVIEW) . '</a>';

?>&nbsp;</td>
        </tr>
      </table>
    </td>
<?php









///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/// DEFAULT side column
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

	// build the side column
	$heading = '';
	$contents = array();
	switch ($action) {
		case 'delete_category':
			$heading = '<b>' . OSF_HEAD_INFO_DELETE_CATEGORY . '</b>';

			$contents[] = array('form' => $faqForm->form_open('categories', FILE_FAQ_ADMIN, 'action=delete_category_confirm&fcPath=' . $fcPath) . $faqForm->hidden_field('cat_id', $cInfo->id));
			$contents[] = array('text' => OSF_DELETE_CAT_INTRO . FaqFuncs::get_all_get_params_hidden(array('fcPath', 'cID', 'fID', 'action', 'cat_id')));
			$contents[] = array('text' => '<br /><b>' . $cInfo->category . '</b>');
			if ($cInfo->childs_count > 0) $contents[] = array('text' => '<br />' . sprintf(OSF_DELETE_WARNING_CHILDS, $cInfo->childs_count));
			if ($cInfo->faqs_count > 0) $contents[] = array('text' => '<br />' . sprintf(OSF_DELETE_WARNING_FAQS, $cInfo->faqs_count));
			$contents[] = array('align' => 'center', 'text' => $faqForm->submit_css(OSF_TIP_DELETE, OSF_ICON_DELETE) .
				' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id')) . 'fcPath=' . $fcPath . '&cID=' . $cInfo->id) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>');

	break;

		case 'move_category':
			$heading = '<b>' . OSF_HEAD_INFO_MOVE_CATEGORY . '</b>';

			$contents[] = array('form' => $faqForm->form_open('categories', FILE_FAQ_ADMIN, 'action=move_cat_confirm&fcPath=' . $fcPath) . $faqForm->hidden_field('cat_id', $cInfo->id));
			$contents[] = array('text' => sprintf(OSF_INTRO_MOVE_CATEGORIES, $cInfo->category) . FaqFuncs::get_all_get_params_hidden(array('fcPath', 'cID', 'fID', 'action', 'cat_id')));
			$contents[] = array('text' => '<br />' . sprintf(OSF_TEXT_MOVE, $cInfo->category) . '<br />' . $faqForm->pulldown_menu('move_to_cat_id', $faqAdmin->get_tree(0, '', $cInfo->id), $current_faq_cat_id));
			$contents[] = array('align' => 'center', 'text' => $faqForm->submit_css(OSF_TIP_MOVE, OSF_ICON_MOVE) .
				' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id')) . 'fcPath=' . $fcPath . '&cID=' . $cInfo->id) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>');

	break;

		case 'delete_faq':
			$heading = '<b>' . OSF_HEAD_INFO_DELETE_FAQ . '</b>';

			$contents[] = array('form' => $faqForm->form_open('faqs', FILE_FAQ_ADMIN, 'action=delete_faq_confirm&fcPath=' . $fcPath) . $faqForm->hidden_field('faq_id', $fInfo->id));
			$contents[] = array('text' => OSF_DELETE_FAQ_INTRO . FaqFuncs::get_all_get_params_hidden(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')));
			$contents[] = array('text' => '<br /><b>Q:</b><br />' . $fInfo->question);
			//$contents[] = array('text' => '<br /><br /><b>A:</b><br />' . $fInfo->answer);

			$faq_categories_string = '';
			$faq_cats_seperator = ' <i class="icon-circle-arrow-right"></i> ';
			$faq_cats_line_seperator = '<br />';

			$faq_categories = $faqAdmin->get_cat_path_array($fInfo->id, 'faqs');
			for ($i = 0, $n = sizeof($faq_categories); $i < $n; $i++) {
				$category_path = '';
				for ($j = 0, $k = sizeof($faq_categories[$i]); $j < $k; $j++) {
					$category_path .= $faq_categories[$i][$j]['text'] . $faq_cats_seperator;
				}
				$category_path = substr($category_path, 0, -strlen($faq_cats_seperator));
				$faq_categories_string .= $faqForm->checkbox_field('faq_categories[]', $faq_categories[$i][sizeof($faq_categories[$i]) - 1]['id'], true) . '&nbsp;' . $category_path . $faq_cats_line_seperator;
			}
			$faq_categories_string = substr($faq_categories_string, 0, -strlen($faq_cats_line_seperator));

			$contents[] = array('text' => '<br />' . $faq_categories_string);
			$contents[] = array('align' => 'center', 'text' => $faqForm->submit_css(OSF_TIP_DELETE, OSF_ICON_DELETE) .
				' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo->id) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>');

	break;

		case 'move_faq':
			$heading = '<b>' . OSF_HEAD_INFO_MOVE_FAQ . '</b>';

			$contents[] = array('form' => $faqForm->form_open('faqs', FILE_FAQ_ADMIN, 'action=move_faq_confirm&fcPath=' . $fcPath) . $faqForm->hidden_field('faq_id', $fInfo->id));
			$contents[] = array('text' => sprintf(OSF_MOVE_FAQS_INTRO, $fInfo->question) . FaqFuncs::get_all_get_params_hidden(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')));
			$contents[] = array('text' => '<br />' . OSF_INFO_CURRENT_CATEGORIES . '<br /><b>' . $faqAdmin->get_output_cat_path($fInfo->id, 'faqs') . '</b>');
			$contents[] = array('text' => '<br />' . sprintf(OSF_TEXT_MOVE, $fInfo->question) . '<br />' . $faqForm->pulldown_menu('move_to_cat_id', $faqAdmin->get_tree(0, ''), $current_faq_cat_id));
			$contents[] = array('align' => 'center', 'text' => $faqForm->submit_css(OSF_TIP_MOVE, OSF_ICON_MOVE) .
				' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo->id) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>');

	break;

		case 'copy_to':
			$heading = '<b>' . OSF_HEAD_INFO_COPY_TO . '</b>';

			$contents[] = array('form' => $faqForm->form_open('copy_to', FILE_FAQ_ADMIN, 'action=copy_to_confirm&fcPath=' . $fcPath) . $faqForm->hidden_field('faq_id', $fInfo->id));
			$contents[] = array('text' => OSF_INFO_COPY_TO_INTRO . FaqFuncs::get_all_get_params_hidden(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')));
			$contents[] = array('text' => '<br />' . OSF_INFO_CURRENT_CATEGORIES . '<br /><b>' . $faqAdmin->get_output_cat_path($fInfo->id, 'faqs') . '</b>');
			$contents[] = array('text' => '<br />' . OSF_CATEGORIES . '<br />' . $faqForm->pulldown_menu('cat_id', $faqAdmin->get_tree(0, ''), $current_faq_cat_id));
			$contents[] = array('text' => '<br />' . OSF_HOW_TO_COPY . '<br />' . $faqForm->radio_field('copy_as', 'link', true) . ' ' . OSF_COPY_AS_LINK . '<br />' . $faqForm->radio_field('copy_as', 'duplicate') . ' ' . OSF_COPY_AS_DUPLICATE);
			$contents[] = array('align' => 'center', 'text' => $faqForm->submit_css(OSF_TIP_COPY, OSF_ICON_COPY) .
				' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo->id) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>');

	break;
		default:
			if ($rows > 0) {
				if (isset($cInfo) && is_object($cInfo)) { // category info
					$heading = '<b>' . $cInfo->category . '</b>';

					$params = FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&cID=' . $cInfo->id;
					$contents[] = array('align' => 'center', 'text' =>
						'<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=edit_category') . '">' . $faqForm->button_css(OSF_TIP_EDIT, OSF_ICON_CHANGE) . '</a>' .
						' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=move_category') . '">' . $faqForm->button_css(OSF_TIP_MOVE, OSF_ICON_MOVE) . '</a>' .
						' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=delete_category') . '">' . $faqForm->button_css(OSF_TIP_DELETE, OSF_ICON_DELETE) . '</a>');

					$contents[] = array('text' => '<hr />' . OSF_CAT_PARENT . '<br /><b>' . FaqFuncs::get_cat_name($cInfo->parent_id) . '</b>');

					$contents[] = array('text' => '<hr />' . OSF_DATE_ADDED . ' ' . FaqFuncs::format_date($cInfo->date_added));
					if (FaqFuncs::not_null($cInfo->last_modified)) $contents[] = array('text' => OSF_LAST_MODIFIED . ' ' . FaqFuncs::format_date($cInfo->last_modified));

					$contents[] = array('text' => '<br />' . OSF_SUBCATEGORIES . ' ' . $cInfo->childs_count . '<br />' . OSF_FAQS . ' ' . $cInfo->faqs_count);


				} elseif (isset($fInfo) && is_object($fInfo)) { // faq info
					$heading = '<b>' . $fInfo->question . '</b>';

					$params = FaqFuncs::get_all_get_params(array('fcPath', 'cID', 'fID', 'action', 'cat_id', 'faq_id')) . 'fcPath=' . $fcPath . '&fID=' . $fInfo->id;
					$contents[] = array('align' => 'center', 'text' =>
						'<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=new_faq') . '">' . $faqForm->button_css(OSF_TIP_EDIT, OSF_ICON_CHANGE) . '</a>' .
						' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=move_faq') . '">' . $faqForm->button_css(OSF_TIP_MOVE, OSF_ICON_MOVE) . '</a>' .
						' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=copy_to') . '">' . $faqForm->button_css(OSF_TIP_COPY_TO, OSF_ICON_COPY) . '</a>');
					$contents[] = array('align' => 'center', 'text' =>
						'<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=delete_faq') . '">' . $faqForm->button_css(OSF_TIP_DELETE, OSF_ICON_DELETE) . '</a>');


					$contents[] = array('text' =>'<hr />' .  OSF_INFO_CURRENT_CATEGORIES . '<br /><small><b>' . $faqAdmin->get_output_cat_path($fInfo->id, 'faqs') . '</b></small>');

					$contents[] = array('text' => '<hr /><b>' . OSF_Q . ':</b><br />' . $fInfo->question);
					$contents[] = array('text' => '<br /><b>' . OSF_A . ':</b><br />' . substr(strip_tags($fInfo->answer), 0, 255) . '...');


					if(FaqFuncs::not_null($fInfo->name . $fInfo->email . $fInfo->phone)){
						$contents[] = array('text' =>'<hr />');

						if($fInfo->client_entry == '1')
							$contents[] = array('text' => '<i class="'.OSF_ICON_USER.' icon-large"></i> ' . OSF_TIP_CLIENT_ENTRY);

						if (FaqFuncs::not_null($fInfo->name)) $contents[] = array('text' => '<b>' . OSF_FAQ_AUTHOR . '</b><br />' . $fInfo->name);
						if (FaqFuncs::not_null($fInfo->email)) $contents[] = array('text' => '<b>' . OSF_FAQ_EMAIL . '</b><br /><a href="mailto:' . $fInfo->email . '?subject=RE: ' . $fInfo->question . '">' . $fInfo->email . '</a>');
						if (FaqFuncs::not_null($fInfo->phone)) $contents[] = array('text' => '<b>' . OSF_FAQ_PHONE . '</b><br />' . $fInfo->phone . '<br />');
					}


					if(FaqFuncs::not_null($fInfo->pdfupload)){
						$contents[] = array('text' =>'<hr />');
						$text = (FaqFuncs::not_null($fInfo->upload_text) ? $fInfo->upload_text : $fInfo->pdfupload);

						$contents[] = array('text' => '<b>' . OSF_DOCUMENT . '</b><br /><a href="' . DIR_WS_DOC . $fInfo->pdfupload . '" target="_blank">' . $text . '</a>');
					}


					$contents[] = array('text' => '<hr />' . OSF_DATE_ADDED . ' ' . FaqFuncs::format_date($fInfo->date_added));
					if (FaqFuncs::not_null($fInfo->last_modified)) $contents[] = array('text' => OSF_LAST_MODIFIED . ' ' . FaqFuncs::format_date($fInfo->last_modified));

				}
			} else { // create category/faq info
				$heading = '<b>' . OSF_EMPTY_CATEGORY . '</b>';

				$contents[] = array('text' => OSF_NO_CHILDS);
			}
	break;
	}


	// display the side column
	$faqTable = new FaqTable;
	if (!FaqFuncs::not_null($heading) && !FaqFuncs::not_null($contents)) {
		$heading = '<b>'.OSF_HEAD_NO_SELECTION.'</b>';
		$contents[] = array('text' => OSF_SELECT_A_ROW);
	}

	switch ($action) {
		case 'delete_category':
		case 'delete_faq':
			$osf_box_class = 'messageHandlerError';
			break;

		case 'move_category':
		case 'move_faq':
			$osf_box_class = 'messageHandlerWarning';
			break;

		case 'copy_to':
			$osf_box_class = 'messageHandlerPlain';
			break;

		default:
			$osf_box_class = 'faqinfo';
			break;
	}

	echo "\n" . '    <td width="25%" valign="top">' . "\n";

	echo '<div class="' . $osf_box_class . '">';
	echo $faqTable->detailTable($heading, $contents);
	echo '</div>';

	echo "\n" . '    </td>' . "\n";
?>
  </tr>
</table>
<?php
}
?>
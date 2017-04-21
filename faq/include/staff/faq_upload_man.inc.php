<?php
/* *************************************************************************
  Id: faq_upload_man.inc.php

  Short for "FAQ Upload Manager".
  Locates and can also remove images and document files uploaded to the faq systems
  public images and faq directories that do not appear to be used in any FAQ entries.
  The folders are scanned for files and compared to the content in the database.
  If a match is found, the file will be preserved, otherwise it will be listed as
  an unused image that can be deleted.

  Most functionality for this file is handled by this file.
  This page is accessed from faq_admin.php
  Only Admins can access this page.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

// this page is only for admins
if(!$osf_isAdmin){
  FaqFuncs::redirect(FaqFuncs::format_url(FILE_FAQ_ADMIN, '', 'SSL'));
}

?>
<h1><?php echo OSF_PAGE_FAQ_UPLOADS; ?></h1>
<?php
/// DEFAULT LANGUAGE FILE.
require_once(DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_upload_man.lang.php');

require_once(DIR_FAQ_INCLUDES . 'FaqUpCleaner.php');
$faqUps = new FaqUpCleaner;



if(isset($_GET['cleaner']) && $_GET['cleaner']=='true'){
?>

<table class="note" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2"><?php echo OSF_ACTIONS; ?></td>
	</tr>
</table>
<table class="ticketoptions" width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
		<td>
            <?php
            echo $faqForm->form_open('finished', FILE_FAQ_ADMIN, '', 'get');
            echo $faqForm->submit_css(OSF_FINISHED, 'icon-ok-sign');
            echo $faqForm->form_close();
            ?>
		</td>
		<td>
            <?php
            echo $faqForm->form_open('upload_checker', FILE_FAQ_ADMIN, '', 'get');
            echo $faqForm->hidden_field('uploads', 'true');
            echo $faqForm->submit_css(OSF_AGAIN, 'icon-repeat');
            echo $faqForm->form_close();
            ?>
		</td>
	</tr>
</table>

<br /><br />

<table class="ticketinfo" width="100%" cellpadding="5" cellspacing="0" border="0" style="border:1px solid #cccccc">
  <tr>
	<td valign="top">
	<h1><?php echo OSF_IMAGES; ?></h1>
<?php
  // list all valid images
  $validImages = $faqUps->findValidImages();
  print('<pre><b>'.OSF_IMG_VALID_UNALTERED.':</b>' . "\n");
  foreach($validImages as $vImg){
  	print($vImg . "\n");
  }
  print('</pre>');



  // list and remove all unused images
  $removeImages = $faqUps->findUnusedImages($validImages);
  print('<pre><b>'.OSF_IMG_DELETED.':</b>' . "\n");
  foreach($removeImages as $rImg){
  	print($rImg . "\n");

  	@unlink(DIR_FS_IMAGES . $rImg);
  }
  print('</pre>');
?>
	</td>

	<td valign="top">
	<h1><?php echo OSF_DOCS; ?></h1>
<?php
  // list all valid DOCUMENTS
  $validPdfs = $faqUps->findValidPdfs();
  print('<pre><b>'.OSF_DOC_VALID_UNALTERED.':</b>' . "\n");
  foreach($validPdfs as $vPdf){
  	print($vPdf . "\n");
  }
  print('</pre>');



  // list and remove all unused DOCUMENTS
  $removePdfs = $faqUps->findUnusedPdfs($validPdfs);
  print('<pre><b>'.OSF_DOC_DELETED.':</b>' . "\n");
  foreach($removePdfs as $rPdf){
  	print($rPdf . "\n");

  	@unlink(DIR_FS_DOC . $rPdf);
  }
  print('</pre>');
?>
	</td>
  </tr>
</table>
<?php





}else{





?>
<table class="note" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="2"><?php echo OSF_EXPLAIN; ?></td>
    </tr>
</table>
<table class="ticketoptions" width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
        <td>
            <?php
            echo $faqForm->form_open('upload_cleaner', FILE_FAQ_ADMIN, '', 'get');
            echo $faqForm->hidden_field('uploads', 'true');
            echo $faqForm->hidden_field('cleaner', 'true');
            echo $faqForm->submit_css(OSF_PERFORM, OSF_ICON_DELETE);
            echo $faqForm->form_close();
            ?>
        </td>
        <td>
            <?php
            echo $faqForm->form_open('cancel', FILE_FAQ_ADMIN, '', 'get');
            echo $faqForm->submit_css(OSF_CANCEL, OSF_ICON_CANCEL);
            echo $faqForm->form_close();
            ?>
        </td>
    </tr>
</table>

<br /><br />

<table class="ticketinfo" width="100%" cellpadding="5" cellspacing="0" border="0" style="border:1px solid #cccccc">
  <tr>
	<td valign="top">
	<h1><?php echo OSF_IMAGES; ?></h1>
<?php
  // list all valid images
  $validImages = $faqUps->findValidImages();
  print('<pre><b>'.OSF_IMG_VALID.':</b>' . "\n");
  foreach($validImages as $vImg){
  	print($vImg . "\n");
  }
  print('</pre>');



  // list all unused images
  $removeImages = $faqUps->findUnusedImages($validImages);
  print('<pre><b>'.OSF_IMG_TO_DEL.':</b>' . "\n");
  foreach($removeImages as $rImg){
  	print($rImg . "\n");
  }
  print('</pre>');
?>
	</td>

	<td valign="top">
	<h1><?php echo OSF_DOCS; ?></h1>
<?php
  // list all valid DOCUMENTS
  $validPdfs = $faqUps->findValidPdfs();
  print('<pre><b>'.OSF_DOC_VALID.':</b>' . "\n");
  foreach($validPdfs as $vPdf){
  	print($vPdf . "\n");
  }
  print('</pre>');



  // list all unused DOCUMENTS
  $removePdfs = $faqUps->findUnusedPdfs($validPdfs);
  print('<pre><b>'.OSF_DOC_TO_DEL.':</b>' . "\n");
  foreach($removePdfs as $rPdf){
  	print($rPdf . "\n");
  }
  print('</pre>');
?>
	</td>
  </tr>
</table>
<?php
}
?>
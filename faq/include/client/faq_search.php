<?php
/* *************************************************************************
  Id: faq_search.php

  Client side external FAQ search form.

  FAQ search form.
  This form can be used in external locations such as osTicket pages.

  TO USE:
  <?php require(ROOT_DIR.'faq/include/client/faq_search.php'); ?>


  Tim Gall
  Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */


/// CONFIG
require_once('./faq/include/OsFaqAdapter.class.php');
if(!$osfAdapter){
	$osfAdapter = new OsFaqAdapter(false);
}

require_once('./faq/include/main.faq.php'); // !important


/// only display if this feature is enabled in admin
if(OSFDB_DISABLE_CLIENT=='false'){

	/// DEFAULT LANGUAGE FILE.
	require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq.lang.php');


	require_once(DIR_FAQ_INCLUDES . 'FaqFuncs.php');
	require_once(DIR_FAQ_INCLUDES . 'FaqForm.php');

	if(!$faqForm)
		$faqForm = new FaqForm;


/// PAGE OUTPUT
?>

<div style="text-align:left;">
<?php
	/// Search form
	echo $faqForm->form_open('faq_search', FILE_FAQ, '', 'get');
	echo $faqForm->input_field('faqsearch', (isset($_GET['faqsearch']) ? trim($_GET['faqsearch']) : ''), 'style="width:98%;" placeholder="' . OSF_SEARCH_FIELD . '"') . '<br />';
	echo $faqForm->submit_css(OSF_SEARCH_BTN) . ' ' . $faqForm->checkbox_field('search_desc', '', true) . ' <small>' . OSF_SEARCH_ANSWER . '</small>';
	echo $faqForm->form_close();
?>
</div>
<?php
} //if(OSFDB_DISABLE_CLIENT=='false'){
?>
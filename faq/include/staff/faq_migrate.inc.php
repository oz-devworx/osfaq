<?php
/* *************************************************************************
 Id: faq_migrate.inc.php

 For migrating FAQ and Categories between various FAQ/KB management systems.


 Tim Gall
 Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
 http://osfaq.oz-devworx.com.au

 This file is part of osFaq.

 Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
 For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

 ************************************************************************* */

/// LANGUAGE FILE
require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_migrate.lang.php');



$action = ( isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '') );
switch ($action) {
	case 'migrate_from_ost':

		// value comes from checkbox
		if( isset($_POST['omit_duplicates']) ){
			$messageHandler->add( OSF_DUPS_IGNORED, FaqMessage::$success );
		}else{
			$messageHandler->add( OSF_DUPS_WARN, FaqMessage::$error );
		}

	break;

	case 'migrate_from_ost_confirm':

		$cats_imported = 0;
		$faqs_imported = 0;
		$faqs_ignored = 0;

		// values come from hidden_field
		$omit_duplicates = ( ( $_POST['omit_duplicates'] == true ) ? true : false );
		$add_to_can = ( ( $_POST['add_to_can'] == true ) ? true : false );//also add faqs to canned responses
		$qty_limit = db_input($_POST['qty_limit'], false);

		if($add_to_can){
			require_once (DIR_FAQ_INCLUDES . 'FaqAdmin.php');
			$faqAdmin = new FaqAdmin;
		}


		// get osTicket faqs for importing to osFAQ
		// /////////////////////////////////////////////
		$osTicket_faq_sql =
"select

ostf.faq_id,
ostf.category_id as cat_id,
ostf.ispublished as faq_status,
ostf.question,
ostf.answer,
ostf.created as faq_created,
ostf.updated as faq_updated,

ostc.ispublic as cat_status,
ostc.name as cat_name,
ostc.created as cat_created,
ostc.updated as cat_updated

from " . TABLE_PREFIX . "faq ostf left join " . TABLE_PREFIX . "faq_category ostc using(category_id)";


		$osTicket_query = db_query($osTicket_faq_sql);
		while ( $osTicket_data = db_fetch_array($osTicket_query) ){

			//duplicate faq handler
			if($omit_duplicates){
				//XXX: Only check question text for now, since inline images in the answer are modified during the import to avoid breakages.
				$dup_faq_check = db_query("select id from " . TABLE_FAQS . " where question = '" . db_input($osTicket_data['question'], false) . "'");
				if( db_num_rows($dup_faq_check) > 0 ){

					//notify admin of duplicate and skip this entry
					$messageHandler->add( sprintf( OSF_MIGRATE_FAQ_EXISTS, '<a href="faq.php?id=' . $osTicket_data['faq_id'] . '" target="_blank">' . $osTicket_data['faq_id'] . '</a>' ), FaqMessage::$plain );

					$faqs_ignored++;

					continue;
				}
			}


			//dont insert duplicate root level cats.
			$new_cat_id = 0;// default to root category

			$dup_cat_check = db_query("select id from " . TABLE_FAQCATS . " where category = '" . db_input($osTicket_data['cat_name'], false) . "' and parent_id = '0'");
			if( db_num_rows($dup_cat_check) > 0 ){
				// if category is found in root, then use that ID; otherwise use root
				$dup_cat_data = db_fetch_array($dup_cat_check);
				$new_cat_id = $dup_cat_data['id'];

			}else{
				// insert new CAT
				$new_cat_array = array(
						'category' => $osTicket_data['cat_name'],

						//expand var to "status + featured"
						'category_status' => ( ($osTicket_data['cat_status'] > 0) ? '1' : '0' ),
						'featured' => ( ($osTicket_data['cat_status'] == 2) ? '1' : '0' ),

						'date_added' => $osTicket_data['cat_created'],
						'last_modified' => $osTicket_data['cat_updated']
				);
				$sqle->db_compile(TABLE_FAQCATS, $new_cat_array, FaqSQLExt::$INSERT);
				$new_cat_id = db_insert_id();

				$cats_imported++;
			}


			// insert FAQ
			$new_faq_array = array(
					'question' => $osTicket_data['question'],
					'answer' => $osTicket_data['answer'],

					//expand var to "status + featured"
					'faq_active' => ( ($osTicket_data['faq_status'] > 0) ? '1' : '0' ),
					'featured' => ( ($osTicket_data['faq_status'] == 2) ? '1' : '0' ),

					'date_added' => $osTicket_data['faq_created'],
					'last_modified' => $osTicket_data['faq_updated']
			);


			$sqle->db_compile(TABLE_FAQS, $new_faq_array, FaqSQLExt::$INSERT);
			$new_faq_id = db_insert_id();
			$faqs_imported++;


			// insert FAQ to CAT relation
			$new_faq2cat_array = array(
					'faqcategory_id' => $new_cat_id,
					'faq_id' => $new_faq_id
			);
			$sqle->db_compile(TABLE_FAQS2FAQCATS, $new_faq2cat_array, FaqSQLExt::$INSERT);

			//also set as canned response
			if($add_to_can){
				$faqAdmin->set_canned($new_faq_id, 1);
			}

			//check import limit
			if( $qty_limit != 'none' ){
				if( $faqs_imported >= $qty_limit ){
					break;
				}
			}
		}


		// notify admin
		$messageHandler->add( sprintf( OSF_MIGRATE_CATS_IMPORTED, $cats_imported ), FaqMessage::$success );
		$messageHandler->add( sprintf( OSF_MIGRATE_FAQS_IMPORTED, $faqs_imported ), FaqMessage::$success );
		$messageHandler->add( sprintf( OSF_MIGRATE_FAQS_IGNORED, $faqs_ignored ), FaqMessage::$plain );

		break;
	case 'migrate_to_ost_confirm':

		$messageHandler->add( OSF_OSF2OST . '<br>' . OSF_MIGRATE_NOT_IMPLEMENTED_YET, FaqMessage::$error );

		break;
	default:
		break;
}


// output system messages first
if ($messageHandler->size() > 0) echo $messageHandler->output() . '<br />';


$params = FaqFuncs::get_all_get_params(array('action'));


//////////////////////////
// Import from osTicket //
//////////////////////////
if ($action == 'migrate_from_ost') {
?>
<h1><?php echo OSF_OST2OSF_HEADING; ?></h1>
<p><?php echo OSF_OST2OSF_DESCRIPTION; ?></p>


<?php echo $faqForm->form_open('faq_migrate', FILE_FAQ_ADMIN, 'migrate=true&action=migrate_from_ost_confirm'); ?>

<?php echo $faqForm->hidden_field('omit_duplicates', ( isset($_POST['omit_duplicates']) ? true : false ) ); ?>
<?php echo $faqForm->hidden_field('add_to_can', ( isset($_POST['add_to_can']) ? true : false ) ); ?>
<?php echo $faqForm->hidden_field('qty_limit', $_POST['qty_limit'] ); ?>


<?php echo $faqForm->submit_css(OSF_IMPORT_NOW, OSF_ICON_COPY); ?> <a href="<?php echo FaqFuncs::format_url(FILE_FAQ_ADMIN, $params); ?>"><?php echo $faqForm->button_css('Cancel', OSF_ICON_CANCEL); ?></a>

<?php echo $faqForm->form_close(); ?>

<?php



///////////////////////
// Export from osFAQ //
///////////////////////
//TODO: write this part in a future release
}else if ($action == 'migrate_to_ost') {
?>
<h1><?php echo OSF_OSF2OST_HEADING; ?></h1>
<p><?php echo OSF_OSF2OST_DESCRIPTION; ?></p>
<a href="<?php echo FaqFuncs::format_url(FILE_FAQ_ADMIN, $params . '&action=migrate_to_ost_confirm'); ?>"><?php echo $faqForm->button_css(OSF_IMPORT_NOW, OSF_ICON_COPY); ?></a>
<?php



////////////////////////////////
// DEFAULT migrate start page //
////////////////////////////////
}else{

	$import_type = array();
	$import_type[] = array('id' => 'migrate_from_ost', 'text' => OSF_OST2OSF);
// 	$import_type[] = array('id' => 'migrate_to_ost', 'text' => OSF_OSF2OST);

	$q_limits = array();
	$q_limits[] = array('id' => '10', 'text' => '10');
	$q_limits[] = array('id' => '50', 'text' => '50');
	$q_limits[] = array('id' => '100', 'text' => '100');
	$q_limits[] = array('id' => '250', 'text' => '250');
	$q_limits[] = array('id' => '500', 'text' => '500');
	$q_limits[] = array('id' => '1500', 'text' => '1,500');
	$q_limits[] = array('id' => '5000', 'text' => '5,000');
	$q_limits[] = array('id' => '10000', 'text' => '10,000');
	$q_limits[] = array('id' => 'none', 'text' => 'No Limit');

	$qty_limit = ( isset($_POST['qty_limit']) ? $_POST['qty_limit'] : 'none' );

?>
<h1><?php echo OSF_MIGRATE_HEADING; ?></h1>
<p><?php echo OSF_MIGRATE_DESCRIPTION; ?></p>


<?php echo $faqForm->form_open('faq_migrate', FILE_FAQ_ADMIN, 'migrate=true'); ?>

<hr>
<h2><?php echo OSF_OPTIONS; ?></h2>

<?php echo $faqForm->pulldown_menu('action', $import_type); ?>
<br><br>

<label for="omit_duplicates"><?php echo $faqForm->checkbox_field('omit_duplicates', '1', true) . ' ' . OSF_OMIT_DUPS; ?></label><br>
<label for="add_to_can"><?php echo $faqForm->checkbox_field('add_to_can', '1', false) . ' ' . OSF_CAN_FAQS; ?></label><br>
<label for="qty_limit"><?php echo OSF_LIMIT_TO . ' ' . $faqForm->pulldown_menu('qty_limit', $q_limits, $qty_limit); ?></label><br>
<br>

<?php echo $faqForm->submit_css(OSF_COPY_FAQ, OSF_ICON_COPY); ?>
<?php echo $faqForm->form_close(); ?>

<?php
}
?>
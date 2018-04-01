<?php
/* *************************************************************************
 Id: OsFaqAdapter.class.php

Provides adapter functions for plugin compatibility with various sites.
This adapter is for pluging into osTicket. Tested with osTicket 1.6 through to 1.10


Tim Gall
Copyright (c) 2009-2017 osfaq.oz-devworx.com.au - All Rights Reserved.
http://osfaq.oz-devworx.com.au

This file is part of osFaq.

Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

/**
 * Adapter functions for plugging osFaq into various web engines.<br />
 * Compatible with <b>osTicket 1.6 and 1.7</b>
 */
class OsFaqAdapter{

	/**
	 *
	 * @param boolean $accelerate - pass in false to bypass gzip page compression
	 */
	public function __construct($accelerate = true){
		if($accelerate)
			require ('accelerator.faq.php'); // page accelerator. MUST BE FIRST
	}


	/**
	 * Init any parent admin related files or init tasks.
	 */
	function init_admin(){
		global $nav, $thisstaff, $errors, $msg,
			$tabs, $submenu, $exempt,
			$ost, $sysnotice, $_SESSION, $cfg,
			$StopIteration,// for ost1.10
			$thisuser;// for ost1.6

		require_once ('staff.inc.php'); //osTicket file
	}

	/**
	 * Init any parent client related files or init tasks.
	 */
	function init_client(){
		global $nav, $thisclient, $errors, $msg, $ost, $cfg,
		$StopIteration;// for ost1.10

		require_once ('client.inc.php'); //osTicket file
	}


	/**
	 * Get the users admin status.
	 *
	 * @return boolean - true if user is an admin
	 */
	function is_admin(){
		global $thisstaff, $thisuser;

		$osf_isAdmin = true;

		// localise calls to parent vars for reduced maintenance & increased flexibility
		if($thisstaff && is_callable(array($thisstaff, 'isAdmin'))){
			$osf_isAdmin = $thisstaff->isAdmin();
		}elseif($thisuser && is_callable(array($thisuser, 'isAdmin'))){
			// allow for osTicket < 1.7-RC5
			$osf_isAdmin = $thisuser->isAdmin();
		}

		return $osf_isAdmin;
	}

	/**
	 * Get the users logged-in status.
	 *
	 * @return boolean - true if user is logged in
	 */
	function is_client(){
		global $thisclient;

		// localise calls to parent vars for reduced maintenance & increased flexibility
		if($thisclient && is_callable(array($thisclient, 'getId'))){
			return ($thisclient->getId() && $thisclient->isValid());
		}

		return false;
	}

	/**
	 * Form token verification code.
	 * Used in forms.
	 *
	 * @return string - form verification code (if any)
	 */
	function form_check_code(){

		$form_code = '';

		// support for osTicket >= 1.7-RC5
		if(function_exists('csrf_token')){
			ob_start();
			csrf_token();//osticket function
			$form_code = ob_get_clean();
		}

		return $form_code;
	}

	/**
	 * Output header file for admin.
	 */
	function get_admin_page_header(){
		global $ost, $thisstaff, $thisuser,
			$tabs, $nav, $ost, $errors, $msg, $warn,
			$cfg;

		require(STAFFINC_DIR.'header.inc.php');
	}

	/**
	 * Output footer file for admin
	 */
	function get_admin_page_footer(){

		ob_start();

		require(STAFFINC_DIR.'footer.inc.php');

		$footer_html = ob_get_clean();

		// pjax needs to be disabled after the pjax script import to override it effectively.
		echo str_replace('</body>', $this->disable_pjax() . "\n" . '</body>', $footer_html);
	}

	/**
	 * Various methods to disable pjax.
	 * Derived from: http://stackoverflow.com/questions/16992506/pjax-how-do-i-turn-off-the-modified-behaviour
	 */
	function disable_pjax($override = false){
		$output = '<script type="text/javascript">';


		if($override){
			$output .= '
var pageLoadCounter = 0;
var MAX_PAGE_LOADS = 20;

$(".pjaxContainer").on("pjax:beforeSend", function (e, xhr, settings) {
	if (++pageLoadCounter > MAX_PAGE_LOADS) {
		// URI can be found at https://github.com/medialize/URI.js
		var uri = URI(settings.url);

		// Remove _pjax from query string before reloading
		uri.removeSearch("_pjax");

		location.href = uri.toString();
		return false;
	}
});
';
		}


		$output .= '
// $.pjax.disable();
// $(document).pjax();
$.pjax.handleClick = function (event, container, options) { return; };
// $.pjax.state.timeout = 0;
delete $.pjax;
// $.pjax.defaults.timeout=0;
';


		$output .= '</script>';

		return $output;
	}

	/**
	 * Output header file for client side
	 */
	function get_client_page_header(){
		global $nav, $cfg, $ost;

		if($nav && is_callable(array($nav, 'setActiveNav'))){
			$nav->setActiveNav('osfaq');
		}

		$extra_setup = $this->build_client_xtra_headers();

		require(CLIENTINC_DIR.'header.inc.php');

		echo $extra_setup;
	}

	/**
	 * Output footer file for client side
	 */
	function get_client_page_footer(){
		require(CLIENTINC_DIR.'footer.inc.php');
	}



	/**
	 * Setup admin navigation as necessary and activate.
	 */
	function build_admin_navigation(){
		global $osf_isAdmin, $nav;

		$nav->setTabActive('osfaq');

		if (OSFDB_STAFF_AS_ADMIN=='true' || $osf_isAdmin) {
			$admin_active = false;

			/// PAGE OUTPUT
			if (isset($_GET['uploads']) && $_GET['uploads'] == 'true') {
				$inc = FILE_FAQ_UNUSED_INC;
			} elseif (isset($_GET['settings']) && $_GET['settings'] == 'true') {
				$inc = FILE_FAQ_SETTINGS;
			} elseif (isset($_GET['map']) && $_GET['map'] == 'true') {
				$inc = FILE_FAQ_MAPPER;
			} elseif (isset($_GET['mapbuilder']) && $_GET['mapbuilder'] == 'true') {
				$inc = FILE_FAQ_MAP_BUILDER;
			} elseif (isset($_GET['versioncheck']) && $_GET['versioncheck'] == 'true') {
				$inc = FILE_FAQ_VERSION_CHECK;
			} elseif (isset($_GET['migrate']) && $_GET['migrate'] == 'true') {
				$inc = FILE_FAQ_MIGRATE;
			} else {
				$inc = FILE_FAQ_ADMIN_INC;
				$admin_active = true;
			}

			$nav->addSubMenu(array('desc' => OSF_PAGE_FAQ, 'href' => FILE_FAQ_ADMIN, 'iconclass' => 'osf_faq'), $admin_active);
			$nav->addSubMenu(array('desc' => OSF_PAGE_FAQ_SITEMAP, 'href' => FILE_FAQ_ADMIN . '?map=true', 'iconclass' => 'osf_sitemap'), isset($_GET['map']));

			if($osf_isAdmin){
				$nav->addSubMenu(array('desc' => OSF_PAGE_FAQ_SETTINGS, 'href' => FILE_FAQ_ADMIN . '?settings=true', 'iconclass' => 'osf_settings'), isset($_GET['settings']));
				$nav->addSubMenu(array('desc' => OSF_PAGE_FAQ_MIGRATE, 'href' => FILE_FAQ_ADMIN . '?migrate=true', 'iconclass' => 'osf_settings'), isset($_GET['migrate']));
				$nav->addSubMenu(array('desc' => OSF_PAGE_FAQ_UPLOADS, 'href' => FILE_FAQ_ADMIN . '?uploads=true', 'iconclass' => 'osf_cleaner'), isset($_GET['uploads']));
			}

			$nav->addSubMenu(array('desc' => OSF_PAGE_FAQ_VCHECK, 'href' => FILE_FAQ_ADMIN . '?versioncheck=true', 'iconclass' => 'osf_check'), isset($_GET['versioncheck']));

		}else{
			$inc = FILE_FAQ_NOT_AUTHORISED;
			$nav->addSubMenu(array('desc' => OSF_BACK_TO_OST, 'href' => 'index.php', 'iconclass' => 'Ticket'), true);
		}

		return $inc;
	}


	/**
	 * Setup admin headers if necessary (stylesheets, javascript, etc).
	 */
	function build_admin_xtra_headers(){
		global $ost, $osf_langDirection;

		// allow fallback for osTicket < 1.7-RC5
		if(class_exists('osTicket') && $ost && is_callable(array($ost, 'addExtraHeader'))){
			// add the stylesheet to header.inc.php
			$ost->addExtraHeader('<!-- // osFaq integration -->');
			$ost->addExtraHeader('<link rel="stylesheet" href="../faq/styles/faq_admin.css" type="text/css" />');

			$ost->addExtraHeader(trim($osf_langDirection));
			$osf_external_info = '';
		}else{

			/// These files must be downloaded seperately from osFaq as a patch for osTicket1.6 integration.
			$osf_external_info = '<link rel="stylesheet" href="../faq/OSTICKET-1.7/css/scp.css" media="screen">' . PHP_EOL;
			$osf_external_info .= '<link rel="stylesheet" href="../faq/OSTICKET-1.7/css/font-awesome.min.css" type="text/css">' . PHP_EOL;

			///These files are standard osFaq files.
			$osf_external_info .= '<link rel="stylesheet" href="../faq/styles/faq_admin.css" type="text/css" />' . PHP_EOL;
			$osf_external_info .= $osf_langDirection;
			$osf_external_info .= '<script type="text/javascript" src="'.DIR_FAQ_INCLUDES.'js/jquery-1.4.2.min.js"></script>' . PHP_EOL;
		}

		return $osf_external_info;
	}

	/**
	 * Setup client headers if necessary (stylesheets, javascript, etc).
	 */
	function build_client_xtra_headers(){
		global $ost, $osf_langDirection;

		// allow fallback for osTicket < 1.7-RC5
		if(class_exists('osTicket') && $ost && is_callable(array($ost, 'addExtraHeader'))){
			// add the stylesheet to header.inc.php (only works on FAQ pages though. Better to include styles in header.inc.php staticly ATM)
// 			$ost->addExtraHeader('<!-- // osFaq integration -->');
// 			$ost->addExtraHeader('<link rel="stylesheet" href="./faq/styles/faq.css" media="screen">');

			$ost->addExtraHeader(trim($osf_langDirection));
			$osf_external_info = '';
		}else{
			///These files are standard osFaq files.
// 			$osf_external_info = '<link rel="stylesheet" href="./faq/styles/faq.css" media="screen">' . PHP_EOL;
			$osf_external_info .= $osf_langDirection;
		}

		return $osf_external_info;
	}

	/**
	 * Format html containing inline images stored in other fashions than the current osFAQ default (such as databases, etc).
	 * @param string $htmlText
	 * @return string
	 */
	function fetch_inline_images($htmlText){
		return Format::viewableImages($htmlText);
	}


	/**
	 * Format html containing inline images stored in other fashions than the current osFAQ default (such as databases, etc).
	 * @param string $htmlText
	 * @return string
	 */
	function store_inline_images($htmlText){
		return Format::localizeInlineImages($htmlText);
	}


	/**
	 * This provides a means to more closely integrate with osTicket and others, without engine specific coding in the main class files.
	 *
	 * @param int $fID - FAQ id
	 * @param int $status - 1 == on, 0 == off
	 *
	 */
	function set_canned_response($fID, $status){
		global $cfg, $sqle;

		//check the faq exists
		$osFaq_sql = "select question from " . TABLE_FAQS . " where id = '" . db_input($fID, false) . "'";
		$osFaq_query = db_query($osFaq_sql);

		if(db_num_rows($osFaq_query) == 0){
			return;
		}


		//common data-check used in inserts and deletes
		$osFaq_data = db_fetch_array($osFaq_query);

		$osTicket_sql = "select canned_id from " . TABLE_PREFIX . "canned_response where title = '" . db_input( $osFaq_data['question'], false ) . "'";
		$osTicket_query = db_query($osTicket_sql);



		if($status == 1){

			if(db_num_rows($osTicket_query) > 0){
				//entry already exists in osTicket
				return;
			}

			// get osTicket language key
			$lang = ( $cfg ? $cfg->getPrimaryLanguage() : 'en_US' );


			$osFaq_data_sql = "select question as title, answer as response from " . TABLE_FAQS . " where id = '" . db_input((int)$fID, false) . "'";

			$osFaq_data_query = db_query($osFaq_data_sql);
			$osFaq_data = db_fetch_array($osFaq_data_query);

			$osFaq_data['lang'] = $lang;
			$osFaq_data['created'] = 'now()';
			$osFaq_data['updated'] = 'now()';
			$osFaq_data['notes'] = "Generated by osFAQ";

			//insert canned response
			$sqle->db_compile(TABLE_PREFIX . "canned_response", $osFaq_data, FaqSQLExt::$INSERT);


		}elseif($status == 0){

			//remove canned response
			if(db_num_rows($osTicket_query) > 0){
				$osTicket_data = db_fetch_array($osTicket_query);

				db_query("delete from " . TABLE_PREFIX . "canned_response where canned_id = '" . db_input( $osTicket_data['canned_id'], false ) . "'");
			}
		}

	}
}
?>
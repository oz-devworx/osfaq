<?php
/* *************************************************************************
  Id: staff.lang.php

  Translation file for staff.inc.php.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_STAFF_TITLE', 'Staff integration');

define('OSFI_ADMIN_DELETE', 'Please delete: %s');

define('OSFI_STAFF_COMPLETE', '<p>Your <b>staff</b> area appears to contain the required files and integration code.</p>
	<p>You can safely continue to the next step.</p>');

define('OSFI_STAFF_INTRO', '<p>You need to integrate some code into your <b>staff</b> area so you can administer your FAQ system.</p>
	<p>The messages below indicate the state of each check I performed.</p>');

define('OSFI_STAFF_ONCE_INTEGRATED', 'Once integrated, the <code>%s</code> function should be something like the example below (copied from osTicket v1.10)');

define('OSFI_FAQ_ADMIN_OK', 'The admin file %s is present');
define('OSFI_FAQ_ADMIN_MISSING', 'Please make sure the admin file is uploaded to your osTicket directory like so: %s');

//define('OSFI_FAQ_STYLES_OK', 'The admin stylesheet is being imported correctly.<br />Edit: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq_admin.css</u>' . '</code><br />if you want to change the appearance of the staff faq pages.');
//define('OSFI_FAQ_STYLES_MISSING', 'The admin stylesheet does not appear to have been imported in the staff header file.<br />Please edit: <code>' . DIR_FS_BASE . 'include/staff/header.inc.php' . '</code><br />and paste the following text between the <code>&lt;head&gt;</code> and <code>&lt;/head&gt;</code> tags, preferably below the other stylesheet imports:');

define('OSFI_NAV_MOD_OK', '<code>class.nav.php</code> appears to have the correct integration code.');
define('OSFI_NAV_MOD_MISSING', '<code>class.nav.php</code> does not have the correct integration code.<br />Please edit <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br />and paste the following below the "Knowledgebase" tab in the function <code>getTabs()</code> (near line 130):');

define('OSFI_NAV_MOD2_MISSING', '<code>class.nav.php</code> does not have the correct integration code.<br />Please edit <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br />and paste the following directly above "$this->navs=$navs;" in the function <code>getNavLinks()</code> (near the bottom of the file. Directly above <code>$this->navs=$navs;</code>):');

?>
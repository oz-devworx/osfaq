<?php
/* *************************************************************************
  Id: staff_old.lang.php

  Translation file for staff.inc.php.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_STAFF_ONCE_INTEGRATED_OLD', 'Once integrated, the <code>StaffNav</code> function should be something like the example below (copied from osTicket v1.6 RC5)');

define('OSFI_FAQ_STYLES_OK_OLD', 'The admin stylesheet is being imported correctly.<br />Edit: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq_admin.css</u>' . '</code><br />if you want to change the appearance of the staff faq pages.');
define('OSFI_FAQ_STYLES_MISSING_OLD', 'The admin stylesheet does not appear to have been imported in the staff header file.<br />Please edit: <code>' . DIR_FS_BASE . 'include/staff/header.inc.php' . '</code><br />and paste the following text between the <code>&lt;head&gt;</code> and <code>&lt;/head&gt;</code> tags, preferably below the other stylesheet imports:');

define('OSFI_NAV_MOD_OK_OLD', '<code>class.nav.php</code> appears to have the correct integration code.');
define('OSFI_NAV_MOD_MISSING_OLD', '<code>class.nav.php</code> does not have the correct integration code.<br />Please edit <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br />and paste the following below the "My Account" tab in the function <code>StaffNav</code> (after line 42):');
?>
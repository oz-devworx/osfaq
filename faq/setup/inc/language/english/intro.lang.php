<?php
/* *************************************************************************
  Id: intro.lang.php

  Translation file for intro.inc.php


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INTRO_INTRO', 'Introduction');
define('OSFI_INTRO_LOGO', 'osFaq Logo');

define('OSFI_INTRO_WELCOME', '<p>Welcome to the installer for osFaq v%s.<br />This is a <span title="Frequently Asked Questions"><u>FAQ</u></span> plugin module for <a href="http://osticket.com/" target="_blank">osTicket v1.7 RC5 - v1.7 STABLE</a>.</p>
<p>osFaq is Open Source software released under the GPLv3.<br />
osFaq is written and maintained by <a href="http://oz-devworx.users.sourceforge.net/" target="_blank">oz-devworx</a>.<br />
English translation by Tim Gall.<br />
This installation wizard will guide you through getting osFaq up and running in your osTicket system.<br />
You can find more information about osFaq at the support website: <a href="http://www.osfaq.oz-devworx.com.au/" target="_blank">http://www.osfaq.oz-devworx.com.au/</a></p>');

define('OSFI_INTRO_PARAM', 'Parameter');
define('OSFI_INTRO_VAL', 'Value');
define('OSFI_INTRO_INST_TYPE', 'Install Type');
define('OSFI_INTRO_ADVICE_1', '<b>BEFORE UPGRADING:</b> You should consider backing up your database. The database name is <i>%s</i>');

define('OSFI_INTRO_OLD_INSTALLER', '<p>Your existing osFaq version is newer than this version.</p>
<p><b>If you wish to downgrade:</b></p>
<ol>
	<li>Backup your existing FAQs, Categories and FAQs-to-Categories database tables. The database name is "<i>%s</i>"</li>
	<li>DROP all osFaq tables from your database. osFaq table names begin with "<i>%s</i>"</li>
	<li>Run this installer again from the beginning <a href="index.php">RESTART THE INSTALLER</a>.</li>
	<li>Re-insert your FAQ data into the downgraded database.</li>
</ol>');

define('OSFI_INTRO_V_DETECTED', '%s detected.');
define('OSFI_INTRO_UPG_TO', 'Upgrade osFaq from v%s to v%s');

define('OSFI_INTRO_ALREADY_INSTALLED', '<h3>osFaq v%s already installed.</h3>
<p>It appears you already have this version installed. You can choose to reinstall the application but be warned that you will loose the FAQs in your existing osFaq installation unless you do a database backup first.<br />
The database name is "<i>%s</i>"</p>');

define('OSFI_INTRO_INSTALL_V', 'Install v%s');

define('OSFI_INSTALLER_FOR', 'Installer for');
define('OSFI_VERSION', 'osFaq version %s');
define('OSFI_OST_INSTALLER_FOR', 'Integration target');
define('OSFI_OST_VERSION', 'osTicket version %s');
define('OSFI_DATABASE', 'Database');
define('OSFI_DB_PREFIX', 'Database Table Prefix');
define('OSFI_DB_PERMISSIONS', 'Database Permissions');
define('OSFI_DOMAIN', 'Server Domain');
define('OSFI_DOC_ROOT', 'Absolute DOCUMENT_ROOT file path');
define('OSFI_WEB_ROOT', 'Absolute Public WEB_ROOT file path');
define('OSFI_EDIT_DOC_ROOT', 'edit DOCUMENT_ROOT');
define('OSFI_EDIT_WEB_ROOT', 'edit WEB_ROOT');
define('OSFI_ROOT_PATH_NF', 'ROOT FILE PATH NOT FOUND');
define('OSFI_INTRO_LANG', 'Language');
define('OSFI_INTRO_LANG_RESET', 'Change');

define('OSFI_OK', 'Ok');
define('OSFI_ERROR', 'Error');
define('OSFI_WARNING', 'Warning');

define('OSFI_MISSING_PERMS', 'Missing permissions');
define('OSFI_OST_SUPPORTED', 'Supported version');
define('OSFI_OST_NOT_SUPPORTED', 'Unsupported version. Might work but integration steps may vary from this install guide.');
?>
<?php
/* *************************************************************************
  Id: schema.lang.php

  Translation file for schema.inc.php and schema_up.inc.php.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INS_TITLE', 'Database integration');
define('OSFI_INS_TABLES', 'Installing database tables');
define('OSFI_INS_COMPLETE_STEP', 'Complete Step 1');
define('OSFI_INS_READY_TITLE', 'Ready to install database tables');

define('OSFI_INS_READY_TEXT', '<p>Click the button below to integrate the FAQ tables into your osTicket database.<br />Your current osTicket table prefix will be used when creating the new tables.</p>
	<p>Click the button below to continue.</p>');


define('OSFI_UPG_TITLE', 'Database upgrade');
define('OSFI_UPG_TABLES', 'Upgrading database tables');

define('OSFI_UPG_READY_TITLE', 'Ready to upgrade your osFaq database tables');

define('OSFI_UPG_READY_TEXT', '<p>Click a button below to upgrade the osFAQ tables in your osTicket database to the latest version.<br />Your current osTicket table prefix will be used when dealing with osFaq tables.</p>
	<p>Choose your option below to continue.</p>');

define('OSFI_UPG_FROM_TO', 'Upgrade from %s to %s');

define('ERROR_QUERY', FAQ_FATAL . 'Errors encountered while processing the database schema file.');
define('ERROR_BAD_FORMAT', FAQ_FATAL . 'The schema file does not appear to be properly formatted.');
define('ERROR_EMPTY_SCHEMA', FAQ_FATAL . 'The schema file is empty or improperly formatted.');
define('OK_SCHEMA_SUCCESS', FAQ_GOOD . 'The FAQ system tables have been inserted.');
?>
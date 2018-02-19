<?php
/* *************************************************************************
  Id: common.lang.php

  Translation file for common elements shared across pages.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('FAQ_TITLE', 'FAQs for osTicket');

define('OSFI_HEAD_INDEX', 'osFaq installation wizard');
define('OSFI_HEAD_INSTALL', 'osFaq install wizard%s');
define('OSFI_HEAD_UPDATE', 'osFaq upgrade wizard%s');

define('OSFI_MANUAL_PATHS', 'Manual Path Setup');
define('OSFI_REFRESH', 'Refresh.');
define('OSFI_CONTINUE', 'Next...');
define('OSFI_IMAGE', 'IMAGE');
define('OSFI_STEP', 'Step %s');
define('OSFI_IGNORE_AND_PROCEED', 'Ignore any incomplete steps and proceed.');
define('OSFI_SKIP_FOR_NOW', 'Skip this step for now.');
define('OSFI_CHECK_AGAIN', 'Check again');
define('OSFI_FAQS', 'FAQs');

define('OSFI_ERROR_ENCOUTERED', '<h3>oops... I encountered one or more problems and cannot continue just now</h3>
  <p>Please correct the problems listed below, then click the button to try again.</p>
  <p>%s</p>
  <p>If you need to move this folder to correct the problem, please be sure to type the new location in your web browser to resart the installer.</p>');

define('OSFI_RESTART_INSTALL', 'Restart the Installation');
define('OSFI_COPYRIGHT', 'Copyright &copy; %s osfaq.oz-devworx.com.au. All Rights Reserved. <a href="http://osfaq.oz-devworx.com.au/" target="_blank">osFaq</a> is not affilliated with <a href="http://osticket.com/" target="_blank">osTicket</a>.');


define('FAQ_GOOD', '<b style="color:green;">OK</b>: ');
define('FAQ_BAD', '<b style="color:red;">MISSING</b>: ');
define('FAQ_FATAL', '<b style="color:red;">FATAL ERROR</b>: ');

define('ERROR_FILES_MISSING', FAQ_FATAL . 'Please check you uploaded all of the osFaq files. Some seem to be missing.');
define('ERROR_CANT_GET_PATH', FAQ_FATAL . 'I was unable to work out your file paths (%s). If your osTicket installation works, you will need to edit some files manually to configure osFaq to function correctly.<br />Please report this error to the developers.');
define('ERROR_OST_SETTINGS', FAQ_FATAL . 'Failed to load the osTicket settings file. Please make sure you have installed <a href="http://osticket.com/" target="_blank">osTicket >= v1.7</a>.');
define('ERROR_OSF_SETTINGS', FAQ_FATAL . 'Failed to load the osFaq settings file. Please make sure you uploaded the osFaq files to the correct locations.');
define('ERROR_CONNECTION', FAQ_FATAL . 'Contact system adminstrator.<br>Unable to connect to the database');
define('ERROR_BROKEN', FAQ_FATAL . 'The package you are trying to install seems to be broken or is not being installed to osTicket >= 1.7');
?>
<?php
/* *************************************************************************
  Id: static_path.lang.php

  Translation file for static_path.inc.php


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_ERROR_CONFIG_WRITE', '<span style="color:red;">The config file is not writable.</span> Please make sure the file: <b>/faq/include/config.faq.php</b> is writable.<br />');
define('OSFI_ERROR_CONFIG_READ', '<span style="color:red;">The config file could not be opened for reading.</span> Please make sure the file: <b>/faq/include/config.faq.php</b> is readable and writable.<br />');
define('OSFI_ERROR_CONFIG_SAVE', '<span style="color:red;">The config file could not be saved.</span> Please make sure the file: <b>/faq/include/config.faq.php</b> is writable.<br />');
define('OSFI_CONFIG_PROTECT', 'Please make sure the file: <b>/faq/include/config.faq.php</b> is NOT writable once you finish installing.<br />');

define('OSFI_SP_PATH_DESCRIPTION', '<h3>Description:</h3>
  You will see an image (directly above) when this path is correct.<br /><br />
  This path should be absolute and use the same type of file seperator your server uses.<br />
  For Windows its usually a backslash like: <b>\\</b> or <b>\\\\</b> or <b>\\\\\\\\</b><br />
  Windows can often accept <b>/</b> as well but not always. <b>\\\\</b> is usually the safest bet to start with.<br />
  <br />
  For other operating systems its usually a forward slash like: <b>/</b><br />
  <br />
  Do NOT use a trailing seperator.');

define('OSFI_SP_DOCROOT', 'DOCUMENT ROOT:');
define('OSFI_SP_WEBROOT', 'WEB PATH ROOT:');

define('OSFI_SP_ROOT_PATH', 'ROOT FILE PATH NOT FOUND');
define('OSFI_SP_WEB_PATH', 'WEB PATH NOT FOUND');

define('OSFI_SP_SEE_IMAGE', '<h3>Description:</h3>
  You will see an image (directly above) when this path is correct.<br /><br />
  Should use web style seperators and have a leading and trailing slash EG: <b>/</b> or <b>/myPath/FromThe/RootDirectory/</b>');

define('OSFI_SP_SAVE_PATHS', 'Save the paths as they appear in the fields');
define('OSFI_SP_RESET_PATHS', 'Reset with dynamic paths');
define('OSFI_SP_CONTINUE_INSTALL', 'I can see an image above each field. Continue Installing.');
define('OSFI_SP_PATHS_RESTORED', 'Dynamic Paths Restored.');
define('OSFI_SP_PATHS_SAVED', 'Path setting saved.');
?>
<?php
/* *************************************************************************
  Id: client.lang.php

  Translation file for client.inc.php and client_up.inc.php.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INS_TITLE', 'Client integration');

define('OSFI_CLIENT_DELETE', 'Please delete: %s');

define('OSFI_CLIENT_COMPLETE', '<p>Your <b>client</b> area appears to contain the required integration code.</p>
	<p>You can safely continue to the next step.</p>');

define('OSFI_CLIENT_INTRO', '<p>You need to integrate some code into your <b>client</b> area so users can access your FAQ system.</p>
	<p>The messages below indicate the state of each check I performed.</p>');

define('OSFI_AN_EXAMPLE', 'An example:');
define('OSFI_EXAMPLE_IMPLEMENTATION', 'This is an example implementation:');

define('OSFI_FAQ_CLIENT_OK', 'The client file <code>%s</code> is present');
define('OSFI_FAQ_CLIENT_MISSING', 'Please make sure the client file is uploaded to your osTicket directory like so: <br />%s');

//define('OSFI_FAQ_SUB_OK', 'The client submit file <code>' . FILE_FAQ_SUBMIT . '</code> is present');
//define('OSFI_FAQ_SUB_MISSING', 'Please make sure the client submit file is uploaded to your osTicket directory like so: <br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_SUBMIT . '</u></code>');

define('OSFI_STYLES_OK', 'The base stylesheet is being imported correctly.<br />Edit: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq.css</u>' . '</code><br />if you want to change the appearance of the client faq pages or featured FAQ module.');
define('OSFI_STYLES_MISSING', 'The base stylesheet does not appear to have been imported in the client header file.<br />Please edit <code>' . DIR_FS_BASE . 'include/client/header.inc.php' . '</code><br />and paste the following text between the <code>&lt;head&gt;</code> and <code>&lt;/head&gt;</code> tags, preferably below the other stylesheet imports:');

//define('OSFI_NAV_MOD_OK', 'I found a link to the FAQ area in the client header file.');
//define('OSFI_NAV_MOD_MISSING', 'I couldnt find a link to the FAQ area in the client header file.<br />Please edit <code>' . DIR_FS_BASE . 'include/client/header.inc.php' . '</code><br />and paste the following text between the <code>&lt;ul id="nav"&gt;</code> and <code>&lt;/ul&gt;</code> tags, preferably directly under the opening <code>ul</code> tag<br />(the link will appear as the far right header link):');

define('OSFI_REQUIRE_OK', 'I found a "require" for the featured FAQ area in your osTicket index page.');
define('OSFI_REQUIRE_MISSING', 'I couldn\'t find a "require" for the featured FAQ area in your osTicket index page.<br />Paste it where you want the featured FAQs to be displayed.<br />The installer/upgrader will check for the existance of this line of code in <code>[your-osTicket-directory]/index.php</code>');
?>
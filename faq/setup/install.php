<?php
/* *************************************************************************
  Id: install.php

  osFaq v1.2 RC installer.
  This is the main installation file.
  Basic checks and all installer-steps are managed from here.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require ('inc/settings.php');


/// manage installer steps
$faq_step = isset($_GET['faq_step']) ? (int)$_GET['faq_step'] : 0;
switch($faq_step){
  case 1:
  $pageInc = 'schema.inc.php';
  break;

  case 2:
  $pageInc = ( (OSTICKET_CHECK_VER == '1.6') ? 'staff_old.inc.php' : 'staff.inc.php' );
  break;

  case 3:
  $pageInc = 'client.inc.php';
  break;

  case 4:
  $pageInc = 'installcomplete.inc.php';
  break;

  case 0:
  default:
  $pageInc = 'intro.inc.php';
  break;
}


define('PAGE_HEADING', sprintf(OSFI_HEAD_INSTALL, (($faq_step>0) ? ' - step '.$faq_step : '')) );

require('inc/header.inc.php');
require('inc/' . $pageInc);
require('inc/footer.inc.php');
?>
<?php
/* *************************************************************************
  Id: upgrade.php

  Handles Upgrading for: osFaq v1.0 RC2/3/4/5/6/ST and 1.1 ST to 1.2 RC

  This is the main upgrade file.
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
/// upgrade type
if(isset($_GET['upgrade_rc']) || !isset($_SESSION['upgrade_rc'])){
  $_SESSION['upgrade_rc'] = isset($_GET['upgrade_rc']) ? (int)$_GET['upgrade_rc'] : 3;
}


switch($_SESSION['upgrade_rc']){
  // upgrading to v1.2 RC
  case 8:
  default:
  	switch($faq_step){
  		case 1:
  			$pageInc = 'schema_up.inc.php';
  			break;

  		case 2:
  			$pageInc = ( (OSTICKET_CHECK_VER == '1.6') ? 'staff_old.inc.php' : 'staff.inc.php' );
  			break;

  		case 3:
  			$pageInc = 'client_up.inc.php';
  			break;

  		case 4:
  			$pageInc = 'installcomplete.inc.php';
  			break;

  		case 0:
  		default:
  			$pageInc = 'intro.inc.php';
  			break;
  	}
  	break;
}


define('PAGE_HEADING', sprintf(OSFI_HEAD_UPDATE, (($faq_step>0) ? ' - step '.$faq_step : '')) );

require('inc/header.inc.php');
require('inc/' . $pageInc);
require('inc/footer.inc.php');
?>
<?php
/* *************************************************************************
  Id: installcomplete.inc.php

  Cool! All done and ready to use.
  This page displays a few (hopefully) helpfull links and tips.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

require (SETUP_LANG_DIR . '/installcomplete.lang.php');
?>
<h3><?php echo OSFI_INSTALL_COMPLETE; ?></h3>
<?php echo OSFI_READY_FOR_USE; ?>

<h3 style="margin:0;padding:0"><?php echo OSFI_TIP; ?></h3>
<div class="messageHandlerPlain"><b><?php echo OSFI_DELETE_SETUP_DIR; ?></b><br />
<?php echo '<code>' . DIR_FS_BASE . 'faq/setup</code>' ?></div>

<h3><?php echo OSFI_NEW_INSTALLATION; ?></h3>
<form action="../../osfaq.php" target="_blank" method="get" enctype="text/plain" style="width:150px;display:inline;">
  <input type="submit" value="<?php echo OSFI_VISIT_CLIENT; ?>" />
</form>

<form action="../../scp/osfaq_admin.php" target="_blank" method="get" enctype="text/plain" style="width:150px;display:inline;">
  <input type="submit" value="<?php echo OSFI_VISIT_ADMIN; ?>" />
</form>

<br />
<h3><?php echo OSFI_RELATED_RESOURCES; ?></h3>
<form action="http://osfaq.oz-devworx.com.au/" target="_blank" method="get" enctype="text/plain" style="width:150px;display:inline;">
  <input type="submit" value="<?php echo OSFI_VISIT_OSFAQ; ?>" />
</form>

<form action="http://osticket.com/" target="_blank" method="get" enctype="text/plain" style="width:150px;display:inline;">
  <input type="submit" value="<?php echo OSFI_VISIT_OSTICKET; ?>" />
</form>

<br />
<h3><?php echo OSFI_LEGAL; ?></h3>
<form action="http://osfaq.oz-devworx.com.au/license/" target="_blank" method="get" enctype="text/plain" style="width:150px;display:inline;">
  <input type="submit" value="<?php echo OSFI_LICENSE; ?>" />
</form>
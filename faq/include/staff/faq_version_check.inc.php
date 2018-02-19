<?php
/* *************************************************************************
 Id: faq_version_check.inc.php

Version checker for osFaq.
Very simple at the moment.


Tim Gall
Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
http://osfaq.oz-devworx.com.au

This file is part of osFaq.

Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

echo '<h1>' . OSF_PAGE_FAQ_VERSION . ' ' . FAQ_VERSION . '</h1>' . PHP_EOL;
?>

<iframe frameborder="0" style="width:100%; border:none; outline:none;" src="<?php echo 'https://osfaq.oz-devworx.com.au/download/version_check.php?v=' . FAQ_VERSION . '&lang=' . OSFDB_DEFAULT_LANG; ?>"></iframe>
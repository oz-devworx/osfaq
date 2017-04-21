<?php
/* *************************************************************************
  Id: staff_old.lang.php

  Translation file for staff.inc.php.


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_STAFF_ONCE_INTEGRATED_OLD', 'Einmal integriert, sollte die Funktion <code>StaffNav</code> so etwa wie das folgende Beispiel aussehen (laut osTicket v1.6 RC5)');

define('OSFI_FAQ_STYLES_OK_OLD', 'Der Admin-Stylesheet wird korrekt importiert.<br />Edit: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq_admin.css</u>' . '</code><br />, wenn Sie das Erscheinungsbild der Mitarbeiter FAQ-Seiten ändern möchten.');
define('OSFI_FAQ_STYLES_MISSING_OLD', 'Der Admin-Stylesheet scheint nicht in der Personal-Header-Datei importiert worden zu sein.<br />
	Bitte bearbeiten: <code>' . DIR_FS_BASE . 'include/staff/header.inc.php' . '</code><br /> und fügen Sie den folgenden Text zwischen den Tags <code>&lt;head&gt;</code> und <code>&lt;/head&gt;</code>, vorzugsweise unter den anderen Stylesheet:');

define('OSFI_NAV_MOD_OK_OLD', '<code>class.nav.php</code> scheint den richtigen Integrationscode zu haben.');
define('OSFI_NAV_MOD_MISSING_OLD', '<code>class.nav.php</code> scheint nicht den richtigen Integrationscode zu haben. Bitte bearbeiten <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br /> und fügen Sie den folgenden unterhalb des "Mein Konto" in der Funktion <code>StaffNav</code> (nach Zeile 42)');
?>
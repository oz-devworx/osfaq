<?php
/* *************************************************************************
  Id: schema.lang.php

  Translation file for schema.inc.php and schema_up.inc.php.


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INS_TITLE', 'Datenbank-Integration');
define('OSFI_INS_TABLES', 'Installiere Datenbanktabellen');
define('OSFI_INS_COMPLETE_STEP', 'Schritt 1 ausführen');
define('OSFI_INS_READY_TITLE', 'Bereit zum Installieren der Datenbanktabellen');

define('OSFI_INS_READY_TEXT', '<p>Klicken Sie auf die Schaltfläche unten, um die FAQ-Tabellen in Ihre osTicket Datenbank zu integrieren.<br />Ihr aktuelles osTicket-Datenbanktabellenpräfix wird bei der Erstellung der neuen Tabellen verwendet.</p>
	<p>Klicken Sie auf die Schaltfläche unten, um fortzufahren.</p>');


define('OSFI_UPG_TITLE', 'Datenbank-Upgrade');
define('OSFI_UPG_TABLES', 'Aktualisieren der Datenbanktabellen');

define('OSFI_UPG_READY_TITLE', 'Bereit, Ihre osFaq Datenbanktabellen zu aktualisieren');

define('OSFI_UPG_READY_TEXT', '<p>Klicken Sie auf eine Schaltfläche unten, um die osFAQ-Tabellen in Ihrer osTicket-Datenbank auf die neueste Version zu aktualisieren.<br />Ihre aktuelles osTicket-Datenbanktabellenpräfix wird verwendet.</p>
	<p>Wählen Sie Ihre Option unten, um fortzufahren.</p>');

define('OSFI_UPG_FROM_TO', 'Upgrade von %s auf %s');

define('ERROR_QUERY', FAQ_FATAL . 'Fehler beim Bearbeiten der Datenbank-Schema-Datei.');
define('ERROR_BAD_FORMAT', FAQ_FATAL . 'Die Schema-Datei scheint nicht richtig formatiert.');
define('ERROR_EMPTY_SCHEMA', FAQ_FATAL . 'Die Schema-Datei ist leer oder falsch formatiert.');
define('OK_SCHEMA_SUCCESS', FAQ_GOOD . 'Die FAQ-Systemtabellen wurden eingefügt.');
?>
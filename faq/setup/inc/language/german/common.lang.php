<?php
/* *************************************************************************
  Id: common.lang.php

  Translation file for common elements shared across pages.


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('FAQ_TITLE', 'FAQs für osTicket');

define('OSFI_HEAD_INDEX', 'osFaq Installationsassistent');
define('OSFI_HEAD_INSTALL', 'osFaq Installationsassistent%s');
define('OSFI_HEAD_UPDATE', 'osFaq Upgrade-Assistent%s');

define('OSFI_MANUAL_PATHS', 'Manual Path Setup');
define('OSFI_REFRESH', 'Aktualisieren.');
define('OSFI_CONTINUE', 'Weiter...');
define('OSFI_IMAGE', 'BILD');
define('OSFI_STEP', 'Schritt %s');
define('OSFI_IGNORE_AND_PROCEED', 'Alle unvollständigen Schritte ignorieren und fortfahren.');
define('OSFI_SKIP_FOR_NOW', 'Diesen Schritt überspringen.');
define('OSFI_CHECK_AGAIN', 'Erneut prüfen');
define('OSFI_FAQS', 'FAQs');

define('OSFI_ERROR_ENCOUTERED', '<h3>oops ... Ich traf auf ein oder mehrere Probleme und kann nicht fortfahren</h3>
  <p>Bitte korrigieren Sie die unten aufgeführten Probleme. Dann klicken Sie auf die Schaltfläche, um es erneut zu versuchen.</p>
  <p>%s</p>
  <p>Wenn Sie diesen Ordner verschieben müssen, um das Problem zu beheben, stellen Sie sicher, dass Sie die neue Adresse in die Adressleiste Ihres Browsers eingeben, um das Installationsprogramm neu zu starten.</p>');

define('OSFI_RESTART_INSTALL', 'Starten Sie die Installation');
define('OSFI_COPYRIGHT', 'Copyright &copy; %s osfaq.oz-devworx.com.au. Alle Rechte vorbehalten. <a href="http://osfaq.oz-devworx.com.au/" target="_blank">osFaq</a> ist kein offizieller Partner von <a href="http://osticket.com/" target="_blank">osTicket</a>.');


define('FAQ_GOOD', '<b style="color:green;">OK</b>: ');
define('FAQ_BAD', '<b style="color:red;">FEHLT</b>: ');
define('FAQ_FATAL', '<b style="color:red;">SCHWERER FEHLER</b>: ');

define('ERROR_FILES_MISSING', FAQ_FATAL . 'Bitte überprüfen Sie, ob alle osFaq-Dateien hochgeladen wurden. Manche scheinen zu fehlen.');
define('ERROR_CANT_GET_PATH', FAQ_FATAL . 'Ich konnte die Dateipfade (%s) nicht auslesen. Wenn Ihre osTicket-Installation funktioniert, müssen Sie einige Dateien manuell bearbeiten, um die korrekte Funktion von osFaq zu gewährleisten.<br />Bitte melden Sie diesen Fehler an die Entwickler.');
define('ERROR_OST_SETTINGS', FAQ_FATAL . 'Ich konnte die osTicket-Einstellungsdatei nicht laden. Bitte stellen Sie sicher, dass <a href="http://osticket.com/" target="_blank">osTicket v1.7 (ST or RC5)</a> installiert ist.');
define('ERROR_OSF_SETTINGS', FAQ_FATAL . 'Ich konnte die osFaq-Einstellungsdatei nicht laden. Bitte stellen Sie sicher, dass die osFaq-Dateien an den richtigen Ort hoch geladen wurden.');
define('ERROR_CONNECTION', FAQ_FATAL . 'Kontakt Systemadministrator.<br />Kann die Verbindung zur Datenbank');
define('ERROR_BROKEN', FAQ_FATAL . 'Das Paket, das Sie zu installieren versuchen, scheint beschädigt zu sein oder kann nicht mit osTicket 1.7 (ST or RC5) installiert werden.');
?>
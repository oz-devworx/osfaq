<?php
/* *************************************************************************
  Id: static_path.lang.php

  Translation file for static_path.inc.php


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_ERROR_CONFIG_WRITE', '<span style="color:red;">Die Konfigurationsdatei ist nicht beschreibbar.</span> Bitte stellen Sie sicher, dass die Datei: <b>/faq/include/config.faq.php</b> beschreibbar ist.<br />');
define('OSFI_ERROR_CONFIG_READ', '<span style="color:red;">Die Konfigurationsdatei konnte nicht zum Lesen geöffnet werden.</span> Bitte stellen Sie sicher, dass die Datei: <b>/faq/include/config.faq.php</b> lesbar und beschreibbar ist.<br />');
define('OSFI_ERROR_CONFIG_SAVE', '<span style="color:red;">Die Konfigurationsdatei konnte nicht gespeichert werden.</span> Bitte stellen Sie sicher, dass die Datei: <b>/faq/include/config.faq.php</b> beschreibbar ist.<br />');
define('OSFI_CONFIG_PROTECT', 'Bitte stellen Sie sicher, dass die Datei: <b>/faq/include/config.faq.php</b> NICHT beschreibbar ist, wenn Sie die Installation beenden.<br />');

define('OSFI_SP_PATH_DESCRIPTION', '<h3>Beschreibung:</h3>
  Sie sehen ein Bild (direkt oben), wenn diese Pfadangabe richtig ist.<br /><br />
  Dieser Pfad sollte absolut sein und die gleiche Art von Dateitrenner haben, den Ihr Server verwendet.<br />
  Für Windows ist es in der Regel ein Backslash wie: <b>\\</b> or <b>\\\\</b> or <b>\\\\\\\\</b><br />
  Windows kann oft <b>/</b> akzeptieren, aber nicht immer. <b>\\\\</b> ist in der Regel die sicherste, mit der auch zu beginnen ist.<br />
  <br />
  Für andere Betriebssysteme genügt nach wie vor ein Schrägstrich: <b>/</b><br />
  <br />
  Verwenden Sie KEINEN abschließenden Trenner.');

define('OSFI_SP_DOCROOT', 'DOCUMENT ROOT:');
define('OSFI_SP_WEBROOT', 'WEB PATH ROOT:');

define('OSFI_SP_ROOT_PATH', 'Root-Dateisystem Pfad nicht gefunden');
define('OSFI_SP_WEB_PATH', 'WEB Pfad nicht gefunden');

define('OSFI_SP_SEE_IMAGE', '<h3>Beschreibung:</h3>
  Sie sehen ein Bild (direkt oben), wenn diese Pfadangabe richtig ist.<br /><br />
  Sollte verwenden Web-Stil Trenner und eine führende und abschließende Schrägstrich EG: <b>/</b> oder <b>/meinpfad/vonThe/RootDirectory/</b>');

define('OSFI_SP_SAVE_PATHS', 'Speichern Sie die Pfade, wie sie in den Feldern angezeiht werden');
define('OSFI_SP_RESET_PATHS', 'Zurücksetzen mit dynamischen Pfaden');
define('OSFI_SP_CONTINUE_INSTALL', 'Ich sehe ein Bild über jedes Feld. Die Installation fortsetzen.');
define('OSFI_SP_PATHS_RESTORED', 'Dynamische Pfade zurückgesetzt.');
define('OSFI_SP_PATHS_SAVED', 'Pfadeinstellung gespeichert.');
?>
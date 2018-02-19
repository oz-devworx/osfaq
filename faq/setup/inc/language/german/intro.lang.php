<?php
/* *************************************************************************
  Id: intro.lang.php

  Translation file for intro.inc.php


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INTRO_INTRO', 'Einführung');
define('OSFI_INTRO_LOGO', 'osFaq Logo');

define('OSFI_INTRO_WELCOME', '<p>Willkommen im Installationsassistenten für osFaq v%s. Dies ist eine <span title="Häufig gestellte Fragen"><u>FAQ</u></span>-Plugin-Modul für <a href="http://osticket.com/" target="_blank">osTicket v1.7 RC5 - v1.10.x</a>.</p><p>osFaq ist Open Source Software unter der GPLv3 veröffentlicht.<br />
  osFaq geschrieben und verwaltet von <a href="http://oz-devworx.users.sourceforge.net/" target="_blank">oz-devworx</a>.<br />
  Deutsche Übersetzungen sowie Installer- und Datenbankübersetzungen von Silvio Paschke.<br />
  Dieser Installationsassistent führt Sie durch den Installationsprozess, um osFaq in Ihrem osTicket System einzurichten und zu betreiben.<br />
  Sie finden weitere Informationen über osFaq auf der Support-Website: <a href="http://www.osfaq.oz-devworx.com.au/" target="_blank">http://www.osfaq.oz-devworx.com.au/</a></p>');

define('OSFI_INTRO_PARAM', 'Parameter');
define('OSFI_INTRO_VAL', 'Wert');
define('OSFI_INTRO_INST_TYPE', 'Art der Installation');
define('OSFI_INTRO_ADVICE_1', '<b>VOR DEM UPGRADE:</b> Sie sollten eine Sicherungskopie Ihrer Datenbank anfertigen. Der Name der Datenbank ist <i>%s</i>');

define('OSFI_INTRO_OLD_INSTALLER', '<p>Ihre bestehende osFaq-Version ist neuer als diese Version.</p>
<p><b>Wenn Sie ein Downgrade wünschen:</b></p>
<ol>
	<li>Sichern Sie Ihre vorhandenen FAQs, Kategorien und FAQs-zu-Kategorien-Datenbanktabellen. Der Name der Datenbank ist "<i>%s</i>"</li>
	<li>Löschen Sie alle osFaq-Tabellen aus der Datenbank. osFaq-Tabellennamen beginnen mit "<i>%s</i>"</li>
	<li>Führen Sie dieses Installationsprogramm erneut von Anfang an aus <a href="index.php">INSTALLATIONSASSISTENTEN STARTEN</a>.</li>
	<li>Fügen Sie Ihre zuvor gesicherten FAQ-Daten wieder in die Datenbank ein.</li>
</ol>');

define('OSFI_INTRO_V_DETECTED', '%s erkannt.');
define('OSFI_INTRO_UPG_TO', 'Upgrade osFaq von v%s zu v%s');

define('OSFI_INTRO_ALREADY_INSTALLED', '<h3>osFaq v%s bereits installiert.</h3>
<p>Es scheint, dass Sie diese Version schon installiert haben. Sie können die Anwendung neu installieren. Aber Achtung: Bereits existierende FAQs in Ihrer bestehenden Installation von osFaq werden verloren gehen, wenn Sie diese nicht zuvor sichern!<br />
Der Name der Datenbank ist "<i>%s</i>"</p>');

define('OSFI_INTRO_INSTALL_V', 'Installieren v%s');

define('OSFI_INSTALLER_FOR', 'Installer für');
define('OSFI_VERSION', 'osFaq Version %s');
define('OSFI_OST_INSTALLER_FOR', 'Integration Ziel');
define('OSFI_OST_VERSION', 'osTicket Version %s');
define('OSFI_DATABASE', 'Datenbank');
define('OSFI_DB_PREFIX', 'Datenbanktabellenpräfix');
define('OSFI_DB_PERMISSIONS', 'Datenbank-Berechtigungen');
define('OSFI_DOMAIN', 'Server-Domain');
define('OSFI_DOC_ROOT', 'Absoluter DOCUMENT_ROOT Dateipfad');
define('OSFI_WEB_ROOT', 'Absoluter öffentlicher WEB_ROOT Dateipfad');
define('OSFI_EDIT_DOC_ROOT', 'DOCUMENT_ROOT bearbeiten');
define('OSFI_EDIT_WEB_ROOT', 'WEB_ROOT bearbeiten');
define('OSFI_ROOT_PATH_NF', 'Root-Dateisystem Pfad nicht gefunden');
define('OSFI_INTRO_LANG', 'Sprache');
define('OSFI_INTRO_LANG_RESET', 'Ändern');

define('OSFI_OK', 'Ok');
define('OSFI_ERROR', 'Fehler');
define('OSFI_WARNING', 'Warnung');

define('OSFI_MISSING_PERMS', 'Fehlende Berechtigungen');
define('OSFI_OST_SUPPORTED', 'Unterstützte Version');
define('OSFI_OST_NOT_SUPPORTED', 'Unsupported Version. Könnte funktionieren, aber Integrationsschritte können von dieser Installationsanleitung variieren.');
?>
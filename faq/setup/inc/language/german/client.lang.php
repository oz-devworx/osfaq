<?php
/* *************************************************************************
  Id: client.lang.php

  Translation file for client.inc.php and client_up.inc.php.


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INS_TITLE', 'Client-Implementierung');

define('OSFI_CLIENT_DELETE', 'Bitte löschen Sie: %s');

define('OSFI_CLIENT_COMPLETE', '<p>Ihr <b>Klient</b> Bereich scheint den erforderlichen Integrationscode zu enthalten.</p>
	<p>Sie können daher mit dem nächsten Schritt fortfahren.</p>');

define('OSFI_CLIENT_INTRO', '<p>Sie müssen Code in Ihren <b>Klient</b> Bereich integrieren, so dass Benutzer auf Ihr FAQ-System zugreifen können.</p>
	<p>Die folgenden Meldungen zeigen den Zustand der einzeln durchgeführten Überprüfungen.</p>');

define('OSFI_AN_EXAMPLE', 'Ein Beispiel:');
define('OSFI_EXAMPLE_IMPLEMENTATION', 'Dies ist eine Beispiel-Implementierung:');

define('OSFI_FAQ_CLIENT_OK', 'Die Klient-Datei  %s ist vorhanden');
define('OSFI_FAQ_CLIENT_MISSING', 'Bitte stellen Sie sicher, dass sich die Klient-Datei in Ihrem osTicket Verzeichnis befindet: %s');

//define('OSFI_FAQ_SUB_OK', 'Die FAQ-Vorschlags-Datei <code>' . FILE_FAQ_SUBMIT . '</code> ist vorhanden');
//define('OSFI_FAQ_SUB_MISSING', 'Bitte stellen Sie sicher,  sich die FAQ-Vorschlags-Datei in Ihrem osTicket Verzeichnis befindet: <br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_SUBMIT . '</u></code>');

define('OSFI_STYLES_OK', 'Das Basis-Stylesheet wird korrekt importiert.<br />Edit: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq.css</u>' . '</code><br />, wenn Sie das Aussehen des Kunden FAQ-Seiten ändern oder vorgestellten FAQ-Modul wollen.');
define('OSFI_STYLES_MISSING', 'Das Basis-Stylesheet erscheint nicht in der Client-Header-Datei importiert wurde.<br />Bitte bearbeiten <code>' . DIR_FS_BASE . 'include/client/header.inc.php' . '</code><br /> und fügen Sie den folgenden Text zwischen den Tags <code>&lt;head&gt;</code> und <code>&lt;/head&gt;</code>, vorzugsweise unter den anderen Stylesheet importiert:');

//define('OSFI_NAV_MOD_OK', 'Ich fand einen Link zu den FAQ-Bereich in der Client-Header-Datei.');
//define('OSFI_NAV_MOD_MISSING', 'Ich konnte einen Link zu dem FAQ-Bereich in der Client-Header-Datei nicht finden.<br />
//	Bitte bearbeiten Sie <code>' . DIR_FS_BASE . 'include/client/header.inc.php' . '</code><br /> und fügen den folgenden Text zwischen den Tags <code>&lt;ul id="nav"&gt;</code> und <code>&lt;/ul&gt;</code> vorzugsweise direkt unter dem öffnenden <code>ul</code> -Tag<br />(der Link wird als ganz rechts Header Link angezeigt) ein:');

define('OSFI_REQUIRE_OK', 'Ich fand ein "require" für den einzubindenden FAQ-Bereich in Ihrer osTicket Index-Seite.');
define('OSFI_REQUIRE_MISSING', 'Ich konnte ein "require" für den einzubindenden FAQ-Bereich in Ihrer osTicket Index-Seite nicht finden.<br />Fügen Sie dies dort ein, wo die FAQs angezeigt werden sollen.<br />Der Installer/Upgrader prüft die Existenz dieser Codezeile in <code>[Ihre-osTicket-Verzeichnis]/index.php</code>');
?>
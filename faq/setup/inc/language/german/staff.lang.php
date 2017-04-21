<?php
/* *************************************************************************
  Id: staff.lang.php

  Translation file for staff.inc.php.


  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_STAFF_TITLE', 'Mitarbeiter-Integration');

define('OSFI_ADMIN_DELETE', 'Bitte löschen Sie: %s');

define('OSFI_STAFF_COMPLETE', '<p>Ihr <b>Mitarbeiter</b> Bereich scheint die gewünschten Dateien und Integrationscode zu enthalten.</p>
	<p>Sie können daher mit dem nächsten Schritt fortfahren.</p>');

define('OSFI_STAFF_INTRO', '<p>Sie müssen Code in Ihren <b>Mitarbeiter</b> Bereich integrieren, damit Sie Ihr FAQ-System verwalten können.</p>
	<p>Die folgenden Meldungen zeigen den Zustand der einzeln durchgeführten Überprüfungen.</p>');

define('OSFI_STAFF_ONCE_INTEGRATED', 'Einmal integriert, sollte die Funktion <code>%s</code> so etwa wie das folgende Beispiel aussehen (laut osTicket v1.10)');

define('OSFI_FAQ_ADMIN_OK', 'Die Admin-Datei %s ist vorhanden');
define('OSFI_FAQ_ADMIN_MISSING', 'Bitte stellen Sie sicher, dass sich die Admin-Datei in Ihrem osTicket Verzeichnis befindet: %s');

//define('OSFI_FAQ_STYLES_OK', 'Der Admin-Stylesheet wird korrekt importiert.<br />Edit: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq_admin.css</u>' . '</code><br />, wenn Sie das Erscheinungsbild der Mitarbeiter FAQ-Seiten ändern möchten.');
//define('OSFI_FAQ_STYLES_MISSING', 'Der Admin-Stylesheet scheint nicht in der Personal-Header-Datei importiert worden zu sein.<br />
//	Bitte bearbeiten: <code>' . DIR_FS_BASE . 'include/staff/header.inc.php' . '</code><br /> und fügen Sie den folgenden Text zwischen den Tags <code>&lt;head&gt;</code> und <code>&lt;/head&gt;</code>, vorzugsweise unter den anderen Stylesheet:');

define('OSFI_NAV_MOD_OK', '<code>class.nav.php</code> scheint den richtigen Integrationscode zu haben.');
define('OSFI_NAV_MOD_MISSING', '<code>class.nav.php</code> scheint nicht den richtigen Integrationscode zu haben. Bitte bearbeiten <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br /> und fügen Sie den folgenden unterhalb "Knowledgebase" in der Funktion <code>getTabs()</code> (nach Zeile 130)');

define('OSFI_NAV_MOD2_MISSING', '<code>class.nav.php</code> scheint nicht den richtigen Integrationscode zu haben. Bitte bearbeiten <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br /> und fügen Sie den folgenden oben des "$this->navs=$navs;" in der Funktion <code>getNavLinks()</code> (nahe dem Ende der Datei. Direkt oberhalb <code>$this->navs=$navs;</code>):');

?>
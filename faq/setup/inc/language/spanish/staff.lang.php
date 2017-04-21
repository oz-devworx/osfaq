<?php
/* *************************************************************************
  Id: staff.lang.php

  Translation file for staff.inc.php.


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_STAFF_TITLE', 'Integración del Staff ');

define('OSFI_ADMIN_DELETE', 'Por favor, elimine: %s');

define('OSFI_STAFF_COMPLETE', '<p>Tu area de <b>staff</b> parece contener los archivos necesarios y el código de integración.</p>
	<p>Puede continuar con el siguiente paso.</p>');

define('OSFI_STAFF_INTRO', '<p>Necesitas integrar el código en su area del <b>staff</b> para que pueda administrar su sistema de FAQ.</p>
	<p>Los mensajes a continuación indican el estado de cada revisión realizada.</p>');

define('OSFI_STAFF_ONCE_INTEGRATED', 'Una vez integrado el codigo en <code>%s</code> deberia quedar algo como en el siguiente ejemplo (copiado de osTicket v1.10)');

define('OSFI_FAQ_ADMIN_OK', 'El archivo de administrador %s está presente');
define('OSFI_FAQ_ADMIN_MISSING', 'Por favor, asegúrese de que el archivo de administrador se carge en su directorio osTicket como tal: %s');

//define('OSFI_FAQ_STYLES_OK', 'La hoja de estilos de administración se importó correctamente.<br />Edita: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq_admin.css</u>' . '</code><br />si quieres cambiar la apariencia de las páginas del Staff del FAQ.');
//define('OSFI_FAQ_STYLES_MISSING', 'La hoja de estilos de administración no parece haber sido importada en el archivo de encabezado del Staff.<br />Edite: <code>' . DIR_FS_BASE . 'include/staff/header.inc.php' . '</code><br />y pegue el siguiente texto entre las etiquetas <code>&lt;head&gt;</code> y <code>&lt;/head&gt;</code>, preferiblemente debajo de los códigos de los otros estilos:');

define('OSFI_NAV_MOD_OK', '<code>class.nav.php</code> parece tener el código de integración correcto .');
define('OSFI_NAV_MOD_MISSING', '<code>class.nav.php</code> No tiene el código de integración correcto.<br />Edite <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br />y pege el siguiente codigo justo debajo de "Knowledgebase" dentro de la funcción <code>StaffNav</code> (atras de la linea 130):');

define('OSFI_NAV_MOD2_MISSING', '<code>class.nav.php</code> No tiene el código de integración correcto.<br />Edite <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br />y pege el siguiente codigo justo arriba "$this->navs=$navs;" dentro de la funcción <code>getNavLinks()</code> (cerca de la parte inferior del archivo. Justo encima de <code>$this->navs=$navs;</code>):');

?>
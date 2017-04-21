<?php
/* *************************************************************************
  Id: staff_old.lang.php

  Translation file for staff.inc.php.


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_STAFF_ONCE_INTEGRATED_OLD', 'Una vez integrado el codigo en <code>StaffNav</code> deberia quedar algo como en el siguiente ejemplo (copiado de osTicket v1.6 RC5)');

define('OSFI_FAQ_STYLES_OK_OLD', 'La hoja de estilos de administración se importó correctamente.<br />Edita: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq_admin.css</u>' . '</code><br />si quieres cambiar la apariencia de las páginas del Staff del FAQ.');
define('OSFI_FAQ_STYLES_MISSING_OLD', 'La hoja de estilos de administración no parece haber sido importada en el archivo de encabezado del Staff.<br />Edite: <code>' . DIR_FS_BASE . 'include/staff/header.inc.php' . '</code><br />y pegue el siguiente texto entre las etiquetas <code>&lt;head&gt;</code> y <code>&lt;/head&gt;</code>, preferiblemente debajo de los códigos de los otros estilos:');

define('OSFI_NAV_MOD_OK_OLD', '<code>class.nav.php</code> parece tener el código de integración correcto .');
define('OSFI_NAV_MOD_MISSING_OLD', '<code>class.nav.php</code> No tiene el código de integración correcto.<br />Edite <code>' . DIR_FS_BASE . 'include/class.nav.php' . '</code><br />y pege el siguiente codigo justo debajo de "My Account" dentro de la funcción <code>StaffNav</code> (atras de la linea 42):');
?>
<?php
/* *************************************************************************
  Id: schema.lang.php

  Translation file for schema.inc.php and schema_up.inc.php.


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INS_TITLE', 'Integración Base de Datos');
define('OSFI_INS_TABLES', 'Instalación de las tablas de base de datos');
define('OSFI_INS_COMPLETE_STEP', 'Completar paso 1');
define('OSFI_INS_READY_TITLE', 'Listo para instalar Tablas de base de datos');

define('OSFI_INS_READY_TEXT', '<p>Haga clic en el botón de abajo para integrar las tablas de FAQ en su base de datos osTicket.<br />El prefijo de la tabla actual de osTicket se utilizará para crear las nuevas tablas.</p>
	<p>Haga clic en el botón de abajo para continuar.</p>');


define('OSFI_UPG_TITLE', 'Actualización de Base de datos ');
define('OSFI_UPG_TABLES', 'Actualización de las tablas de la base de datos');

define('OSFI_UPG_READY_TITLE', 'Listo para actualizar las tablas de base de datos osFaq');

define('OSFI_UPG_READY_TEXT', '<p>Haga clic en un botón para actualizar las tablas de osFAQ a la última versión dentro de la base de datos de osTicket .<br />Su prefijo de la tabla actual de osTicket se utilizará para crear las tablas de osFaq.</p>
	<p>Elija a continuación una opción para continuar.</p>');

define('OSFI_UPG_FROM_TO', 'Actualizar de %s a %s');

define('ERROR_QUERY', FAQ_FATAL . 'Errores encontrados al procesar el esquema de archivo de base de datos.');
define('ERROR_BAD_FORMAT', FAQ_FATAL . 'El archivo de esquema no parece tener el formato correcto.');
define('ERROR_EMPTY_SCHEMA', FAQ_FATAL . 'El archivo de esquema está vacío o formateado incorrectamente.');
define('OK_SCHEMA_SUCCESS', FAQ_GOOD . 'Las tablas del sistema FAQ se han creado.');
?>
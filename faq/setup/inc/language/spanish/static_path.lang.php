<?php
/* *************************************************************************
  Id: static_path.lang.php

  Translation file for static_path.inc.php


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_ERROR_CONFIG_WRITE', '<span style="color:red;">El archivo de configuración no tiene permisos de escritura.</span> Asegurese de que el archivo: <b>/faq/include/config.faq.php</b> tenga permisos de escritura.<br />');
define('OSFI_ERROR_CONFIG_READ', '<span style="color:red;">El archivo de configuración no se puede abrir para la lectura.</span> Asegurate de que el archivo: <b>/faq/include/config.faq.php</b> tenga permisos de escritura y lectura.<br />');
define('OSFI_ERROR_CONFIG_SAVE', '<span style="color:red;">El archivo de configuración no se puede guardar.</span> Asegurate de que el archivo: <b>/faq/include/config.faq.php</b> tenga permisos de escritura.<br />');
define('OSFI_CONFIG_PROTECT', 'Asegurate de revertir los permisos del archivo: <b>/faq/include/config.faq.php</b> una vez termine la instalación .<br />');

define('OSFI_SP_PATH_DESCRIPTION', '<h3>Descripción:</h3>
  Usted verá una imagen (justo encima), cuando esta ruta sea la correcta.<br /><br />
  Esta ruta debe ser absoluta y utilizar el mismo tipo de separador de archivos que su servidor.<br />
  Para Windows por lo general es como una barra invertida: <b>\\</b> o <b>\\\\</b> o <b>\\\\\\\\</b><br />
  Windows a veces puede aceptar <b>/</b> pero no siempre. <b>\\\\</b> suele ser la apuesta más segura para empezar.<br />
  <br />
  Para otros sistemas operativos generalmente es una barra diagonal como: <b>/</b><br />
  <br />
  NO use un separador al final.');

define('OSFI_SP_DOCROOT', 'DOCUMENTO RAIZ:');
define('OSFI_SP_WEBROOT', 'RAIZ DE RUTA WEB:');

define('OSFI_SP_ROOT_PATH', 'RUTA DEL ARCHIVO RAIZ NO ENCONTRADA');
define('OSFI_SP_WEB_PATH', 'RUTA DE WEB NO ENCONTRADA');

define('OSFI_SP_SEE_IMAGE', '<h3>Descripción:</h3>
  Usted verá una imagen (justo encima), cuando esta ruta sea la correcta.<br /><br />
 Se debe utilizar separadores web, debe tener una barra de entrada y salida Ejemplo: <b>/</b> o <b>/myPath/FromThe/RootDirectory/</b>');

define('OSFI_SP_SAVE_PATHS', 'Guardar las rutas tal y como aparecen en los campos');
define('OSFI_SP_RESET_PATHS', 'Restablecer con rutas dinámicas');
define('OSFI_SP_CONTINUE_INSTALL', 'Puedo ver una imagen encima de cada campo. Continuar con la instalación.');
define('OSFI_SP_PATHS_RESTORED', 'Rutas dinámicas Restablecidas.');
define('OSFI_SP_PATHS_SAVED', 'Configuración de rutas guardadas.');
?>
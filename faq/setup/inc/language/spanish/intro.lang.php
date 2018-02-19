<?php
/* *************************************************************************
  Id: intro.lang.php

  Translation file for intro.inc.php


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INTRO_INTRO', 'Introducción');
define('OSFI_INTRO_LOGO', 'osFaq Logo');

define('OSFI_INTRO_WELCOME', '<p>Bienvenido al instalador para osFaq v%s.<br />Esto es un modulo de <span title="Preguntas Frecuentes"><u>FAQ</u></span> para <a href="http://osticket.com/" target="_blank">osTicket v1.7 RC5 - v1.10.x</a>.</p>
<p>osFaq es un software de código abierto publicado bajo la GPLv3.<br />
osFaq está escrito y mantenido por <a href="http://oz-devworx.users.sourceforge.net/" target="_blank">oz-devworx</a>.<br />
Traducción Español por <a href="http://elartedeganar.com" title="Sitio Web" target="_blank">Francisco Flores</a>.<br />
Este asistente de instalación le guiará a través del proceso de instalación para conseguir que osFaq quede instalado y funcionando en su osTicket.<br />
Puede encontrar más información sobre osFaq en el sitio Web de soporte: <a href="http://www.osfaq.oz-devworx.com.au/" target="_blank">http://www.osfaq.oz-devworx.com.au/</a></p>');

define('OSFI_INTRO_PARAM', 'Parametro');
define('OSFI_INTRO_VAL', 'Valor');
define('OSFI_INTRO_INST_TYPE', 'Tipo de Instalación');
define('OSFI_INTRO_ADVICE_1', '<b>ANTES DE ACTUALIZAR:</b> Es aconsejable crear copias de seguridad de la base de datos. El nombre de base de datos es <i>%s</i>');

define('OSFI_INTRO_OLD_INSTALLER', '<p>Su versión osFaq existente es más reciente que esta versión.</p>
<p><b>Si desea instalar una version inferior:</b></p>
<ol>
	<li>Crea una copia de seguridad de FAQs existentes, las categorías y FAQs a tablas de las categorías de la base de datos . El nombre de base de datos es "<i>%s</i>"</li>
	<li>Elimine todas las tablas de osFaq de la base de datos. El nombres de las tablas de osFaq empiezan por "<i>%s</i>"</li>
	<li>Ejecutar el programa de instalación de nuevo desde el principio <a href="index.php">REINICIAR EL INSTALADOR</a>.</li>
	<li>Vuelva a insertar los datos de la FAQs en la base de datos inferior.</li>
</ol>');

define('OSFI_INTRO_V_DETECTED', '%s detectado.');
define('OSFI_INTRO_UPG_TO', 'Actualiza osFaq de v%s a v%s');

define('OSFI_INTRO_ALREADY_INSTALLED', '<h3>la v%s de osFaq ya esta instalada.</h3>
<p>Parece que ya tiene esta versión instalada. Usted puede optar por instalar la aplicación, pero se advierte que perderá las preguntas frecuentes de su instalación de osFaq existentes a menos que hagas primero una copia de seguridad de tu base de datos.<br />
El nombre de base de datos es "<i>%s</i>"</p>');

define('OSFI_INTRO_INSTALL_V', 'Instalar v%s');

define('OSFI_INSTALLER_FOR', 'El instalador para');
define('OSFI_VERSION', 'version de osFaq  %s');
define('OSFI_OST_INSTALLER_FOR', 'Integración de destino');
define('OSFI_OST_VERSION', 'version de osTicket %s');
define('OSFI_DATABASE', 'Base de Datos');
define('OSFI_DB_PREFIX', 'Prefijo de la tabla de la base de datos');
define('OSFI_DB_PERMISSIONS', 'Permisos de bases de datos');
define('OSFI_DOMAIN', 'Servidor del Dominio');
define('OSFI_DOC_ROOT', 'Ruta Absoluta de DOCUMENT_ROOT');
define('OSFI_WEB_ROOT', 'Ruta Absoluta de WEB_ROOT');
define('OSFI_EDIT_DOC_ROOT', 'edita DOCUMENT_ROOT');
define('OSFI_EDIT_WEB_ROOT', 'edita WEB_ROOT');
define('OSFI_ROOT_PATH_NF', 'RUTA DEL ROOT NO ENCONTRADA');
define('OSFI_INTRO_LANG', 'Idioma');
define('OSFI_INTRO_LANG_RESET', 'Cambiar');

define('OSFI_OK', 'Ok');
define('OSFI_ERROR', 'Error');
define('OSFI_WARNING', 'Advertencia');

define('OSFI_MISSING_PERMS', 'Permisos que faltan');
define('OSFI_OST_SUPPORTED', 'Versión compatible');
define('OSFI_OST_NOT_SUPPORTED', 'Versión no compatible. Podría funcionar, pero las medidas de integración pueden variar de esta guía de instalación.');
?>
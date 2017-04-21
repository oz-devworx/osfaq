<?php
/* *************************************************************************
  Id: faq_settings.lang.php

  Language file for staff/faq_settings.inc.php


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSF_FS_ADDED', 'Añadido');
define('OSF_FS_DESCRIPTION', 'Descripciónn');
define('OSF_FS_KEY', 'Key');
define('OSF_FS_MODIFIED', 'Modificado');
define('OSF_FS_SETTING', 'Configuración');
define('OSF_FS_UPDATED', 'Valor Actualizado');
define('OSF_FS_VALUE', 'Valor');

define('OSF_LANG_NOT_FOUND', 'El idioma en el archivo de lenguaje SQL no se a encontrado en %s');
define('OSF_LANG_ROW_MISMATCH', 'Número incorrecto de filas en el archivo SQL.<br />Yo estaba esperando %s filas pero encontre %s filas.');
define('OSF_LANG_MISMATCH', 'El idioma en el archivo de lenguaje SQL no coincide con el nombre del idioma seleccionado.<br />El sistema volvera al indioma Inglés por ahora. Una vez que el SQL se corriga, vuelva a intentarlo.');
define('OSF_LANG_SQL_ERROR', 'Errores encontrados al procesar el esquema de la base de datos.<br />Por favor, revise sus registros de errores. Una vez corregido, inténtalo de nuevo.<br />También trate de usar phpMyAdmin para probar su SQL en una base de datos de prueba.');
define('OSF_LANG_UPDATED', 'Base de datos de traducciones actualizadas.');
define('OSF_LANG_SCHEMA_BAD', 'El archivo de esquema no parece tener el formato correcto.');
define('OSF_LANG_SCHEMA_EMPTY', 'El archivo de esquema está vacío o formateado incorrectamente.');
define('OSF_LANG_MISSING', 'Falta clave key');
define('OSF_LANG_DUPLICATE', 'Clave key Duplicada');
define('OSF_LANG_SCHEMA_IILEGAL', 'El archivo de esquema está tratando de usar SQL que no se permite. Solo %s y %s queries estan permitidas.');

define('OSF_FS_HTACCESS_INFO', 'Actualizar archivo .htaccess?<br />
	<br />
	<b>NOTE:</b> Actualización del archivo .htaccess sobrescribirá las entradas existentes en el archivo "%s" y el habilita el sistema de dirección de SEO, si está encendido (arriba).<br />
	<br />
	Para obtener más información, consulte las <a href="http://osfaq.oz-devworx.com.au/install.php" target="_blank">instrucciones de instalación</a>');

define('OSF_FS_HTACCESS_NOWRITE', '.htaccess no se a escrito en %s');
define('OSF_FS_HTACCESS_WRITE', '.htaccess escrito en (%s).<br />Por favor, cambie los permisos del archivo\'s a no escritura.');
define('OSF_FS_HTACCESS_NOT_EXIST', '.htaccess no existe. Por fafor crear uno en: "%s" y cambie los permisos de escritura para permitir su escritura.');
define('OSF_FS_HTACCESS_NOT_WRITEABLE', '.htaccess sin permisos de escritura. Por favor cambie los permisos: "%s"');

define('OSF_FS_SSL_NOT_INSTALLED', '<b>NOTE:</b> SSL no está instalado en este servidor este ajuste se ha deshabilitado por razones de seguridad.');
define('OSF_FS_SSL_INSTALLED', 'SSL parece estar instalado y funcionando en este servidor.');

define('OSF_FS_LANGUAGE', 'Idioma: ');
define('OSF_FS_TIMEZONE', 'Zona Horaria: ');
define('OSF_FS_WYSIWYG_THEME', 'Tema: ');

define('OSF_FS_HTACCESS_UPLOAD', 'Actualizar archivo .htaccess: %s');

define('OSF_RED', 'Rojo');
define('OSF_WHITE', 'Blanco');
define('OSF_BLACK_GLASS', 'Vidrio negro');
define('OSF_CLEAN', 'Limpio');
?>
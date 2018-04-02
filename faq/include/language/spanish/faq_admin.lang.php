<?php
/* *************************************************************************
  Id: faq_admin.lang.php

  Language file for osfaq_admin.php
  These constants are shared between more than one page


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */
// SHARED MAIN HEADINGS
define('OSF_PAGE_FAQ', 'Administración');
define('OSF_PAGE_FAQ_SETTINGS', 'Configuración');
define('OSF_PAGE_FAQ_MIGRATE', 'Importación y exportación');
define('OSF_PAGE_FAQ_UPLOADS', 'Gestor de Descarga');
define('OSF_PAGE_FAQ_SITEMAP', 'Mapa del Sitio xml');
define('OSF_PAGE_FAQ_VCHECK', 'Versión cheque');
define('OSF_PAGE_FAQ_VERSION', 'Versión');

// SHARED TOOLTIPS/BUTTON TEXT
define('OSF_TIP_CANCEL', 'Cancelar');
define('OSF_TIP_EDIT', 'Editar');
define('OSF_TIP_INSERT', 'Guardar');
define('OSF_TIP_INFO', 'Info');
define('OSF_TIP_BACK', 'Volver');
define('OSF_TIP_UPDATE', 'Actualizar');

// SHARED TEXT
define('OSF_TEXT_TOP', 'Nivel Superior');
define('OSF_Q', 'Q');
define('OSF_A', 'A');
define('OSF_EXISTS', 'existe');
define('OSF_WRITABLE', 'Inscribible');
define('OSF_NOT_WRITABLE', 'no se puede escribir');
define('OSF_NOT_EXIST', 'No Existe');
define('OSF_OF', ' de ');
define('OSF_CLIENT_DISABLED', 'El área de Preguntas Frecuentes del lado del cliente no está en línea en este momento.');
define('OSF_ERROR_FILE_NOT_SAVED', 'ERROR: No se pudo guardar el archivo!');
define('OSF_BYTES_WRITTEN', ' bytes escritos.');

// faq_admin.php ONLY
define('OSF_BACK_TO_OST', 'Volver a la Administración de Tickets');
define('OSF_WARN_DOC_DIR_WRITE', 'El Directorio upload no tiene permisos de escritura.<br>Cambie los permisos de escritura: ' . realpath(DIR_FS_DOC));
define('OSF_WARN_DOC_DIR_EXIST', 'El Directorio upload no existe.<br>Crea el Directorio en: ' . DIR_FS_DOC);
define('OSF_WARN_IMG_DIR_WRITE', 'El Directorio images upload no tiene permisos de escritura.<br>Cambie los permisos de escritura: ' . realpath(DIR_FS_IMAGES));
define('OSF_WARN_IMG_DIR_EXIST', 'El Directorio images upload no existe.<br>Crea el Directorio en: ' . DIR_FS_IMAGES);
define('OSF_WARN_SETUP_DIR', 'Es importante eliminar el directorio osFaq <code>setup</code> por razones de seguridad.<br /><code>' . realpath(OSF_DOC_ROOT . DIR_FS_WEB_ROOT . 'faq/setup/') . '</code>');
define('OSF_WARN_DB_VERSION', 'La version (%s) no coincide con la versión en la base de datos (%s). Por favor, asegúrese de que ha subido los archivos correctos y ejecute el asistente de instalación en:<br /><code>' . OSF_DOC_ROOT . DIR_FS_WEB_ROOT . 'faq/setup/</code>');


require_once('faq_paginator.lang.php');
?>
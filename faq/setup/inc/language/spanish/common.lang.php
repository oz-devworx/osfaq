<?php
/* *************************************************************************
  Id: common.lang.php

  Translation file for common elements shared across pages.


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('FAQ_TITLE', 'Preguntas Frecuentes para osTicket');

define('OSFI_HEAD_INDEX', 'osFaq Asistente de instalación');
define('OSFI_HEAD_INSTALL', 'osFaq Asistentes de instalaciones');
define('OSFI_HEAD_UPDATE', 'osFaq Asistente de actualización');

define('OSFI_MANUAL_PATHS', 'Manual de cofiguración de Ruta');
define('OSFI_REFRESH', 'Refrescar.');
define('OSFI_CONTINUE', 'Siguiente...');
define('OSFI_IMAGE', 'IMAGEN');
define('OSFI_STEP', 'Paso %s');
define('OSFI_IGNORE_AND_PROCEED', 'Ignore cualquier paso incompleto y continuar.');
define('OSFI_SKIP_FOR_NOW', 'Saltar este paso por ahora.');
define('OSFI_CHECK_AGAIN', 'Comprobar de nuevo');
define('OSFI_FAQS', 'Preguntas Frecuentes');

define('OSFI_ERROR_ENCOUTERED', '<h3>oops ... Me encontré con uno o más problemas y no puedo continuar en este momento</h3>
  <p>Por favor, corrija los problemas que se muestran a continuación, y despues haga clic en el botón para volver a intentarlo.</p>
  <p>%s</p>
  <p>Si tiene que mover esta carpeta para corregir el problema, por favor asegúrese de escribir la nueva ubicación en tu navegador web para reiniciar el instalador.</p>');

define('OSFI_RESTART_INSTALL', 'Reinicie la instalación');
define('OSFI_COPYRIGHT', 'Copyright &copy; %s osfaq.oz-devworx.com.au. Todos los Derechos Reservados. <a href="http://osfaq.oz-devworx.com.au/" target="_blank">osFaq</a> no está afiliado con <a href="http://osticket.com/" target="_blank">osTicket</a>.');


define('FAQ_GOOD', '<b style="color:green;">OK</b>: ');
define('FAQ_BAD', '<b style="color:red;">AUSENTE</b>: ');
define('FAQ_FATAL', '<b style="color:red;">ERROR FATAL </b>: ');

define('ERROR_FILES_MISSING', FAQ_FATAL . 'Por favor, compruebe que ha cargado todos los archivos de osFaq. Algunos parecen estar ausentes.');
define('ERROR_CANT_GET_PATH', FAQ_FATAL . 'Soy incapaz de resolver sus rutas de archivos (%s). Si tu instalación de osTicket esta funcionando bien, tendrá que modificar algunos archivos de forma manual para que osFaq funcione correctamente.<br />Por favor, informe de este error a los desarrolladores.');
define('ERROR_OST_SETTINGS', FAQ_FATAL . 'No se pudo cargar el archivo de configuración de osTicket. Por favor, asegúrate de que tienes instalado <a href="http://osticket.com/" target="_blank">osTicket >= 1.7</a>.');
define('ERROR_OSF_SETTINGS', FAQ_FATAL . 'No se pudo cargar el archivo de configuración de osFaq. Por favor, asegúrese de que ha cargado los archivos osFaq en las ubicaciones correctas.');
define('ERROR_CONNECTION', FAQ_FATAL . 'Póngase en contacto con el administrador del sistema.<br>No se puede conectar a la base de datos');
define('ERROR_BROKEN', FAQ_FATAL . 'El paquete que está intentando instalar parece estar roto o no se puede instalar en osTicket >= 1.7');
?>
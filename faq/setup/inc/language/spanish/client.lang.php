<?php
/* *************************************************************************
  Id: client.lang.php

  Translation file for client.inc.php and client_up.inc.php.


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFI_INS_TITLE', 'Integración Cliente');

define('OSFI_CLIENT_DELETE', 'Por favor, elimine: %s');

define('OSFI_CLIENT_COMPLETE', '<p>Tu area de <b>cliente</b> parece contener el código de integración requerido.</p>
	<p>Puede continuar Con seguridad con el siguiente paso .</p>');

define('OSFI_CLIENT_INTRO', '<p>Necesita integrar un código en su area de <b>cliente</b> para que los usuarios puedan acceder a su sistema de Preguntas Frecuentes.</p>
	<p>Los mensajes a continuación indican el estado de cada comprobación realizada.</p>');

define('OSFI_AN_EXAMPLE', 'Un Ejemplo:');
define('OSFI_EXAMPLE_IMPLEMENTATION', 'Este es un ejemplo de implementación:');

define('OSFI_FAQ_CLIENT_OK', 'El archivo de cliente %s está presente');
define('OSFI_FAQ_CLIENT_MISSING', 'Por favor, asegúrese de que el archivo de cliente es subido a su directorio osTicket como tal: %s');

//define('OSFI_FAQ_SUB_OK', 'El Archivo de envio del Cliente <code>' . FILE_FAQ_SUBMIT . '</code> está presente');
//define('OSFI_FAQ_SUB_MISSING', 'Por favor, asegúrese de que el archivo de envio del cliente es subido a su directorio osTicket como tal: <br /><code>' . DIR_FS_BASE . '<u>' . FILE_FAQ_SUBMIT . '</u></code>');

define('OSFI_STYLES_OK', 'La hoja de estilos base fue importada correctamente.<br />Editar: <code>' . DIR_FS_BASE . 'faq/styles/<u>faq.css</u>' . '</code><br />si desea cambiar la apariencia de las páginas del cliente o el modulo  de preguntas frecuentes destacadas.');
define('OSFI_STYLES_MISSING', 'La hoja de estilos base no parece haber sido importada en el archivo de cabecera del cliente.<br />Por Favor Edite <code>' . DIR_FS_BASE . 'include/client/header.inc.php' . '</code><br /> y añada la siguiente linea entre las etiquetas <code>&lt;head&gt;</code> y <code>&lt;/head&gt;</code>, preferiblemente debajo de las lineas de los otros estilos:');

//define('OSFI_NAV_MOD_OK', 'He encontrado un enlace a la zona de Preguntas Frecuentes en el archivo de cabecera del cliente.');
//define('OSFI_NAV_MOD_MISSING', 'No he podido encontrar un enlace a la zona de Preguntas Frecuentes en el archivo de cabecera del cliente.<br />Por Favor Edite <code>' . DIR_FS_BASE . 'include/client/header.inc.php' . '</code><br /> y añada la siguiente linea entre las etiquetas <code>&lt;ul id="nav"&gt;</code> and <code>&lt;/ul&gt;</code> , preferiblemente debajo de la linea My Tickets <code>ul</code> <br />(El enlace aparecera a la izquierda en el menu):');

define('OSFI_REQUIRE_OK', 'He encontrado una referencia de posición para las Preguntas Frecuentes destacadas en el archivo index de osTicket.');
define('OSFI_REQUIRE_MISSING', 'No he podido encontrar una referencia de posición para las Preguntas Frecuentes destacadas en el archivo index de osTicket.<br />Ponga esa linea en el lugar donde desea que las Preguntas Frecuentes destacadas se muestren.<br />El instalador / actualizador verificara la existencia de esta línea de código en <code>[tu-directorio-osTicket]/index.php</code>');
?>
<?php
/* *************************************************************************
  Id: faq_map.lang.php


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSF_SITEMAP_GENERATOR', 'Generador de Mapa del Sitio');

define('OSF_SITEMAP_RESULTS', OSF_SITEMAP_GENERATOR . ' Probando');
define('OSF_WORKING', 'En Curso... Espera.');

// for SEO links to the top level faq category
define('OSF_FAQ_PAGE', 'Preguntas Frecuentes');

/// common definitions
define('OSF_SITEMAP_ALT', 'Funciona con Google, Yahoo, Bing, Ask.com y otros');
define('OSF_SITEMAP_PING', 'Notificación instantanea a Google, Yahoo, Bing y Ask.com al Completar?');
define('OSF_SITEMAP_PING_RESULT', 'Los motores de búsqueda fueron informados de los cambios. Puedes ver los resultados más abajo:');

define('OSF_SITEMAP_OUTPUT', 'Salida a:');
define('OSF_APPEND_TO', 'Anexar a: ');

define('OSF_SITEMAP_LOCAL', 'Crear un archivo de mapa del sitio completo');
define('OSF_SITEMAP_OTHER', 'Añadir este árbol de mapa a un mapa existente');
define('OSF_SM_OTHER_OPT1', 'Añadir elementos a una <b>sitemap</b> existente');
define('OSF_SM_OTHER_OPT2', 'Guardar los resultados en un mapa nuevo y añade una referencia a él en un mapa ya existente <b>sitemap_index</b>.');
define('OSF_SITEMAP_TEST', 'Sólo quiero ver los resultados sin tener que escribir en un archivo');


//big one. This is the help information
define('OSF_SITEMAP_HELP', '
<b class="sm_alt_text">¿Qué es un mapa del sitio XML?</b>
<p>Un mapa del sitio XML es una herramienta de rastreo web diseñada para ayudar a los robots de indexación de los motores de búsqueda con la indexación de su sitio correctamente.<br />
Las especificaciones utilizadas por este sistema se puede encontrar en: <a href="http://www.sitemaps.org/protocol.php" target="_blank">http://www.sitemaps.org/protocol.php</a></p>

<b class="sm_alt_text">Notas importantes:</b>
<p>Si un mapa del sitio que desea escribir se marca como<b>"no existe"</b>, tendrá que crear el primero el archivo en el servidor y configurar sus permisos de escritura.</p>
<p>Si un mapa del sitio que desea escribir se marca como <b>"no se puede escribir"</b>, tendrá que configurar sus permisos de escritura.</p>

<b class="sm_alt_text">Uso:</b>
<p>Selecciona la <b>"' . OSF_SITEMAP_OUTPUT . '"</b> opción deseada.</p>
<p>Cada opción tiene diferentes requisitos que se mostrará después de seleccionar. Las opciones son:</p>
<ol>
  <li><b>"' . OSF_SITEMAP_LOCAL . '"</b> guardar un mapa del sitio completo en la ubicación seleccionada.</li>
  <li><b>"' . OSF_SITEMAP_OTHER . '"</b> añade los resultados de un mapa existente. Las opciones son:</li>
  <ul>
    <li>' . OSF_SM_OTHER_OPT1 . '</li>
    <li>' . OSF_SM_OTHER_OPT2 . '</li>
  </ul>
  <li><b>"' . OSF_SITEMAP_TEST . '"</b> escribe su salida a una ventana del navegador para realizar pruebas.<br />Nada se guarda en el disco.</li>
</ol>
<br />

<b class="sm_alt_text">Cómo aprovechar un archivo sitemap.xml:</b>
<ol>
  <li>Utilice la opción de notificación instantánea para notificar a Google, Yahoo!, Bing and Ask.com cuando se genera un mapa nuevo.</li>
  <li>Añadir una entrada al mapa del sitio en tu web <b>"robots.txt"</b> Vease en: <a href="http://www.sitemaps.org/protocol.php#informing" target="_blank">http://www.sitemaps.org/protocol.php#informing</a></li>
  <li>Crear una cuenta y monitorear el estado de mapas de sitio en<b>"Google Webmaster Tools"</b>. Vease en: <a href="https://www.google.com/webmasters/tools/" target="_blank">https://www.google.com/webmasters/tools/</a></li>
  <li>Crear una cuenta y monitorear el estado de mapas de sitio en <b>"Yahoo! Site Explorer"</b>. Vease en: <a href="http://siteexplorer.search.yahoo.com/" target="_blank">http://siteexplorer.search.yahoo.com/</a></li>
  <li>Crear una cuenta y monitorear el estado de mapas de sitio en <b>"Bing Webmaster Center"</b>. Vease en: <a href="http://www.bing.com/webmaster" target="_blank">http://www.bing.com/webmaster</a></li>
</ol>

<hr />
<span style="font-size:10px;color:#999999;">Notas al pie:<br />
Google&trade; es una marca comercial registrada de Google.<br />
Yahoo!&reg; es una marca comercial registrada de Yahoo<br />
Bing&trade; es una marca comercial registrada de Microsoft&trade;<br />
Ask.com&trade; es una marca comercial registrada de Ask.com.</span>
');


define('OSF_DESCRIPTION', 'Descripción:');
define('OSF_SM_DESCRIPTION', 'Ultima descripción del Mapa');

define('OSF_NEW_DESCRIPTION', 'El archivo debe existir y tener permisos de escritura completa. Cada archivo de la lista a continuación le indican su estado actual.
<br />Esta opción sobrescribe el archivo seleccionado cuando el mapa se genera.');


define('OSF_APD_DESCRIPTION', 'Esta opción añadirá los elementos de mapa de un mapa existente.
<br />Si decide añadir a un archivo de sitemap_index, se creara un mapa nuevo y una referencia a su archivo sitemap_index existentes.
<br />Sólo los mapas del sitio y los archivos sitemap_index seran listados. Esta comprobación se basa en las entradas que ya están dentro de los archivos. Archivos vacíos no se consideran válidos.');


define('OSF_TEST_DESCRIPTION', 'Esta opción no va a escribir o modificar los archivos. La salida se mostrará en una ventana del navegador.
<br />Se recomienda ejecutar esta opción primero si no ha ejecutado el SiteMapper antes. En el resultado será más fácil de ver si es necesario crear algun archivo en su servidor primero.');


define('OSF_INDEX_TEST', 'Este es el último mapa de una serie de %d.<br />
Los mapas de sitio en este set usan compresión gzip , pero se muestran en texto plano por lo que facilita su lectura aquí.<br />
Este conjunto también tiene un archivo sitemap_index.<br />
El sitemap_index contendrá una lista de URL para todos los mapas de sitio en esta serie y se muestra a continuación del ultimo mapa.<br />
Los resultados mostrados son indicativos para generar todos los archivos y el índice en este set.
<br /><br />
Los URLs del mapa utiliza URLs absolutas en los archivos actuales. Si los archivos no existen, se le informará para crearlos en el archivo index más debajo.<br />');


define('OSF_MAP_TEST', 'Los resultados mostrados son indicativos para generar el archivo actual.');

define('OSF_APD_TITLE', 'Opciones ligadas');
define('OSF_NEW_TITLE', 'Opciones de escritura');
define('OSF_MAPUI_TITLE', 'Ayuda para xml Sitemaps');
define('OSF_APD_NO_SITEMAP', 'No hay mapas válidos en este dominio.');
define('OSF_APD_NO_INDEX', 'No hay Sitemap_index válida en este dominio.');
define('OSF_STATISTICS', 'Estadísticas:');
define('OSF_ESTIMATED_RUNTIME', 'Duración estimada: %s segundos');
define('OSF_MEMORY_USAGE', 'Uso de la memoria: ');
define('OSF_URLS_WRITTEN', ' URLs escritas.');

define('OSF_SITEMAP_DEST', 'Destino Mapa del sitio');
define('OSF_SITEMAP_URL', 'URL Mapa del sitio:');
define('OSF_SITEMAP_CREATE', 'Generar mapa del sitio');
define('OSF_SITEMAP_WRITE', 'Último Escrito:');
define('OSF_SM_ENTRIES', 'Entradas Mapa del sitio:');
define('OSF_SM_LOCATION', 'Ubicación:');
define('OSF_SM_OUTPUT', 'Resultados Mapa del sitio:');


define('OSF_SITEMAP_SUCCESS', 'Mapa del sitio enviado exitosamente a "%s" ');
define('OSF_SITEMAP_SUCCESS_GZ', 'Las entradas del mapa escritas exitosamente en "%s" ');
define('OSF_SITEMAP_SUCCESS_IDX', 'Split-sitemaps comprimido y guardado. El archivo sitemap_index fue escrito exitosamente en "%s" ');

define('OSF_SITEMAP_ERROR_NO_SM', '%s No existe. Por favor, cree el archivo y cambie sus permisos a 777.');
define('OSF_SITEMAP_ERROR_RESTRICTED', '%s no es accesible. Por favor, cambie sus permisos a 777.');
define('OSF_SITEMAP_ERROR', 'ERROR: se a encontrado un problema escribiendo a "%s".');
define('OSF_SITEMAP_ERROR_OUTPUT', 'Algo ha salido mal? Lo sentimos. Si el error persiste, por favor haga un informe de error (bug) a través de: <a href="http://sourceforge.net/projects/osfaq/support" target="_blank">http://sourceforge.net/projects/osfaq/support</a>');
?>
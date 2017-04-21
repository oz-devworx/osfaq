<?php
/* *************************************************************************
  Id: faq_upload_man.lang.php

  Language file for staff/faq_upload_man.inc.php


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */


// opening text
define('OSF_ACTIONS', 'A continuación se muestra una lista de las acciones de limpieza que se llevaron a cabo.');

define('OSF_EXPLAIN', '<p>Esta página le permitirá eliminar las imágenes y los documentos que ha subido, pero ya no se utilizan en su FAQ.</p>
<p>A continuación se muestra una lista de archivos válidos y los archivos no utilizados que se quitará si continúa con el siguiente paso.</p>
<p>Por favor, compruebe que no hay archivos válidos marcados para su eliminación. Si no esta seguro, podría ser una buena idea hacer primero una copia de seguridad de sus imagenes existente y carpetas de documentos.</p>
<p>Las carpetas se encuentran en:<br />
<code>' .DIR_FS_IMAGES. '</code><br />
y<br />
<code>' .DIR_FS_DOC. '</code></p>');


// buttons
define('OSF_FINISHED', 'Terminado');
define('OSF_AGAIN', 'Comprobar de nuevo');
define('OSF_CANCEL', 'Cancelar');
define('OSF_PERFORM', 'Realizar la limpieza');

// main headings
define('OSF_IMAGES', 'FAQ Imagenes');
define('OSF_DOCS', 'FAQ Documentos');

// minor headings
define('OSF_IMG_VALID', 'Imagenes Validas');
define('OSF_IMG_TO_DEL', 'Imagenes Marcadas para su Eliminación');
define('OSF_IMG_VALID_UNALTERED', 'Imagenes Validas Inalteradas');
define('OSF_IMG_DELETED', 'Imagenes Eliminadas');

define('OSF_DOC_VALID', 'Documentos Validos');
define('OSF_DOC_TO_DEL', 'Documentos Marcados para su Eliminación');
define('OSF_DOC_VALID_UNALTERED', 'Documentos Validos Inalterados');
define('OSF_DOC_DELETED', 'Documentos Eliminados');

// appended text
define('OSF_DAMAGED_NAME', 'Nombre de archivo Corrupto');
define('OSF_REMOTE_OR_MISSING', 'Archivo remoto o Faltante');
?>
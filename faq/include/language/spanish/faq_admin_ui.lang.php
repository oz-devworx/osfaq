<?php
/* *************************************************************************
  Id: faq_admin_ui.lang.php

  Language file for staff/faq_admin_ui.inc.php


  Spanish Translation provided by Francisco Flores 2011

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSF_MAIN_TITLE', 'Preguntas Frecuentes');

// TOOLTIPS/BUTTON TEXT
define('OSF_TIP_FOLDER', 'Carpeta de Categoria');
define('OSF_TIP_PREVIEW', 'Previsualización ');
define('OSF_TIP_COPY', 'Copia');
define('OSF_TIP_COPY_TO', 'Copiar a');
define('OSF_TIP_DELETE', 'Eliminar');
define('OSF_TIP_MOVE', 'Mover');
define('OSF_TIP_NEW_CAT', 'Nueva Categoria');
define('OSF_TIP_NEW_FAQ', 'Nueva Pregunta Frecuente');
//define('OSF_TIP_STATUS_GREEN', 'Activo');
define('OSF_TIP_STATUS_GREEN_LIGHT', 'Activar');
//define('OSF_TIP_STATUS_RED', 'Desactivado');
define('OSF_TIP_STATUS_RED_LIGHT', 'Desactivar');
define('OSF_TIP_CLIENT_ENTRY', 'Entrada de cliente presentado');

define('OSF_EMPTY_CATEGORY', 'Categoria Vacia');

define('OSF_ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: No se pueden enlazar en la misma categoría.');
define('OSF_ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT', 'Error: La categoría no se puede mover dentro de la categoría hija.');


define('OSF_HEAD_AUTHOR_DETAIL', 'Detalles del Autor');
define('OSF_HEAD_FAQ_DETAIL', 'Detalles de la Pregunta Frecuente');
define('OSF_HEAD_NO_SELECTION', 'Nada seleccionado');
define('OSF_HEAD_TITLE_GOTO', 'Ir a:');
define('OSF_HEAD_TITLE_SEARCH', 'Buscar:');
define('OSF_HEAD_ACTION', 'Accion');
define('OSF_HEAD_CATS_FAQS', 'Preguntas Frecuentes');
define('OSF_HEAD_FEATURED', 'Función');
define('OSF_HEAD_INFO_EDIT_CATEGORY', 'Editar Categoria en [ %s ]');
define('OSF_HEAD_INFO_MOVE_CATEGORY', 'Mover Categoria');
define('OSF_HEAD_INFO_MOVE_FAQ', 'Mover Pregunta Frecuente');
define('OSF_HEAD_INFO_NEW_CATEGORY', 'Nueva Categoria en [ %s ]');
define('OSF_HEAD_STATUS', 'Estado');
define('OSF_HEAD_INFO_COPY_TO', 'Copiar a');
define('OSF_HEAD_INFO_DELETE_CATEGORY', 'Eliminar Categoria');
define('OSF_HEAD_INFO_DELETE_FAQ', 'Eliminar Pregunta Frecuente');
define('OSF_HEAD_VIEWS', 'Vistas');
define('OSF_HEAD_SORT_ASC', 'Ordenar Ascendente');
define('OSF_HEAD_SORT_DESC', 'Ordenar Descendente');

define('OSF_ANY_STATUS', 'Cualquier Status');


define('OSF_NESTED_VIEW', 'Ver Nested');
define('OSF_FLAT_VIEW', 'Vista Plana');
define('OSF_SHOW_BOTH', 'Mostrar ambos');
define('OSF_CATS', 'Categorías');
define('OSF_FAQS', 'FAQs');
define('OSF_CLEAR_FILTERS', 'Restablecer Filtros');
define('OSF_SELECT_TO_REMOVE', 'Seleccione esta opción para eliminar:');

define('OSF_CAT_NAME', 'Nombre Categoría:');
define('OSF_CAT_PARENT', 'Categoría Superior:');
define('OSF_CATEGORIES', 'Categorias Pregunta Frecuente:');
define('OSF_CAT_MOVED', 'Categoría Movido');
define('OSF_CLEAR_SEARCH', 'Limpiar Busqueda');
define('OSF_COPY_AS_DUPLICATE', 'Duplicar Pregunta Frecuente');
define('OSF_COPY_AS_LINK', 'Enlazar Pregunta Frecuente');
define('OSF_DATE_ADDED', 'Fecha Añadida: ');

define('OSF_CAT_REMOVED', 'Eliminado de la categoría FAQ %s');
define('OSF_FAQ_REMOVED_FROM_ALL', 'Ha retirado este FAQ de todas las categorías, así que dejó una copia en la categoría base. Si usted desea eliminarla o desactivarla puedes hacerlo desde su nuevo hogar.');


define('OSF_DELETE_CAT_INTRO', '¿Está seguro que desea eliminar esta categoría?');
define('OSF_DELETE_FAQ_INTRO', '¿Está seguro que desea eliminar permanentemente esta Pregunta Frecuente?');
define('OSF_DELETE_WARNING_CHILDS', '<b>ADVERTENCIA:</b> Hay %s (child-)categorias enlazadas a esta categoria!');
define('OSF_DELETE_WARNING_FAQS', '<b>ADVERTENCIA:</b> Hay %s Preguntas Frecuentes enlazadas a esta categoria!');
define('OSF_DISABLED', 'Desactivado');
define('OSF_DOCUMENT_UPLOAD', 'Los archivos de documento se mostrará en la parte inferior de las respuestas de las Preguntas Frecuentes.');
define('OSF_EDIT_FAQ', 'Editar Preguntas Frecuentes');
define('OSF_ENABLED', 'Activo');
define('OSF_FAQ_ANSWER', 'Respuesta:');
define('OSF_FAQ_AUTHOR', 'Nombre Autor:');
define('OSF_FAQ_AVAILABLE', 'Activo');
define('OSF_DATE_ADDED', 'Añadido en la fecha: ');
define('OSF_FAQ_EMAIL', 'Email del Autor:');
define('OSF_NOT_AVAILABLE', 'Desactivado');
define('OSF_DOCUMENT', 'Documento: ');
define('OSF_FAQ_PHONE', 'Telefono Autor:');
define('OSF_QUESTION', 'Pregunta:');
define('OSF_FAQS', 'Preguntas Frecuentes:');
define('OSF_STATUS', 'Status:');
define('OSF_FREE_BROWSE_MODE', 'No se pueden crear Categorias o Preguntas Frecuentes<br />estando en el modo<br />SHOW-ALL.');
define('OSF_HOW_TO_COPY', 'Metodo de Copia:');
define('OSF_INFO_COPY_TO_INTRO', 'Por favor, elija una categoría donde desea copiar esta Pregunta Frecuente');
define('OSF_INFO_CURRENT_CATEGORIES', 'Categorias Actuales:');

define('OSF_TEXT_IMAGES', 'Subir Imagen');
define('OSF_IMAGE_UPLOADS', 'Cargador Conveniente de archivos de imágenes en línea.<br /><ol>  <li>Subir Imagen/es usando <b>el boton</b> Subir Imagen.</li>  <li>Arrastre la miniatura (a la derecha) en su documento (arriba).</li>  <li>Para editar los atributos de imagen, haga doble clic en la imagen en el documento (arriba).</li>  <li>Para ver las imágenes que has subido, haga clic en el icono ver-imagen.</li> </ol>');
define('OSF_UPLOAD', 'Subir');
define('OSF_VALID_TYPES', 'Tipo de Extensiones Validas: ');
define('OSF_TYPES_ALLOWED', 'Solo JPG, PNG o GIF estan permitidos');
define('OSF_UPLOADING', 'Subiendo...');
define('OSF_FAILED', 'Subida Fallida');
define('OSF_IMAGE_BROWSE', 'Mirar imagenes');
define('OSF_NO_IMAGE', 'No hay imágenes');
define('OSF_ITEMS_TOTAL', 'Artículos %s visualiza');
define('OSF_ITEMS_OF_TOTAL', '%s a %s (%s artículos de la visualiza)');

define('OSF_LAST_MODIFIED', 'Ultima Modificada: ');
define('OSF_TEXT_MOVE', 'Mover <b>%s</b> a:');
define('OSF_INTRO_MOVE_CATEGORIES', 'Por favor, seleccione la categoría donde desea que <b>%s</b> sea alojada');
define('OSF_MOVE_FAQS_INTRO', 'Por favor, seleccione la categoría donde desea que <b>%s</b> sea alojada');
define('OSF_HEAD_NEW_FAQ', 'Nueva Pregunta Frecuente');
define('OSF_NO_CHILDS', 'Por favor, introduzca una nueva categoría o preguntas frecuentes en este nivel.');
define('OSF_TEXT_PRIVATE', ' <i>(privado)</i>');
define('OSF_TEXT_PUBLIC', ' <i>(publico)</i>');
define('OSF_REMOVE_DOC', ' Marque aquí para quitar el documento');
define('OSF_SELECT_A_ROW', 'Por favor, seleccione una fila');
define('OSF_SHOW_ALL', 'Mostrar todos:');
define('OSF_SUBCATEGORIES', 'Subcategorias de Preguntas Frecuentes:');
define('OSF_INFO_TOP', 'Preguntas Frecuentes se pueden agregar a cualquier subcategoría de <b>' . OSF_TEXT_TOP . '</b>.');
define('OSF_INFO_SEARCH', 'Preguntas Frecuentes nuevas pueden\no pueden ser añadida a los resultados de la busqueda. Borra tu búsqueda y ve a una categoría para añadir nuevas categorías o Preguntas Frecuentes.');
define('OSF_DOC_FOR_REMOVAL', 'Marcados para la eliminación');
define('OSF_DOC_FOR_UPLOAD', 'Listo para descargar');
define('OSF_BTN_YES', 'Si');
define('OSF_BTN_NO', 'No');

define('OSF_WARN_QUESTION_EMPTY', 'El campo PREGUNTA debe contener al menos un carácter.<br />Pulse el botón VOLVER para hacer cambios.');
define('OSF_WARN_ANSWER_EMPTY', 'El campo de respuesta debe contener al menos un carácter.<br />Pulse el botón VOLVER para hacer cambios.');
define('OSF_WARN_CAT_EMPTY', 'Por favor, compruebe los campos del formulario siguiente y vuelva a intentarlo.\n\n* Se requiere un nombre de categoría. Min 2 caracteres\n');
define('OSF_DOCUMENT_UPLOAD_TEXT', 'Enlace Texto');
define('OSF_FILTER_TAB', 'Filtrar');

define('OSF_ERROR_NOT_UPLOADED', '%s no se ha subido correctamente');
define('OSF_ERROR_TOO_LARGE', '%s era demasiado grande, no cargado');
define('OSF_ERROR_INVALID_EXTENSION', '%s tenía una extensión de archivo no válido, no cargado');
define('OSF_SUCCESS_FILE_UPLOADED', 'Archivo: %s cargadas!');
?>
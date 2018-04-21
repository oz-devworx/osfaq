<?php
/* *************************************************************************
 Id: FaqForm.php

 Convenience class for generating form compnents.


 Tim Gall
 Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
 http://osfaq.oz-devworx.com.au

 This file is part of osFaq.

 Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
 For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

 ************************************************************************* */

class FaqForm {

  public static $tfRequired;

  /**
   * FaqForm::__construct()
   *
   * @return
   */
  function __construct() {
    $tfRequired = ' <b style="color:red;">*</b>';
    self::ckedit_init();
  }

  /**
   * Outputs a form button
   *
   * @param string $text - Visible button text
   * @param string $button_icon - [optional] icon class/s to use with link
   * @param string $params - additional params to be included in the button tag
   * @param string $position - [default is left] left or right
   * @param string $button_class - [optional] for custom button classes
   * @return string styled form submit button
   */
  function submit_css($text, $button_icon = '', $params = '', $position = 'left', $button_class = 'osf_button') {

  	$text = FaqFuncs::output_string($text);

  	$image_submit = '<button type="submit" class="' . $button_class . '"';

  	if (FaqFuncs::not_null($params)) $image_submit .= ' ' . $params;

  	$image_submit .= '>';

    if($position == 'right') $image_submit .= $text;

    if(FaqFuncs::not_null($button_icon)) $image_submit .= ' <i class="' . $button_icon . '"></i> ';

    if($position == 'left') $image_submit .= $text;

    $image_submit .= '</button>';

    return $image_submit;
  }

  /**
   * Outputs a button suitable for wrapping with a link.
   *
   * @param string $text - Visible button text
   * @param string $button_icon - [optional] icon class/s to use with link
   * @param string $params - additional params to be included in the button tag
   * @param string $position - [default is left] left or right
   * @param string $button_class - [optional] for custom button classes
   * @return string styled form submit button
   */
  function button_css($text, $button_icon = '', $params = '', $position = 'left', $button_class = 'osf_button') {

  	$text = FaqFuncs::output_string($text);

  	$button = '<i class="' . $button_class . '"';

    if (FaqFuncs::not_null($params)) $button .= ' ' . $params;

    $button .= '>';

    if($position == 'right') $button .= $text;

    if(FaqFuncs::not_null($button_icon)) $button .= ' <i class="' . $button_icon . '"></i> ';

    if($position == 'left') $button .= $text;

    $button .= '</i>';

    return $button;
  }

  /**
   * Return a form opening tag
   *
   * @param mixed $name
   * @param mixed $action
   * @param string $parameters
   * @param string $method
   * @param string $params
   * @param string $link_type
   * @return
   */
  function form_open($name, $action, $parameters = '', $method = 'post', $params = '', $link_type = 'NONSSL') {
  	global $osfAdapter;

    $form = '<form id="' . FaqFuncs::output_string($name) . '" action="';

    // added ssl failsafe to form urls
    if (getenv('HTTPS') == 'on') {
      $link_type = 'SSL';
    }

    $form .= FaqFuncs::format_url($action, $parameters, $link_type);
    $form .= '" method="' . FaqFuncs::output_string($method) . '"';
    if (FaqFuncs::not_null($params)) {
      $form .= ' ' . $params;
    }
    $form .= '>';

    // form verification systems
    $form .= $osfAdapter->form_check_code();

    return $form;
  }

  function form_close(){
  	return '</form>' . PHP_EOL;
  }

  /**
   * Output a form input field
   *
   * @param mixed $name
   * @param string $value
   * @param string $parameters
   * @param bool $required
   * @param string $type
   * @param bool $reinsert_value
   * @return
   */
  function input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
    $field = '';

    $field .= '<input type="' . FaqFuncs::output_string($type) . '" name="' . FaqFuncs::output_string($name) . '" id="' . FaqFuncs::output_string($name) . '"';
    if (isset($_GET[$name]) && ($reinsert_value == true) && is_string($_GET[$name])) {
      $field .= ' value="' . FaqFuncs::output_string(stripslashes($_GET[$name])) . '"';
    } else
    if (isset($_POST[$name]) && ($reinsert_value == true) && is_string($_POST[$name])) {
      $field .= ' value="' . FaqFuncs::output_string(stripslashes($_POST[$name])) . '"';
    } else
    if (FaqFuncs::not_null($value)) {
      $field .= ' value="' . FaqFuncs::output_string($value) . '"';
    }
    if (FaqFuncs::not_null($parameters))
    $field .= ' ' . $parameters;
    $field .= '>';

    if ($required == true)
    $field .= FaqForm::$tfRequired;

    return $field;
  }

  /**
   * Output a selection field - alias function for checkbox_field() and radio_field()
   *
   * @param mixed $name
   * @param mixed $type
   * @param string $value
   * @param bool $checked
   * @param string $compare
   * @param string $parameter
   * @return
   */
  function selection_field($name, $type, $value = '', $checked = false, $compare = '', $parameter = '') {
    $selection = '<input type="' . $type . '" name="' . $name . '" id="' . $name . '"';
    if ($value != '') {
      $selection .= ' value="' . $value . '"';
    }
    if (($checked == true) || ($_GET[$name] == 'on') || ($value && ($_GET[$name] == $value)) || ($value && ($value == $compare))) {
      $selection .= ' checked="checked"';
    } else
    if (($checked == true) || ($_POST[$name] == 'on') || ($value && ($_POST[$name] == $value)) || ($value && ($value == $compare))) {
      $selection .= ' checked="checked"';
    }
    if ($parameter != '') {
      $selection .= ' ' . $parameter;
    }
    $selection .= '>';
    return $selection;
  }

  /**
   * Output a form checkbox field
   *
   * @param mixed $name
   * @param string $value
   * @param bool $checked
   * @param string $compare
   * @param string $parameter
   * @return
   */
  function checkbox_field($name, $value = '', $checked = false, $compare = '', $parameter = '') {
    return $this->selection_field($name, 'checkbox', $value, $checked, $compare, $parameter);
  }

  /**
   * Output a form radio field
   *
   * @param mixed $name
   * @param string $value
   * @param bool $checked
   * @param string $compare
   * @param string $parameter
   * @return
   */
  function radio_field($name, $value = '', $checked = false, $compare = '', $parameter = '') {
    return $this->selection_field($name, 'radio', $value, $checked, $compare, $parameter);
  }

  /**
   * Output a form textarea field
   *
   * @param mixed $name
   * @param mixed $wrap
   * @param mixed $width
   * @param mixed $height
   * @param string $text
   * @param string $parameters
   * @param bool $reinsert_value
   * @return
   */
  function textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . FaqFuncs::output_string($name) . '" id="' . FaqFuncs::output_string($name) . '" wrap="' . FaqFuncs::output_string($wrap) . '" cols="' . FaqFuncs::output_string($width) . '" rows="' . FaqFuncs::output_string($height) . '"';
    if (FaqFuncs::not_null($parameters))
    $field .= ' ' . $parameters;
    $field .= '>';
    if ((isset($_GET[$name])) && ($reinsert_value == true)) {
      $field .= stripslashes($_GET[$name]);
    } else
    if ((isset($_POST[$name])) && ($reinsert_value == true)) {
      $field .= stripslashes($_POST[$name]);
    }
    $field .= $text;
    $field .= '</textarea>';

    return $field;
  }

  /**
   * Initialise the text area editor if enabled
   */
  function ckedit_init(){
  	if( (OSFDB_WYSIWYG_STAFF=='true') || (OSFDB_WYSIWYG_CLIENT=='true') ){
  		include(DIR_WS_REL_ROOT.'faq/ckeditor/'.FAQ_CK_VERSION.'/ckeditor_php5.php');
  	}
  }

  /**
   * return a WYSIWYG editor if enabled in admin; otherwise return a textarea.
   *
   * Renders at the spot it is called from unless $return is set
   * in which case it will be returned as a string.
   *
   * @param string $name
   * @param integer $width - can be whole integer for px or include % symbol for % of parent width
   * @param integer $height
   * @param string $text
   * @param string $tbar - toolbar
   * @param boolean $return - return as string. Defaults to direct output.
   * @param string $theme - the theme to use for this editors skin
   * @param string $lang_code [optional]
   * @param string $lang_direction [optional]
   * @return string A html WYSIWYG editor ready to use
   */
  function editor_field($name, $width, $height, $text, $tbar = '', $return = false, $theme = '', $lang_code = OSF_LANG_CODE, $lang_direction = OSF_LANG_DIRECTION) {

  	if($tbar=='Client'){
  		$config['toolbar'] = array(
  				array( 'Source','-','Maximize','-','Cut','Copy','Paste','PasteText','PasteFromWord','-','RemoveFormat','SpecialChar','-','Find','Replace','-','Undo','Redo' ),
  				array( 'Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','Link','Unlink','Anchor','-','BulletedList','NumberedList','-','Indent','Outdent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','HorizontalRule' ),
  		);
  	}

  	// theme can be changed from settings admin page
  	$config['skin'] = ( is_dir( OSF_DOC_ROOT . DIR_FS_WEB_ROOT . 'faq/ckeditor/' . FAQ_CK_VERSION . '/skins/' . $theme) ? $theme : 'moono');


  	$config['width'] = $width;
  	$config['height'] = $height;
  	$config['baseHref'] = HTTP_SERVER . DIR_FS_WEB_ROOT;
  	$config['bodyId'] = 'faqs';
  	$config['bodyClass'] = 'answer';
  	$config['contentsCss'] = array(DIR_FS_WEB_ROOT . 'faq/styles/faq.css', DIR_FS_WEB_ROOT . 'faq/styles/wysiwyg_edit.css');

  	$config['language'] = $lang_code;
  	$config['defaultLanguage'] = $lang_code;
  	$config['contentsLanguage'] = $lang_code;
  	$config['contentsLangDirection'] = $lang_direction;


  	$CKEditor = new CKEditor();
  	$CKEditor->basePath = DIR_FS_WEB_ROOT.'faq/ckeditor/'.FAQ_CK_VERSION.'/';
  	$CKEditor->returnOutput = $return;

  	return $CKEditor->editor($name, $text, $config);
  }

  /**
   * Output a form hidden field
   *
   * @param mixed $name
   * @param string $value
   * @param string $parameters
   * @return
   */
  function hidden_field($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" name="' . FaqFuncs::output_string($name) . '"';
    if (FaqFuncs::not_null($value)) {
      $field .= ' value="' . FaqFuncs::output_string($value) . '"';
    } else
    if (isset($_GET[$name]) && is_string($_GET[$name])) {
      $field .= ' value="' . FaqFuncs::output_string(stripslashes($_GET[$name])) . '"';
    } else
    if (isset($_POST[$name]) && is_string($_POST[$name])) {
      $field .= ' value="' . FaqFuncs::output_string(stripslashes($_POST[$name])) . '"';
    }
    if (FaqFuncs::not_null($parameters))
    $field .= ' ' . $parameters;
    $field .= '>';
    return $field;
  }

  /**
   * Output a form pull down menu
   *
   * @param mixed $name
   * @param mixed $values
   * @param string $default
   * @param string $parameters
   * @param bool $required
   * @return
   */
  function pulldown_menu($name, $values, $default = '', $parameters = '', $required = false) {
    $field = '<select name="' . FaqFuncs::output_string($name) . '" id="' . FaqFuncs::output_string($name) . '"';
    if (FaqFuncs::not_null($parameters)) {
      $field .= ' ' . $parameters;
    }
    $field .= '>';
    if (empty($default) && isset($_GET[$name])){
      $default = stripslashes($_GET[$name]);
    }elseif (empty($default) && isset($_POST[$name])) {
      $default = stripslashes($_POST[$name]);
    }

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
      $field .= '<option value="' . FaqFuncs::output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' selected="selected"';
      }
      $field .= '>' . FaqFuncs::output_string($values[$i]['text']) . '</option>';
    }
    $field .= '</select>';
    if ($required == true){
      $field .= FaqForm::$tfRequired;
    }
    return $field;
  }

}
?>
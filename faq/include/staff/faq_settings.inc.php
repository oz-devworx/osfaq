<?php
/* *************************************************************************
 Id: faq_settings.inc.php

 The FAQ settings admin page.
 Most functionality for this file is handled by this file.
 This page is accessed from faq_admin.php
 Only Admins can access this page.


 Tim Gall
 Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
 http://osfaq.oz-devworx.com.au

 This file is part of osFaq.

 Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
 For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

 ************************************************************************* */

// this page is only for admins
if(!$osf_isAdmin){
  FaqFuncs::redirect(FaqFuncs::format_url(FILE_FAQ_ADMIN, '', 'SSL'));
}

// LANGUAGE FILE
require_once(DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_settings.lang.php');

require_once (DIR_FAQ_INCLUDES . 'FaqSettings.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
if ($action=='save_setting') {

  $fsID = db_input($_POST['fsID'], false);

  $saveArray = array('key_value' => db_input($_POST['key_value'], false),
                     'last_modified' => 'now()');

  $sqle->db_compile(TABLE_FAQ_SETTINGS, $saveArray, FaqSQLExt::$UPDATE, 'id='.$fsID);

  $messageHandler->addNext(OSF_FS_UPDATED, FaqMessage::$success);

  //if the setting was language, also refresh the db lang table
  if(isset($_POST['refresh_db_lang'])){
    //language update class
    require_once(DIR_FAQ_INCLUDES . 'FaqLangUpdate.php');
    FaqLangUpdate::updateDbLang($saveArray['key_value']);
  }elseif(isset($_POST['write_to_file'])){
    FaqSettings::updateHtaccessFile(($_POST['key_value']=='false'));
  }elseif(isset($_POST['hta_limits'])){
    FaqSettings::updateHtaccessUpoadLimits();
  }

  FaqFuncs::redirect(FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&fsID=' . $fsID, 'SSL'));
}




if ($messageHandler->size() > 0) echo $messageHandler->output();
?>
<h1><?php echo OSF_PAGE_FAQ_SETTINGS; ?></h1>
<table cellpadding="0" cellspacing="4" width="100%">
	<tr>
		<td valign="top">
		<table cellpadding="2" cellspacing="0" width="100%" class="list">
			<tr>
				<th><?php echo OSF_FS_SETTING; ?></th>
				<th><?php echo OSF_FS_VALUE; ?></th>
				<th><?php echo OSF_FS_MODIFIED; ?></th>
				<th><?php echo ACTION; ?></th>
			</tr>
			<?php
			$selectColumns = array('fs.id', 'fs.key_name', 'fs.key_value', 'fs.field_type', 'fsl.title', 'fsl.description', 'fs.date_added', 'fs.last_modified');


			$langQuery = db_query("select settings_key from " . TABLE_FAQ_SETTINGS_LANG . " where language = '".OSFDB_DEFAULT_LANG."'");
			if(db_num_rows($langQuery) > 0){
			  $queryLang = OSFDB_DEFAULT_LANG;
			}else{
			  $queryLang = 'english';//default if no specified lang rows exist
			}

			$faqConfigQuery = $sqle->db_compile(TABLE_FAQ_SETTINGS . ' fs left join ' . TABLE_FAQ_SETTINGS_LANG . ' fsl on(fs.key_name=fsl.settings_key)', $selectColumns, FaqSQLExt::$SELECT, "fsl.language='".$queryLang."'", '', 'sort_order ASC');

			if(db_num_rows($faqConfigQuery)==0){
			  //language update class
			  require_once(DIR_FAQ_INCLUDES . 'FaqLangUpdate.php');
			  //make sure at least one language is installed
			  FaqLangUpdate::dbLangCheck();

			  FaqFuncs::redirect(FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&fsID=1', 'SSL'));
			}

			while ($faqConfig = db_fetch_array($faqConfigQuery)) {

			  if($faqConfig['field_type']=='heading'){

			    echo '        <tr>' . "\n";
			    echo '        	<th colspan="4">'.$faqConfig['title'].'</th>' . "\n";
			    echo '        </tr>' . "\n";

			  }else{

			    if ( (!isset($_GET['fsID']) || (isset($_GET['fsID']) && ($_GET['fsID'] == $faqConfig['id']))) && !isset($fsInfo)) {
			      $fsInfo = new FaqArrayData($faqConfig);
			    }

			    if ( isset($fsInfo) && is_object($fsInfo) && ($faqConfig['id'] == $fsInfo->id) ) {
			      echo '        <tr class="osf_active" onclick="document.location.href=\'' . FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&action=edit_setting&fsID=' . $faqConfig['id']) . '\'">' . "\n";
			    } else {
			      echo '        <tr onclick="document.location.href=\'' . FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&fsID=' . $faqConfig['id']) . '\'">' . "\n";
			    }

			    // prep value preview text
			    $key_value_preview = strip_tags($faqConfig['key_value']);
			    if(strlen($key_value_preview) > 20){
			      $key_value_preview = substr($key_value_preview, 0, 17).'...';
			    }
			    if($faqConfig['field_type']=='textfield'){
			      if(FaqFuncs::not_null($color_preview = FaqSettings::is_string_a_color($key_value_preview))){
			        $key_value_preview = $color_preview;
			      }
			    }

			    echo '        	<td>'.$faqConfig['title'].'</td>' . "\n";
			    echo '        	<td>'. (FaqFuncs::not_null($key_value_preview) ? $key_value_preview : '&nbsp;') .'</td>' . "\n";
			    echo '        	<td>'.( (FaqFuncs::not_null($faqConfig['last_modified']) && $faqConfig['last_modified']!='0000-00-00 00:00:00') ? FaqFuncs::format_date($faqConfig['last_modified']) : 'never' ).'</td>' . "\n";


			    if ( isset($fsInfo) && is_object($fsInfo) && ($faqConfig['id'] == $fsInfo->id) ) {
			      echo '        	<td align="right">' . '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&action=edit_setting&fsID=' . $faqConfig['id']) . '">' . '<i class="'.OSF_ICON_ARROW_RIGHT.'" title="'.OSF_TIP_EDIT.'"></i>' . '</a>' . '&nbsp;</td>' . "\n";
			    } else {
			      echo '        	<td align="right">' . '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&action=edit_setting&fsID=' . $faqConfig['id']) . '">' . '<i class="'.OSF_ICON_EDIT.'" title="'.OSF_TIP_EDIT.'"></i>' . '</a>' . '&nbsp;</td>' . "\n";
			    }

			    echo '        </tr>' . "\n";
			  }

			}
			?>
		</table>
		</td>
		<?php

		if(isset($fsInfo)){
		  $heading = '';
		  $contents = array();

		  switch($action){


		    case 'edit_setting':
		      $heading = '<b>' . $fsInfo->title . '</b>';

		      $contents[] = array('form' => $faqForm->form_open('faq_settings', FILE_FAQ_ADMIN, 'settings=true&action=save_setting') . $faqForm->hidden_field('fsID', $fsInfo->id));

		      $contents[] = array('align' => 'center', 'text' => $faqForm->submit_css(OSF_TIP_INSERT, OSF_ICON_SAVE) .
		      	' <a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&fsID=' . $fsInfo->id) . '">' . $faqForm->button_css(OSF_TIP_CANCEL, OSF_ICON_CANCEL) . '</a>');

		      switch($fsInfo->field_type){
		        case 'textarea':
		          $valueEditor = $faqForm->textarea_field('key_value', 'soft', 35, 10, $fsInfo->key_value);
		          break;

		        case 'truefalse':
		          $valAsBoolean = ($fsInfo->key_value == 'true') ? true:false;
		          $valueEditor = $faqForm->radio_field('key_value', 'true', $valAsBoolean) . ' true<br />' . $faqForm->radio_field('key_value', 'false', !$valAsBoolean) . ' false';

		          if($fsInfo->key_name=='OSFDB_URL_FRIENDLY'){
		            $valueEditor .= '<br />' . $faqForm->checkbox_field('write_to_file', 'true', true) . ' ' . sprintf(OSF_FS_HTACCESS_INFO, realpath('../.htaccess'));
		          }elseif($fsInfo->key_name=='OSFDB_ENABLE_SSL'){

		            // check if SSL is installed or not. If its not, disable the option to change this setting.
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, HTTPS_SERVER . DIR_FS_WEB_ROOT . FILE_FAQ);

                // Set so curl_exec returns the result instead of outputting it.
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

                // Get the response and close the channel.
                curl_exec($ch);//ignore the content portion
                $response = curl_getinfo($ch);
                curl_close($ch);

                if(($response['http_code'] >= 200) && ($response['http_code'] < 300)){
                  $valueEditor .= '<br /><br />' . OSF_FS_SSL_INSTALLED;
                }else{
                  $valueEditor = $fsInfo->key_value . '<br /><br />' . OSF_FS_SSL_NOT_INSTALLED;
                  //just to lean on the side of paranoia we also make sure the SSL setting is false
                  //so osFaq is still accessible and not reduced to an error page.
                  $saveArray = array('key_value' => 'false', 'last_modified' => 'now()');
                  $sqle->db_compile(TABLE_FAQ_SETTINGS, $saveArray, FaqSQLExt::$UPDATE, "key_name='{$fsInfo->key_name}'");
                }

		          }
		          break;

		        case 'lang':
    		      // refresh the language array.
              if(isset($_SESSION['osf_languages'])){
                unset($_SESSION['osf_languages']);
              }
              $_SESSION['osf_languages'] = array();
              $osf_lang_dir = dir(DIR_FAQ_LANG);
              while (false !== ($osf_lang_file = $osf_lang_dir->read())) {
                if ( (substr($osf_lang_file, 0, 1)!='.') && (substr($osf_lang_file, 0, 1)!='_') && is_dir(DIR_FAQ_LANG . $osf_lang_file) ){
                  $_SESSION['osf_languages'][] = array('id' => $osf_lang_file, 'text' => $osf_lang_file);
                }
              }

		          $valueEditor = OSF_FS_LANGUAGE . $faqForm->pulldown_menu('key_value', $_SESSION['osf_languages'], $fsInfo->key_value, '', true) . '<br />';
		          $valueEditor .= $faqForm->hidden_field('refresh_db_lang', true);
		          break;


		        case 'timezone':
		          $valueEditor = OSF_FS_TIMEZONE . $faqForm->pulldown_menu('key_value', FaqSettings::getTimezones(), $fsInfo->key_value, '', true) . '<br />';
		          break;


		        case 'wysiwyg_theme':

		        	// Dynamically find theme names in the WYSIWYG themes folder
		        	$valueEditor = OSF_FS_WYSIWYG_THEME . $faqForm->pulldown_menu('key_value', FaqSettings::findThemes(), $fsInfo->key_value, '', true) . '<br />';
		          break;


		        case 'upload_size':
		          $valueEditor = $faqForm->input_field('key_value', (int)$fsInfo->key_value) . 'bytes<br />';
		          $valueEditor .= number_format((int)$fsInfo->key_value, 0, '', ',') . ' bytes = (<i>' . FaqSettings::byte_to_let($fsInfo->key_value) . '</i>)<br />';

		          $valueEditor .= <<<JSF
<script type="text/javascript">
function hta_pre_or_edit(hta_limits){
	if(hta_limits.checked){
		\$('#ini_preview').css('display', 'none');
		\$('#ini_edit').css('display', 'inline');
	}else{
		\$('#ini_preview').css('display', 'inline');
		\$('#ini_edit').css('display', 'none');
	}
}
</script>
JSF;
		          $valueEditor .= $faqForm->checkbox_field('hta_limits', 'true', false, '', 'onclick="hta_pre_or_edit(this);"') . ' ' . sprintf(OSF_FS_HTACCESS_UPLOAD, realpath('../.htaccess')) . '<br /><br />';

		          $ini_memory = FaqSettings::let_to_byte(ini_get('memory_limit'));
		          $ini_post = FaqSettings::let_to_byte(ini_get('post_max_size'));
		          $ini_upload = FaqSettings::let_to_byte(ini_get('upload_max_filesize'));


		          $valueEditor .= '<div id="ini_preview" name="ini_preview" style="display:inline;">';
		          $valueEditor .= '<b>php.ini, .htaccess:</b><br />';
		          $valueEditor .= '<div style="background-color:#0000FF; display:inline-block; width:20px; color:#ffffff;">&nbsp;I.</div> <b>memory_limit</b><br />' . number_format($ini_memory, 0, '', ',') . ' bytes (<i>' . FaqSettings::byte_to_let($ini_memory) . '</i>)<br /><br />';
		          $valueEditor .= '<div style="background-color:#FF6600; display:inline-block; width:20px;">&nbsp;II.</div> <b>post_max_size</b><br />' . number_format($ini_post, 0, '', ',') . ' bytes (<i>' . FaqSettings::byte_to_let($ini_post) . '</i>)<br /><br />';
		          $valueEditor .= '<div style="background-color:#FFCC00; display:inline-block; width:20px;">&nbsp;III.</div> <b>upload_max_filesize</b><br />' . number_format($ini_upload, 0, '', ',') . ' bytes (<i>' . FaqSettings::byte_to_let($ini_upload) . '</i>)<br />';
		          $valueEditor .= '</div>';

		          $valueEditor .= '<div id="ini_edit" name="ini_edit" style="display:none;">';
		          $valueEditor .= '<b>.htaccess:</b><br />';
		          $valueEditor .= '<div style="background-color:#0000FF; display:inline-block; width:20px; color:#ffffff;">&nbsp;I.</div> <b>memory_limit</b><br />' . $faqForm->input_field('memory_limit', $ini_memory) . 'bytes<br /><br />';
		          $valueEditor .= '<div style="background-color:#FF6600; display:inline-block; width:20px;">&nbsp;II.</div> <b>post_max_size</b><br />' . $faqForm->input_field('post_max_size', $ini_post) . 'bytes<br /><br />';
		          $valueEditor .= '<div style="background-color:#FFCC00; display:inline-block; width:20px;">&nbsp;III.</div> <b>upload_max_filesize</b><br />' . $faqForm->input_field('upload_max_filesize', $ini_upload) . 'bytes<br />';
		          $valueEditor .= '</div>';

		          $valueEditor .= '<div style="background-color:#0000FF; display:block; color:#FFFFFF; text-align:center; padding:2px 5px 5px 5px; margin:10px 0 0 0;">I. memory_limit<br />';
		          $valueEditor .= '	<div style="background-color:#FF6600; display:block; color:#000000; padding:2px 5px 5px 5px; margin:2px 0 0 0;">II. post_max_size<br />';
		          $valueEditor .= '		<div style="background-color:#FFCC00; display:block; padding:2px 5px 5px 5px; margin:2px 0 0 0;">III. upload_max_filesize<br />';
		          $valueEditor .= '			<div style="background-color:#FFFFFF; margin:2px 0 0 0;">IV. '.OSF_FS_VALUE.'</div>';
		          $valueEditor .= '		</div>';
		          $valueEditor .= '	</div>';
		          $valueEditor .= '</div>';

		          break;

		        case 'recaptcha_theme':
		          $recap_themes = array();
		          $recap_themes[] = array('id' => 'dark', 'text' => OSF_DARK);
		          $recap_themes[] = array('id' => 'light', 'text' => OSF_LIGHT);

		          $valueEditor = $faqForm->pulldown_menu('key_value', $recap_themes, $fsInfo->key_value, '', true);

              break;

		        case 'textfield':
		        default:
		          $valueEditor = $faqForm->input_field('key_value', $fsInfo->key_value);

		          if(FaqFuncs::not_null(FaqSettings::is_string_a_color($fsInfo->key_value))){
		            $valueEditor .= '<script type="text/javascript" src="'.DIR_FAQ_INCLUDES.'js/farbtastic/farbtastic.js"></script>' . "\n";
		            $valueEditor .= '<link rel="stylesheet" href="'.DIR_FAQ_INCLUDES.'js/farbtastic/farbtastic.css" type="text/css" />' . "\n";
		            $valueEditor .= '<div id="colorpicker"></div>';
		            $valueEditor .= <<<EOD
<script type="text/javascript">
  \$(document).ready(function() {
    \$('#colorpicker').farbtastic('#key_value');
  });
</script>
EOD;
		          }

		          break;
		      }

		      $contents[] = array('text' => '<b>' . OSF_FS_DESCRIPTION . ':</b><br />' . $fsInfo->description);

		      if($fsInfo->field_type=='upload_size'){
		        $contents[] = array('text' => '<hr /><div style="background-color:#FFFFFF; display:inline-block; width:20px;">&nbsp;IV.</div> <b>' . OSF_FS_VALUE . ':</b><br />' . $valueEditor);
		      }else{
		        $contents[] = array('text' => '<hr /><b>' . OSF_FS_VALUE . ':</b><br />' . $valueEditor);
		      }

		      /// enable the following line for developing (makes life easier)
		      //$contents[] = array('text' => '<hr /><b>' . OSF_FS_KEY . ':</b><br />' . $fsInfo->key_name);

		      $contents[] = array('text' => '<hr /><b>' . OSF_FS_ADDED . ':</b>' . FaqFuncs::format_date($fsInfo->date_added));
		      if(FaqFuncs::not_null($fsInfo->last_modified)) $contents[] = array('text' => '<b>' . OSF_FS_MODIFIED . ':</b>' . FaqFuncs::format_date($fsInfo->last_modified));

		      break;



		    default:
		      $heading = '<b>' . $fsInfo->title . '</b>';

		      $contents[] = array('align' => 'center', 'text' => '<a href="' . FaqFuncs::format_url(FILE_FAQ_ADMIN, 'settings=true&action=edit_setting&fsID=' . $fsInfo->id) . '">' . $faqForm->button_css(OSF_TIP_EDIT, OSF_ICON_CHANGE) . '</a>');

		      $contents[] = array('text' => '<b>' . OSF_FS_DESCRIPTION . ':</b><br />' . $fsInfo->description);

		      $contents[] = array('text' => '<hr /><b>' . OSF_FS_VALUE . ':</b><br />' . $fsInfo->key_value . FaqSettings::is_string_a_color($fsInfo->key_value));

		      /// enable the following line for developing (makes life easier)
		      //$contents[] = array('text' => '<hr /><b>' . OSF_FS_KEY . ':</b><br />' . $fsInfo->key_name);

		      $contents[] = array('text' => '<hr /><b>' . OSF_FS_ADDED . ':</b>' . FaqFuncs::format_date($fsInfo->date_added));
		      if(FaqFuncs::not_null($fsInfo->last_modified)) $contents[] = array('text' => '<b>' . OSF_FS_MODIFIED . ':</b>' . FaqFuncs::format_date($fsInfo->last_modified));
		  }



		  if (FaqFuncs::not_null($heading) && FaqFuncs::not_null($contents)) {
		    echo '    <td width="25%" valign="top">' . "\n";

		    $faqTable = new FaqTable;

		    switch ($action) {
		    	case 'edit_setting':
		    		$osf_box_class = 'messageHandlerWarning';
		    		break;

		    	default:
		    		$osf_box_class = 'faqinfo';
		    		break;
		    }


		    echo '<div class="' . $osf_box_class . '">';
		    echo $faqTable->detailTable($heading, $contents);
		    echo '</div>';

		    echo '    </td>' . "\n";
		  }
		}
		?>
	</tr>
</table>

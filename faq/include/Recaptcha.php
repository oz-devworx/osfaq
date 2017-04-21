<?php
/* *************************************************************************
  Id: Recaptcha.php

  Generates an internationalized reCaptcha box.
  The default themes from reCaptcha break with languages that use
  a few more characters than english for descriptions. Ironically
  this occurs with the default translations from reCAPTCHA.

  This class produces reCaptcha themes like the default ones
  but in a wide version and fully translated.

  I found in testing that the local "lang" variable for recaptcha was being
  over-ridden by a variable in the returned script from the recaptcha call
  which is internationalized based on location and possibly language settings
  of the computer displaying the reCaptcha box.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */
/**
 * The "lang" option for the recaptcha API doesn't seem to work reliably and
 * the default recaptcha boxes would break if some of the language text is too long.
 * I noticed it with German but it would apply to many languages.
 * This class generates themes very simmillar to the recaptcha defaults
 * but they are wider to allow for different langugages without breaking
 * the reCAPTCHA box.
 *
 * @author Tim Gall
 * @version v1.0 - 2012-01-28
 */
class RecaptchaI18nBox{

  private function __construct(){

  }

  public static function draw_recaptcha_box($theme='red'){
    switch($theme){
      case 'red':
      case 'white':
      case 'blackglass':
        self::get_recaptcha_styles($theme);
        self::get_recaptcha_box($theme);

      case 'clean':
      default:
        self::get_recaptcha_js($theme);
        break;
    }
  }

  private static function get_recaptcha_styles($theme){
?>
  <style type="text/css" media="all">
  #recap_custom{background:#000000 url(<?php echo DIR_FS_WEB_ROOT; ?>faq/img/recaptcha_<?php echo $theme; ?>.gif) no-repeat left top; height:123px; width:332px;}
  #recaptcha_image{position:relative; top:6px; left:16px; height:57px; width:300px; margin:0; padding:0; clear:both;}
  .recap_txt, .recaptcha_only_if_incorrect_sol{margin:0 0 0 20px; font-weight:bold; font-size:11px;}
  .recaptcha_resp{margin:2px 0 0 25px;}
  .recap_btn1 a, .recap_btn2 a, .recap_btn3 a, .recap_btn2t a{width:25px; height:16px; display:block; z-index:1000;}
  .recap_btn2t a{background: url(<?php echo DIR_FS_WEB_ROOT; ?>faq/img/recaptcha_<?php echo $theme; ?>_txt.gif) no-repeat top left;}
  </style>
<?php
  }

  private static function get_recaptcha_box($theme){
?>
  <div id="recap_custom" style="display:none;">
  	<div id="recaptcha_image" title="<?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_IMAGE_ALT_TEXT); ?>"></div>
  	<table width="332" border="0" cellspacing="0" cellpadding="0" style="margin:14px 0 0 0;">
  		<tr>
  			<td width="205" valign="top">
  				<div class="recaptcha_only_if_incorrect_sol" style="color:red"><?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_INCORRECT_TRY_AGAIN); ?></div>
  				<div class="recaptcha_only_if_image recap_txt"><?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_INSTRUCTIONS_VISUAL); ?></div>
  				<div class="recaptcha_only_if_audio recap_txt"><?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_INSTRUCTIONS_AUDIO); ?></div>
  				<input class="recaptcha_resp" type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
  			</td>
  			<td valign="top">
  				<div class="recap_btn1"><a href="javascript:Recaptcha.reload()" title="<?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_REFRESH_BTN); ?>">&nbsp;</a></div>
  				<div class="recaptcha_only_if_image recap_btn2"><a href="javascript:Recaptcha.switch_type('audio')" title="<?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_AUDIO_CHALLENGE); ?>">&nbsp;</a></div>
  				<div class="recaptcha_only_if_audio recap_btn2t"><a href="javascript:Recaptcha.switch_type('image')" title="<?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_VISUAL_CHALLENGE); ?>">&nbsp;</a></div>
  				<div class="recap_btn3"><a href="javascript:Recaptcha.showhelp()" title="<?php echo FaqFuncs::c_unicode_to_htmlentities(OSFR_HELP_BTN); ?>">&nbsp;</a></div></td>
  		</tr>
  	</table>
  </div>
<?php
  }

  private static function get_recaptcha_js($theme){
?>
  <script type="text/javascript">
    var RecaptchaOptions = {
        custom_translations : {
          visual_challenge : "<?php echo OSFR_VISUAL_CHALLENGE; ?>",
          audio_challenge : "<?php echo OSFR_AUDIO_CHALLENGE; ?>",
          refresh_btn : "<?php echo OSFR_REFRESH_BTN; ?>",
          instructions_visual : "<?php echo OSFR_INSTRUCTIONS_VISUAL; ?>",
          instructions_context : "<?php echo OSFR_INSTRUCTIONS_CONTEXT; ?>",
          instructions_audio : "<?php echo OSFR_INSTRUCTIONS_AUDIO; ?>",
          help_btn : "<?php echo OSFR_HELP_BTN; ?>",
          play_again : "<?php echo OSFR_PLAY_AGAIN; ?>",
          cant_hear_this : "<?php echo OSFR_CANT_HEAR_THIS; ?>",
          incorrect_try_again : "<?php echo OSFR_INCORRECT_TRY_AGAIN; ?>",
          image_alt_text : "<?php echo OSFR_IMAGE_ALT_TEXT; ?>"
        },
        lang : "<?php echo OSF_LANG_CODE; ?>",
<?php
    if($theme=='clean'){
?>
        theme : "<?php echo $theme; ?>",
<?php
    }else{
?>
        theme : "custom",
        custom_theme_widget: "recap_custom",
<?php
    }
?>
				tabindex : <?php echo (int)OSFDB_RECAPTCHA_TAB_INDEX; ?>
  	};
  </script>
<?php
  }
}
?>
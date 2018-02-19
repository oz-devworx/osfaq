<?php
/* *************************************************************************
  Id: Recaptcha.php

  Generates an internationalized reCaptcha v2 box.


  Tim Gall
  Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

// LANGUAGE FILE
require_once(DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq_recaptcha.lang.php');

/**
 *
 * @author Tim Gall
 * @version v2.0 - 2018-02-14
 */
class RecaptchaV2Lib{

  private function __construct(){

  }

  /**
   * Renders the visible part of the reCaptcha box
   * @param string $theme The theme colour... options: dark or light
   */
  public static function draw_recaptcha_box($theme='light'){
    switch($theme){
      case 'dark':
        self::get_recaptcha_box('dark');
        break;

      default:
      	self::get_recaptcha_box('light');
        break;
    }
  }

  /**
   * Handles validating the users input.
   * @return boolean - true on success, false on failure
   */
  public static function validate_recaptcha_response() {
   	global $messageHandler;

	if (isset ( $_POST ['g-recaptcha-response'] ) && ! empty ( $_POST ['g-recaptcha-response'] )) {
		// get verify response data
		$verifyResponse = file_get_contents ( 'https://www.google.com/recaptcha/api/siteverify?secret=' . OSFDB_RECAPTCHA_PRIVATE_KEY . '&response=' . $_POST ['g-recaptcha-response'] );
		$responseData = json_decode ( $verifyResponse );
		if ($responseData->success) {
			$error = false;
		} else {
			$error = true;
			//Verification failed, please try again.
			$messageHandler->add(OSFR_ERROR);
		}
	} else {
		$error = true;
		$messageHandler->add(OSFR_ERROR);
	}

	return $error;
  }

  public static function get_recaptcha_js($return = false){
  	$output = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';

  	if($return)
  		return $output;

  		echo $output;
  }

  /**
   * Renders the visible part of the reCaptcha box
   * @param string $theme The theme colour... options: dark or light
   */
  private static function get_recaptcha_box($theme){
?>
<div class="g-recaptcha" data-sitekey="<?php echo OSFDB_RECAPTCHA_PUBLIC_KEY; ?>" data-theme="<?php echo $theme; ?>"></div>
<?php
  }


}
?>
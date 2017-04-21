<?php
/* *************************************************************************
  Id: faq_recaptcha.lang.php

  Language file for recaptchalib.php
  These constants are used for the reCaptcha plugin from Google


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFR_NOT_OPEN_SOCKET', 'Could not open socket');
define('OSFR_TO_USE_RECAPTCHA', 'To use reCAPTCHA you must get an API key from %s');
define('OSFR_FOR_SECURITY_PASS_IP', 'For security reasons, you must pass the remote ip to reCAPTCHA');
define('OSFR_MAILHIDE_REQUIRES_MCRYPT', 'To use reCAPTCHA Mailhide, you need to have the mcrypt php module installed.');
define('OSFR_MAILHIDE_SIGNUP', 'To use reCAPTCHA Mailhide, you have to sign up for a public and private key, you can do so at %s');
define('OSFR_REVEAL_EMAIL_ADDRESS', 'Reveal this e-mail address');
define('OSFR_ERROR', 'Check the reCAPTCHA box for errors');

// the following translations are from reCAPTCHA
define('OSFR_VISUAL_CHALLENGE', 'Get a visual challenge');
define('OSFR_AUDIO_CHALLENGE', 'Get an audio challenge');
define('OSFR_REFRESH_BTN', 'Get a new challenge');
define('OSFR_INSTRUCTIONS_VISUAL', 'Type the two words:');
define('OSFR_INSTRUCTIONS_CONTEXT', 'Type the words in the boxes:');
define('OSFR_INSTRUCTIONS_AUDIO', 'Type what you hear:');
define('OSFR_HELP_BTN', 'Help');
define('OSFR_PLAY_AGAIN', 'Play sound again');
define('OSFR_CANT_HEAR_THIS', 'Download sound as MP3');
define('OSFR_INCORRECT_TRY_AGAIN', 'Incorrect. Try again.');
define('OSFR_IMAGE_ALT_TEXT', 'reCAPTCHA challenge image');
?>
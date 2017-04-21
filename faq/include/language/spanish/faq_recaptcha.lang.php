<?php
/* *************************************************************************
  Id: faq_recaptcha.lang.php

  Language file for recaptchalib.php
  These constants are used for the reCaptcha plugin from Google


  Spanish Translation provided by Francisco Flores 2011

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
define('OSFR_VISUAL_CHALLENGE', 'Obtener una pista visual');
define('OSFR_AUDIO_CHALLENGE', 'Obtener una pista sonora');
define('OSFR_REFRESH_BTN', 'Obtener una pista nueva');
define('OSFR_INSTRUCTIONS_VISUAL', 'Escribe las dos palabras:');
define('OSFR_INSTRUCTIONS_CONTEXT', 'Escribe las palabras de los cuadros:');
define('OSFR_INSTRUCTIONS_AUDIO', 'Escribe lo que oigas:');
define('OSFR_HELP_BTN', 'Ayuda');
define('OSFR_PLAY_AGAIN', 'Volver a reproducir el sonido');
define('OSFR_CANT_HEAR_THIS', 'Descargar el sonido en MP3');
define('OSFR_INCORRECT_TRY_AGAIN', 'Incorrecto. Vu\u00e9lvelo a intentar.');
define('OSFR_IMAGE_ALT_TEXT', 'Pista de imagen reCAPTCHA');
?>
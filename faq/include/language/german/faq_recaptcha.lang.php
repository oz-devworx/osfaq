<?php
/* *************************************************************************
  Id: faq_recaptcha.lang.php

  Language file for recaptchalib.php
  These constants are used for the reCaptcha plugin from Google

  German Translation provided by Silvio Paschke 2010

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

define('OSFR_NOT_OPEN_SOCKET', 'Konnte Socket nicht öffnen');
define('OSFR_TO_USE_RECAPTCHA', 'Um reCAPTCHA nutzen zu können, muss ein API-Schlüssel unter %s angefordert werden.');
define('OSFR_FOR_SECURITY_PASS_IP', 'Aus Sicherheitsgründen muss Ihre IP-Adresse zu reCAPTCHA übertragen werden.');
define('OSFR_MAILHIDE_REQUIRES_MCRYPT', 'Um reCAPTCHA Mailhide nutzen zu können, muss das PHP-Modul mcrypt installiert sein.');
define('OSFR_MAILHIDE_SIGNUP', 'Um reCAPTCHA Mailhide nutzen zu können, muss eine Anmeldung für einen öffentlichen und privaten Schlüssel erfolgen. Dies ist hier möglich: %s');
define('OSFR_REVEAL_EMAIL_ADDRESS', 'Diese E-Mailadresse enthüllen');
define('OSFR_ERROR', 'Prüfung des reCAPTCHA Felds bei Fehlern');

// the following translations are from reCAPTCHA
define('OSFR_VISUAL_CHALLENGE', 'Captcha abrufen');
define('OSFR_AUDIO_CHALLENGE', 'Audio-Captcha abrufen');
define('OSFR_REFRESH_BTN', 'Neues Captcha abrufen');
define('OSFR_INSTRUCTIONS_VISUAL', 'Geben Sie die 2 W\u00f6rter ein:');
define('OSFR_INSTRUCTIONS_CONTEXT', 'Worte aus den Feldern eingeben:');
define('OSFR_INSTRUCTIONS_AUDIO', 'Geben Sie das Geh\u00f6rte ein:');
define('OSFR_HELP_BTN', 'Hilfe');
define('OSFR_PLAY_AGAIN', 'Wort erneut abspielen');
define('OSFR_CANT_HEAR_THIS', 'Wort als MP3 herunterladen');
define('OSFR_INCORRECT_TRY_AGAIN', 'Falsch. Bitte versuchen Sie es erneut.');
define('OSFR_IMAGE_ALT_TEXT', 'reCAPTCHA-Bild');
?>
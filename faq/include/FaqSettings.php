<?php
/* *************************************************************************
  Id: FaqSettings.php

  A collection of support functions for faq_settings.inc.php


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

class FaqSettings{

  private function __construct() {

  }



  /**
   * Used for testing if a value is a color
   * and/or to display a color swatch if the value is a color.
   *
   * @param mixed $string
   * @return a color swatch if the value is a 3 or 6 digit hexidecimal color reference; otherwise null is returned
   */
  public static function is_string_a_color($string){
  	return preg_match('@^#[a-f0-9]{6}|#[a-f0-9]{3}$@Ui', $string) ? '<div style="width:50px; height:20px; background-color:' . $string . ';">&nbsp;</div>' : null;
  }

  /**
   * Get a list of timezones supported on this server
   * or fallback to php.ini date.timezone
   * and any manual entries in the active localisation file.
   *
   * @return a 2 dimensional array of timezone names
   */
  public static function getTimezones(){
    $timezone_list = array();
    //php >= 5.1.0
    if(function_exists('timezone_identifiers_list')){
      $timezones = timezone_identifiers_list();
      foreach($timezones as $id => $name){
        $timezone_list[] = array('id' => $name, 'text' => $name);
      }
    }else{
      //php < 5.1.0
      $timezone_list[] = array('id' => getenv('date.timezone'), 'text' => getenv('date.timezone'));
      if(OSF_TZ!='' && !in_array(OSF_TZ, $timezone_list)){
        $timezone_list[] = array('id' => OSF_TZ, 'text' => OSF_TZ);
      }
    }

    return $timezone_list;
  }

  private static function getHtaccessRedirectHead(){
    $redirect_headers =  'Options +FollowSymLinks' . PHP_EOL;
    $redirect_headers .= 'RewriteEngine On' . PHP_EOL;
    $redirect_headers .= 'RewriteBase ' . DIR_FS_WEB_ROOT . PHP_EOL;
    $redirect_headers .= PHP_EOL;
    $redirect_headers .= 'RewriteCond %{REQUEST_FILENAME} !-d' . PHP_EOL;
    $redirect_headers .= 'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL;
    $redirect_headers .= PHP_EOL;

    return $redirect_headers;
  }

  /**
   * Attempts to preserve existing unrelated info in the .htaccess file.<br />
   * Updates PHP memory, post and upload sizes via a .htaccess file.
   *
   * @param boolean $remove_redirects
   */
  public static function updateHtaccessFile($remove_redirects=false){
    global $messageHandler;

    $hta_file_name = '../.htaccess';
    $rwbase = DIR_FS_WEB_ROOT;

    if(!is_file($hta_file_name)){
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_NOT_EXIST, realpath($hta_file_name)), FaqMessage::$warning);
      return;
    }elseif(!is_writeable($hta_file_name)){
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_NOT_WRITEABLE, realpath($hta_file_name)), FaqMessage::$warning);
      return;
    }

    $htacces_string = file_get_contents($hta_file_name);
		$htacces_array = explode("\n", $htacces_string);
		$htacces_string = '';
		$htacces_string_post = '';

		foreach($htacces_array as $value){
			if(preg_match('/^(Options\s+\+FollowSymLinks|RewriteEngine\s+On|RewriteBase\s+|RewriteCond\s+%{REQUEST_FILENAME}\s+|RewriteRule\s+\^\(\.\*\)-c\(\[0\-9\]\+\))/i', trim($value))){
				$value = '';
			}elseif(preg_match('/^(RewriteCond\s+|RewriteRule\s+)/i', trim($value))){
			  $htacces_string_post .= rtrim($value) . PHP_EOL;
			  $value = '';
			}
			$htacces_string .= rtrim($value) . PHP_EOL;
		}
		$htacces_string = trim($htacces_string);
		$htacces_string .= PHP_EOL;

    if(!$remove_redirects){
      $htacces_string .= PHP_EOL;
      $htacces_string .= self::getHtaccessRedirectHead();
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-a([0-9]+)-p.html$ '.FILE_FAQ.'?cid=$2&answer=$3&print=true&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-a([0-9]+).html$ '.FILE_FAQ.'?cid=$2&answer=$3&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-a([0-9]+)-(pg|i)([0-9]+)-p.html$ '.FILE_FAQ.'?cid=$2&answer=$3&$4=$5&print=true&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-a([0-9]+)-(pg|i)([0-9]+).html$ '.FILE_FAQ.'?cid=$2&answer=$3&$4=$5&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-(pg|i)([0-9]+)-p.html$ '.FILE_FAQ.'?cid=$2&$3=$4&print=true&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-(pg|i)([0-9]+).html$ '.FILE_FAQ.'?cid=$2&$3=$4&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+)-p.html$ '.FILE_FAQ.'?cid=$2&print=true&%{QUERY_STRING}' . PHP_EOL;
      $htacces_string .= 'RewriteRule ^(.*)-c([0-9]+).html$ '.FILE_FAQ.'?cid=$2&%{QUERY_STRING}' . PHP_EOL;
    }

    // restore custom redirects
    if(strlen($htacces_string_post) > 0){
      // restore the redirect headers if the SEO redirects were flagged for removal
      if($remove_redirects){
        $htacces_string .= PHP_EOL;
        $htacces_string .= rtrim(self::getHtaccessRedirectHead()) . PHP_EOL;
      }
      $htacces_string .= PHP_EOL;
      $htacces_string .= trim($htacces_string_post) . PHP_EOL;
    }else{
      $htacces_string .= PHP_EOL;
    }

    // write to file
    if(false === file_put_contents($hta_file_name, $htacces_string)){
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_NOWRITE, realpath($hta_file_name)), FaqMessage::$error);
    }else{
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_WRITE, realpath($hta_file_name)), FaqMessage::$success);
    }
  }

  /**
   * Preserves existing unrelated info in the .htaccess file.<br />
   * Updates PHP memory, post and upload sizes via a .htaccess file.
   */
  public static function updateHtaccessUpoadLimits(){
    global $messageHandler, $_POST;

    $hta_file_name = '../.htaccess';
    $rwbase = DIR_FS_WEB_ROOT;

    if(!is_file($hta_file_name)){
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_NOT_EXIST, realpath($hta_file_name)), FaqMessage::$warning);
      return;
    }elseif(!is_writeable($hta_file_name)){
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_NOT_WRITEABLE, realpath($hta_file_name)), FaqMessage::$warning);
      return;
    }

    $htacces_string = file_get_contents($hta_file_name);

		$htacces_array = explode("\n", $htacces_string);
		$htacces_string = '';


		foreach($htacces_array as $value){
			if(preg_match('/^(php_value)\s+(memory_limit|post_max_size|upload_max_filesize)\s+/i', trim($value))){
				$value = '';
			}
			$htacces_string .= rtrim($value) . PHP_EOL;
		}
		$htacces_string = trim($htacces_string);


		$limit = isset($_POST['memory_limit']) ? self::byte_to_let($_POST['memory_limit']) : 0;
		$max_size = isset($_POST['post_max_size']) ? self::byte_to_let($_POST['post_max_size']) : 0;
		$max_filesize = isset($_POST['upload_max_filesize']) ? self::byte_to_let($_POST['upload_max_filesize']) : 0;

		// prepend upload filesize over-ride values
		$htacces_string_pre = '';
		if($limit != 0) $htacces_string_pre .= 'php_value memory_limit ' . $limit . PHP_EOL;
		if($max_size != 0) $htacces_string_pre .= 'php_value post_max_size ' . $max_size . PHP_EOL;
		if($max_filesize != 0) $htacces_string_pre .= 'php_value upload_max_filesize ' . $max_filesize . PHP_EOL;
    if(strlen($htacces_string_pre) > 0) $htacces_string_pre .= PHP_EOL;

		$htacces_string = $htacces_string_pre . $htacces_string . PHP_EOL;

    // write to file
    if(false === file_put_contents($hta_file_name, $htacces_string)){
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_NOWRITE, realpath($hta_file_name)), FaqMessage::$error);
    }else{
      $messageHandler->addNext(sprintf(OSF_FS_HTACCESS_WRITE, realpath($hta_file_name)), FaqMessage::$success);
    }
  }

  /**
   * Copied from the PHP5 manuals comment section.<br />
   * Authors notes:<br />
   * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
   * @author gilthans dot NO dot SPAM at gmail dot com (03-Dec-2007 06:52)
   * @param string $v data size in php.ini notation
   * @return int - size of $v in bytes
   */
  public static function let_to_byte($v){
    $l = substr($v, -1);
    $ret = substr($v, 0, -1);
    switch(strtoupper($l)){
      case 'P':
        $ret *= 1024;
      case 'T':
        $ret *= 1024;
      case 'G':
        $ret *= 1024;
      case 'M':
        $ret *= 1024;
      case 'K':
        $ret *= 1024;
        break;
    }
    return $ret;
  }

  /**
   * Found this function in the php5 manuals user comments. Many thanks to the author.
   * The function has been changed from the original to produce php.ini notation results
   *
   * @param mixed $v as an integer, in bytes.
   * @return A nicely rounded value to the most appropriate scale,
   * with scale indicator if > Bytes.<br />
   * EG: K, M, G, T, P
   */
  public static function byte_to_let($v){
    if(is_numeric($v) && $v > 0){
      $decr = 1024;
      $step = 0;
      $prefix = array('','K','M','G','T','P');

      while(($v / $decr) > 0.9){
        $v = $v / $decr;
        $step++;
      }
      return round($v,0).$prefix[$step];
    } else {
      return '0';
    }
  }

  public static function bytes_to_megabytes($byte_value){
    return round(($byte_value/(1024*1024)), 0);
  }

}
?>
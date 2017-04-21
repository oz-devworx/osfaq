<?php
/* *************************************************************************
 Id: FaqMessage.php

Provides user notifications to client and admin FAQ pages
from the FAQ script.


Tim Gall
Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
http://osfaq.oz-devworx.com.au

This file is part of osFaq.

Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

class FaqMessage {

	/* added static class vars 2010-03-05 00:00, Tim Gall
	 * NOTE: For backward php compatibility we use "public static".
	* In actuality these should be "const" (php >= 5.3.0)
	* or "public static final" (php >= 6.0.0)
	*/
	public static $error = 'error';
	public static $warning = 'warning';
	public static $success = 'success';
	public static $plain = 'plain';

	/**
	 * FaqMessage::FaqMessage()
	 */
	function __construct() {
		$this->messages = array();

		$this->session_to_stack();
	}


	/**
	 * FaqMessage::add()
	 *
	 * @param string $message
	 * @param string $type [optional] default = 'error'
	 */
	public function add($message, $type = 'error') {
		if ($type == FaqMessage::$error) {
			$this->messages[] = array('type' => FaqMessage::$error, 'text' => '<i class="icon-warning-sign icon-large"></i> ' . $message);
		} elseif ($type == FaqMessage::$warning) {
			$this->messages[] = array('type' => FaqMessage::$warning, 'text' => '<i class="icon-exclamation-sign icon-large"></i> ' . $message);
		} elseif ($type == FaqMessage::$success) {
			$this->messages[] = array('type' => FaqMessage::$success, 'text' => '<i class="icon-ok-sign icon-large"></i> ' . $message);
		} else {
			$this->messages[] = array('type' => FaqMessage::$plain, 'text' => '<i class="icon-info-sign icon-large"></i> ' . $message);
		}
	}

	/**
	 * FaqMessage::addNext()
	 *
	 * @param string $message
	 * @param string $type [optional] default = 'error'
	 */
	public function addNext($message, $type = 'error') {
		if (!isset($_SESSION['osf_MessageStack'])) {
			$_SESSION['osf_MessageStack'] = array();
		}

		$_SESSION['osf_MessageStack'][] = array('text' => $message, 'type' => $type);
	}

	/**
	 * Output any messages in the message stack grouped by type.
	 *
	 * @return string - All messages on the stack compiled into html ready for display.
	 */
	public function output() {
		$output = '';

		$error_messages = '';
		$warning_messages = '';
		$success_messages = '';
		$plain_messages = '';

		// group messages by type for neater looking output
		foreach ($this->messages as $message) {

			switch($message['type']){
				case self::$error:
					$error_messages .= $message['text'] . '<br />';
					break;
				case self::$warning:
					$warning_messages .= $message['text'] . '<br />';
					break;
				case self::$success:
					$success_messages .= $message['text'] . '<br />';
					break;
				case self::$plain:
				default:
					$plain_messages .= $message['text'] . '<br />';
					break;
			}
		}

		if(!empty($error_messages))
			$output .= '<div class="messageHandlerError">' . $error_messages . '</div>' . "\n";

		if(!empty($warning_messages))
			$output .= '<div class="messageHandlerWarning">' . $warning_messages . '</div>' . "\n";

		if(!empty($success_messages))
			$output .= '<div class="messageHandlerSuccess">' . $success_messages . '</div>' . "\n";

		if(!empty($plain_messages))
			$output .= '<div class="messageHandlerPlain">' . $plain_messages . '</div>' . "\n";

		return $output;
	}

	/**
	 * Get the count of all messages in this stack;
	 * Messages held in the session var are not included
	 *
	 * @return int - how many messages on the stack
	 */
	public function size() {
		return count($this->messages);
	}

	/**
	 * Moves messages in the session array to the message stack
	 */
	public function session_to_stack(){
		/// output any stored messages from addNext()
		if (isset($_SESSION['osf_MessageStack'])) {

			//print ('<pre><b>$_SESSION</b><br>');print_r($_SESSION);print ('</pre>');

			foreach ($_SESSION['osf_MessageStack'] as $message) {
				$this->add($message['text'], $message['type']);
			}
			unset($_SESSION['osf_MessageStack']);
		}
	}
}
?>
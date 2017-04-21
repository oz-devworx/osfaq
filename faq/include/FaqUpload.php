<?php
/* *************************************************************************
 Id: FaqUpload.php

Makes file uploads easier to manage.
Originally based on a user comment in the php5 manual.

**********************************************************************

Updated: 2009-11-05 Tim Gall
Fixed truncated filename issue

Updated: 2009-11-06 Tim Gall
Added new params for reposting form data

Updated: 2009-11-09 Tim Gall
Improved functionality for reposting form data.

Updated: 2012-01-22 Tim Gall
Added duplicate file name checking. Duplicate names have a timestamp appended to the name.

Updated: 2013-02-27 Tim Gall
Removed form wrapper on upload fields.

Updated: 2013-03-09 Tim Gall
Added language translations, remodelled core functions
to remove any left over junk from previous versions
and improve user feedback when uploading.

**********************************************************************
USE:
Set your desired parameters when constructing a new instance.

Use drawForm() to render the uplad field/s in html.

Use processFiles() to process the uploaded files.

The $file_names[] array will contain the upload names
after they have been processed and moved.
*********************************************************************


Tim Gall
Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
http://osfaq.oz-devworx.com.au

This file is part of osFaq.

Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

class FileUpload {
	var $num_of_uploads;
	var $file_types_array;
	var $max_file_size;
	var $upload_fs_dir;
	var $upload_ws_dir;
	var $label;
	var $form_id;
	var $file_names = array();
	var $permissions = 0644;// must be an octal integer, must start with a zero.

	var $trimNameLength = 45;//added & value increased from 15. 2009-11-05 Tim Gall

	var $textStar = '<b style="color:red">*</b>';

	/**
	 * FaqUpload::__construct()
	 *
	 * @param string $form_id - name of the form to work with
	 * @param integer $num_of_uploads
	 * @param array $file_types_array - an array of filetype names
	 * @param integer $max_file_size
	 * @param string $upload_fs_dir
	 * @param string $upload_ws_dir
	 * @param string $label
	 * @return void
	 */
	function __construct($form_id, $num_of_uploads = 1, $file_types_array = array(), $max_file_size = 1048576, $upload_fs_dir = "", $upload_ws_dir = "", $label = OSF_DOCUMENT) {

		$this->num_of_uploads = $num_of_uploads;
		$this->file_types_array = $file_types_array;
		$this->max_file_size = $max_file_size;
		$this->upload_fs_dir = $upload_fs_dir;
		$this->upload_ws_dir = $upload_ws_dir;
		$this->label = $label;
		$this->form_id = $form_id;

		if (!is_numeric($this->max_file_size)) {
			$this->max_file_size = 1048576;
		}
	}

	/**
	 * FaqUpload::drawForm()
	 *
	 * @return string - a html upload form field
	 */
	function drawForm() {
		/* removed form opening & closing tags since they were no longer needed. 2013-02-27 Tim Gall */
		$form = $this->label . '<br /><input type="hidden" name="' . $this->form_id . '" id="' . $this->form_id . '" value="TRUE"><input type="hidden" name="MAX_FILE_SIZE" value="' . $this->max_file_size . '">';

		for ($x = 0; $x < $this->num_of_uploads; $x++) {
			$form .= '<input type="file" name="file[]" />' . $this->textStar . '<br />';
		}

		if($this->hiddenFields > 0){
			for($i = 0; $i < $this->hiddenFields; $i++) $form .= '<input type="hidden" value="" id="hidden'.($i+1). '" name="hidden'.($i+1). '" />';
		}

		$form .= $this->textStar . OSF_VALID_TYPES;
		for ($x = 0; $x < count($this->file_types_array); $x++) {
			if ($x < count($this->file_types_array) - 1) {
				$form .= $this->file_types_array[$x] . ", ";
			} else {
				$form .= $this->file_types_array[$x] . ".";
			}
		}
		echo ($form);
	}


	/**
	 * FaqUpload::processFiles()
	 *
	 * @return boolean - false if error occurs
	 */
	function processFiles() {
		global $messageHandler;

		$result_flag = true;

		if (isset($_POST[$this->form_id]) && isset($_FILES["file"]["error"])) {

			$result_flag = false;

			foreach ($_FILES["file"]["error"] as $key => $value) {
				if ($_FILES["file"]["name"][$key] != "") {
					if ($value == UPLOAD_ERR_OK) {
						$origfilename = $_FILES["file"]["name"][$key];
						$filename = explode(".", $_FILES["file"]["name"][$key]);

						$filenameext = strtolower($filename[count($filename) - 1]);

						$file_ext_allow = false;
						for ($x = 0; $x < count($this->file_types_array); $x++) {
							if ($filenameext == strtolower($this->file_types_array[$x])) {
								$file_ext_allow = true;
								break;
							}
						}

						if ($file_ext_allow) {

							unset($filename[count($filename) - 1]);
							$filename = implode(".", $filename);
							$filename_pre = $filename;
							$filename = substr($filename, 0, $this->trimNameLength) . '.' . $filenameext;

							// append a timestamp to duplicate file names to avoid overwritting. 2012-01-22 Tim Gall
							$dir = dir($this->upload_fs_dir);
							while ($single_file = $dir->read()) {
								if($single_file==$filename){
									$filename = substr($filename_pre, 0, ($this->trimNameLength - 10)) . '_' . time() . '.' . $filenameext;
								}
							}

							// moved to after name truncation occurs. 2009-11-05 Tim Gall
							$this->file_names[] = $filename;


							if ($_FILES["file"]["size"][$key] < $this->max_file_size) {
								/* 2010-12-20 Tim Gall
								 *
								* Added filename translation from utf-8 to ascii for move_uploaded_file()
								* Im still not sure why this fixes the issue since its not applied to the db name
								* and the actual saved file still gets saved with a utf-8 name.
								* However the result seems to stop utf-8 chars in the filenames from getting corrupted.
								*
								* Its possible its something related to
								* the interaction between php and the operating system with file manipulations???
								*/
								if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $this->upload_fs_dir . FaqFuncs::utf8_to_ascii($filename))) {

									chmod($this->upload_fs_dir . $filename, $this->permissions);

									$messageHandler->add(sprintf(OSF_SUCCESS_FILE_UPLOADED, ' <a href="' . $this->upload_ws_dir . $filename . '" target="_blank">' . $filename . '</a> '), FaqMessage::$success);

									$result_flag = true;

								} else {
									$messageHandler->add(sprintf(OSF_ERROR_NOT_UPLOADED, $origfilename), FaqMessage::$error);
								}
							} else {
								$messageHandler->add(sprintf(OSF_ERROR_TOO_LARGE, $origfilename), FaqMessage::$error);
							}
						} else {
							$messageHandler->add(sprintf(OSF_ERROR_INVALID_EXTENSION, $origfilename), FaqMessage::$error);
						}
					} else {
						$messageHandler->add(sprintf(OSF_ERROR_NOT_UPLOADED, $origfilename), FaqMessage::$error);
					}
				}
			}
		}
		return $result_flag;
	}// END function processFiles() {
}
?>
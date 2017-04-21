<?php
/* *************************************************************************
  Id: FaqTable.php

  Convenience class for generating single column tables.


  Tim Gall
  Copyright (c) 2009-2014 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

class FaqTable extends OneColTable {
  /**
   * FaqTable::FaqTable()
   *
   * @return void
   */
  function __construct() {
    $this->table = '';
  }

  /**
   * FaqTable::detailTable()
   *
   * @param string $heading
   * @param string $contents
   * @return
   */
  function detailTable($heading = '', $contents = '') {
    $this->heading_class = '';
    $this->data_class = '';
    $this->params = 'class="faqinfo"';
    $this->table = $this->OneColTable($heading, $contents);

    return $this->table;
  }
}


class OneColTable {
  var $border = '0';
  var $width = '100%';
  var $cellspacing = '0';
  var $cellpadding = '2';
  var $params = '';
  var $heading_class = '';
  var $data_class = '';

  /**
   * GPTable::OneColTable()
   *
   * Modified: 2014-12-03 Tim Gall - Moved form tags to wrap table instead of being between rows.
   * 	Only one form allowed per table now.
   *
   * @param string $heading
   * @param string | array $contents
   * @return A single column html table (may include a single wrapping form).
   */
  function OneColTable($heading = '', $contents = '') {
    $table_string = '';
    $close_form = false;

    if ($heading != '' || $contents != '') {
      $table_string .= '<table border="' . $this->border . '" width="' . $this->width . '" cellspacing="' . $this->cellspacing . '" cellpadding="' . $this->cellpadding . '"' . (($this->params != '') ? " " . $this->params : '') . ">" . "\n";

      if ($heading != '') {
        $table_string .= '  <tr' . (FaqFuncs::not_null($this->heading_class) ? ' ' . $this->heading_class : '') . '>' . "\n";
        $table_string .= '    <th>' . $heading . '</th>' . "\n";
        $table_string .= '  </tr>' . "\n";
      }

      if (is_array($contents)) {

        foreach ($contents as $data) {
          if (FaqFuncs::not_null($data['form'])) {
            $table_string = $data['form'] . $table_string;
          } else {
            $table_string .= '  <tr>' . "\n";
            $table_string .= '    <td' . (FaqFuncs::not_null($this->data_class) ? ' ' . $this->data_class : '') . (FaqFuncs::not_null($data['align']) ? ' align="' . $data['align'] . '"' : '') . '>' . $data['text'] . '</td>' . "\n";
            $table_string .= '  </tr>' . "\n";
          }
        }

      } elseif ($contents != '') {
        $table_string .= '  <tr>' . "\n";
        $table_string .= '    <td' . (FaqFuncs::not_null($this->data_class) ? ' ' . $this->data_class : '') . '>' . $contents . '</td>' . "\n";
        $table_string .= '  </tr>' . "\n";
      }

      $table_string .= '</table>' . "\n";

      if ($close_form == true) {
      	$table_string .= '</form>';
      }
    }

    return $table_string;
  }
}
?>
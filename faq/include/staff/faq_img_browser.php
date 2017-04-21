<?php
/* *************************************************************************
 Id: faq_img_browser.php

 Displays images that have previously been uploaded by admins.


 Tim Gall
 Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
 http://osfaq.oz-devworx.com.au

 This file is part of osFaq.

 Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
 For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

 ************************************************************************* */

?>
<style rel="stylesheet" type="text/css">
<!--
.browse_img{display:block; font-family:Arial, Helvetica, sans-serif, tahoma;}
.browse_img img{display:inline; float:left; width:100px; height:100px; margin:2px;}
.browse_img button{
	margin:10px 10px 10px 0; padding:4px 0 4px 0;
	font-weight:bold; font-size:10pt;
	font-family:Arial, Helvetica, sans-serif, tahoma;
	text-align:center;
	color:#3366cc;
	border:1px solid #555;
	width:162px;
	border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;
	background-color: #D1D1D1; background: -webkit-gradient(linear, left top, left bottom, from(#F2F2F2), to(#D1D1D1)); background: -moz-linear-gradient(top, #F2F2F2, #D1D1D1); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F2F2F2', endColorstr='#D1D1D1');/* ie7 */ -ms-filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F2F2F2', endColorstr='#D1D1D1');/* ie8 */
  cursor:pointer !important;
}
.browse_img button:hover{border:1px solid #FF9900;}

/* pagination */
.paginate_row {padding: 2px 6px 2px 6px; font-family: Arial, Helvetica, sans-serif; background-color:#eee; color:#3a87ad; border:1px solid #ddd;}
.paginate_top{-webkit-border-radius: 10px 10px 0 0; -khtml-border-radius: 10px 10px 0 0;  -moz-border-radius: 10px 10px 0 0; border-radius: 10px 10px 0 0;}
.paginate_bot{-webkit-border-radius: 0 0 10px 10px; -khtml-border-radius: 0 0 10px 10px;  -moz-border-radius: 0 0 10px 10px; border-radius: 0 0 10px 10px;}
-->
</style>
<!--[if lte IE 8]>
<style type="text/css" media="screen">
.browse_img input{
	margin:10px 10px 10px -10px; padding:2px 0 2px 0;
	font-weight:bold; font-size:10pt;
	font-family:Arial, Helvetica, sans-serif, tahoma;
	text-align:center;
	color:#3366cc;
	border:1px solid #555;
	width:150px;
	background-color: #D1D1D1; background: -webkit-gradient(linear, left top, left bottom, from(#F2F2F2), to(#D1D1D1)); background: -moz-linear-gradient(top, #F2F2F2, #D1D1D1); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F2F2F2', endColorstr='#D1D1D1');/* ie7 */ -ms-filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F2F2F2', endColorstr='#D1D1D1');/* ie8 */
  cursor:pointer !important;
</style>
<![endif]-->
<div class="browse_img">
<?php
if( (isset($_POST['list_images']) && $_POST['list_images']=='true') || (isset($_GET['list_images']) && $_GET['list_images']=='true') ){
	$images_directory = '../faq/images/';
	$images = array();
	$images_dir = dir($images_directory);

	while (false !== ($image_file = $images_dir->read())) {
		if ( (substr($image_file, 0, 1)!='.') && (substr($image_file, 0, 1)!='_') && (substr($image_file, -4)!='.txt') && (substr($image_file, -4)!='.php') && !is_dir($images_directory . $image_file) ){
			if(is_file($images_directory . $image_file))
				//it seems the php file manipulation functions can mess with utf-8 names
				//so we try to take preventative measures.
				$images[] = FaqFuncs::utf8_to_ascii($image_file, true);
		}
	}
	$images_dir->close();

	$osf_counter = 0;
	if(count($images)>0){

		$pages->items_total = count($images);
		$pages->paginate();

		echo '<div class="paginate_row paginate_top">';
		//echo $pages->display_pages(); // page numbers
		echo $pages->display_jump_menu(); // page jump menu
		echo $pages->display_items_per_page(); // items per page menu
		echo '</div>';

		foreach($images as $img){
			$osf_counter++;

			if($osf_counter > ($pages->low + $pages->high))
				break;

			if($osf_counter > $pages->low)
				echo '<img src="' . DIR_WS_IMAGES . $img . '" alt="'.$img.'" title="'.$img.'" />';
		}
	}else{
		echo '<b style="color:red;">' . OSF_NO_IMAGE . '</b>';
	}

}else{
	echo $faqForm->form_open('new_faq', 'osfaq_assist.php', 'img_browse=true', 'post');
	echo $faqForm->hidden_field('list_images', 'true');
	echo $faqForm->submit_css(OSF_IMAGE_BROWSE);
	echo $faqForm->form_close();
}
?>
</div>
<?php
/* *************************************************************************
 Id: button_gradient.php

Renders svg gradients.


Tim Gall
Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
http://osfaq.oz-devworx.com.au

This file is part of osFaq.

Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

function osf_render_svg_gradient(){
	global $_GET;

	$osf_svg_start = (isset($_GET['from']) && osf_validate_color($_GET['from'])) ? $_GET['from'] : '000000';
	$osf_svg_stop = (isset($_GET['to']) && osf_validate_color($_GET['to'])) ? $_GET['to'] : '000000';

	$osf_svg_start = ltrim($osf_svg_start, '#');
	$osf_svg_stop = ltrim($osf_svg_stop, '#');

	header('Content-type: image/svg+xml; charset=utf-8');

	echo '<?xml version="1.0"?>' . PHP_EOL;

?>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%">
    <defs>
        <linearGradient id="linear-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#<?php echo $osf_svg_start; ?>" stop-opacity="1"/>
            <stop offset="100%" stop-color="#<?php echo $osf_svg_stop; ?>" stop-opacity="1"/>
        </linearGradient>
    </defs>
    <rect ry="3" rx="3" width="100%" height="100%" fill="url(#linear-gradient)"/>
</svg>
<?php
}

function osf_validate_color($color){
	return preg_match('@^([#]{0,1})([a-f0-9]{3,6})$@i', $color);
}


// returns an svg image
osf_render_svg_gradient();
?>
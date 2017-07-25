<?php

/**
* 
* PHP Default Font Image Pluggable Set 
*
* Copyright (C) 2006 Matsuda Shota
* http://sgssweb.com/
* admin@sgssweb.com
*
* ------------------------------------------------------------------------
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
* ------------------------------------------------------------------------
*
*/



require_once 'package.fig.php';




class DefaultFontImagePluggableSet
	extends GMIPluggableSet
{
	var $defaultVariables = array(
		"text" => null,
		"size" => null,
		"font" => null,
		"color" => "0x000000",
		"alpha" => "100",
		"leading" => "{size}",
		"padding" => 0,
		"width" => null,
		"height" => null,
		"align" => "left",
		"valign" => "middle",
		"bgcolor" => "0xffffff",
		"bgtrans" => "true",
		"bgimage" => null,
		"antialias" => 4,
		"type" => "gif",
		"palette" => 256,
		"quality" => 100,
		"file" => null
	);
	
	function DefaultFontImagePluggableSet() {
		parent::GMIPluggableSet();
	}
	
	function getExpression() {
		
		$vars = $this->getVariables();
		
		if (isset($vars['exec'])) {
			return $vars['exec'];
		}
		
		if ($vars['text'] !== null && $vars['font'] !== null && $vars['size'] !== null) {
			$font = "font {font:{font},{size},{leading}};";
		
			if ($vars['width'] !== null && $vars['height'] !== null) {
				$string = "string {text},0,0,{width},{height},{align},{valign};";
				$autoResize = "autoresize width;";
			}
			else if ($vars['width'] !== null) {
				$string = "string {text},0,0,{width},{align};";
				$autoResize = "autoresize both;";
			}
			else {
				$string = "string {text};";
				$autoResize = "autoresize both;";
			}
		}
		else {
			$font = "";
			$string = "";
		}
		
		if ($vars['bgimage'] !== null) {
			$pattern = "pattern {image:{bgimage}};";
		}
		else {
			$pattern = "";
		}
		
		if ($vars['type'] == 'jpeg') {
			$type = "type {type},{quality};";
		}
		else {
			if ($vars['bgtrans'] == 'false') {
				$type = "type {type},{palette};";
			}
			else {
				$type = "type {type},{palette},{color:{bgcolor}};";
			}
		}
		
		if ($vars['file'] !== null) {
			$file = "file {file};";
		}
		else {
			$file = "";
		}

		return "size {width},{height}; $autoResize $type $file padding {padding}; color {color:{bgcolor}}; fill; $pattern color {color:{color},{alpha}}; antialias {antialias}; $font $string";
	}
	
	function getVariables() {
		return array_merge($this->defaultVariables, $_GET);
	}
}



// remove slashes inserted by "magic quotes"
if (get_magic_quotes_gpc()) {
	$_GET = array_map("strip_text_slashes", $_GET);
	$_POST = array_map("strip_text_slashes", $_POST);
	$_COOKIE = array_map("strip_text_slashes", $_COOKIE);
}
function strip_text_slashes($arg) {
	if(!is_array($arg)) {
		$arg = stripslashes($arg);
	}
	else if (is_array($arg)) {
		$arg = array_map("strip_text_slashes", $arg);
	}
	return $arg;
}



$pluggableSet = new DefaultFontImagePluggableSet();
$fig = new FontImageGenerator();
$fig->setPluggableSet($pluggableSet);
$fig->execute();


?>

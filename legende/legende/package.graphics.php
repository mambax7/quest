<?php

/**
* 
* PHP Graphics
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
*
* 2006-4-20		First release.
*
*/



require_once 'package.adt.php';



class Canvas
	extends Image
{
	var $autoResizeMode = 'none'; // string
	var $outputType = 'gif'; // string
	var $outputParameter = 256; // int
	var $transparentColor = null; // Color
	var $padding; // Insets
	var $width; // int
	var $height; // int
	
	// Canvas()
	// Canvas(int width, int height)
	function Canvas($width = 1, $height = 1) {
		parent::Image();
		$this->width = $width;
		$this->height = $height;
		$this->padding = new Insets();
	}
	
	// void setAutoResizeMode(string autoResizeMode)
	function setAutoResizeMode($autoResizeMode) {
		if ($autoResizeMode == 'none' || $autoResizeMode == 'width' || 
			$autoResizeMode == 'height' || $autoResizeMode == 'both') {
			$this->autoResizeMode = $autoResizeMode;
		}
	}
	// void setOutputType(string type)
	// void setOutputType(string type, int parameter)
	// void setOutputType(string type, int parameter, Color transparentColor)
	function setOutputType($type, $parameter = null, $transparentColor = null) {
		switch ($type) {
			case 'png':
				$this->outputType = $type;
				$this->outputParameter = ($parameter !== null)? $parameter
															  : 256;
				$this->transparentColor = ($transparentColor !== null)? $transparentColor
																	  : null;
				break;
			
			case 'jpeg':
				$this->outputType = $type;
				$this->outputParameter = ($parameter !== null)? $parameter
															  : 100;
				break;
			
			case 'gif':
				$this->outputType = $type;
				$this->outputParameter = ($parameter !== null)? $parameter
															  : 256;
				$this->transparentColor = ($transparentColor !== null)? $transparentColor
																	  : null;
				break;
		}	
	}
	// string getAutoResizeMode()
	function getAutoResizeMode() {
		return $this->autoResizeMode;
	}
	// void setPadding(Insets padding) {
	function setPadding(&$padding) {
		$this->padding =& $padding;
	}
	// Insets getPadding() {
	function &getPadding() {
		return $this->padding;
	}
	// int getWidth()
	function getWidth() {
		$padding =& $this->getPadding();
		if ($this->getAutoResizeMode() == 'both' || $this->getAutoResizeMode() == 'width') {
			$g =& $this->getGraphics();
			$clipBounds =& $g->getClipBounds();
			return $padding->left + $clipBounds->width + $padding->right;
		}
		return $padding->left + $this->width + $padding->right;
	}
	// int getHeight()
	function getHeight() {
		$padding =& $this->getPadding();
		if ($this->getAutoResizeMode() == 'both' || $this->getAutoResizeMode() == 'height') {
			$g =& $this->getGraphics();
			$clipBounds =& $g->getClipBounds();
			return $padding->top + $clipBounds->height + $padding->bottom;
		}
		return $padding->top + $this->height + $padding->bottom;
	}
	function setSize($arg1, $arg2 = null) {
		// void setSize(Dimension d)
		if(func_num_args() == 1) {
			$this->setSize($arg1->width, $arg1->height);
		}
		// void setSize(int width, int height)
		else if(func_num_args() == 2) {
			$this->width = $arg1;
			$this->height = $arg2;
		}
	}
	
	
	// Image getImage(string url)
	function getImage($url) {
		$extension = substr($url, -4);
		
		switch ($extension) {
			case "jpeg":
			case ".jpg":
				$source = @imageCreateFromJPEG($url);
				break;
				
			case ".gif":
				$source = @imageCreateFromGIF($url);
				break;
			
			case ".png":
			case "ping":
				$source = @imageCreateFromPNG($url);
				break;
			
			default:
				$source = null;
		}
		
		if (!$source) {
			return null;
		}
		
		$image = new Image();
		$image->setSource($source);
		
		return $image;
	}
	
	
	// void complete()	
	function complete() {
		$g =& $this->getGraphics();
		$contexts =& $g->getContexts();
		$clipBounds =& $g->getClipBounds();
		$padding =& $this->getPadding();
		
		$offsetX = $padding->left;
		$offsetY = $padding->top;
		
		switch ($this->getAutoResizeMode()) {
			case 'none':
				break;
				
			case 'width':
				$offsetX -= $clipBounds->x;
				break;
				
			case 'height':
				$offsetY -= $clipBounds->y;
				break;
				
			case 'both':
			default:
				$offsetX -= $clipBounds->x;
				$offsetY -= $clipBounds->y;
				break;
		}
		
		$this->source = imageCreateTrueColor(max(1, $this->getWidth()), max(1, $this->getHeight()));
		
		for ($i = 0; $i < count($contexts); $i ++) {
			$contexts[$i]->draw($this, $offsetX, $offsetY);
		}
		
		$g->dispose();
	}
	
	
	// void output()
	function output() {
		switch ($this->outputType) {
			case 'png':
				imageTrueColorToPalette($this->getSource(), false, $this->outputParameter);
				if ($this->transparentColor !== null) {
					$closestRGB = imageColorClosest($this->getSource(), 
													$this->transparentColor->getRed(), 
													$this->transparentColor->getGreen(), 
													$this->transparentColor->getBlue());
					imageColorTransparent($this->getSource(), $closestRGB);
				}
				header("Content-type: image/png");
				imagePNG($this->getSource());
				break;
				
			case 'jpeg':
				header("Content-type: image/jpeg");
				imageJPEG($this->getSource(), null, $this->outputParameter);
				break;
				
			case 'gif':
				imageTrueColorToPalette($this->getSource(), false, $this->outputParameter);
				if ($this->transparentColor !== null) {
					$closestRGB = imageColorClosest($this->getSource(), 
													$this->transparentColor->getRed(), 
													$this->transparentColor->getGreen(), 
													$this->transparentColor->getBlue());
					imageColorTransparent($this->getSource(), $closestRGB);
				}
				header("Content-type: image/gif");
				imageGIF($this->getSource());
				break;
		}
	}
}



class Graphics
{
	var $clipBounds; // Point
	var $contexts; // array
	
	var $color; // Color
	var $font; // Font
	var $antialias; // int
	var $textAntialias; // int
	
	var $offset; // Point
	
	// Graphics()
	function Graphics() {
		$this->clipBounds = null;
		$this->contexts = array();
		
		$this->color = new Color(0xffffff);
		$this->font = null;
		$this->antialias = 1;
		$this->textAntialias = 4;
		
		$this->offset = new Point();
	}
	
	// void setAntialias(int antialias)
	function setAntialias($antialias) {
		$this->antialias = $antialias;
	}
	// void setTextAntialias(int textAntialias)
	function setTextAntialias($textAntialias) {
		$this->textAntialias = $textAntialias;
	}
	// void setColor(Color color)
	function setColor(&$color) {
		$this->color =& $color;
	}
	// void setFont(Font font)
	function setFont(&$font) {
		$this->font =& $font;
	}
	// int getAntialias()
	function getAntialias() {
		return $this->antialias;
	}
	// int getTextAntialias()
	function getTextAntialias() {
		return $this->textAntialias;
	}
	// Color getColor()
	function &getColor() {
		return $this->color;
	}
	// Font getFont()
	function &getFont() {
		return $this->font;
	}
	// FontMetrics getFontMetrics()
	function &getFontMetrics() {
		return $this->font->getMetrics();
	}
	
	// void translate(int dx, int dy);
	function translate($dx, $dy) {
		$this->offset->translate($dx, $dy);
	}
	
	// void fill()
	function fill() {
		$context = new FillContext($this->getColor());
		$this->addContext($context);
	}
	
	// void pattern(Image image)
	// void pattern(Image image, string repeat)
	function pattern(&$image, $repeat = 'repeat') {
		if ($image === null) {
			return;
		}
		$context = new PatternContext($image, $repeat);
		$this->addContext($context);
	}
	
	function drawRect($arg1, $arg2 = null, $arg3 = null, $arg4 = null) {
		// void drawRect(Rectangle rect)
		if (func_num_args() == 1) {
			$this->drawRect($arg1->x, $arg1->y, $arg1->width, $arg1->height);
		}
		// void drawRect(int x, int y, int widht, int height)
		else if (func_num_args() == 4) {
			$context = new RectangleContext($this->offset->x + $arg1, $this->offset->y + $arg2, $arg3, $arg4, $this->getColor());
			$this->addContext($context);
			$this->updateClipBounds($context->getX(), $context->getY(), $context->getWidth(), $context->getHeight());
		}
	}
	
	function fillRect($arg1, $arg2 = null, $arg3 = null, $arg4 = null) {
		// void fillRect(Rectangle rect)
		if (func_num_args() == 1) {
			$this->fillRect($arg1->x, $arg1->y, $arg1->width, $arg1->height);
		}
		// void fillRect(int x, int y, int width, int height)
		else if (func_num_args() == 4) {
			$context = new FillRectangleContext($this->offset->x + $arg1, $this->offset->y + $arg2, $arg3, $arg4, $this->getColor());
			$this->addContext($context);
			$this->updateClipBounds($context->getX(), $context->getY(), $context->getWidth(), $context->getHeight());
		}
	}
	
	function patternRect(&$arg1, $arg2, $arg3 = null, $arg4 = null, $arg5 = null, $arg6 = null) {
		if ($arg1 === null) {
			return;
		}
		
		// void patternRect(Image image, Rectangle rect)
		if (func_num_args() == 2) {
			$this->patternRect($arg1, $arg2->x, $arg2->y, $arg2->width, $arg2->height, 'repeat');
		}
		// void patternRect(Image image, Rectangle rect, string repeat)
		else if (func_num_args() == 3) {
			$this->patternRect($arg1, $arg2->x, $arg2->y, $arg2->width, $arg2->height, $arg3);
		}
		// void patternRect(Image image, int x, int y, int width, int height)
		else if (func_num_args() == 5) {
			$this->patternRect($arg1, $arg2, $arg3, $arg4, $arg5, 'repeat');
		}
		// void patternRect(Image image, int x, int y, int width, int height, string repeat)
		else if (func_num_args() == 6) {
			$context = new PatternRectangleContext($arg1, $this->offset->x + $arg2, $this->offset->y + $arg3, $arg4, $arg5, $arg6);
			$this->addContext($context);
			$this->updateClipBounds($context->getX(), $context->getY(), $context->getWidth(), $context->getHeight());
		}
	}
	
	
	function drawImage(&$arg1, $arg2, $arg3, $arg4 = null, $arg5 = null, $arg6 = null, $arg7 = null, $arg8 = null, $arg9 = null) {
		if ($arg1 === null) {
			return;
		}
		
		// void drawImage(Image image, int x, int y)
		if (func_num_args() == 3) {
			$this->drawImage($arg1, 
							 $arg2, $arg3,
							 $arg2 + $arg1->getWidth(), $arg3 + $arg1->getHeight(),
							 0, 0,
							 $arg1->getWidth(), $arg1->getHeight());
		}
		// void drawImage(Image image, int x, int y, int width, int height)
		else if (func_num_args() == 5) {
			$this->drawImage($arg1, 
							 $arg2, $arg3,
							 $arg2 + $arg4, $arg3 + $arg5,
							 0, 0,
							 $arg1->getWidth(), $arg1->getHeight());
		}
		// void drawImage(Image image, int dx1, int dx1, int dx2, int dx2, int sx1, int sx1, int sx2, int sx2)
		else if (func_num_args() == 9) {
			$context = new ImageContext($arg1, 
										$this->offset->x + $arg2, $this->offset->y + $arg3,
										$this->offset->x + $arg4, $this->offset->y + $arg5,
										$arg6, $arg7,
										$arg8, $arg9);
								
			$this->addContext($context);
			$this->updateClipBounds($context->getX(), $context->getY(), $context->getWidth(), $context->getHeight());
		}
	}
	
	
	function drawString($arg1, $arg2 = null, $arg3 = null, $arg4 = null, $arg5 = null, $arg6 = null, $arg7 = null) {
		if ($this->getFont() === null) {
			return;
		}
		
		// void drawString(string text) 
		if (func_num_args() == 1) {
			$context = new TextContext($arg1, $this->offset->x, $this->offset->y, null, null, 'left', 'top', 
									   $this->getColor(), 
									   $this->getFont(),
									   $this->getTextAntialias());
		}
		// void drawString(string text, int x, int y) 
		else if (func_num_args() == 3) {
			$context = new TextContext($arg1, $this->offset->x + $arg2, $this->offset->y + $arg3, null, null, 'left', 'top', 
									   $this->getColor(), 
									   $this->getFont(),
									   $this->getTextAntialias());
		}
		// void drawString(string text, int x, int y, int width, int height) 
		else if (func_num_args() == 5) {
			$context = new TextContext($arg1, $this->offset->x + $arg2, $this->offset->y + $arg3, $arg4, $arg5, 'left', 'top', 
									   $this->getColor(), 
									   $this->getFont(),
									   $this->getTextAntialias());
		}
		// void drawString(string text, int x, int y, int width, int height, string align, string valign) 
		else if (func_num_args() == 7) {
			$context = new TextContext($arg1, $this->offset->x + $arg2, $this->offset->y + $arg3, $arg4, $arg5, $arg6, $arg7, 
									   $this->getColor(), 
									   $this->getFont(),
									   $this->getTextAntialias());
		}
		else {
			return;
		}
		
		$this->addContext($context);
		$this->updateClipBounds($context->getX(), $context->getY(), $context->getWidth(), $context->getHeight());
	}
	
	
	// array getContexts()
	function &getContexts() {
		return $this->contexts;
	}
	// void addContext(GraphicsContext context)
	function addContext(&$context) {
		array_push($this->contexts, $context);
	}
	
	
	// void dispose()
	function dispose() {
		for ($i = 0; $i < count($this->contexts); $i ++) {
			$this->contexts[$i]->dispose();
		}
		$this->contexts = array();
	}
	
	
	// Rectangle getContexts()
	function &getClipBounds() {
		return ($this->clipBounds !== null)? $this->clipBounds
										   : new Rectangle();
	}
	// void updateClipBounds(int x, int y, int width, int height)
	function updateClipBounds($x, $y, $width, $height) {
		if ($this->clipBounds === null) {
			$this->clipBounds = new Rectangle($x, $y, $width, $height);
		}
		else {
			$this->clipBounds->x = min($this->clipBounds->x, $x);
			$this->clipBounds->y = min($this->clipBounds->y, $y);
			$this->clipBounds->width = max($this->clipBounds->width, $x - $this->clipBounds->x + $width);
			$this->clipBounds->height = max($this->clipBounds->height, $y - $this->clipBounds->y + $height);
		}
	}
}



class GraphicsContext
{
	var $x = null; // int
	var $y = null; // int
	var $width = null; // int
	var $height = null; // int
	
	// GraphicsContext()
	function GraphicsContext() {
	}
	
	// void draw(Image image)
	function draw(&$image) {
	}
	
	// int getX()
	function getX() {
		return $this->x;
	}
	// int getY()
	function getY() {
		return $this->y;
	}
	// int getWidth()
	function getWidth() {
		return $this->width;
	}
	// int getHeight()
	function getHeight() {
		return $this->height;
	}
	
	// void dispose()
	function dispose() {
	}
}
	
	
class FillContext
	extends GraphicsContext
{
	var $color = null; // Color
	
	// FillContext(Color color)
	function FillContext($color) {
		parent::GraphicsContext();
		$this->color = $color;
	}
	
	// void draw(Image image)
	// void draw(Image image, int offsetX, int offsetY)
	function draw(&$image, $offsetX = 0, $offsetY = 0) {
		$this->drawImpl($image, 0, 0, $offsetX + $image->getWidth(), $offsetY + $image->getHeight());
	}
	
	// void drawImpl(Image image, int x, int y, int width, int height)
	function drawImpl(&$image, $x, $y, $width, $height) {
		imageFilledRectangle($image->getSource(),
							 $x, $y, 
							 $x + $width, $y + $height,
							 $this->color->getRGB());
	}
}
	
	
class FillRectangleContext
	extends FillContext
{
	// FillRectangleContext(int x, int y, int width, int height, Color color)
	function FillRectangleContext($x, $y, $width, $height, $color) {
		parent::FillContext($color);
		$this->x = $x;
		$this->y = $y;
		$this->width = $width - 1;
		$this->height = $height - 1;
	}
	
	// void draw(Image image)
	// void draw(Image image, int offsetX, int offsetY)
	function draw(&$image, $offsetX = 0, $offsetY = 0) {
		$this->drawImpl($image, $offsetX + $this->x, $offsetY + $this->y, $this->width, $this->height);
	}
}


class RectangleContext
	extends FillRectangleContext
{
	// RectangleContext(int x, int y, int width, int height, Color color)
	function RectangleContext($x, $y, $width, $height, $color) {
		parent::FillRectangleContext($x, $y, $width, $height, $color);
	}
	
	// void drawImpl(Image image, int x, int y, int width, int height)
	function drawImpl(&$image, $x, $y, $width, $height) {
		imageRectangle($image->getSource(),
					   $x, $y, 
					   $x + $width, $y + $height,
					   $this->color->getRGB());
	}
}


class PatternContext
	extends GraphicsContext
{
	var $image = null; // Image
	var $repeat; // string
	
	// PatternContext(Image image, string repeat)
	function PatternContext($image, $repeat) {
		parent::GraphicsContext();
		$this->image = $image;
		$this->repeat = $repeat;
	}
	
	// void draw(Image image)
	// void draw(Image image, int offsetX, int offsetY)
	function draw(&$image, $offsetX = 0, $offsetY = 0) {
		$this->drawImpl($image, 0, 0, $image->getWidth(), $image->getHeight());
	}
	
	// void drawImpl(Image image, int x, int y, int width, int height)
	function drawImpl(&$image, $x, $y, $width, $height) {
		if (!is_resource($this->image->getSource())) {
			return;
		}
		
		imageSetTile($image->getSource(), $this->image->getSource());
		switch ($this->repeat) {
			case 'repeat':
				imageFilledRectangle($image->getSource(), 
									 $x, $y, 
									 $x + $width, $y + $height,
									 IMG_COLOR_TILED);
				break;
			case 'repeat-x':
				imageFilledRectangle($image->getSource(),
									 $x, $y, 
									 $x + $width, $y + min($this->image->getHeight() - 1, $height),
									 IMG_COLOR_TILED);
				break;
			case 'repeat-y':
				imageFilledRectangle($image->getSource(), 
									 $x, $y, 
									 $x + min($this->image->getWidth() - 1, $width), $y + $height,
									 IMG_COLOR_TILED);
				break;
			case 'no-repeat':
				imageFilledRectangle($image->getSource(), 
									 $x, $y, 
									 $x + min($this->image->getWidth() - 1, $width), $y + min($this->image->getHeight() - 1, $height),
									 IMG_COLOR_TILED);
				break;
		}
	}
	
	// void dispose()
	function dispose() {
		$this->image->flush();
	}
}


class PatternRectangleContext
	extends PatternContext
{
	// PatternRectangleContext(Image image, Rectangle rect, string repeat)
	function PatternRectangleContext($image, $x, $y, $width, $height, $repeat) {
		parent::PatternContext($image, $repeat);
		$this->x = $x;
		$this->y = $y;
		$this->width = $width - 1;
		$this->height = $height - 1;
	}
	
	// void draw(Image image)
	// void draw(Image image, int offsetX, int offsetY)
	function draw(&$image, $offsetX = 0, $offsetY = 0) {
		$this->drawImpl($image, $offsetX + $this->x, $offsetY + $this->y, $this->width, $this->height);
	}
}


class ImageContext
	extends GraphicsContext
{
	var $image = null;
	
	var $sx; // int
	var $sy; // int
	var $sw; // int
	var $sh; // int
	
	// ImageContext(Image image, int dx1, int dy1, int dx2, int dy2, int sx1, int sy1, int sx2, int sy2)
	function ImageContext($image, $dx1, $dy1, $dx2, $dy2, $sx1, $sy1, $sx2, $sy2) {
		parent::GraphicsContext();
		
		$this->image = $image;
		$this->x = min($dx1, $dx2);
		$this->y = min($dy1, $dy2);
		$this->width = abs($dx1 - $dx2);
		$this->height = abs($dy1 - $dy2);
		$this->sx = min($sx1, $sx2);
		$this->sy = min($sy1, $sy2);
		$this->sw = abs($sx1 - $sx2);
		$this->sh = abs($sy1 - $sy2);
	}
	
	// void draw(Image image)
	// void draw(Image image, int offsetX, int offsetY)
	function draw(&$image, $offsetX = 0, $offsetY = 0) {
		if (!is_resource($this->image->getSource())) {
			return;
		}
		
		imageCopyResampled($image->getSource(), // destination image
				  		   $this->image->getSource(), // source image
				  		   $offsetX + $this->x, $offsetY + $this->y, // destination x, y
				  		   $this->sx, $this->sy, // source x, y
				  		   $this->width, $this->height, // destination w, h
				  		   $this->sw, $this->sh); // source w, h
	}
	
	// void dispose()
	function dispose() {
		$this->image->flush();
	}
}


class TextContext
	extends GraphicsContext
{
	var $color = null; // Color
	var $font = null; // Font
	var $metrics; // FontMetrics
	
	var $text; // string
	var $align; // string
	var $valign; // string
	var $textAntialias; // int
	
	var $lines; // array
	var $lineCount; // int
	var $actualWidth; // int
	var $actualHeight; // int
	
	// TextContext(string text, int x, int y, int width, int height, string align, string valign, Color color, Font font, int textAntialias) 
	function TextContext($text, $x, $y, $width, $height, $align, $valign, $color, $font, $textAntialias) {
		parent::GraphicsContext();
		
		$this->font = $font->deriveFont($font->size * $textAntialias);
		$this->metrics = $this->font->getMetrics();
		$this->text = $text;
		$this->x = $x;
		$this->y = $y;
		$this->width = ($width === null)? 65536 : $width;
		$this->height = ($height === null)? 65536 : $height;
		$this->color = $color;
		$this->align = $align;
		$this->valign = $valign;
		$this->textAntialias = $textAntialias;
		
		$this->prepareDrawing();
	}
	
	// void draw(Image image)
	// void draw(Image image, int offsetX, int offsetY)
	function draw(&$image, $offsetX = 0, $offsetY = 0) {
		$this->boxedString($image, $this->text, 
						   $offsetX + $this->x, $offsetY + $this->y, 
						   $this->width, $this->height, 
						   $this->align, $this->valign);
	}
	
	// int getWidth()
	function getWidth() {
		return ($this->width == 65536)? $this->actualWidth
									  : $this->width;
	}
	// int getHeight()
	function getHeight() {
		return ($this->height == 65536)? $this->actualHeight
									   : $this->height;
	}
	
	
	// void prepareDrawing()
	function prepareDrawing() {
		
		// make a line array by dividing at a break return
		$lines = preg_split("/\n/", $this->text);
		
		$this->lineCount = 0;
		$this->actualWidth = 0;
		
		$caret = 0;
		$previousCaret = 0;
		
		for ($i = 0; $i < count($lines); $i ++) {
			
			$lines[$i] = array($lines[$i]);
			
			for ($n = 0; $n < count($lines[$i]); $n ++) {
				// calcurates string width when founds a space in a line.
				// if string width is wider than the width, 
				// back the caret to the previous space position and splice line into two.
				while ($caret <= strlen($lines[$i][$n])) {
					$caret ++;
					
					// splice at previous character position
					// if no space is found before string width is wider than the width.
					if ($i == 0 && $previousCaret == 0) {
						$lineWidth = round($this->metrics->stringWidth(trim(substr($lines[$i][$n], 0, $caret))) / $this->textAntialias);
						if ($lineWidth >= $this->width) {
							$previousCaret = max(1, $caret - 1);
						}
					}
					
					if (substr($lines[$i][$n], $caret, 1) == " " || $caret == strlen($lines[$i][$n])) {
						
						$lineWidth = round($this->metrics->stringWidth(trim(substr($lines[$i][$n], 0, $caret))) / $this->textAntialias);
						$this->actualWidth = max($lineWidth, $this->actualWidth);
						
						if ($lineWidth >= $this->width) {
							// divide a line into two with deleting extra spaces at the each side.
							array_splice($lines[$i], $n, 1, array(trim(substr($lines[$i][$n], 0, $previousCaret)),
																  trim(substr($lines[$i][$n], $previousCaret))));
							break;
						}
						// cache the current caret position.
						$previousCaret = $caret;
					}
				}
				// reset the caret position.
				$caret = $previousCaret = 0;
				
				$this->lineCount ++;
			}
		}
		
		$this->actualHeight = round($this->metrics->getLeading() * $this->lineCount / $this->textAntialias);
		$this->lines =& $lines;
	}
	
	
	// void draw(Image image, string text, int x, int y)
	function imageString(&$image, $text, $x, $y) {
		$width = $this->metrics->stringWidth($text);
		$height = $this->metrics->getHeight();
		$bufferedWidth = round($width / $this->textAntialias);
		$bufferedHeight = round($height / $this->textAntialias);
		
		$transparentRGB = $this->color->getTransparent();
		$bufferedSource = imageCreateTrueColor($width, $height);
		$bufferedSource2 = imageCreateTrueColor($bufferedWidth, $bufferedHeight);
		imageFill($bufferedSource, 0, 0, $transparentRGB);
		// for garbage detection
		imagealphablending($bufferedSource2, false);
		
		imageTTFText(
			$bufferedSource, // image
			$this->font->size, // size
			0, // angle
			0, $this->metrics->getAscent(), // x, y
			min(-1, -$this->color->getRGB()), // color
			$this->font->name, // font
			$text // text
		);
		
		imageCopyResampled($bufferedSource2, // dest
						   $bufferedSource, // source
						   0, 0, // dest x, y
						   0, 0, // source x, y
						   $bufferedWidth, $bufferedHeight, // dest w, h
						   $width, $height); // source w, h
		
		// remove alpha garbages result from imageCopyResampled
		for ($dx =0; $dx < imagesX($bufferedSource2); $dx ++) {
			for ($dy =0; $dy < imagesY($bufferedSource2); $dy ++) {
				if (imagecolorat($bufferedSource2, $dx, $dy) > 0x7d000000) {
					imagesetpixel($bufferedSource2, $dx, $dy, $transparentRGB);
				}
			}
		}
		
		imageCopy($image->getSource(),
				  $bufferedSource2,
				  $x, $y,
				  0, 0,
				  $bufferedWidth, $bufferedHeight);
		
		imageDestroy($bufferedSource);
		imageDestroy($bufferedSource2);	
	}
	
	/** 
	 * draws aligned string.
	 *
	 * the calcuration method of drawing position of each line is:
	 * 
	 *  left:
	 *      X.line = X
	 * 
	 *  center:
	 *                   W - W.line
	 *      X.line = X + ----------
	 *                       2
	 * 
	 *  right:
	 *      X.line = X + W - W.line
	 * 
	 *  adjust:
	 *                                          n
	 *                                     W -  ∑ W.word(i)
	 *                       k                 i=0
	 *      X.word(k) = X +  ∑ W.word(i) + ---------------- * k     (0 <= k <= n, n != 1)
	 *                      i=0                  n - 1
	 *
	 */
	// void alignedString(Image image, string text, int x, int y, int width, string align)
	function alignedString(&$image, $text, $x, $y, $width, $align) {
		
		switch ($align) {
			case 'left':
				$this->imageString($image, $text, $x, $y);
				break;
				
			case 'center':
				$this->imageString($image, 
								   $text, 
								   $x + ($width - round($this->metrics->stringWidth($text) / $this->textAntialias)) / 2, $y);
				break;
				
			case 'right':
				$this->imageString($image, 
								   $text, 
								   $x + $width - round($this->metrics->stringWidth($text) / $this->textAntialias), $y);
				break;
				
			case 'adjust':
				// split a line into an array by space.
				$words = preg_split("/\s/", $text);
				
				// store the width of each words.
				$widths = array();
				for($i = 0; $i < count($words); $i ++) {
					$widths[$i] = round($this->metrics->stringWidth($words[$i]) / $this->textAntialias);
				}
				
				// draw
				for ($i = 0; $i < count($words); $i ++) {
					if (strlen($words[$i]) > 0) {
						$this->imageString($image, 
								   		   $words[$i],
										   $x + array_sum(array_slice($widths, 0, $i)) + ($width - array_sum($widths)) / max(1, count($words) - 1) * $i, $y);
					}
				}
				break;
		}
	}
		
	/**
	 * draws multi-line string in a box.
	 * 
	 * this firstly splits the string into an array by break return, 
	 * then splits again each paragraph by width.
	 * 
	 * text alignments is "left", "center", "right", "left-adjust", "center-adjust", "right-adjust" and "adjust".
	 * last 4 alignments behave the same as "adjust" except the last line of a paragraph.
	 * 
	 */
	// void boxedString(Image image, string text, int x, int y, int width, int height, string align, string valign)
	function boxedString(&$image, $text, $x, $y, $width, $height, $align, $valign) {
		/** 
		 * calcurate offset of y position for vetical alignment.
		 * the offset doesn't be under 0 in "bottom" and "middle" alignment
		 *
		 * the calcuration method of drawing y position of text box is:
		 *
		 *              n-1
		 *  Y.box = W -  ∑ H.line(i) - ASCENT.line - DESCENT.line
		 *               i
		 *
		 */
		$offsetY = 0;
		switch ($valign) {
			case 'bottom':
				$offsetY = max(0, $height - $this->actualHeight);
				break;
				
			case 'middle':
				$offsetY = max(0, ($height - $this->actualHeight) / 2);
				break;
				
			case 'top':
			default:
		}
		
		$leading = round($this->metrics->getLeading() / $this->textAntialias);
		$lineNum = 0;
		
		// draw all string elements
		for ($i = 0; $i < count($this->lines); $i ++) {
			for ($n = 0; $n < count($this->lines[$i]); $n ++) {
			
				// if element is not empty
				// and is not taller than height
				if (strlen($this->lines[$i][$n]) > 0 &&
					$y + $leading * $lineNum < $height) {
				   
				   	
					if (($n < count($this->lines[$i]) - 1 && 
						($align == 'left-adjust' || $align == 'center-adjust' || $align == 'right-adjust')) ||
						$align == 'adjust') {
					   
						$this->alignedString($image,
											 $this->lines[$i][$n], 
											 $x, $offsetY + $y + $leading * $lineNum, 
											 $width,
											 'adjust');
					}
				   	else {
				   		switch ($align) {
							case 'right':
							case 'right-adjust':
								$this->alignedString($image,
													 $this->lines[$i][$n], 
													 $x, $offsetY + $y + $leading * $lineNum, 
													 $width,
													 'right');
								break;
								
							case 'center':
							case 'center-adjust':
								$this->alignedString($image,
													 $this->lines[$i][$n], 
													 $x, $offsetY + $y + $leading * $lineNum, 
													 $width,
													 'center');
								break;
							
							case 'left':
							case 'left-adjust':
							default:
								$this->alignedString($image,
													 $this->lines[$i][$n], 
													 $x, $offsetY + $y + $leading * $lineNum, 
													 $width,
													 'left');
						}
					}
				}
				
				$lineNum ++;
			}
		}
	}
}




?>
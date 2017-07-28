<?php

/**
 *
 * PHP Abstract Drawing Toolkit
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
 * 2006-4-20        First release.
 *
 */

class Image
{
    public $source; // resource
    public $graphics; // Graphics

    // Image(resource source)
    /**
     * Image constructor.
     */
    public function __construct()
    {
        $this->graphics = new Graphics($this);
    }

    // int getWidth()

    /**
     * @return int
     */
    public function getWidth()
    {
        return imagesx($this->source);
    }

    // int getHeight()

    /**
     * @return int
     */
    public function getHeight()
    {
        return imagesy($this->source);
    }

    // Graphics getGraphics()

    /**
     * @return \Graphics
     */
    public function getGraphics()
    {
        return $this->graphics;
    }

    // Image &getScaledInstance(int width, int height)

    /**
     * @param $width
     * @param $height
     * @return \Image
     */
    public function getScaledInstance($width, $height)
    {
        $newSource = imagecreatetruecolor($width, $height);
        imagecopyresampled($newSource, // dest
                           $this->source, // source
                           0, 0, // dest x, y
                           0, 0, // source x, y
                           $width, $height, // dest w, h
                           $this->getWidth(), $this->getWidth()); // source w, h
        $newImage = new Image($newSource);

        return $newImage;
    }

    // resource getSource()
    public function &getSource()
    {
        return $this->source;
    }

    // void setSource(resource source)

    /**
     * @param $source
     */
    public function setSource(&$source)
    {
        $this->source =& $source;
    }

    // void flush()
    public function flush()
    {
        imagedestroy($this->source);
    }
}

/**
 * Class Font
 */
class Font
{
    public $name; // string
    public $size; // int
    public $metrics; // FontMetrics

    // Font(string name, int size)
    /**
     * Font constructor.
     * @param $name
     * @param $size
     */
    public function __construct($name, $size)
    {
        $this->name    = $name;
        $this->size    = $size;
        $this->metrics = new FontMetrics($this);
    }

    // FontMetrics getMetrics()

    /**
     * @return \FontMetrics
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    // Font deriveFont(int size)

    /**
     * @param $size
     * @return \Font
     */
    public function deriveFont($size)
    {
        $font                   = new Font($this->name, $size);
        $font->metrics          = new FontMetrics($font);
        $font->metrics->leading = $this->metrics->leading;

        return $font;
    }

    // string getFontName()
    public function getFontName()
    {
        return $this->name;
    }

    // string getSize()
    public function getSize()
    {
        return $this->size;
    }
}

/**
 * Class FontMetrics
 */
class FontMetrics
{
    public $font; // Font
    public $leading; // float
    public $cornersCache; // array

    // FontMetrics(Font font)
    /**
     * FontMetrics constructor.
     * @param $font
     */
    public function __construct(&$font)
    {
        $this->font    =& $font;
        $this->leading = 1.75;
        $this->_invalidateCornersCache();
    }

    // int stringWidth(string text)

    /**
     * @param $text
     * @return mixed
     */
    public function stringWidth($text)
    {
        $corners = $this->_calcurateCorners($text);

        return $corners[2];
    }

    // int getAscent()

    /**
     * @return mixed
     */
    public function getAscent()
    {
        if ($this->cornersCache === null) {
            $this->_createCornersCache();
        }

        return -$this->cornersCache[5];
    }

    // int getDescent()

    /**
     * @return mixed
     */
    public function getDescent()
    {
        if ($this->cornersCache === null) {
            $this->_createCornersCache();
        }

        return $this->cornersCache[1];
    }

    // int getHeight()

    /**
     * @return mixed
     */
    public function getHeight()
    {
        if ($this->cornersCache === null) {
            $this->_createCornersCache();
        }

        return $this->cornersCache[1] - $this->cornersCache[5];
    }

    // int getLeading()

    /**
     * @return int
     */
    public function getLeading()
    {
        return (int)($this->getHeight() * $this->leading);
    }

    // void setLineHeight(number lineHeight)

    /**
     * @param $lineHeight
     */
    public function setLineHeight($lineHeight)
    {
        $this->leading = $lineHeight / $this->font->size;
    }

    /**
     * @param $text
     * @return array
     */
    public function _calcurateCorners($text)
    {
        // dummy image for specifying text image corners
        $image = imagecreate(1, 1);

        return imagettftext($image, $this->font->size, 0, 0, 0, -1, $this->font->name, $text);
    }

    public function _createCornersCache()
    {
        $this->cornersCache = $this->_calcurateCorners('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890');
    }

    public function _invalidateCornersCache()
    {
        $this->cornersCache = null;
    }
}

/**
 * Class Rectangle
 */
class Rectangle
{
    public $x; // int
    public $y; // int
    public $width; // int
    public $height; // int

    /**
     * Rectangle constructor.
     * @param null $arg1
     * @param null $arg2
     * @param null $arg3
     * @param null $arg4
     */
    public function __construct($arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null)
    {
        // Rectangle()
        if (func_num_args() == 0) {
            $this->Rectangle(0, 0, 0, 0);
        } // Rectangle(Point p)
        elseif (func_num_args() == 1 && get_class($arg1) == 'point') {
            $this->Rectangle($arg1->x, $arg1->y, 0, 0);
        } // Rectangle(Dimension d)
        elseif (func_num_args() == 1 && get_class($arg1) == 'dimension') {
            $this->Rectangle(0, 0, $arg1->width, $arg1->height);
        } // Rectangle(Point p, Dimension d)
        elseif (func_num_args() == 2 && get_class($arg1) == 'point' && get_class($arg2) == 'dimension') {
            $this->Rectangle($arg1->x, $arg1->y, $arg2->width, $arg2->height);
        } // Rectangle(int width, int height)
        elseif (func_num_args() == 2) {
            $this->Rectangle(0, 0, $arg1, $arg2);
        } // Rectangle(int x, int y, int width, int height)
        elseif (func_num_args() == 4) {
            $this->x      = $arg1 + 0;
            $this->y      = $arg2 + 0;
            $this->width  = $arg3 + 0;
            $this->height = $arg4 + 0;
        }
    }

    // Point getLocation()
    public function getLocation()
    {
        return new Point($this->x, $this->y);
    }

    // Dimension getSize()
    public function getSize()
    {
        return new Dimension($this->width, $this->height);
    }

    // int getX()
    public function getX()
    {
        return $this->x;
    }

    // int getY()
    public function getY()
    {
        return $this->y;
    }

    // int getWidth()
    public function getWidth()
    {
        return $this->width;
    }

    // int getHeight()
    public function getHeight()
    {
        return $this->height;
    }

    public function setSize($arg1, $arg2 = null)
    {
        // void setSize(Dimension d)
        if (func_num_args() == 1) {
            $this->setSize($arg1->width, $arg1->height);
        } // void setSize(int width, int height)
        elseif (func_num_args() == 2) {
            $this->width  = $arg1 + 0;
            $this->height = $arg2 + 0;
        }
    }

    public function setLocation($arg1, $arg2 = null)
    {
        // void setLocation(Point p)
        if (func_num_args() == 1) {
            $this->setLocation($arg1->x, $arg1->y);
        } // void setLocation(int x, int y)
        elseif (func_num_args() == 2) {
            $this->x = $arg1 + 0;
            $this->y = $arg2 + 0;
        }
    }

    // void translate(int dx, int dy)
    public function translate($dx, $dy)
    {
        $this->x += $dx;
        $this->y += $dy;
    }

    // void grow(int h, int v)
    public function grow($h, $v)
    {
        $this->width  += $h;
        $this->height += $v;
    }
}

class Insets
{
    public $top; // int
    public $left; // int
    public $bottom; // int
    public $right; // int

    public function __construct($top = 0, $left = 0, $bottom = 0, $right = 0)
    {
        // Insets()
        // Insets(int top, int left, int bottom, int right)
        $this->top    = $top + 0;
        $this->left   = $left + 0;
        $this->bottom = $bottom + 0;
        $this->right  = $right + 0;
    }
}

class Point
{
    public $x; // int
    public $y; // int

    public function __construct($arg1 = null, $arg2 = null)
    {
        // Point()
        if (func_num_args() == 0) {
            $this->Point(0, 0);
        } // Point(Point p)
        elseif (func_num_args() == 1) {
            $this->Point($arg1->x, $arg1->y);
        } // Point(int x, int y)
        elseif (func_num_args() == 2) {
            $this->x = $arg1 + 0;
            $this->y = $arg2 + 0;
        }
    }

    // void translate(int dx, int dy)
    public function translate($dx, $dy)
    {
        $this->x += $dx;
        $this->y += $dy;
    }

    // int getX()
    public function getX()
    {
        return $this->x;
    }

    // int getY()
    public function getY()
    {
        return $this->y;
    }

    // Point getLocation()
    public function getLocation()
    {
        return new Point($this->x, $this->y);
    }

    public function setLocation($arg1, $arg2 = null)
    {
        // void setLocation(Point p)
        if (func_num_args() == 1) {
            $this->setLocation($arg1->x, $arg1->y);
        } // void setLocation(int x, int y)
        elseif (func_num_args() == 2) {
            $this->x = $arg1 + 0;
            $this->y = $arg2 + 0;
        }
    }
}

class Dimension
{
    public $width; // int
    public $height; // int

    public function __construct($arg1 = null, $arg2 = null)
    {
        // Dimension()
        if (func_num_args() == 0) {
            $this->Dimension(0, 0);
        } // Dimension(Dimension d)
        elseif (func_num_args() == 1) {
            $this->Dimension($arg1->width, $arg1->height);
        } // Dimension(int x, int y)
        elseif (func_num_args() == 2) {
            $this->width  = $arg1 + 0;
            $this->height = $arg2 + 0;
        }
    }

    // int getWidth()
    public function getWidth()
    {
        return $this->width;
    }

    // int getHeight()
    public function getHeight()
    {
        return $this->height;
    }

    // Dimension getSize()
    public function getSize()
    {
        return new Dimension($this->width, $this->height);
    }

    public function setSize($arg1, $arg2 = null)
    {
        // setSize(Dimension d)
        if (func_num_args() == 1) {
            $this->setSize($arg1->width, $arg1->height);
        } // setSize(int x, int y)
        elseif (func_num_args() == 2) {
            $this->width  = $arg1;
            $this->height = $arg2;
        }
    }
}

class Color
{
    public $value; // int

    public function __construct($arg1, $arg2 = null, $arg3 = null, $arg4 = null)
    {
        // Color(int argb)
        if (func_num_args() == 1) {
            $this->value = $arg1 & 0x7fffffff;
        } // Color(int rgb, int a)
        elseif (func_num_args() == 2) {
            $this->Color($arg1 >> 16, $arg1 >> 8, $arg1, $arg2);
        } // Color(int r, int g, int b)
        elseif (func_num_args() == 3) {
            $this->Color($arg1, $arg2, $arg3, 0);
        } // Color(int r, int g, int b, int a)
        elseif (func_num_args() == 4) {
            $this->Color((((100 - $arg4) * 1.27) & 0x7f) << 24 | ($arg1 & 0xff) << 16 | ($arg2 & 0xff) << 8 | ($arg3 & 0xff) << 0);
        }
    }

    // int getRed()
    public function getRed()
    {
        return ($this->value >> 16) & 0xff;
    }

    // int getGreen()
    public function getGreen()
    {
        return ($this->value >> 8) & 0xff;
    }

    // int getBlue()
    public function getBlue()
    {
        return ($this->value >> 0) & 0xff;
    }

    // int getAlpha()
    public function getAlpha()
    {
        return 100 - (($this->value >> 24) & 0x7f) / 1.27;
    }

    // int getRGB()
    public function getRGB()
    {
        return $this->value;
    }

    // int getTransparent()
    public function getTransparent()
    {
        return ((0x7f << 24) | ($this->getRed() << 16) | ($this->getGreen() << 8) | $this->getBlue());
    }
}

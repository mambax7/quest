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

require_once __DIR__ . '/package.fig.php';

/**
 * Class DefaultFontImagePluggableSet
 */
class DefaultFontImagePluggableSet extends GMIPluggableSet
{
    public $defaultVariables = [
        'text'      => null,
        'size'      => null,
        'font'      => null,
        'color'     => '0x000000',
        'alpha'     => '100',
        'leading'   => '{size}',
        'padding'   => 0,
        'width'     => null,
        'height'    => null,
        'align'     => 'left',
        'valign'    => 'middle',
        'bgcolor'   => '0xffffff',
        'bgtrans'   => 'true',
        'bgimage'   => null,
        'antialias' => 4,
        'type'      => 'gif',
        'palette'   => 256,
        'quality'   => 100,
        'file'      => null
    ];

    /**
     * DefaultFontImagePluggableSet constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed|string
     */
    public function getExpression()
    {
        $vars = $this->getVariables();

        if (isset($vars['exec'])) {
            return $vars['exec'];
        }

        if (null !== $vars['text'] && null !== $vars['font'] && null !== $vars['size']) {
            $font = 'font {font:{font},{size},{leading}};';

            if (null !== $vars['width'] && null !== $vars['height']) {
                $string     = 'string {text},0,0,{width},{height},{align},{valign};';
                $autoResize = 'autoresize width;';
            } elseif (null !== $vars['width']) {
                $string     = 'string {text},0,0,{width},{align};';
                $autoResize = 'autoresize both;';
            } else {
                $string     = 'string {text};';
                $autoResize = 'autoresize both;';
            }
        } else {
            $font   = '';
            $string = '';
        }

        if (null !== $vars['bgimage']) {
            $pattern = 'pattern {image:{bgimage}};';
        } else {
            $pattern = '';
        }

        if ('jpeg' == $vars['type']) {
            $type = 'type {type},{quality};';
        } else {
            if ('false' == $vars['bgtrans']) {
                $type = 'type {type},{palette};';
            } else {
                $type = 'type {type},{palette},{color:{bgcolor}};';
            }
        }

        if (null !== $vars['file']) {
            $file = 'file {file};';
        } else {
            $file = '';
        }

        return "size {width},{height}; $autoResize $type $file padding {padding}; color {color:{bgcolor}}; fill; $pattern color {color:{color},{alpha}}; antialias {antialias}; $font $string";
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return array_merge($this->defaultVariables, $_GET);
    }
}

// remove slashes inserted by "magic quotes"
if (get_magic_quotes_gpc()) {
    $_GET    = array_map('strip_text_slashes', $_GET);
    $_POST   = array_map('strip_text_slashes', $_POST);
    $_COOKIE = array_map('strip_text_slashes', $_COOKIE);
}
/**
 * @param $arg
 * @return array|string
 */
function strip_text_slashes($arg)
{
    if (!is_array($arg)) {
        $arg = stripslashes($arg);
    } elseif (is_array($arg)) {
        $arg = array_map('strip_text_slashes', $arg);
    }

    return $arg;
}

$pluggableSet = new DefaultFontImagePluggableSet();
$fig          = new FontImageGenerator();
$fig->setPluggableSet($pluggableSet);
$fig->execute();

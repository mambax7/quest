<?php
//  ------------------------------------------------------------------------ //
//                        QUEST - MODULE FOR XOOPS 2                         //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is NOT free software; you can NOT redistribute it and/or    //
//  modify without my assent.                                                //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed WITHOUT ANY WARRANTY; without even the       //
//  implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. //
//  ------------------------------------------------------------------------ //
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/*
 * Fonction, incomplète, pour générer un fichier csv
 *
 */

/**
 * Class csv
 */
class csv
{
    public $escapetrings;            // Booléen, faut il échapper les chaines de caractères ?
    public $stringsseparator;        // S'il faut échapper les chaines de caractères, indique avec quel caractère
    public $lineseparator;            // Séparateur de lignes
    public $fieldseparator;        // Séparateur de champs
    public $header;                // Entête
    public $line;                    // Ligne de données
    public $filename;                // Nom du fichier
    public $fp;                    // Pointeur de fichier

    /**
     * csv constructor.
     * @param string $filename
     * @param string $fieldseparator
     * @param string $lineseparator
     * @param bool   $escapestring
     * @param string $stringseparator
     */
    public function __construct($filename = '', $fieldseparator = '|', $lineseparator = "\n", $escapestring = false, $stringseparator = '')
    {
        $this->filename         = $filename;
        $this->fieldseparator   = $fieldseparator;
        $this->lineseparator    = $lineseparator;
        $this->escapetrings     = $escapestring;
        $this->stringsseparator = $stringseparator;
        $this->header           = array();
        $this->line             = array();
    }

    public function openCSV()
    {
        $this->fp = fopen($this->filename, 'w') || exit('Error, impossible to create the requested file');
    }

    public function closeCSV()
    {
        fclose($this->fp);
    }

    /**
     * @param $field
     */
    public function addHeader($field)
    {
        $this->header[] = $field;
    }

    public function writeHeader()
    {
        fwrite($this->fp, implode($this->fieldseparator, $this->header) . $this->lineseparator);
    }

    /**
     * @param $data
     */
    public function addData($data)
    {
        if ($this->escapetrings && is_string($data)) {
            $this->line[] = $this->stringsseparator . $data . $this->stringsseparator;
        } else {
            $this->line[] = $data;
        }
    }

    public function clearData()
    {
        $this->line = array();
    }

    public function writeData()
    {
        fwrite($this->fp, implode($this->fieldseparator, $this->line) . $this->lineseparator);
        $this->clearData();
    }
}

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

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
//if (!class_exists('XoopsPersistableObjectHandler')) {
//    include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';
//}

include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';


class questions extends MyObject
{
    public function __construct()
    {
        $this->initVar('IdQuestion', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdQuestionnaire', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdCategorie', XOBJ_DTYPE_INT, null, false);
        $this->initVar('TexteQuestion', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('OrdreQuestion', XOBJ_DTYPE_INT, null, false);
        $this->initVar('ComplementQuestion', XOBJ_DTYPE_TXTAREA, null, false);
    }
}

class QuestQuestionsHandler extends MyXoopsPersistableObjectHandler
{
    public function __construct($db)
    {    //                                         Table               Classe      Id
        parent::__construct($db, 'quest_questions', 'questions', 'IdQuestion');
    }

    /**
     * Renvoie le nombre de questions par cat?gorie d'un questionnaire particulier
     *
     * @param  int $IdQuestionnaire Identifiant du questionnaire
     * @return array Cl?=Id Cat?gorie Valeur=Nombre de questions
     */
    public function QuestionsCountPerQuestionnaire($IdQuestionnaire)
    {
        $ret    = array();
        $sql    = 'SELECT count(*) as cpt, IdCategorie FROM ' . $this->table . ' WHERE IdQuestionnaire=' . (int)$IdQuestionnaire . ' GROUP BY IdCategorie ORDER BY IdCategorie';
        $result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[$myrow['IdCategorie']] = $myrow['cpt'];
        }

        return $ret;
    }
}

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

/**
 * Class respondquestionn
 */
class respondquestionn extends MyObject
{
    /**
     * respondquestionn constructor.
     */
    public function __construct()
    {
        $this->initVar('IdRespondQuestion', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdQuestionnaire', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdRespondant', XOBJ_DTYPE_INT, null, false);
        $this->initVar('DateDebut', XOBJ_DTYPE_INT, null, false);
        $this->initVar('DateFin', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Statut', XOBJ_DTYPE_INT, null, false);
    }
}

/**
 * Class QuestRespondquestionnHandler
 */
class QuestRespondquestionnHandler extends MyXoopsPersistableObjectHandler
{
    /**
     * QuestRespondquestionnHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct($db)
    {    //                             Table                   Classe              Id
        parent::__construct($db, 'quest_respondquestionn', 'respondquestionn', 'IdRespondQuestion');
    }
}

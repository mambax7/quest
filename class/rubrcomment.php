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

defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
//if (!class_exists('XoopsPersistableObjectHandler')) {
//    include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';
//}

include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';

/**
 * Class rubrcomment
 */
class rubrcomment extends MyObject
{
    /**
     * rubrcomment constructor.
     */
    public function __construct()
    {
        $this->initVar('IdRubrComment', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdRespondant', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdQuestionnaire', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdCategorie', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Comment1', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('Comment2', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('Comment3', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('DateReponse', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IP', XOBJ_DTYPE_TXTBOX, null, false, 32);
    }
}

/**
 * Class QuestRubrcommentHandler
 */
class QuestRubrcommentHandler extends MyXoopsPersistableObjectHandler
{
    /**
     * QuestRubrcommentHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct($db)
    {    //                             Table               Classe          Id
        parent::__construct($db, 'quest_rubrcomment', 'rubrcomment', 'IdRubrComment');
    }
}

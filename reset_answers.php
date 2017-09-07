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
include __DIR__ . '/../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';

/**
 * Remise � z�ro de toutes les r�ponses d'un r�pondant pour un questionnaire donn�
 */

// On commence par v�rifier que le questionnaire a �t� sp�cifi�
$quest_id = 0;
if (!isset($_GET['IdQuestionnaire']) && !isset($_POST['IdQuestionnaire'])) {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR9);
} else {
    $quest_id = (int)$_GET['IdQuestionnaire'];
}
// Ensuite on v�rifie que la personne � le droit d'acc�der � ce questionnaire
// D�j�, est-ce quelqu'un de connect� ?
$uid = 0;
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else {    // Acc�s r�serv� aux utilisateurs enregistr�s
    redirect_header(XOOPS_URL . '/index.php', 2, _ERRORS);
}

$questionnairesHandler =  xoops_getModuleHandler('questionnaires', 'quest');
$questionnaire          = $questionnairesHandler->get($quest_id);
if (!is_object($questionnaire)) {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR11);
}
// Ensuite on v�rifie que l'utilisateur a le droit de r�pondre � ce questionnaire
if (!$questionnairesHandler->isVisible($questionnaire, $uid)) {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR3);    // Pas le droit, on d�gage.
}

// On temine en v�rifiant que le param�trage du questionnaire autorise la suppression de toutes les r�ponses d'une personne
if (xoops_trim($questionnaire->getVar('ResetButton')) != '') {
    $reponsesHandler    =  xoops_getModuleHandler('reponses', 'quest');
    $rubrcommentHandler =  xoops_getModuleHandler('rubrcomment', 'quest');
    // Suppression des r�ponses
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('IdQuestionnaire', $quest_id, '='));
    $criteria->add(new Criteria('IdRespondant', $uid, '='));
    $reponsesHandler->deleteAll($criteria);
    // Suppression des commentaires
    $rubrcommentHandler->deleteAll($criteria);
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ANSWERS_DELETED);    // Vos r�ponses ont �t� supprim�es
} else {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR12);    // Suppression non autoris�e.
}

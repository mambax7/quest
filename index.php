<?php
//  ------------------------------------------------------------------------ //
//                        QUEST - MODULE FOR XOOPS 2                         //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://www.instant-zero.com/>                        //
// ------------------------------------------------------------------------- //
//  This program is NOT free software; you can NOT redistribute it and/or    //
//  modify without my assent.   										     //
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
$GLOBALS['xoopsOption']['template_main'] = 'quest_index.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';
$uid = 0;
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else {    // Accès réservé aux utilisateurs enregistrés
    redirect_header(XOOPS_URL . '/index.php', 2, _ERRORS);
}
$categoriesHandler     = xoops_getModuleHandler('categories', 'quest');
$questionnairesHandler = xoops_getModuleHandler('questionnaires', 'quest');
$questionsHandler      = xoops_getModuleHandler('questions', 'quest');
$reponsesHandler       = xoops_getModuleHandler('reponses', 'quest');
// On commence par vérifier le nombre de questionnaires non répondus pour l'utilisateur courant.
$tbl_questionnaires       = [];
$quest_non_answered_count = 0;
$tbl_questionnaires       = $questionnairesHandler->GetNonAnsweredQuestionnaires($uid);
$quest_non_answered_count = count($tbl_questionnaires);
if ($quest_non_answered_count == 0) {    // Tous les questionnaires ont été répondus, on dit merci et au revoir ********************************************************************
    $xoopsTpl->assign('action', 1);
} elseif ($quest_non_answered_count == 1) {    // Il ne reste qu'un seul questionnaire à ne pas avoir été totalement répondu, on affiche les catégories du questionnaire *************
    $xoopsTpl->assign('action', 2);
    reset($tbl_questionnaires);
    $id_category           = key($tbl_questionnaires);
    $tmp_quest             = current($tbl_questionnaires);
    $donnees               = $tmp_quest->toArray();
    $donnees['IdCategory'] = $id_category;
    $xoopsTpl->assign('questionnaire', $donnees);
    $IdQuestionnaire             = $tmp_quest->getVar('IdQuestionnaire');
    $_SESSION['IdQuestionnaire'] = $IdQuestionnaire;
    $tout_repondu                = false;
    $tbl_categories              = [];
    $tbl_categories              = $categoriesHandler->getCategoriesAndState($IdQuestionnaire, $uid, $tout_repondu);
    $xoopsTpl->assign('tout_repondu', $tout_repondu);
    if (!$tout_repondu) {
        foreach ($tbl_categories as $cle_category => $one_category) {
            list($id_categoy, $etat_category) = explode('-', $cle_category);
            $donnees         = $one_category->toArray();
            $donnees['etat'] = $etat_category;
            $xoopsTpl->append('categories', $donnees);
        }
    }
} elseif ($quest_non_answered_count > 1) {    // Il reste plusieurs questionnaires non répondus, on affiche la liste de ces questionnaires ******************************************
    $xoopsTpl->assign('action', 3);
    if (count($tbl_questionnaires) > 0) {
        foreach ($tbl_questionnaires as $id_category => $one_questionnaire) {
            $donnees               = $one_questionnaire->toArray();
            $donnees['IdCategory'] = $id_category;
            $xoopsTpl->append('questionnaires', $donnees);
        }
    }
}
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' - ' . _QUEST_INDEX);
include_once XOOPS_ROOT_PATH . '/footer.php';

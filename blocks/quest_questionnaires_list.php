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

/**
 * Liste des questionnaires auxquels l'utilisateur n'a pas répondu
 * @param $options
 * @return array|null
 */
function b_quest_questionnaires_list_show($options)
{
    global $xoopsUser;
    $block = [];
    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
    } else {
        return null;
    }
    $tbl_questionnaires     = [];
    $questionnairesHandler =  xoops_getModuleHandler('questionnaires', 'quest');
    $tbl_questionnaires     = $questionnairesHandler->GetNonAnsweredQuestionnaires($uid);
    if (count($tbl_questionnaires) > 0) {
        foreach ($tbl_questionnaires as $id_category => $one_questionnaire) {
            $donnees                   = $one_questionnaire->toArray();
            $donnees['IdCategory']     = $id_category;
            $block['questionnaires'][] = $donnees;
        }
    } else {
        return null;
    }

    return $block;
}

/**
 * @param $options
 */
function b_quest_questionnaires_list_edit($options)
{
}

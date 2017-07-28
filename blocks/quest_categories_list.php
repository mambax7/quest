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
 * Liste des cat�gories du questionnaire en cours
 *
 * Si toutes les cat�gories du questionnaire en cours ont �t� r�pondues alors le bloc n'affiche rien
 * Si on n'a pas r�pondu � tout, il faut afficher l'�tat d'avancement de chaque cat�gorie
 * Chaque cat�gorie affich�e est "cliquable" pour aller r�pondre
 * @param $options
 * @return array|null
 */
function b_quest_categories_list_show($options)
{
    global $xoopsUser;
    $block = array();
    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
    } else {
        return null;
    }

    $questionnaires_handler = &xoops_getModuleHandler('questionnaires', 'quest');
    // Les blocs �tant appel�s avant les pages, sans ces 3 lignes le bloc n'affiche pas les cat�gories du bon questionnaire
    if (isset($_GET['IdQuestionnaire'])) {
        $_SESSION['IdQuestionnaire'] = (int)$_GET['IdQuestionnaire'];
    }

    if (isset($_SESSION['IdQuestionnaire'])) {
        $IdQuestionnaire = (int)$_SESSION['IdQuestionnaire'];
        $tmp_quest       = $questionnaires_handler->get($IdQuestionnaire);
        if (!$questionnaires_handler->isVisible($tmp_quest, $uid)) {    // Questionnaire "accessible" ?

            return null;
        }
    } else {    // S'il n'y a pas de questionnaire de s�lectionn� par d�faut, on regarde s'il n'y en aurait pas qu'un seul dans la base (auquel cas on va le prendre)
        if ($questionnaires_handler->getCount() == 1) {
            $tbl_quest       = $questionnaires_handler->getObjects();
            $tmp_quest       = $tbl_quest[0];
            $IdQuestionnaire = $tmp_quest->getVar('IdQuestionnaire');
            if ($questionnaires_handler->isVisible($tmp_quest, $uid)) {
                $_SESSION['IdQuestionnaire'] = $IdQuestionnaire;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    $categories_handler = &xoops_getModuleHandler('categories', 'quest');
    $tout_repondu       = false;
    $tbl_categories     = array();
    $tbl_categories     = $categories_handler->getCategoriesAndState($IdQuestionnaire, $uid, $tout_repondu);

    if (!$tout_repondu) {
        foreach ($tbl_categories as $cle_category => $one_category) {
            list($id_categoy, $etat_category) = explode('-', $cle_category);
            $donnees               = $one_category->toArray();
            $donnees['etat']       = $etat_category;
            $block['categories'][] = $donnees;
        }
    } else {
        return null;
    }

    return $block;
}

/**
 * @param $options
 */
function b_quest_categories_list_edit($options)
{
}

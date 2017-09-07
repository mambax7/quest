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
 * Affichage du statut de chaque questionnaire duquel l'utilisateur courant est commanditaire
 */

include __DIR__ . '/../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'quest_status.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';
include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';

$uid = 0;
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else {    // Accès réservé aux utilisateurs enregistrés
    redirect_header(XOOPS_URL . '/index.php', 2, _ERRORS);
}

// Initialisation des handlers
$cac_categoriesHandler =  xoops_getModuleHandler('cac_categories', 'quest');
$categoriesHandler     =  xoops_getModuleHandler('categories', 'quest');
$enquetesHandler       =  xoops_getModuleHandler('enquetes', 'quest');
$questionnairesHandler =  xoops_getModuleHandler('questionnaires', 'quest');
$questionsHandler      =  xoops_getModuleHandler('questions', 'quest');
$reponsesHandler       =  xoops_getModuleHandler('reponses', 'quest');
$rubrcommentHandler    =  xoops_getModuleHandler('rubrcomment', 'quest');
// Handler Xoops
$memberHandler = xoops_getHandler('member');

// Début des travaux
// On commence par rechercher les questionnaires desquels l'utilisateur est commanditaire
$groups             = quest_getUserGroups();
$tbl_questionnaires = [];
$tbl_questionnaires = $questionnairesHandler->getObjects($groups);
foreach ($tbl_questionnaires as $one_questionnaire) {
    $tbl           = [];
    $tbl_solutions = [];
    $tbl           = $one_questionnaire->toArray();
    // Récupération des informations sur l'enquêté
    $enquete        = $enquetesHandler->get($one_questionnaire->getVar('IdEnquete'));
    $tbl['Enquete'] = $enquete->toArray();

    $tbl_categories = [];
    $critere        = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '=');
    $critere->setSort('OrdreCategorie');
    $tbl_categories = $categoriesHandler->GetObjects($critere);

    // ****************************************************************************************************************
    // Statistiques globales
    // ****************************************************************************************************************
    // Récupération de la liste des utilisateurs
    $list_users = $list_users2 = [];
    $tbl_users  = [];
    $tbl_users  = $memberHandler->getUsersByGroup($one_questionnaire->getVar('Groupe'), true);    // En tant qu'objet

    foreach ($tbl_users as $one_user) {
        $list_users[]  = xoops_trim($one_user->getVar('name')) != '' ? $one_user->getVar('name') : $one_user->getVar('uname');
        $list_users2[] = $one_user->getVar('uid');
    }

    natcasesort($list_users);    // Tri naturel de la liste
    $tbl['respondants'] = $list_users;
    // Solution 1
    $tbl_solutions['users_to_respond'] = count($list_users);    // Nombre de personnes devant répondre
    $tbl['respondants_count']          = $tbl_solutions['users_to_respond'];

    // Recherche des personnes qui n'ont pas répondu

    // On commence par chercher la liste des personnes qui ont répondu
    $tbl_repondu = $reponsesHandler->getUsersIdPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));
    // Normalement la différence entre la liste des personnes qui doivent répondre et la liste des personnes qui ont répondu
    // est égale à la liste des personnes qui n'ont pas du tout répondu
    $tbl_non_repondus = array_diff($list_users2, $tbl_repondu);

    // Solution 2
    $tbl_solutions['users_without_replies'] = count($tbl_non_repondus);        // Nombre d'utilisateurs qui n'ont pas du tout répondu
    $tbl_solutions['users_partially_reply'] = 0;
    $tbl_solutions['users_full_reply']      = 0;

    // Recherche du nombre total de questions du questionnaire
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
    $questionnaire_questions_count = $questionsHandler->getCount($criteria);

    // Recherche du nombre de questions par catégorie pour ce questionnaire
    $tbl_questions_count_per_category = [];    // Clé=Id Catégorie, Valeur = Nb questions
    $tbl_questions_count_per_category = $questionsHandler->QuestionsCountPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));

    // Ensuite, on regarde pour chaque personne qui a répondu pour savoir si elle a répondu à tout ou partiellement
    foreach ($tbl_repondu as $one_uid) {
        $tout_repondu = true;    // On part du postulat que la personne a répondu à tout
        foreach ($tbl_categories as $one_category) {    // Boucle sur les catégories
            if ($one_category->getVar('AfficherDroite') || $one_category->getVar('AfficherGauche')) {
                $criteria = new CriteriaCompo();
                $critere  = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '=');
                $criteria->add(new Criteria('IdRespondant', $one_uid, '='));
                $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
                if ($one_category->getVar('AfficherDroite')) {
                    $criteria->add(new Criteria('Id_CAC1', 0, '<>'));
                }
                if ($one_category->getVar('AfficherGauche')) {
                    $criteria->add(new Criteria('Id_CAC2', 0, '<>'));
                }
                $answers_count = $reponsesHandler->getCount($criteria);    // Nombre de réponses de cette personne
                if ($answers_count != $tbl_questions_count_per_category[$one_category->getVar('IdCategorie')]) {
                    $tout_repondu = false;
                    break;    // Pas la peine de continuer, cette personne n'a pas répondu sur cette catégorie
                }
            }
            // Vérification des commentaires
            if ($tout_repondu && (xoops_trim($one_category->getVar('comment1')) != '' || xoops_trim($one_category->getVar('comment2')) != '' || xoops_trim($one_category->getVar('comment3')) != '')) {
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('IdRespondant', $one_uid, '='));
                $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
                $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
                if (xoops_trim($one_category->getVar('comment1')) != '') {
                    $criteria->add(new Criteria('LENGTH(TRIM(Comment1))', 0, '>'));
                }
                if (xoops_trim($one_category->getVar('comment2')) != '') {
                    $criteria->add(new Criteria('LENGTH(TRIM(Comment2))', 0, '>'));
                }
                if (xoops_trim($one_category->getVar('comment3')) != '') {
                    $criteria->add(new Criteria('LENGTH(TRIM(Comment3))', 0, '>'));
                }
                $cnt = $rubrcommentHandler->getCount($criteria);
                if ($cnt == 0) {
                    $tout_repondu = false;
                }
            }
        }

        if ($tout_repondu) {
            $tbl_solutions['users_full_reply']++;
        } else {
            $tbl_solutions['users_partially_reply']++;
        }
    }
    // Calcul des pourcentages
    $tbl_solutions['pourcent_users_to_respond']      = 100;    // Nombre de personnes devant répondre
    $tbl_solutions['pourcent_users_without_replies'] = ($tbl_solutions['users_without_replies'] / $tbl_solutions['users_to_respond']) * 100;            // Nombre d'utilisateurs qui n'ont pas du tout répondu
    $tbl_solutions['pourcent_users_partially_reply'] = ($tbl_solutions['users_partially_reply'] / $tbl_solutions['users_to_respond']) * 100;
    $tbl_solutions['pourcent_users_full_reply']      = ($tbl_solutions['users_full_reply'] / $tbl_solutions['users_to_respond']) * 100;
    $tbl['stats_globales']                           = $tbl_solutions;

    // ****************************************************************************************************************
    // Statistiques détaillée catégorie par catégorie
    // ****************************************************************************************************************
    $tbl_total = [];

    foreach ($tbl_categories as $one_category) {        // Boucle sur les catégories
        // Recherche du nombre de personnes qui ont répondu à cette catégorie
        $criteria = new CriteriaCompo();
        $critere  = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '=');
        $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
        if ($one_category->getVar('AfficherDroite')) {
            $criteria->add(new Criteria('Id_CAC1', 0, '<>'));
        }
        if ($one_category->getVar('AfficherGauche')) {
            $criteria->add(new Criteria('Id_CAC2', 0, '<>'));
        }
        $answers_count = $reponsesHandler->getCount($criteria);

        $tbl2 = [];
        $tbl2 = $one_category->toArray();
        // Recherche du nombre de commentaires répondus
        if (xoops_trim($one_category->getVar('comment1')) != '') {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
            $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
            $criteria->add(new Criteria('LENGTH(TRIM(Comment1))', 0, '>'));
            $cnt                   = $rubrcommentHandler->getCount($criteria);
            $tbl2['Comment1Count'] = $cnt;
        } else {
            $tbl2['Comment1Count'] = 0;
        }

        if (xoops_trim($one_category->getVar('comment2')) != '') {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
            $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
            $criteria->add(new Criteria('LENGTH(TRIM(Comment2))', 0, '>'));
            $cnt                   = $rubrcommentHandler->getCount($criteria);
            $tbl2['Comment2Count'] = $cnt;
        } else {
            $tbl2['Comment2Count'] = 0;
        }

        if (xoops_trim($one_category->getVar('comment3')) != '') {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
            $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
            $criteria->add(new Criteria('LENGTH(TRIM(Comment3))', 0, '>'));
            $cnt                   = $rubrcommentHandler->getCount($criteria);
            $tbl2['Comment3Count'] = $cnt;
        } else {
            $tbl2['Comment3Count'] = 0;
        }

        // Recherche du nombre de questions
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
        $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
        $questions_count         = $questionsHandler->getCount($criteria);
        $tbl2['questions_count'] = $questions_count;

        // Recherche du nombre de réponses que l'on devrait avoir
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
        $cac_count = $cac_categoriesHandler->getCount($criteria);

        if ($one_category->getVar('AfficherDroite') && $one_category->getVar('AfficherGauche')) {
            $tbl2['cac_count'] = $questions_count * 2;
        } else {
            $tbl2['cac_count'] = $questions_count;
        }

        // Récupération du nombre de réponses
        $criteria = new CriteriaCompo();
        $critere  = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '=');
        $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
        if ($one_category->getVar('AfficherDroite')) {
            $criteria->add(new Criteria('Id_CAC1', 0, '<>'));
        }
        if ($one_category->getVar('AfficherGauche')) {
            $criteria->add(new Criteria('Id_CAC2', 0, '<>'));
        }
        $answers_count         = $reponsesHandler->getCount($criteria);
        $tbl2['answers_count'] = $answers_count;

        $tbl_total['questions'] .= $questions_count;
        $tbl_total['reponses']  .= $answers_count;

        $tbl['categories'][] = $tbl2;
    }
    $tbl['total_questions']   = $tbl_total['questions'];
    $tbl['total_reponses']    = $tbl_total['reponses'];
    $tbl['total_nonrepondus'] = $tbl_total['questions'] - $tbl_total['reponses'];
    $xoopsTpl->append('questionnaires', $tbl);
}

$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' - ' . _QUEST_STATUS_INDEX);
include_once XOOPS_ROOT_PATH . '/footer.php';

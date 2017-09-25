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
 * Génération automatique des relances de tous les questionnaires
 */

include __DIR__ . '/../../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';
include XOOPS_ROOT_PATH . '/class/xoopsmailer.php';

echo "<br>Initialisation of Handlers\n";
// Initialisation des handlers
$cac_categoriesHandler = xoops_getModuleHandler('cac_categories', 'quest');
$categoriesHandler     = xoops_getModuleHandler('categories', 'quest');
$enquetesHandler       = xoops_getModuleHandler('enquetes', 'quest');
$questionnairesHandler = xoops_getModuleHandler('questionnaires', 'quest');
$questionsHandler      = xoops_getModuleHandler('questions', 'quest');
$reponsesHandler       = xoops_getModuleHandler('reponses', 'quest');
$rubrcommentHandler    = xoops_getModuleHandler('rubrcomment', 'quest');
// Handler Xoops
$memberHandler = xoops_getHandler('member');

if (function_exists('xoops_getMailer')) {
    $xoopsMailer = xoops_getMailer();
} else {
    $xoopsMailer =& getMailer();
}

$xoopsMailer->useMail();

echo "<br>Retrieving the list of questionnaires\n"; //Récupération de la liste des questionnaires
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('DateFermeture', time(), '>='));
$criteria->add(new Criteria('DateOuverture', time(), '<='));
$tbl_questionnaires = $questionnairesHandler->getObjects($criteria);
foreach ($tbl_questionnaires as $one_questionnaire) {
    echo '<br>Traitement du questionnaire ' . $one_questionnaire->getVar('LibelleQuestionnaire');
    // On commence par vérifier que les relances sur le questionnaire n'ont pas déjà été faites
    if (0 != $one_questionnaire->getVar('DerniereRelance')) {
        $date_reference = $one_questionnaire->getVar('DerniereRelance');
    } else {
        $date_reference = $one_questionnaire->getVar('DateOuverture');
    }
    $prochaine_relance = $date_reference + ($one_questionnaire->getVar('FrequenceRelances') * 86400);
    if (time() >= $prochaine_relance) {    // Il faut relancer
        // Les paramètres du mailer
        $xoopsMailer->setFromEmail($one_questionnaire->getVar('EmailFrom'));
        $xoopsMailer->setFromName($one_questionnaire->getVar('EmailFromName'));
        $xoopsMailer->setSubject($one_questionnaire->getVar('SujetRelance'));

        // On commence par mettre à jour le questionnaire pour indiquer que les relances ont été faites
        $one_questionnaire->setVar('DerniereRelance', time());
        $one_questionnaire->setVar('NbRelances', $one_questionnaire->getVar('NbRelances') + 1);
        $questionnairesHandler->insert($one_questionnaire, true);

        // Ensuite on récupère la liste complète des personnes qui doivent répondre à ce questionnaire
        $tbl_repondu = $tbl_relances = $tbl_users = $list_users = $tbl_non_repondus = $tbl_users2 = [];
        $tbl_users   = $memberHandler->getUsersByGroup($one_questionnaire->getVar('Groupe'), true);    // En tant qu'objet

        foreach ($tbl_users as $one_user) {
            $list_users[]                         = $one_user->getVar('uid');
            $tbl_users2[$one_user->getVar('uid')] = $one_user;
        }

        // Liste des personnes qui ont répondu (partiellement ou totalement)
        $tbl_repondu = $reponsesHandler->getUsersIdPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));

        // Normalement la différence entre la liste des personnes qui doivent répondre et la liste des personnes qui ont répondu
        // est égale à la liste des personnes qui n'ont pas du tout répondu
        $tbl_non_repondus = array_diff($list_users, $tbl_repondu);
        if (2 == $one_questionnaire->getVar('RelancesOption')) {        // On ne doit relancer que ceux qui n'ont pas du tout répondu
            $tbl_relances = $tbl_non_repondus;
        } else {    // On relance tout le monde
            $tbl_relances                     = $tbl_non_repondus;
            $tbl_questions_count_per_category = [];    // Clé=Id Catégorie, Valeur = Nb questions
            $tbl_questions_count_per_category = $questionsHandler->QuestionsCountPerQuestionnaire($one_questionnaire->getVar('IdQuestionnaire'));
            $tbl_categories                   = [];
            $critere                          = new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '=');
            $critere->setSort('OrdreCategorie');
            $tbl_categories = $categoriesHandler->GetObjects($critere);
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
                    if ($tout_repondu && ('' != xoops_trim($one_category->getVar('comment1')) || '' != xoops_trim($one_category->getVar('comment2')) || '' != xoops_trim($one_category->getVar('comment3')))) {
                        $criteria = new CriteriaCompo();
                        $criteria->add(new Criteria('IdRespondant', $one_uid, '='));
                        $criteria->add(new Criteria('IdQuestionnaire', $one_questionnaire->getVar('IdQuestionnaire'), '='));
                        $criteria->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
                        if ('' != xoops_trim($one_category->getVar('comment1'))) {
                            $criteria->add(new Criteria('LENGTH(TRIM(Comment1))', 0, '>'));
                        }
                        if ('' != xoops_trim($one_category->getVar('comment2'))) {
                            $criteria->add(new Criteria('LENGTH(TRIM(Comment2))', 0, '>'));
                        }
                        if ('' != xoops_trim($one_category->getVar('comment3'))) {
                            $criteria->add(new Criteria('LENGTH(TRIM(Comment3))', 0, '>'));
                        }
                        $cnt = $rubrcommentHandler->getCount($criteria);
                        if (0 == $cnt) {
                            $tout_repondu = false;
                        }
                    }
                }
                if (!$tout_repondu) {
                    $tbl_relances[] = $one_uid;
                }
            }
        }
        // Les relances
        foreach ($tbl_relances as $one_uid) {
            //TODO: Voir si on peut utiliser le champs replyTo mais cela ne semble pas possible
            $user = $tbl_users2[$one_uid];
            echo '<br>Relance de ' . $user->getVar('uname');
            $body = $one_questionnaire->getVar('CorpsRelance');
            $body = str_replace('{SITE_URL}', XOOPS_URL, $body);
            $body = str_replace('{USER_LOGIN}', $user->getVar('uname'), $body);
            $body = str_replace('{USER_FULLNAME}', $user->getVar('name'), $body);
            $body = str_replace('{LAST_RESTART}', formatTimestamp($date_reference), $body);
            $body = str_replace('{QUESTIONNAIRE_NAME}', $one_questionnaire->getVar('LibelleQuestionnaire'), $body);
            $body = str_replace('{QUESTIONNAIRE_START}', formatTimestamp($one_questionnaire->getVar('DateOuverture')), $body);
            $body = str_replace('{QUESTIONNAIRE_END}', formatTimestamp($one_questionnaire->getVar('DateFermeture')), $body);
            $xoopsMailer->setBody($body);
            $xoopsMailer->setToEmails($user->getVar('email'));
            $xoopsMailer->send();
        }
    }
}
echo "<br><b>Action terminated</b>\n"; //Action terminée

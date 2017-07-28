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
include '../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';

$next_categoryid = 0;
$uid             = 0;
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else {    // Accès réservé aux utilisateurs enregistrés
    redirect_header(XOOPS_URL . '/index.php', 2, _ERRORS);
    exit();
}

// TODO: Gérer le champ GoOnAfterEnd
// Initialisation des handlers
$cac_handler            = &xoops_getModuleHandler('cac', 'quest');
$cac_categories_handler = &xoops_getModuleHandler('cac_categories', 'quest');
$categories_handler     = &xoops_getModuleHandler('categories', 'quest');
$enquetes_handler       = &xoops_getModuleHandler('enquetes', 'quest');
$questionnaires_handler = &xoops_getModuleHandler('questionnaires', 'quest');
$questions_handler      = &xoops_getModuleHandler('questions', 'quest');
$reponses_handler       = &xoops_getModuleHandler('reponses', 'quest');
$rubrcomment_handler    = &xoops_getModuleHandler('rubrcomment', 'quest');

$tbl_questionnaires       = $questionnaires_handler->GetNonAnsweredQuestionnaires($uid);
$quest_non_answered_count = 0;
$quest_non_answered_count = count($tbl_questionnaires);

if ($quest_non_answered_count == 0) {    // Tous les questionnaires ont été répondus, merci et au revoir
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ALL_REPLYED);
    exit();
}

// ********************************************************************************************************************
// Sauvegarde des données *********************************************************************************************
// ********************************************************************************************************************
if (isset($_POST['action']) && $_POST['action'] == 'save') {
    $categoryid      = (int)$_POST['category'];    // On compare la catégorie provenant du formulaire avec celle enregistrée en session
    $questionnaireid = (int)$_POST['quest'];
    // Chargement de la catégorie et du questionnaire
    $save_categ = $categories_handler->get($categoryid);
    if (!is_object($save_categ)) {    // Catégorie introuvable
        redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR2);
        exit();
    }

    $save_quest = $questionnaires_handler->get($save_categ->getVar('IdQuestionnaire'));
    if (!is_object($save_quest)) {
        redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR6);
        exit();
    }

    // Ensuite on vérifie que l'utilisateur a le droit de répondre à ce questionnaire et donc à cette catégorie
    if (!$questionnaires_handler->isVisible($save_quest, $uid)) {
        redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR3);    // Pas le droit, on dégage.
        exit();
    }

    // Toute la partie suivante a été mise en commentaire "à cause" de l'utilisation d'ajax.
    // Il n'est en effet plus nécessaire de sauvegarder les données car elles sont sauvegardée dès la saisie

    /*
        // On peut passer à la sauvegarde des données ************************************************************
        // On recherche la liste des questions de la catégorie
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('IdQuestionnaire', $save_quest->getVar('IdQuestionnaire') ,'='));
        $criteria->add(new Criteria('IdCategorie', $save_categ->getVar('IdCategorie') ,'='));
        $criteria->setSort('OrdreQuestion');
        $tbl_questions = $questions_handler->getObjects($criteria, true);   // Avec les ID de questions
        $ch_id_questions = join(',',array_keys($tbl_questions));    // Création d'un liste sous la forme id1,id2,id3 ...
        $ip = Quest_IP();

        // Les commentaires
        // On supprime les données actuelles
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('IdQuestionnaire', $save_quest->getVar('IdQuestionnaire') ,'='));
        $criteria->add(new Criteria('IdCategorie', $save_categ->getVar('IdCategorie') ,'='));
        $criteria->add(new Criteria('IdRespondant', $uid ,'='));
        $rubrcomment_handler->deleteAll($criteria);
        // Et on enregistre les nouvelles
        $commentaire1 = isset($_POST['comment1']) ? $_POST['comment1'] : '';
        $commentaire2 = isset($_POST['comment2']) ? $_POST['comment2'] : '';
        $commentaire3 = isset($_POST['comment3']) ? $_POST['comment3'] : '';
        $res = $rubrcomment_handler->quickInsert(array('IdRespondant' => $uid,
                                                'IdQuestionnaire' => $save_quest->getVar('IdQuestionnaire'),
                                                'IdCategorie' => $save_categ->getVar('IdCategorie'),
                                                'Comment1' => $commentaire1,
                                                'Comment2' => $commentaire2,
                                                'Comment3' => $commentaire3,
                                                'DateReponse' => time(),
                                                'IP' => $ip
                                                ));
        if (!$res) {
            redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR7);
            exit();
        }

        // Les réponses en elle même
        // On supprime les données actuelles
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('IdQuestionnaire', $save_quest->getVar('IdQuestionnaire') ,'='));
        $criteria->add(new Criteria('IdCategorie', $save_categ->getVar('IdCategorie') ,'='));
        $criteria->add(new Criteria('IdRespondant', $uid ,'='));
        $criteria->add(new Criteria('IdQuestion','('.$ch_id_questions.')','IN'));
        $reponses_handler->deleteAll($criteria);
        $afficherdroite = $save_categ->getVar('AfficherDroite');
        $affichergauche = $save_categ->getVar('AfficherGauche');

        // Boucle sur les réponses pour les enregistrer
        foreach($tbl_questions as $id_question => $one_question) {
            $idcac_droite = 0;
            $idcac_gauche = 0;
            $date_sais = time();
            if ($afficherdroite) {
                $nomcac = 'q'.$id_question.'d';
                if (isset($_POST[$nomcac])) {
                    $idcac_droite = (int)($_POST[$nomcac]);
                }
            }
            if ($affichergauche) {
                $nomcac = 'q'.$id_question.'g';
                if (isset($_POST[$nomcac])) {
                    $idcac_gauche = (int)($_POST[$nomcac]);
                }
            }

            // On vérifie ce qu'il faut enregistrer
            $save = true;
            if ($save_categ->getVar('AfficherDroite') && $save_categ->getVar('AfficherGauche')) {
                if (empty($idcac_droite) && empty($idcac_gauche)) {
                    $save = false;
                }
            } elseif ($save_categ->getVar('AfficherDroite') && empty($idcac_droite)) {
                $save = false;
            } elseif ($save_categ->getVar('AfficherGauche') && empty($idcac_gauche)) {
                $save = false;
            }
            if ($save) {
                $res=$reponses_handler->quickInsert(array('IdQuestionnaire' => $save_quest->getVar('IdQuestionnaire'),
                                                        'IdCategorie' => $save_categ->getVar('IdCategorie'),
                                                        'IdRespondant' => $uid,
                                                        'IdQuestion' => $id_question,
                                                        'Id_CAC1' => $idcac_droite,
                                                        'Id_CAC2' => $idcac_gauche,
                                                        'DateReponse' => $date_sais,
                                                        'IP' => $ip));
                if (!$res) {
                    redirect_header(XOOPS_URL.'/index.php',2,_QUEST_ERROR8);
                    exit();
                }
            }
        }
    */
    // Passage à la prochaine catégorie
    $crit_categ = new Criteria('IdQuestionnaire', $questionnaireid, '=');
    $crit_categ->setSort('OrdreCategorie');
    $tbl_categories = $categories_handler->getIds($crit_categ);
    $at_the_end     = false;
    $pos            = array_search($categoryid, $tbl_categories);
    if ($pos + 1 == count($tbl_categories)) {
        $at_the_end = true;
    }
    if (!$at_the_end) {
        $next_categoryid = $tbl_categories[$pos + 1];
    } else {
        $next_categoryid = -1;
    }
}

// Ce code est placé là *VOLONTAIREMENT* car il permet de retarder l'apparition des blocs
// Il ne faut pas le déplacer de là
$xoopsOption['template_main'] = 'quest_category.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

// ********************************************************************************************************************
// Recherche et affichage des données *********************************************************************************
// ********************************************************************************************************************
// Vérification de la catégorie
$categoryid = 0;
if (isset($_GET['categoryid'])) {
    $categoryid = (int)$_GET['categoryid'];
} elseif (isset($_POST['categoryid'])) {
    $categoryid = (int)$_POST['categoryid'];
} else {    // Rien n'a été spécifié
    if ($next_categoryid == 0) {
        redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR1);
        exit();
    } else {
        if ($next_categoryid != -1) {
            $categoryid = $next_categoryid;
        } else {    // On est arrivé à la dernière catégorie.
            redirect_header(XOOPS_URL . '/index.php', 4, _QUEST_THANK_YOU2);
            exit();
        }
    }
}

// Recherche du questionnaire correspondant
// On commence par chercher sa catégorie
$current_categ = $categories_handler->get($categoryid);
if (!is_object($current_categ)) {    // Catégorie introuvable
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR2);
    exit();
}
$_SESSION['IdQuestionnaire'] = $current_categ->getVar('IdQuestionnaire');
// Maintenant qu'on connait l'identifiant du questionnaire, on va aller le chercher
$current_quest = $questionnaires_handler->get($current_categ->getVar('IdQuestionnaire'));

// Ensuite on vérifie que l'utilisateur a le droit de répondre à ce questionnaire et donc à cette catégorie
if (!$questionnaires_handler->isVisible($current_quest, $uid)) {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR3);    // Pas le droit, on dégage.
    exit();
}

$_SESSION['IdCategory'] = $current_categ->getVar('IdCategorie');
// Si on est encore là c'est que tout va bien.
// Le questionnaire n'a pas été totalement répondu et on a le droit de le voir et d'y répondre

$url_prototype = '<script type="text/javascript" src="' . XOOPS_URL . '/modules/quest/js/prototype.js' . '"></script>';
$xoopsTpl->assign('xoops_module_header', $url_prototype);

// On assigne les données du questionnaire ****************************************************************************
$xoopsTpl->assign('questionnaire', $current_quest->toArray());
// Mise en place du lien permettant à l'utilisateur de supprimer toutes ses réponses du questionnaire en cours
if (xoops_trim($current_quest->getVar('ResetButton')) != '') {
    $xoopsTpl->assign('confirmation_to_delete_answers', quest_JavascriptLinkConfirm(_QUEST_DELETE_ANSWERS_MESSAGE));
    $xoopsTpl->assign('text_to_delete_answers', $current_quest->getVar('ResetButton'));
}

// On assigne les données de la catégorie *****************************************************************************
$xoopsTpl->assign('category', $current_categ->toArray());

// Etat de la catégorie (0=Aucune réponse, 1=Tout répondu, 2= Partiellement répondu)
$xoopsTpl->assign('category_state', $categories_handler->getCategoryState($current_categ, $uid));

// Récupération des informations sur l'enquêté ************************************************************************
$current_enquete = $enquetes_handler->get($current_quest->getVar('IdEnquete'));
$xoopsTpl->assign('enquete', $current_enquete->toArray());

// Récupération des questions de la catégorie *************************************************************************
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('IdQuestionnaire', $current_quest->getVar('IdQuestionnaire'), '='));
$criteria->add(new Criteria('IdCategorie', $current_categ->getVar('IdCategorie'), '='));
$criteria->setSort('OrdreQuestion');
$tbl_questions   = $questions_handler->getObjects($criteria, true);    // Avec les ID de questions
$ch_id_questions = '';
$ch_id_questions = implode(',', array_keys($tbl_questions));    // Création d'un liste sous la forme id1,id2,id3 ...

// Récupération des CAC de cette catégorie ****************************************************************************
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('IdCategorie', $current_categ->getVar('IdCategorie'), '='));
$criteria->setSort('DroiteGauche, Ordre');
$tbl_cac_categories = $cac_categories_handler->getObjects($criteria);
if (count($tbl_cac_categories) > 0) {        // S'il y a des questions
    $tbl_id_cac = array();
    foreach ($tbl_cac_categories as $one_cac_category) {
        $tbl_id_cac[] = $one_cac_category->getVar('IdCAC');
    }
    $ch_id_categ = '';
    $ch_id_categ = implode(',', $tbl_id_cac);

    // Récupération des libellés associés *********************************************************************************
    $criteria = new Criteria('IdCAC', '(' . $ch_id_categ . ')', 'IN');
    $criteria->setSort('IdCAC');
    $tbl_libelles_cac = $cac_handler->getObjects($criteria, true);    // Avec comme clé, l'ID de CAC

    // Récupération des réponses ******************************************************************************************
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('IdQuestionnaire', $current_quest->getVar('IdQuestionnaire'), '='));
    $criteria->add(new Criteria('IdCategorie', $current_categ->getVar('IdCategorie'), '='));
    $criteria->add(new Criteria('IdRespondant', $uid, '='));
    $criteria->add(new Criteria('IdQuestion', '(' . $ch_id_questions . ')', 'IN'));
    $tbl_reponses = $reponses_handler->getObjects($criteria);
}

// Récupération des commentaires **************************************************************************************
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('IdRespondant', $uid, '='));
$criteria->add(new Criteria('IdQuestionnaire', $current_quest->getVar('IdQuestionnaire'), '='));
$criteria->add(new Criteria('IdCategorie', $current_categ->getVar('IdCategorie'), '='));
$tbl_commentaires = array();
$tbl_commentaires = $rubrcomment_handler->getObjects($criteria);
if (count($tbl_commentaires) > 0) {
    $one_commentaire = $tbl_commentaires[0];
    $xoopsTpl->assign('commentaire1', $one_commentaire->getVar('Comment1', 'e'));
    $xoopsTpl->assign('commentaire2', $one_commentaire->getVar('Comment2', 'e'));
    $xoopsTpl->assign('commentaire3', $one_commentaire->getVar('Comment3', 'e'));
} else {
    $xoopsTpl->assign('commentaire1', '');
    $xoopsTpl->assign('commentaire2', '');
    $xoopsTpl->assign('commentaire3', '');
}

// Construction des CAC de droite et de la légende de droite **********************************************************
$tbl_sesCAC_D    = array();
$tbl_sesCAC_G    = array();
$tbl_all_cac_ids = array();

$tbl_cac_droite     = array();
$tbl_legende_droite = array();
if ($current_categ->getVar('AfficherDroite')) {
    foreach ($tbl_cac_categories as $one_cac_category) {    // Boucle sur toutes les cac_categories
        if ($one_cac_category->getVar('DroiteGauche') == 1) {
            $id                                               = $one_cac_category->getVar('IdCAC');    // On récupère l'ID de la cac
            $cac_courante                                     = $tbl_libelles_cac[$id];        // Renvoie un objet de type quest_cac
            $libelle_long                                     = $cac_courante->getVar('LibelleCAC');
            $libelle_court                                    = $cac_courante->getVar('LibelleCourtCac');
            $tbl_cac_droite[]                                 = array('IdCAC' => $one_cac_category->getVar('IdCAC'), 'LibelleCourt' => xoops_trim($libelle_court));
            $tbl_sesCAC_D[$one_cac_category->getVar('IdCAC')] = array('LibelleCourt' => xoops_trim($libelle_court), 'LibelleLong' => xoops_trim($libelle_long));
            $tbl_legende_droite[]                             = array('LibelleCourt' => xoops_trim($libelle_court), 'LibelleLong' => xoops_trim($libelle_long));
            $tbl_all_cac_ids[]                                = 'r' . $id . 's.png';
        }
    }
    $xoopsTpl->assign('LegendeDroite', $tbl_legende_droite);
    $xoopsTpl->assign('CAC_Droite', $tbl_cac_droite);
} else {
    $xoopsTpl->assign('LegendeDroite', '');
    $xoopsTpl->assign('CAC_Droite', '');
}

// Construction des CAC de gauche et de la légende de gauche **********************************************************
$tbl_cac_gauche     = array();
$tbl_legende_gauche = array();
if ($current_categ->getVar('AfficherGauche')) {
    foreach ($tbl_cac_categories as $one_cac_category) {    // Boucle sur toutes les cac_categories
        if ($one_cac_category->getVar('DroiteGauche') == 2) {
            $id                                               = $one_cac_category->getVar('IdCAC');    // On récupère l'ID de la cac
            $cac_courante                                     = $tbl_libelles_cac[$id];        // Renvoie un objet de type quest_cac
            $libelle_long                                     = $cac_courante->getVar('LibelleCAC');
            $libelle_court                                    = $cac_courante->getVar('LibelleCourtCac');
            $tbl_cac_gauche[]                                 = array('IdCAC' => $one_cac_category->getVar('IdCAC'), 'LibelleCourt' => xoops_trim($libelle_court), 'LibelleLong' => xoops_trim($libelle_long));
            $tbl_sesCAC_G[$one_cac_category->getVar('IdCAC')] = array('LibelleCourt' => xoops_trim($libelle_court), 'LibelleLong' => xoops_trim($libelle_long));
            $tbl_legende_gauche[]                             = array('LibelleCourt' => xoops_trim($libelle_court), 'LibelleLong' => xoops_trim($libelle_long));
            $tbl_all_cac_ids[]                                = 'l' . $id . 's.png';
        }
    }
    $xoopsTpl->assign('LegendeGauche', $tbl_legende_gauche);
    $xoopsTpl->assign('CAC_Gauche', $tbl_cac_gauche);
} else {
    $xoopsTpl->assign('LegendeGauche', '');
    $xoopsTpl->assign('CAC_Gauche', '');
}

$xoopsTpl->assign('preloaded_cac', $tbl_all_cac_ids);
$_SESSION['tbl_sesCAC_D'] = $tbl_sesCAC_D;
$_SESSION['tbl_sesCAC_G'] = $tbl_sesCAC_G;

// Synthèse du tout ***************************************************************************************************
// Construction d'un tableau qui contient toutes les questions avec les réponses
$cptquestion            = 0;
$tbl_questions_reponses = array();
foreach ($tbl_questions as $id_question => $one_question) {
    $Id_CAC1 = $Id_CAC2 = 0;
    ++$cptquestion;
    foreach ($tbl_reponses as $one_reponse) {
        if ($one_reponse->getVar('IdQuestion') == $one_question->getVar('IdQuestion')) {
            $Id_CAC1 = $one_reponse->getVar('Id_CAC1');
            $Id_CAC2 = $one_reponse->getVar('Id_CAC2');
            break;
        }
    }

    $tbl_questions_reponses[] = array(
        'IdQuestion'         => $one_question->getVar('IdQuestion'),
        'NumeroQuestion'     => $cptquestion,
        'OrdreQuestion'      => $one_question->getVar('OrdreQuestion'),
        'TexteQuestion'      => $one_question->getVar('TexteQuestion'),
        'ComplementQuestion' => $one_question->getVar('ComplementQuestion'),
        'Id_CAC1'            => $Id_CAC1,                // Droite
        'Id_CAC2'            => $Id_CAC2                // Gauche
    );
}
$xoopsTpl->assign('questions_reponses', $tbl_questions_reponses);

// Les commentaires
$comment_lines  = 21;
$comments_count = 0;
if (xoops_trim($current_categ->getVar('comment1')) != '') {
    ++$comments_count;
}
if (xoops_trim($current_categ->getVar('comment2')) != '') {
    $comment_lines -= 7;
    ++$comments_count;
}
if (xoops_trim($current_categ->getVar('comment3')) != '') {
    $comment_lines -= 7;
    ++$comments_count;
}
$xoopsTpl->assign('comment_lines', $comment_lines);    // Indique le nombre de lignes des textarea de saisie des commentaires
$xoopsTpl->assign('comments_count', $comments_count);    // Nombre de zones de commentaires à saisir (de 0 à 3)
$_SESSION['comment_lines'] = $comment_lines;
$xoopsTpl->assign('xoops_pagetitle', $current_quest->getVar('LibelleQuestionnaire') . ' - ' . $current_categ->getVar('LibelleCategorie'));

// Création des boutons précédent, suivant et imprimer ****************************************************************
$btn_suiv = $btn_prev = '';
if (!isset($tbl_categories)) {
    $crit_categ = new Criteria('IdQuestionnaire', $current_quest->getVar('IdQuestionnaire'), '=');
    $crit_categ->setSort('OrdreCategorie');
    $tbl_categories = $categories_handler->getIds($crit_categ);
}

$pos = array_search($current_categ->getVar('IdCategorie'), $tbl_categories);
// Bouton suivant
if ($pos + 1 != count($tbl_categories)) {
    $categid  = $tbl_categories[$pos + 1];
    $btn_suiv = XOOPS_URL . '/modules/quest/category.php?IdQuestionnaire=' . $current_quest->getVar('IdQuestionnaire') . '&categoryid=' . $categid;
}
// Bouton précédent
if ($pos != 0) {
    $categid  = $tbl_categories[$pos - 1];
    $btn_prev = XOOPS_URL . '/modules/quest/category.php?IdQuestionnaire=' . $current_quest->getVar('IdQuestionnaire') . '&categoryid=' . $categid;
}
$xoopsTpl->assign('btn_suiv', $btn_suiv);
$xoopsTpl->assign('btn_prev', $btn_prev);

include_once XOOPS_ROOT_PATH . '/footer.php';

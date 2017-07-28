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
 * Page charg�e de r�aliser l'export des donn�es pour le client
 */
include '../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';
include_once XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('xoops_pagetitle', _QUEST_EXPORT_WELCOME);

if (!class_exists('csv')) {
    include_once XOOPS_ROOT_PATH . '/modules/quest/class/csv.php';
}

$uid = 0;
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else {    // Acc�s r�serv� aux utilisateurs enregistr�s
    redirect_header(XOOPS_URL . '/index.php', 2, _ERRORS);
    exit();
}
$cac_handler            = &xoops_getModuleHandler('cac', 'quest');
$cac_categories_handler = &xoops_getModuleHandler('cac_categories', 'quest');
$categories_handler     = &xoops_getModuleHandler('categories', 'quest');
$enquetes_handler       = &xoops_getModuleHandler('enquetes', 'quest');
$questionnaires_handler = &xoops_getModuleHandler('questionnaires', 'quest');
$questions_handler      = &xoops_getModuleHandler('questions', 'quest');
$reponses_handler       = &xoops_getModuleHandler('reponses', 'quest');
$rubrcomment_handler    = &xoops_getModuleHandler('rubrcomment', 'quest');

/*
 * Affichage du formulaire de connexion
 *
 */
/**
 * @param string $message
 */
function questform($message = '')
{
    global $questionnaires_handler;
    $groups              = quest_getUserGroups();
    $lang_submit         = _SUBMIT;
    $lang_enter_password = _QUEST_EXPORT_SELECT_QUEST;
    $lang_fields_sep     = _QUEST_EXPORT_FIELDS_SEP;
    $lang_welcome        = _QUEST_EXPORT_WELCOME;
    $tbl_questionnaires  = $questionnaires_handler->getObjects($groups);
    foreach ($tbl_questionnaires as $one_questionnaire) {
        $select_options .= '<option value="' . $one_questionnaire->getVar('IdQuestionnaire') . '">' . $one_questionnaire->getVar('LibelleQuestionnaire') . '</option>';
    }
    $str = <<<EOD
    <form name='flogin' id='flogin' action='status.php' method='post'>
    <h1>$lang_welcome</h1>
    <br><b>$message</b><br>
    <table border="0">
    <tr>
        <td>$lang_enter_password</td><td><select name='quest'>$select_options</select></td>
    </tr>
    <tr>
        <td>$lang_fields_sep<td><input type="text" name="fieldsep" size="2" value=";" /></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="btngo" VALUE="$lang_submit" /></td>
    </tr>
    </table>
    </form>
EOD;
    echo $str;
}

include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';
if (isset($_POST['btngo']) || isset($_GET['IdQuestionnaire'])) {
    $id_qestionnaire = isset($_GET['IdQuestionnaire']) ? (int)$_GET['IdQuestionnaire'] : (int)$_POST['quest'];
    $critere         = new Criteria('IdQuestionnaire', $id_qestionnaire, '=');
    $quest_count     = $questionnaires_handler->getCount($critere);
    if ($quest_count == 0) {
        loginform(_QUEST_EXPORT_ERROR1);
        exit;
    }
    // Si on est encore l� c'est que tout va bien (ou presque)
    // R�cup�ration du formulaire
    $tbl_quest     = $questionnaires_handler->getObjects($critere);
    $questionnaire = $tbl_quest[0];
    // Derni�re v�rification, est-ce que l'utilisateur courant appartient bien au groupe du questionnaire ?
    $groups = quest_getUserGroups($uid, false);    // Groupe(s) de l'utilisateur
    if (!in_array($questionnaire->getVar('PartnerGroup'), $groups)) {
        loginform(_QUEST_EXPORT_ERROR3);    // C'est pas beau de tricher !
        exit;
    }

    // R�cup�ration des informations sur l'enqu�t�
    $enquete = $enquetes_handler->get($questionnaire->getVar('IdEnquete'));
    if ($enquete == null) {
        exit(_QUEST_EXPORT_ERROR2);
    }

    $disk_file = XOOPS_UPLOAD_PATH . '/quest_' . $questionnaire->getVar('IdQuestionnaire') . '.csv';
    $http_file = XOOPS_UPLOAD_URL . '/quest_' . $questionnaire->getVar('IdQuestionnaire') . '.csv';

    $csv = new csv($disk_file, isset($_POST['fieldsep']) ? $_POST['fieldsep'] : ';');
    $csv->openCSV();

    // Cr�ation de l'ent�te du fichier CSV
    $csv->addHeader('questionnaire_IdQuestionnaire');
    $csv->addHeader('questionnaire_LibelleQuestionnaire');
    $csv->addHeader('questionnaire_DateOuverture');
    $csv->addHeader('questionnaire_DateFermeture');
    $csv->addHeader('questionnaire_DateRelance');
    $csv->addHeader('questionnaire_IdEnquete');
    $csv->addHeader('questionnaire_NomEnquete');
    $csv->addHeader('questionnaire_PrenomEnquete');
    $csv->addHeader('categorie_IdCategorie');
    $csv->addHeader('categorie_LibelleCategorie');
    $csv->addHeader('categorie_LibelleCompltCategorie');
    $csv->addHeader('categorie_OrdreCategorie');
    $csv->addHeader('categorie_AfficherDroite');
    $csv->addHeader('categorie_AfficherGauche');
    $csv->addHeader('categorie_comment1');
    $csv->addHeader('categorie_comment2');
    $csv->addHeader('categorie_comment3');
    $csv->addHeader('categorie_comment1mandatory');
    $csv->addHeader('categorie_comment2mandatory');
    $csv->addHeader('categorie_comment3mandatory');
    $csv->addHeader('question_IdQuestion');
    $csv->addHeader('question_TexteQuestion');
    $csv->addHeader('question_ComplementQuestion');
    $csv->addHeader('question_OrdreQuestion');
    $csv->addHeader('reponse_IdReponse');
    $csv->addHeader('reponse_IdRespondant');
    $csv->addHeader('reponse_RespondantLogin');
    $csv->addHeader('reponse_RespondantName');
    $csv->addHeader('reponse_IdCACDroite');
    $csv->addHeader('reponse_LibelleCourtDroite');
    $csv->addHeader('reponse_LibelleLongDroite');
    $csv->addHeader('reponse_IdCACGauche');
    $csv->addHeader('reponse_LibelleCourtGauche');
    $csv->addHeader('reponse_LibelleLongGauche');
    $csv->addHeader('reponse_comment1');
    $csv->addHeader('reponse_comment2');
    $csv->addHeader('reponse_comment3');
    $csv->addHeader('reponse_DateReponse');
    $csv->addHeader('reponse_IP');
    $csv->addHeader('respondant_email');
    $csv->writeHeader();

    // Recherche de toutes les cat�gories du questionnaire
    $critere = new Criteria('IdQuestionnaire', $questionnaire->getVar('IdQuestionnaire'), '=');
    $critere->setSort('OrdreCategorie');
    $tbl_categories = $categories_handler->GetObjects($critere);

    // R�cup�ration des CAC
    $critere = new Criteria('IdCac', 0, '<>');
    $critere->setSort('IdCAC');
    $tbl_CAC = $cac_handler->GetObjects($critere, true);

    // R�cup�ration des questions par cat�gorie
    $critere = new Criteria('IdQuestionnaire', $questionnaire->getVar('IdQuestionnaire'), '=');
    $critere->setSort('IdCategorie, OrdreQuestion');
    $tbl_questions    = array();
    $tbl_tmpquestions = array();
    $tbl_tmpquestions = $questions_handler->GetObjects($critere);
    if (count($tbl_tmpquestions) > 0) {
        $first_id = $tbl_tmpquestions[0];
        $vold     = $first_id->getVar('IdCategorie');
        $tbl_tmp  = array();
        foreach ($tbl_tmpquestions as $one_question) {
            if ($one_question->getVar('IdCategorie') == $vold) {
                $tbl_tmp[] = $one_question;
            } else {
                $tbl_questions[$vold] = $tbl_tmp;
                $tbl_tmp              = array();
                $vold                 = $one_question->getVar('IdCategorie');
            }
        }
        $tbl_questions[$vold] = $tbl_tmp;
    }

    // R�cup�ration des utilisateurs
    $tbl_users = quest_getUsersFromGroup($questionnaire->getVar('Groupe'));
    foreach ($tbl_users as $one_user) {    // Boucle sur les utilisateurs
        foreach ($tbl_categories as $one_categorie) {    // Boucle sur les cat�gories
            // R�cup�ration de toutes les r�ponses de cette personne pour cette cat�gorie
            $tbl_answers = array();
            $criteria    = new CriteriaCompo();
            $criteria->add(new Criteria('IdQuestionnaire', $questionnaire->getVar('IdQuestionnaire'), '='));
            $criteria->add(new Criteria('IdRespondant', $one_user->getVar('uid'), '='));
            $criteria->add(new Criteria('IdCategorie', $one_categorie->getVar('IdCategorie'), '='));
            $tbl_reponses = $reponses_handler->getObjects2($criteria, 'IdQuestion');

            $tbl_tmp_comment = array();
            $comment1        = $comment2 = $comment3 = '';
            $tbl_tmp_comment = $rubrcomment_handler->getObjects($criteria);
            if (count($tbl_tmp_comment) == 1) {
                $tmp_comment = $tbl_tmp_comment[0];
                $comment1    = nl2br($tmp_comment->getVar('Comment1'));
                $comment2    = nl2br($tmp_comment->getVar('Comment2'));
                $comment3    = nl2br($tmp_comment->getVar('Comment3'));
            }
            $tbl_questions2 = $tbl_questions[$one_categorie->getVar('IdCategorie')];
            foreach ($tbl_questions2 as $one_question) {
                if (isset($tbl_reponses[$one_question->getVar('IdQuestion')])) {
                    $reponse = $tbl_reponses[$one_question->getVar('IdQuestion')];
                    $csv->clearData();
                    $csv->addData($questionnaire->getVar('IdQuestionnaire'));
                    $csv->addData($questionnaire->getVar('LibelleQuestionnaire'));
                    $csv->addData(date('Ymd', $questionnaire->getVar('DateOuverture')));
                    $csv->addData(date('Ymd', $questionnaire->getVar('DateFermeture')));
                    $csv->addData(date('Ymd', $questionnaire->getVar('DerniereRelance')));
                    $csv->addData($questionnaire->getVar('IdEnquete'));
                    $csv->addData($enquete->getVar('NomEnquete'));
                    $csv->addData($enquete->getVar('PrenomEnquete'));
                    $csv->addData($one_categorie->getVar('IdCategorie'));
                    $csv->addData($one_categorie->getVar('LibelleCategorie'));
                    $csv->addData($one_categorie->getVar('LibelleCompltCategorie'));
                    $csv->addData($one_categorie->getVar('OrdreCategorie'));
                    $csv->addData($one_categorie->getVar('AfficherDroite'));
                    $csv->addData($one_categorie->getVar('AfficherGauche'));
                    $csv->addData($one_categorie->getVar('comment1'));
                    $csv->addData($one_categorie->getVar('comment2'));
                    $csv->addData($one_categorie->getVar('comment3'));
                    $csv->addData($one_categorie->getVar('comment1mandatory'));
                    $csv->addData($one_categorie->getVar('comment2mandatory'));
                    $csv->addData($one_categorie->getVar('comment3mandatory'));
                    $csv->addData($one_question->getVar('IdQuestion'));
                    $csv->addData($one_question->getVar('TexteQuestion'));
                    $csv->addData(nl2br($one_question->getVar('ComplementQuestion')));
                    $csv->addData($one_question->getVar('OrdreQuestion'));
                    $csv->addData($reponse->getVar('IdReponse'));
                    $csv->addData($reponse->getVar('IdRespondant'));
                    $csv->addData($one_user->getVar('uname'));
                    $csv->addData($one_user->getVar('name'));
                    $csv->addData($reponse->getVar('Id_CAC1'));
                    $libellecourt = $libellelong = '';
                    if ($reponse->getVar('Id_CAC1') != 0) {
                        $cac_tmp      = $tbl_CAC[$reponse->getVar('Id_CAC1')];
                        $libellecourt = $cac_tmp->getVar('LibelleCourtCac');
                        $libellelong  = $cac_tmp->getVar('LibelleCAC');
                    }
                    $csv->addData($libellecourt);
                    $csv->addData($libellelong);

                    $csv->addData($reponse->getVar('Id_CAC2'));
                    $libellecourt = $libellelong = '';
                    if ($reponse->getVar('Id_CAC2') != 0) {
                        $cac_tmp      = $tbl_CAC[$reponse->getVar('Id_CAC2')];
                        $libellecourt = $cac_tmp->getVar('LibelleCourtCac');
                        $libellelong  = $cac_tmp->getVar('LibelleCAC');
                    }
                    $csv->addData($libellecourt);
                    $csv->addData($libellelong);
                    $csv->addData($comment1);
                    $csv->addData($comment2);
                    $csv->addData($comment3);
                    $csv->addData(date('Ymd', $reponse->getVar('DateReponse')));
                    $csv->addData($reponse->getVar('IP'));
                    $csv->addData($one_user->getVar('email'));
                    $csv->writeData();
                }
            }
        }
    }
    $csv->closeCSV();
    echo '<h1>' . _QUEST_EXPORT_WELCOME . '</h1>';
    echo sprintf(_QUEST_EXPORT_READY, $http_file, $http_file);
} else {    // Affichage du formulaire de connexion
    questform();
}

include_once XOOPS_ROOT_PATH . '/footer.php';

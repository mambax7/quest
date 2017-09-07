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
 * Enregistrement des CAC � la vol�e pour une CAC donn�e dans une r�ponse, pour une cat�gorie dans un questionnaire et pour une personne
 */
include_once __DIR__ . '/../../mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';

$uid = 0;
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
} else {    // Acc�s r�serv� aux utilisateurs enregistr�s
    redirect_header(XOOPS_URL . '/index.php', 2, _ERRORS);
}

// Param�tres recus
$IdCategorie     = (int)$_POST['IdCategorie'];
$IdQuestionnaire = (int)$_POST['IdQuestionnaire'];
$IdCAC           = (int)$_POST['IdCAC'];
$IdQuestion      = (int)$_POST['IdQuestion'];
$DG              = (int)$_POST['DG']; // 1=Droite, 2=Gauche
$IP              = Quest_IP();

// Initialisation des handlers
$categoriesHandler     =  xoops_getModuleHandler('categories', 'quest');
$questionnairesHandler =  xoops_getModuleHandler('questionnaires', 'quest');
$reponsesHandler       =  xoops_getModuleHandler('reponses', 'quest');

// On commence par les v�rifications
// Chargement de la cat�gorie et du questionnaire
$save_categ = $categoriesHandler->get($IdCategorie);
if (!is_object($save_categ)) {    // Cat�gorie introuvable
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR2);
}

$save_quest = $questionnairesHandler->get($save_categ->getVar('IdQuestionnaire'));
if (!is_object($save_quest)) {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR6);
}

// Ensuite on v�rifie que l'utilisateur a le droit de r�pondre � ce questionnaire et donc � cette cat�gorie
if (!$questionnairesHandler->isVisible($save_quest, $uid)) {
    redirect_header(XOOPS_URL . '/index.php', 2, _QUEST_ERROR3);    // Pas le droit, on d�gage.
}

// On peut passer � la sauvegarde des donn�es *************************************************************************
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('IdQuestionnaire', $save_quest->getVar('IdQuestionnaire'), '='));
$criteria->add(new Criteria('IdCategorie', $save_categ->getVar('IdCategorie'), '='));
$criteria->add(new Criteria('IdQuestion', $IdQuestion, '='));
$criteria->add(new Criteria('IdRespondant', $uid, '='));
$tbl_reponse = $reponsesHandler->getObjects($criteria);

if (count($tbl_reponse) == 1) {    // R�ponse d�j� enregistr�e, il faut mettre � jour
    $reponse = $tbl_reponse[0];
    if ($DG == 1) {
        $reponse->setVar('Id_CAC1', $IdCAC);
    } else {
        $reponse->setVar('Id_CAC2', $IdCAC);
    }
    $reponse->setVar('DateReponse', time());
    $reponse->setVar('IP', $IP);
    $reponsesHandler->insert($reponse, true);
} else {    // Nouvelle r�ponse, il faut ajouter ******************************
    $reponse = $reponsesHandler->create(true);
    $reponse->setVar('IdQuestionnaire', $IdQuestionnaire);
    $reponse->setVar('IdCategorie', $IdCategorie);
    $reponse->setVar('IdRespondant', $uid);
    $reponse->setVar('IdQuestion', $IdQuestion);
    if ($DG == 1) {
        $reponse->setVar('Id_CAC1', $IdCAC);
    } else {
        $reponse->setVar('Id_CAC2', $IdCAC);
    }
    $reponse->setVar('DateReponse', time());
    $reponse->setVar('IP', $IP);
    $reponsesHandler->insert($reponse, true);
}

// Et au final, on r�affichage des donn�es ****************************************************************************
// $tbl_sesCAC[$one_cac_category->getVar('IdCAC')] = array('LibelleCourt' => xoops_trim($libelle_court), '' => xoops_trim($libelle_long));
$lr = '';
if ($DG == 1) { // 1=Droite, 2=Gauche
    $tbl_cac = $_SESSION['tbl_sesCAC_D'];
    $lr      = 'd';
    $lr2     = 'r';
} else {
    $lr      = 'g';
    $lr2     = 'l';
    $tbl_cac = $_SESSION['tbl_sesCAC_G'];
}
$resultat = '';
foreach ($tbl_cac as $cac_id => $cac_datas) {
    $suffixe = 'n';
    if ($cac_id == $IdCAC) {
        $suffixe = 's';
    }
    $LibelleLong = $cac_datas['LibelleLong'];
    $resultat    .= '<img src="' . XOOPS_URL . '/modules/quest/images/cac/' . $lr2 . $cac_id . $suffixe . '.png" alt="' . $LibelleLong . '" border="0" onclick="changeme(\'q' . $IdQuestion . $lr . '\',' . $cac_id . ',' . $IdQuestion . ',' . $DG . ')" /> ';
    //file_put_contents('verif.txt',$resultat);
}
echo $resultat;

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
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
//if (!class_exists('XoopsPersistableObjectHandler')) {
//    include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';
//}

include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';

/**
 * Class categories
 */
class categories extends MyObject
{
    /**
     * categories constructor.
     */
    public function __construct()
    {
        $this->initVar('IdCategorie', XOBJ_DTYPE_INT, null, false);
        $this->initVar('IdQuestionnaire', XOBJ_DTYPE_INT, null, false);
        $this->initVar('LibelleCategorie', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('LibelleCompltCategorie', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('OrdreCategorie', XOBJ_DTYPE_INT, null, false);
        $this->initVar('AfficherDroite', XOBJ_DTYPE_INT, null, false);
        $this->initVar('AfficherGauche', XOBJ_DTYPE_INT, null, false);
        $this->initVar('comment1', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('comment2', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('comment3', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('comment1mandatory', XOBJ_DTYPE_INT, null, false);
        $this->initVar('comment2mandatory', XOBJ_DTYPE_INT, null, false);
        $this->initVar('comment3mandatory', XOBJ_DTYPE_INT, null, false);
    }
}

/**
 * Class QuestCategoriesHandler
 */
class QuestCategoriesHandler extends MyXoopsPersistableObjectHandler
{
    /**
     * QuestCategoriesHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct($db)
    {    //                          Table               Classe          Id
        parent::__construct($db, 'quest_categories', 'categories', 'IdCategorie');
    }

    /**
     * Renvoie la liste des cat�gories d'un questionnaire avec son �tat
     *
     * @param   int     IdQuestionnaire     L'identifiant du questionnaire dont on veut r�cup�rer les infos
     * @param   int     uid                 L'identifiant de la personne
     * @param   boolean toutrepondu         Indique si la personne a r�pondu � toutes les cat�gories du questionnaire
     * @return array Liste des cat�gories sous la forme Id Cat�gorie-Etat de la cat�gorie (pas saisie/en cours/termin�) / Objet cat�gorie
     */
    public function getCategoriesAndState($IdQuestionnaire, $uid, &$toutrepondu)
    {
        $ret            = array();
        $tbl_categories = array();
        // 1) Il faut commencer par v�rifier si l'utilisateur n'a pas d�j� r�pondu � tout, auquel cas il ne faut rien lui afficher
        $tout_repondu = true;
        // On commence par r�cup�rer la liste compl�te de toutes les cat�gories de ce questionnaire
        $crit_categ = new Criteria('IdQuestionnaire', $IdQuestionnaire, '=');
        $crit_categ->setSort('OrdreCategorie');
        $tbl_categories =& $this->getObjects($crit_categ);
        foreach ($tbl_categories as $one_category) {
            $etat = $this->getCategoryState($one_category, $uid);
            if ($etat == 0 || $etat == 2) {
                $tout_repondu = false;
            }
            $ret[$one_category->getVar('IdCategorie') . '-' . $etat] = $one_category;
        }

        return $ret;
    }

    /**
     * Renvoie l'�tat d'une cat�gorie
     *
     * 0=Aucune r�ponse, 1=Tout r�pondu, 2= Partiellement r�pondu
     *
     * @param     $one_category
     * @param int $uid L'utilisateur � tester
     * @return int
     * @internal param object $category La cat�gorie � tester
     */
    public function getCategoryState(&$one_category, $uid)
    {
        $etat                      = 0;
        $quest_questions_handler   = &xoops_getModuleHandler('questions', 'quest');
        $quest_reponses_handler    = &xoops_getModuleHandler('reponses', 'quest');
        $quest_rubrcomment_handler = &xoops_getModuleHandler('rubrcomment', 'quest');

        // Recherche du nombre de questions pour cette cat�gorie
        $criteria2 = new CriteriaCompo();
        $criteria2->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'), '='));
        $criteria2->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
        $quest_count = $quest_questions_handler->getCount($criteria2);    // Nombre de questions de cette cat�gorie
        // Nombre de r�ponses faites pour cette cat�gorie (de ce questionnaire) pour cet utilisateur
        $criteria3 = new CriteriaCompo();
        $criteria3->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'), '='));
        $criteria3->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
        $criteria3->add(new Criteria('IdRespondant', $uid, '='));
        $answers_count = $quest_reponses_handler->getCount($criteria3);
        if ($answers_count == 0 && $quest_count > 0) {    // Aucune r�ponse mais il y a des questions
            $etat = 0;
        } elseif ($answers_count == $quest_count) {    // Le nombre de r�ponses correspond au nombre de questions
            // Il faut v�rifier que toutes les questions ont bien �t� r�pondues
            $criteria4 = new CriteriaCompo();
            $criteria4->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'), '='));
            $criteria4->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
            $criteria4->add(new Criteria('IdRespondant', $uid, '='));
            if ($one_category->getVar('AfficherDroite') == 1) {
                $criteria4->add(new Criteria('Id_CAC1', 0, '<>'));
            }
            if ($one_category->getVar('AfficherGauche') == 1) {
                $criteria4->add(new Criteria('Id_CAC2', 0, '<>'));
            }
            $answers_count2 = $quest_reponses_handler->getCount($criteria4);
            if ($answers_count2 == $quest_count) {    // Le nombre de r�ponses correspond au nombre de questions
                // Reste � v�rifier les r�ponses aux commentaires
                $etat             = 1;    // On part du postulat qu'effectivement tout est r�pondu
                $tbl_rubr_comment = array();
                $criteria5        = new CriteriaCompo();
                $criteria5->add(new Criteria('IdQuestionnaire', $one_category->getVar('IdQuestionnaire'), '='));
                $criteria5->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
                $criteria5->add(new Criteria('IdRespondant', $uid, '='));
                $criteria5->add(new Criteria('IdCategorie', $one_category->getVar('IdCategorie'), '='));
                $tbl_rubr_comment = $quest_rubrcomment_handler->getObjects($criteria5);
                //echo "<br>".$criteria5->render();

                if (count($tbl_rubr_comment) > 0) {    // Ca se pr�sente bien, il y a un enregistrement
                    $rubrcomment = $tbl_rubr_comment[0];
                    if ($one_category->getVar('comment1mandatory') && xoops_trim($rubrcomment->getVar('Comment1')) == '') {
                        $etat = 2;
                    }
                    if ($one_category->getVar('comment2mandatory') && xoops_trim($rubrcomment->getVar('Comment2')) == '') {
                        $etat = 2;
                    }
                    if ($one_category->getVar('comment3mandatory') && xoops_trim($rubrcomment->getVar('Comment3')) == '') {
                        $etat = 2;
                    }
                } else {    // Il n'y a pas d'enregistrement pour les commentaires, reste � v�rifier qu'on attendait un ou des commentaires
                    if (xoops_trim($one_category->getVar('comment1')) != '') {    // On devait avoir un commentaire et il n'y en a pas eu
                        $etat = 2;
                    } elseif (xoops_trim($one_category->getVar('comment2')) != '') {    // On devait avoir un commentaire et il n'y en a pas eu
                        $etat = 2;
                    } elseif (xoops_trim($one_category->getVar('comment3')) != '') {    // On devait avoir un commentaire et il n'y en a pas eu
                        $etat = 2;
                    }
                }
            } else {
                $etat = 2;    // Partiellement r�pondu
            }
        } else {    // Partiellement r�pondu
            $etat = 2;
        }

        return $etat;
    }
}

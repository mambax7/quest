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

defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
//if (!class_exists('XoopsPersistableObjectHandler')) {
//    include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';
//}

include_once XOOPS_ROOT_PATH . '/modules/quest/class/PersistableObjectHandler.php';

/**
 * Class questionnaires
 */
class questionnaires extends MyObject
{
    /**
     * questionnaires constructor.
     */
    public function __construct()
    {
        $this->initVar('IdQuestionnaire', XOBJ_DTYPE_INT, null, false);
        $this->initVar('LibelleQuestionnaire', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('IdEnquete', XOBJ_DTYPE_INT, null, false);
        $this->initVar('DateOuverture', XOBJ_DTYPE_INT, null, false);
        $this->initVar('DateFermeture', XOBJ_DTYPE_INT, null, false);
        $this->initVar('NbSessions', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Etat', XOBJ_DTYPE_INT, null, false);
        $this->initVar('ltor', XOBJ_DTYPE_INT, null, false);
        $this->initVar('SujetRelance', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('CorpsRelance', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('SujetOuverture', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('CorpsOuverture', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('FrequenceRelances', XOBJ_DTYPE_INT, null, false);
        $this->initVar('DerniereRelance', XOBJ_DTYPE_INT, null, false);
        $this->initVar('NbRelances', XOBJ_DTYPE_INT, null, false);
        $this->initVar('ReplyTo', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('Groupe', XOBJ_DTYPE_INT, null, false);
        $this->initVar('PartnerGroup', XOBJ_DTYPE_INT, null, false);
        $this->initVar('RelancesOption', XOBJ_DTYPE_INT, null, false);
        $this->initVar('EmailFrom', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('EmailFromName', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('Introduction', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('GoOnAfterEnd', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('ResetButton', XOBJ_DTYPE_TXTBOX, null, false, 255);
    }
}

/**
 * Class QuestQuestionnairesHandler
 */
class QuestQuestionnairesHandler extends MyXoopsPersistableObjectHandler
{
    /**
     * QuestQuestionnairesHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct($db)
    {    //                            Table                   Classe          Id
        parent::__construct($db, 'quest_questionnaires', 'questionnaires', 'IdQuestionnaire');
    }

    /**
     * Renvoie la liste des questionnaires auxquel l'utilisateur n'a pas r�pondu, en respectant les droits
     *
     * @param   int     uid     Identifiant de l'utilisateur
     * @return array Liste des questionnaires sous la forme ID Premi�re cat�gorie => Objet Questionnaire
     */
    public function GetNonAnsweredQuestionnaires($uid)
    {
        include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';
        $ret                = [];
        $tbl_questionnaires = [];
        $tbl_categories     = [];
        $categoriesHandler = xoops_getModuleHandler('categories', 'quest');

        // On commence par r�cup�rer la liste des questionnaires
        $criteria = new CriteriaCompo();
        $criteria->add(quest_getUserGroups());        // Questionnaires auxquels l'utilisateur peut r�pondre (de part la gestion des droits)
        $criteria->add(new Criteria('DateFermeture', time(), '>'));        // Questionnaires non "p�rim�s"
        $criteria->add(new Criteria('DateOuverture', time(), '<='));        // Questionnaires non "p�rim�s"
        $criteria->setSort('LibelleQuestionnaire');

        $tbl_questionnaires =& $this->getObjects($criteria);
        foreach ($tbl_questionnaires as $questionnaire) {    // Boucle sur les questionnaires
            // Recherche de ses cat�gories
            $critere = new Criteria('IdQuestionnaire', $questionnaire->getVar('IdQuestionnaire'), '=');
            $critere->setSort('OrdreCategorie');
            $tbl_categories = $categoriesHandler->GetObjects($critere);
            foreach ($tbl_categories as $one_categorie) {    // Boucle sur les cat�gories
                // Si le questionnaire n'est pas termin� :
                $etat = $categoriesHandler->getCategoryState($one_categorie, $uid);
                if (1 != $etat) {
                    $ret[$one_categorie->getVar('IdCategorie')] = $questionnaire;
                    break;    // Pas la peine de boucler sur les cat�gories
                }
            }
        }

        return $ret;
    }

    /**
     * Indique si un questionnaire est "visible" d'un utilisateur (s'il a les droits et si le questionnaire n'est pas p�rim� et s'il est publi�)
     *
     * @param      $Questionnaire
     * @param  int $uid L'utilisateur courant
     * @return bool Indique si le questionnaire est accessible/visible de l'utlisateur
     * @internal param object $Questionnaires Le questionnaire � traiter
     */
    public function isVisible($Questionnaire, $uid)
    {
        include_once XOOPS_ROOT_PATH . '/modules/quest/include/functions.php';
        // Premier test, par rapport aux droits
        if (!in_array($Questionnaire->getVar('Groupe'), quest_getUserGroups($uid, false))) {
            return false;
        } else {
            // Deuxi�me test, par rapport � la date de fermeture
            if ($Questionnaire->getVar('DateFermeture') < time()) {
                return false;
            } else {    // Dernier test, par rapport � la date de mise en service du questionnaire
                if ($Questionnaire->getVar('DateOuverture') <= time()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}

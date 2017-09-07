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

/**
 * Renvoie, sous la forme d'un critère, la liste des groupes auxquels un utilisateur fait partie
 *
 * @param int  $uid Id de l'utilisateur à tester (si rien de spécifié, on prend l'utilisateur courant)
 * @param bool $asCriteria
 * @return criteria La liste des groupes
 */
function quest_getUserGroups($uid = 0, $asCriteria = true)
{
    global $xoopsUser;
    if ($uid == 0) {
        $uid = $xoopsUser->getVar('uid');
    }
    $memberHandler = xoops_getHandler('member');
    $tbl_groups     = $memberHandler->getGroupsByUser($uid);
    if ($asCriteria) {
        $groups_string = implode(',', $tbl_groups);
        $criteria      = new Criteria('Groupe', '(' . $groups_string . ')', 'IN');

        return $criteria;
    } else {
        return $tbl_groups;
    }
}

/**
 * Renvoie la liste des utilisateurs d'un groupe
 *
 * @param int $group_id Groupe recherché
 * @return array    tableau d'objets XoopsUser
 */
function quest_getUsersFromGroup($group_id)
{
    $tbl_users      = [];
    $memberHandler = xoops_getHandler('member');
    $tbl_users      = $memberHandler->getUsersByGroup($group_id, true);

    return $tbl_users;
}

/**
 * Fonction chargée de renvoyer l'adresse IP du visiteur courant
 *
 */
function Quest_IP()
{
    $proxy_ip = '';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
        $proxy_ip = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        $proxy_ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
        $proxy_ip = $_SERVER['HTTP_FORWARDED'];
    } elseif (!empty($_SERVER['HTTP_VIA'])) {
        $proxy_ip = $_SERVER['HTTP_VIA'];
    } elseif (!empty($_SERVER['HTTP_X_COMING_FROM'])) {
        $proxy_ip = $_SERVER['HTTP_X_COMING_FROM'];
    } elseif (!empty($_SERVER['HTTP_COMING_FROM'])) {
        $proxy_ip = $_SERVER['HTTP_COMING_FROM'];
    }
    $regs = [];
    if (!empty($proxy_ip) && $is_ip = preg_match('/^(\d{1,3}\.){3,3}\d{1,3}/', $proxy_ip, $regs) && count($regs) > 0) {
        $the_IP = $regs[0];
    } else {
        $the_IP = $_SERVER['REMOTE_ADDR'];
    }

    return $the_IP;
}

/**
 * Create (in a link) a javascript confirmation box
 * @param $msg
 * @return string
 */
function quest_JavascriptLinkConfirm($msg)
{
    return "onclick=\"javascript:return confirm('" . str_replace("'", ' ', $msg) . "')\"";
}

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

$modversion['version']             = 2.0;
$modversion['module_status']       = 'Beta 1';
$modversion['release_date']        = '2016/07/05';
$modversion['name']                = 'quest';
$modversion['description']         = 'Gestion de questionnaires';
$modversion['credits']             = '';
$modversion['author']              = 'Devconcept (Hervé Thouzard, Christian Edom)';
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0 or later';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']            = 0;
$modversion['image']               = 'assets/images/logoModule.png';
$modversion['dirname']             = basename(__DIR__);
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.9';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = array('mysql' => '5.5');

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file
$modversion['tables'][0] = 'quest_cac';                    // Dictionary checkboxes
$modversion['tables'][1] = 'quest_cac_categories';        //  Link between categories and checkboxes
$modversion['tables'][2] = 'quest_categories';            // Dictionary categories
$modversion['tables'][3] = 'quest_enquetes';            // Table of respondents
$modversion['tables'][4] = 'quest_questionnaires';        // List of all questionnaires
$modversion['tables'][5] = 'quest_questions';            // Questions by category
$modversion['tables'][6] = 'quest_reponses';            // Replies per person / Questionnaire / class / issue
$modversion['tables'][7] = 'quest_respondquestionn';    // List of people who have finished answering
$modversion['tables'][8] = 'quest_rubrcomment';            // Responses to Comments

// Admin things
$modversion['hasAdmin']    = 1;                            // Not at the moment
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 0;
// Comments
$modversion['hasComments'] = 0;
// Notifications
$modversion['hasNotification'] = 0;

// Templates
$modversion['templates'][1]['file']        = 'quest_index.tpl';
$modversion['templates'][1]['description'] = 'Module Index';

$modversion['templates'][2]['file']        = 'quest_category.tpl';
$modversion['templates'][2]['description'] = 'List the issues of class to answer';

$modversion['templates'][3]['file']        = 'quest_status.tpl';
$modversion['templates'][3]['description'] = 'Page allowing (x) Sponsor (s) to see the status of questionnaires';

/**
 * Displays the unanswered questionnaires list list (answered the questionnaires are not visible)
 */
$modversion['blocks'][1]['file']        = 'quest_questionnaires_list.php';
$modversion['blocks'][1]['name']        = '_MI_QUEST_BNAME1';
$modversion['blocks'][1]['description'] = 'Display the list of unanswered questionnaires';
$modversion['blocks'][1]['show_func']   = 'b_quest_questionnaires_list_show';
$modversion['blocks'][1]['edit_func']   = 'b_quest_questionnaires_list_edit';
$modversion['blocks'][1]['options']     = '1';    // Trier par
$modversion['blocks'][1]['template']    = 'quest_block_questionnaire_list.tpl';

/**
 * Displays a list of categories (the current schedule) that have not been answered
 */
$modversion['blocks'][2]['file']        = 'quest_categories_list.php';
$modversion['blocks'][2]['name']        = '_MI_QUEST_BNAME2';
$modversion['blocks'][2]['description'] = 'Display the list of unanswered categories';
$modversion['blocks'][2]['show_func']   = 'b_quest_categories_list_show';
$modversion['blocks'][2]['edit_func']   = 'b_quest_categories_list_edit';
$modversion['blocks'][2]['options']     = '1';    // 1 = Sort by
$modversion['blocks'][2]['template']    = 'quest_block_categories_list.tpl';

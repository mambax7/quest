<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @author       XOOPS Development Team
 */

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();


$adminObject->displayNavigation(basename(__FILE__));
//------------- Test Data ----------------------------
//xoops_loadLanguage('admin/modulesadmin', 'system');
//require_once __DIR__ . '/../testdata/index.php';
//$adminObject->addItemButton(_AM_SYSTEM_MODULES_INSTALL_TESTDATA, '__DIR__ . /../../testdata/index.php?op=load', 'add');
//$adminObject->displayButton('left', '');
//------------- End Test Data ----------------------------
$adminObject->displayIndex();

require_once __DIR__ . '/admin_footer.php';

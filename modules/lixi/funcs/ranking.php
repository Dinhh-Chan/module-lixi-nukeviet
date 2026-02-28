<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2026 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_LIXI')) {
    exit('Stop!!!');
}

global $db, $module_data, $module_name, $page_title, $module_info, $my_head;

$page_title = $lang_module['ranking'];

$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

$sql = 'SELECT fullname, userid, SUM(amount_received) as total FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants GROUP BY userid, fullname HAVING total>0 ORDER BY total DESC LIMIT 20';
$list = $db->query($sql)->fetchAll();

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/ranking.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('ranking.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('ranking'));
foreach ($list as $i => $row) {
    $row['stt'] = $i + 1;
    $row['total'] = number_format($row['total'], 0, ',', '.');
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

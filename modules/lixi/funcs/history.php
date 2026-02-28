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

global $db, $user_info, $client_info, $module_data, $module_name, $page_title, $module_info, $my_head;

$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

if (!defined('NV_IS_USER')) {
    $login_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    nv_redirect_location($login_url);
}

$page_title = $lang_module['history'];

$sql = 'SELECT p.*, e.title as event_title, e.alias as event_alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants p 
    LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_events e ON p.event_id=e.id 
    WHERE p.userid=' . $user_info['userid'] . ' ORDER BY p.join_time DESC LIMIT 50';
$list = $db->query($sql)->fetchAll();

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/history.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('history.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('history'));
foreach ($list as $row) {
    $row['join_time'] = nv_date('d/m/Y H:i', $row['join_time']);
    $row['amount_received'] = number_format($row['amount_received'], 0, ',', '.');
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

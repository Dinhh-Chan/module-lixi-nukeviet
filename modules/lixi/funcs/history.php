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

$prefix = NV_PREFIXLANG . '_' . $module_data;
$sql = 'SELECT p.*, e.title as event_title, e.alias as event_alias FROM ' . $prefix . '_participants p 
    LEFT JOIN ' . $prefix . '_events e ON p.event_id=e.id 
    WHERE p.userid=' . $user_info['userid'] . ' ORDER BY p.join_time DESC LIMIT 50';
$list = $db->query($sql)->fetchAll();

$total_received = $db->query('SELECT COALESCE(SUM(amount_received),0) FROM ' . $prefix . '_participants WHERE userid=' . $user_info['userid'])->fetchColumn();

$icon_configs = [
    ['icon' => 'celebration', 'class' => 'lixi-history-icon-orange'],
    ['icon' => 'auto_awesome', 'class' => 'lixi-history-icon-pink'],
    ['icon' => 'casino', 'class' => 'lixi-history-icon-blue'],
    ['icon' => 'redeem', 'class' => 'lixi-history-icon-primary'],
    ['icon' => 'stars', 'class' => 'lixi-history-icon-purple']
];

foreach ($list as $i => &$row) {
    $row['event_title'] = nv_htmlspecialchars($row['event_title'] ?? '');
    $row['detail_url'] = !empty($row['event_alias']) ? NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&alias=' . $row['event_alias'] : '#';
    $row['join_date'] = nv_date('d/m/Y', $row['join_time']);
    $row['join_time_fmt'] = nv_date('H:i', $row['join_time']);
    $row['amount_received_fmt'] = number_format($row['amount_received'], 0, ',', '.');
    $cfg = $icon_configs[$i % count($icon_configs)];
    $row['icon'] = $cfg['icon'];
    $row['icon_class'] = $cfg['class'];
}
unset($row);

$user_avatar = 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle fill="%23ddd" cx="50" cy="50" r="50"/></svg>');
if (defined('NV_IS_USER') && !empty($user_info['photo'])) {
    $user_avatar = NV_BASE_SITEURL . $user_info['photo'];
}
$user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login';
if (defined('NV_IS_USER')) {
    $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=editinfo';
}

$total_count = count($list);
$showing_from = $total_count > 0 ? 1 : 0;
$showing_to = $total_count;

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/history.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('history.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('history'));
$xtpl->assign('USER_AVATAR', $user_avatar);
$xtpl->assign('USER_LINK', $user_link);
$xtpl->assign('TOTAL_RECEIVED', number_format($total_received, 0, ',', '.'));
$showing_entries = str_replace(['{FROM}', '{TO}', '{TOTAL}'], [$showing_from, $showing_to, $total_count], $lang_module['showing_entries']);
$xtpl->assign('SHOWING_ENTRIES', $showing_entries);

foreach ($list as $row) {
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

if (empty($list)) {
    $xtpl->parse('main.empty');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

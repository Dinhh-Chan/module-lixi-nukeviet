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

global $db, $nv_Request, $user_info, $client_info, $module_data, $module_name, $page_title, $lang_module, $lang_global, $module_info, $my_head;

$my_head .= '<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">';
$my_head .= '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@24,400,0&display=swap" rel="stylesheet">';
$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

if (!defined('NV_IS_USER')) {
    $login_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    nv_redirect_location($login_url);
}

$page_title = $lang_module['create_event'];

$row = [
    'title' => '',
    'description' => '',
    'max_participants' => 10,
    'num_envelopes' => 10,
    'amount_type' => 'fixed',
    'amount_fixed' => 10000,
    'amount_min' => 1000,
    'amount_max' => 50000,
    'start_time' => 0,
    'end_time' => 0,
    'start_datetime' => '',
    'end_datetime' => ''
];

$error = '';
$success = false;

if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['description'] = $nv_Request->get_string('description', 'post', '');
    $row['max_participants'] = max(1, (int) $nv_Request->get_string('max_participants', 'post', '10'));
    $row['num_envelopes'] = max(1, (int) $nv_Request->get_string('num_envelopes', 'post', '10'));
    $row['amount_type'] = $nv_Request->get_string('amount_type', 'post', 'fixed');
    if (!in_array($row['amount_type'], ['fixed', 'random'], true)) {
        $row['amount_type'] = 'fixed';
    }
    $row['amount_fixed'] = max(0, (float) $nv_Request->get_string('amount_fixed', 'post', '0'));
    $row['amount_min'] = max(0, (float) $nv_Request->get_string('amount_min', 'post', '0'));
    $row['amount_max'] = max(0, (float) $nv_Request->get_string('amount_max', 'post', '0'));

    $start_str = $nv_Request->get_string('start_datetime', 'post', '');
    $end_str = $nv_Request->get_string('end_datetime', 'post', '');
    $row['start_time'] = !empty($start_str) ? strtotime($start_str) : 0;
    $row['end_time'] = !empty($end_str) ? strtotime($end_str) : 0;

    $alias = change_alias($row['title']);
    if (empty($row['title'])) {
        $error = 'Vui lòng nhập tiêu đề.';
    } elseif ($db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE alias=' . $db->quote($alias))->fetchColumn()) {
        $error = 'Liên kết tĩnh đã tồn tại.';
    } else {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_events (userid, title, alias, description, max_participants, num_envelopes, amount_type, amount_fixed, amount_min, amount_max, start_time, end_time, status, add_time, edit_time) VALUES (:userid, :title, :alias, :description, :max_participants, :num_envelopes, :amount_type, :amount_fixed, :amount_min, :amount_max, :start_time, :end_time, 1, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ')');
        $stmt->execute([
            ':userid' => $user_info['userid'],
            ':title' => $row['title'],
            ':alias' => $alias,
            ':description' => $row['description'],
            ':max_participants' => $row['max_participants'],
            ':num_envelopes' => $row['num_envelopes'],
            ':amount_type' => $row['amount_type'],
            ':amount_fixed' => $row['amount_fixed'],
            ':amount_min' => $row['amount_min'],
            ':amount_max' => $row['amount_max'],
            ':start_time' => $row['start_time'],
            ':end_time' => $row['end_time']
        ]);
        $success = true;
        $row = ['title' => '', 'description' => '', 'max_participants' => 10, 'num_envelopes' => 10, 'amount_type' => 'fixed', 'amount_fixed' => 10000, 'amount_min' => 1000, 'amount_max' => 50000, 'start_time' => 0, 'end_time' => 0, 'start_datetime' => date('Y-m-d\TH:i', NV_CURRENTTIME), 'end_datetime' => date('Y-m-d\TH:i', NV_CURRENTTIME + 86400 * 7)];
    }
    if ($error) {
        $row['start_datetime'] = $row['start_time'] ? date('Y-m-d\TH:i', $row['start_time']) : date('Y-m-d\TH:i', NV_CURRENTTIME);
        $row['end_datetime'] = $row['end_time'] ? date('Y-m-d\TH:i', $row['end_time']) : date('Y-m-d\TH:i', NV_CURRENTTIME + 86400 * 7);
    }
} else {
    $row['start_datetime'] = date('Y-m-d\TH:i', NV_CURRENTTIME);
    $row['end_datetime'] = date('Y-m-d\TH:i', NV_CURRENTTIME + 86400 * 7);
}

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=create';

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/create.tpl')) {
    $template = 'default';
}

$row['amount_type_fixed'] = ($row['amount_type'] == 'fixed') ? ' checked' : '';
$row['amount_type_random'] = ($row['amount_type'] == 'random') ? ' checked' : '';

$user_avatar = 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle fill="%23ddd" cx="50" cy="50" r="50"/><circle fill="%23999" cx="50" cy="40" r="18"/><path fill="%23999" d="M20 95 q15-25 60-25 t60 25z"/></svg>');
if (defined('NV_IS_USER') && !empty($user_info['photo'])) {
    $user_avatar = NV_BASE_SITEURL . $user_info['photo'];
}
$user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login';
if (defined('NV_IS_USER')) {
    $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=editinfo';
}

$xtpl = new XTemplate('create.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('MENU', nv_theme_lixi_menu('create'));
$xtpl->assign('USER_AVATAR', $user_avatar);
$xtpl->assign('USER_LINK', $user_link);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('DATA', $row);
$xtpl->assign('FORM_ACTION', $base_url);
$xtpl->assign('ERROR', $error);
$xtpl->assign('SUCCESS', $success);

if ($error) {
    $xtpl->parse('main.error');
}
if ($success) {
    $xtpl->parse('main.success');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

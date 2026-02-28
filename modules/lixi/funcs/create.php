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
    'amount_max' => 50000
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

    $alias = change_alias($row['title']);
    if (empty($row['title'])) {
        $error = 'Vui lòng nhập tiêu đề.';
    } elseif ($db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE alias=' . $db->quote($alias))->fetchColumn()) {
        $error = 'Liên kết tĩnh đã tồn tại.';
    } else {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_events (userid, title, alias, description, max_participants, num_envelopes, amount_type, amount_fixed, amount_min, amount_max, status, add_time, edit_time) VALUES (:userid, :title, :alias, :description, :max_participants, :num_envelopes, :amount_type, :amount_fixed, :amount_min, :amount_max, 1, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ')');
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
            ':amount_max' => $row['amount_max']
        ]);
        $success = true;
        $row = ['title' => '', 'description' => '', 'max_participants' => 10, 'num_envelopes' => 10, 'amount_type' => 'fixed', 'amount_fixed' => 10000, 'amount_min' => 1000, 'amount_max' => 50000];
    }
}

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=create';

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/create.tpl')) {
    $template = 'default';
}

$row['amount_type_fixed'] = ($row['amount_type'] == 'fixed') ? ' selected' : '';
$row['amount_type_random'] = ($row['amount_type'] == 'random') ? ' selected' : '';

$xtpl = new XTemplate('create.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('MENU', nv_theme_lixi_menu('create'));
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

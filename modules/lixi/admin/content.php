<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2026 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$id = $nv_Request->get_int('id', 'post,get', 0);
$row = [
    'title' => '',
    'description' => '',
    'max_participants' => 10,
    'num_envelopes' => 10,
    'amount_type' => 'fixed',
    'amount_fixed' => 10000,
    'amount_min' => 1000,
    'amount_max' => 50000,
    'status' => 1
];

if ($id) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE id=' . $id)->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }
    $page_title = $lang_module['edit_event'];
} else {
    $page_title = $lang_module['add_event'];
}

$error = '';
$action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=content' . ($id ? '&id=' . $id : '');

if ($nv_Request->get_int('save', 'post') == 1) {
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
    $row['status'] = $nv_Request->get_int('status', 'post', 1);

    $alias = change_alias($row['title']);
    $sql_check = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE alias=' . $db->quote($alias);
    if ($id) {
        $sql_check .= ' AND id!=' . $id;
    }
    if (empty($row['title'])) {
        $error = 'Vui lòng nhập tiêu đề.';
    } elseif ($db->query($sql_check)->fetchColumn()) {
        $error = 'Liên kết tĩnh đã tồn tại.';
    } else {
        if ($id) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_events SET
                title=:title, alias=:alias, description=:description, max_participants=:max_participants,
                num_envelopes=:num_envelopes, amount_type=:amount_type, amount_fixed=:amount_fixed,
                amount_min=:amount_min, amount_max=:amount_max, status=:status, edit_time=' . NV_CURRENTTIME . '
                WHERE id=' . $id;
        } else {
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_events (
                userid, title, alias, description, max_participants, num_envelopes,
                amount_type, amount_fixed, amount_min, amount_max, status, add_time, edit_time
            ) VALUES (
                0, :title, :alias, :description, :max_participants, :num_envelopes,
                :amount_type, :amount_fixed, :amount_min, :amount_max, :status, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . '
            )';
        }
        $sth = $db->prepare($sql);
        $sth->execute([
            ':title' => $row['title'],
            ':alias' => $alias,
            ':description' => $row['description'],
            ':max_participants' => $row['max_participants'],
            ':num_envelopes' => $row['num_envelopes'],
            ':amount_type' => $row['amount_type'],
            ':amount_fixed' => $row['amount_fixed'],
            ':amount_min' => $row['amount_min'],
            ':amount_max' => $row['amount_max'],
            ':status' => $row['status']
        ]);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }
}

$xtpl = new XTemplate('content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('ACTION', $action);
$row['amount_type_fixed'] = ($row['amount_type'] == 'fixed') ? ' selected' : '';
$row['amount_type_random'] = ($row['amount_type'] == 'random') ? ' selected' : '';
$row['status_active'] = $row['status'] ? ' selected' : '';
$row['status_inactive'] = !$row['status'] ? ' selected' : '';
$xtpl->assign('DATA', $row);
$xtpl->assign('ERROR', $error);

if ($row['amount_type'] == 'fixed') {
    $xtpl->parse('main.fixed');
} else {
    $xtpl->parse('main.random');
}

if ($error) {
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

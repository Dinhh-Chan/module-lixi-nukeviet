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

global $db, $nv_Request, $user_info, $client_info, $module_data, $module_name, $page_title, $lang_module, $module_info, $my_head;

$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

$alias = $nv_Request->get_string('alias', 'get,post', '');
if (empty($alias) and !empty($array_op[1])) {
    $alias = $array_op[1];
}
if (empty($alias)) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$event = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE alias=' . $db->quote($alias) . ' AND status=1')->fetch();
if (empty($event)) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$page_title = $event['title'];

$num_participants = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE event_id=' . $event['id'])->fetchColumn();
$can_join = ($num_participants < $event['num_envelopes']);
$event['title'] = nv_htmlspecialchars($event['title']);
$event['description'] = !empty($event['description']) ? nv_htmlspecialchars($event['description']) : 'Điền thông tin bên dưới để nhận phong bì may mắn của bạn!';

$user_already_joined = false;
if (defined('NV_IS_USER')) {
    $user_already_joined = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE event_id=' . $event['id'] . ' AND userid=' . $user_info['userid'])->fetchColumn();
}

$error = '';
$success = false;
$result_amount = 0;

if ($can_join and !$user_already_joined and $nv_Request->isset_request('submit', 'post')) {
    $fullname = $nv_Request->get_title('fullname', 'post', '');
    $birthyear = $nv_Request->get_title('birthyear', 'post', '');
    $bank_account = $nv_Request->get_title('bank_account', 'post', '');
    $bank_name = $nv_Request->get_title('bank_name', 'post', '');

    if (empty($fullname)) {
        $error = 'Vui lòng nhập họ tên.';
    } else {
        $amount = 0;
        if ($event['amount_type'] == 'fixed') {
            $amount = (float) $event['amount_fixed'];
        } else {
            $min = (float) $event['amount_min'];
            $max = (float) $event['amount_max'];
            $amount = ($min < $max) ? rand((int) $min, (int) $max) : $min;
        }

        $userid = defined('NV_IS_USER') ? $user_info['userid'] : 0;

        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_participants (event_id, userid, fullname, birthyear, bank_account, bank_name, amount_received, join_time) VALUES (:event_id, :userid, :fullname, :birthyear, :bank_account, :bank_name, :amount, ' . NV_CURRENTTIME . ')');
        $stmt->execute([
            ':event_id' => $event['id'],
            ':userid' => $userid,
            ':fullname' => $fullname,
            ':birthyear' => $birthyear,
            ':bank_account' => $bank_account,
            ':bank_name' => $bank_name,
            ':amount' => $amount
        ]);

        $db->exec('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_events SET hitstotal=hitstotal+1 WHERE id=' . $event['id']);
        $success = true;
        $result_amount = $amount;
    }
}

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=join&alias=' . $event['alias'];

$user_avatar = 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle fill="%23ddd" cx="50" cy="50" r="50"/></svg>');
if (defined('NV_IS_USER') && !empty($user_info['photo'])) {
    $user_avatar = NV_BASE_SITEURL . $user_info['photo'];
}
$user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login';
if (defined('NV_IS_USER')) {
    $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=editinfo';
}

$banks = ['Vietcombank', 'Techcombank', 'MB Bank', 'Momo'];

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/join.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('join.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('main'));
$xtpl->assign('USER_AVATAR', $user_avatar);
$xtpl->assign('USER_LINK', $user_link);
$xtpl->assign('EVENT', $event);
$xtpl->assign('BASE_URL', $base_url);
$xtpl->assign('NUM_PARTICIPANTS', $num_participants);
$xtpl->assign('CAN_JOIN', $can_join);
$xtpl->assign('USER_ALREADY_JOINED', $user_already_joined);
$xtpl->assign('SUCCESS', $success);
$xtpl->assign('RESULT_AMOUNT', number_format($result_amount, 0, ',', '.'));
$xtpl->assign('ERROR', $error);
$xtpl->assign('FORM_ACTION', $base_url);

foreach ($banks as $b) {
    $xtpl->assign('BANK_OPTION', ['value' => $b, 'label' => $b]);
    $xtpl->parse('main.form.bank_option');
}

if ($error) {
    $xtpl->parse('main.error');
}
if ($success) {
    $xtpl->parse('main.success');
}
if ($can_join and !$user_already_joined and !$success) {
    $xtpl->parse('main.form');
}
if ($user_already_joined and !$success) {
    $xtpl->parse('main.already_joined');
}
if (!$can_join and !$success) {
    $xtpl->parse('main.full');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

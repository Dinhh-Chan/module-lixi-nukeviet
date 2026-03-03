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

global $db, $user_info, $client_info, $module_data, $module_name, $page_title, $module_info, $my_head, $global_config;

$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

if (!defined('NV_IS_USER')) {
    $login_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    nv_redirect_location($login_url);
}

$page_title = $lang_module['my_events'];

$prefix = NV_PREFIXLANG . '_' . $module_data;
$sql = 'SELECT e.*,
    (SELECT COUNT(*) FROM ' . $prefix . '_participants p WHERE p.event_id=e.id) as num_participants,
    (SELECT COALESCE(SUM(amount_received),0) FROM ' . $prefix . '_participants p WHERE p.event_id=e.id) as total_distributed
    FROM ' . $prefix . '_events e
    WHERE e.userid=' . $user_info['userid'] . '
    ORDER BY e.add_time DESC';
$list = $db->query($sql)->fetchAll();

$total_claimed = 0;
$total_envelopes = 0;
$active_envelopes_count = 0;

$avatar_colors = ['#ef4444', '#f97316', '#64748b', '#ec4899', '#8b5cf6', '#06b6d4'];

foreach ($list as $i => &$row) {
    $row['title'] = nv_htmlspecialchars($row['title']);
    $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=join&alias=' . $row['alias'];
    $row['detail_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&alias=' . $row['alias'];
    $row['add_time_fmt'] = nv_date('d/m/Y', $row['add_time']);
    $row['add_time_short'] = nv_date('d M, Y', $row['add_time']);
    $row['progress'] = $row['num_envelopes'] > 0 ? min(100, round(($row['num_participants'] / $row['num_envelopes']) * 100)) : 0;
    $row['remaining'] = max(0, $row['num_envelopes'] - $row['num_participants']);
    $row['total_distributed_fmt'] = number_format($row['total_distributed'], 0, ',', '.');
    $row['is_active'] = ($row['status'] == 1) && (empty($row['end_time']) || $row['end_time'] > NV_CURRENTTIME);
    $row['status_label'] = $row['is_active'] ? $lang_module['active'] : $lang_module['ended'];
    $row['status_class'] = $row['is_active'] ? 'active' : 'ended';
    $row['row_class'] = $row['is_active'] ? '' : ' lixi-myevents-row-ended';
    $row['avatar_initials'] = mb_strtoupper(mb_substr(preg_replace('/\s+/', '', $row['title']), 0, 3));
    if (empty($row['avatar_initials'])) {
        $row['avatar_initials'] = 'EV';
    }
    $row['avatar_color'] = $avatar_colors[$i % count($avatar_colors)];
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=content&id=' . $row['id'];
    $row['url_export'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=export&id=' . $row['id'];

    $total_claimed += $row['num_participants'];
    $total_envelopes += $row['num_envelopes'];
    if ($row['is_active']) {
        $active_envelopes_count += $row['remaining'];
    }
}
unset($row);

$total_distributed = $db->query('SELECT COALESCE(SUM(p.amount_received),0) FROM ' . $prefix . '_participants p
    INNER JOIN ' . $prefix . '_events e ON p.event_id=e.id WHERE e.userid=' . $user_info['userid'])->fetchColumn();
$claims_ratio = $total_envelopes > 0 ? round(($total_claimed / $total_envelopes) * 100) : 0;

$stats = [
    'total_events' => count($list),
    'total_distributed' => $total_distributed,
    'total_distributed_fmt' => number_format($total_distributed, 0, ',', '.'),
    'claims_ratio' => $claims_ratio,
    'claims_ratio_text' => $total_claimed . '/' . $total_envelopes,
    'active_envelopes' => $active_envelopes_count
];

$user_avatar = 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle fill="%23ddd" cx="50" cy="50" r="50"/></svg>');
if (defined('NV_IS_USER') && !empty($user_info['photo'])) {
    $user_avatar = NV_BASE_SITEURL . $user_info['photo'];
}
$user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login';
if (defined('NV_IS_USER')) {
    $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=editinfo';
}
$user_name = defined('NV_IS_USER') ? $user_info['username'] : '';
$user_email = defined('NV_IS_USER') && !empty($user_info['email']) ? $user_info['email'] : '';

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/my_events.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('my_events.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('my_events'));
$xtpl->assign('STATS', $stats);
$xtpl->assign('USER_AVATAR', $user_avatar);
$xtpl->assign('USER_LINK', $user_link);
$xtpl->assign('USER_NAME', nv_htmlspecialchars($user_name));
$xtpl->assign('USER_EMAIL', nv_htmlspecialchars($user_email));
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);

if (empty($list)) {
    $xtpl->parse('main.empty');
} else {
    foreach ($list as $row) {
        $xtpl->assign('EVENT', $row);
        $xtpl->parse('main.has_events.loop');
    }
    $xtpl->parse('main.has_events');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

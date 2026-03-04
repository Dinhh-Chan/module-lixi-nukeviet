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

global $db, $nv_Request, $module_data, $module_name, $page_title, $lang_module, $module_info, $my_head, $user_info;

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

$event['title'] = nv_htmlspecialchars($event['title']);
$event['description'] = nv_htmlspecialchars($event['description']);
$event_id = (int) $event['id'];

// Danh sách sự kiện để đổi view
$events = $db->query('SELECT id, title, alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE status=1 ORDER BY add_time DESC')->fetchAll();

function lixi_relative_time_detail($timestamp)
{
    if (empty($timestamp)) {
        return '';
    }
    $diff = NV_CURRENTTIME - $timestamp;
    if ($diff < 60) {
        return 'Vừa xong';
    }
    if ($diff < 3600) {
        return floor($diff / 60) . ' phút trước';
    }
    if ($diff < 86400) {
        return floor($diff / 3600) . ' giờ trước';
    }
    if ($diff < 172800) {
        return 'Hôm qua';
    }
    if ($diff < 604800) {
        return floor($diff / 86400) . ' ngày trước';
    }
    return nv_date('d/m/Y', $timestamp);
}

$sql = 'SELECT p.fullname, p.userid,
    SUM(p.amount_received) as total,
    COUNT(DISTINCT p.event_id) as events_joined,
    MAX(p.join_time) as last_join_time
    FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants p
    WHERE p.event_id=' . $event_id . ' AND p.amount_received>0
    GROUP BY p.userid, p.fullname
    HAVING total>0
    ORDER BY total DESC
    LIMIT 50';
$list = $db->query($sql)->fetchAll();

$podium = [];
$table_rows = [];

foreach ($list as $i => $row) {
    $row['rank'] = $i + 1;
    $row['fullname'] = nv_htmlspecialchars($row['fullname']);
    $row['initial'] = mb_strtoupper(mb_substr($row['fullname'], 0, 1));
    if (empty($row['initial'])) {
        $row['initial'] = '?';
    }
    $row['total_fmt'] = number_format($row['total'], 0, ',', '.');
    $row['last_ago'] = lixi_relative_time_detail($row['last_join_time']);
    $row['events_joined_text'] = str_replace('{n}', $row['events_joined'], $lang_module['events_count']);

    if ($row['userid'] > 0 && defined('NV_USERS_GLOBALTABLE')) {
        $u = $db->query('SELECT photo FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $row['userid'])->fetch();
        $row['avatar'] = !empty($u['photo']) ? NV_BASE_SITEURL . $u['photo'] : '';
    } else {
        $row['avatar'] = '';
    }
    $row['avatar_style'] = !empty($row['avatar']) ? 'background-image:url(\'' . str_replace("'", "\\'", $row['avatar']) . '\')' : '';

    if ($i < 3) {
        $podium[] = $row;
    }
    $table_rows[] = $row;
}

$stats = [
    'total_distributed' => $db->query('SELECT COALESCE(SUM(amount_received),0) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE event_id=' . $event_id)->fetchColumn(),
    'total_participants' => $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE event_id=' . $event_id)->fetchColumn(),
    'events_hosted' => $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events')->fetchColumn(),
    'avg_amount' => 0
];
$stats['total_distributed_fmt'] = number_format($stats['total_distributed'], 0, ',', '.');
$stats['total_participants_fmt'] = number_format($stats['total_participants'], 0, ',', '.');
$stats['events_hosted_fmt'] = number_format($stats['events_hosted'], 0, ',', '.');
if ($stats['total_participants'] > 0) {
    $stats['avg_amount'] = round($stats['total_distributed'] / $stats['total_participants']);
}
$stats['avg_amount_fmt'] = number_format($stats['avg_amount'], 0, ',', '.');

$user_balance = 0;
$user_avatar = 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle fill="%23ddd" cx="50" cy="50" r="50"/></svg>');
if (defined('NV_IS_USER') && $user_info['userid'] > 0) {
    $user_balance = $db->query('SELECT COALESCE(SUM(amount_received),0) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE userid=' . $user_info['userid'] . ' AND event_id=' . $event_id)->fetchColumn();
    if (!empty($user_info['photo'])) {
        $user_avatar = NV_BASE_SITEURL . $user_info['photo'];
    }
}
$user_balance_fmt = number_format($user_balance, 0, ',', '.');
$user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login';
if (defined('NV_IS_USER')) {
    $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=editinfo';
}

$total_count = count($list);
$showing_ranking = str_replace(['{n}', '{total}'], [$total_count, $total_count], $lang_module['showing_ranking']);
$ranking_for = str_replace('{EVENT_TITLE}', $event['title'], $lang_module['ranking_for_event']);

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/detail.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('ranking'));
$xtpl->assign('EVENT', $event);
$xtpl->assign('STATS', $stats);
$xtpl->assign('USER_AVATAR', $user_avatar);
$xtpl->assign('USER_LINK', $user_link);
$xtpl->assign('USER_BALANCE', $user_balance_fmt);
$xtpl->assign('SHOWING_RANKING', $showing_ranking);
$xtpl->assign('RANKING_FOR', $ranking_for);

// Dropdown đổi sự kiện
$all_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=ranking';
$xtpl->assign('FILTER_ALL', ['url' => $all_url]);
if (!empty($events)) {
    foreach ($events as $e) {
        $e_title = nv_htmlspecialchars($e['title']);
        $e_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=detail&amp;alias=' . $e['alias'];
        $selected = ((int) $e['id'] === $event_id) ? ' selected' : '';
        $xtpl->assign('FILTER_EVENT', [
            'title' => $e_title,
            'url' => $e_url,
            'selected' => $selected
        ]);
        $xtpl->parse('main.event_switch.loop');
    }
    $xtpl->parse('main.event_switch');
}

foreach ([1 => 'silver', 0 => 'gold', 2 => 'bronze'] as $idx => $medal) {
    if (isset($podium[$idx])) {
        $p = $podium[$idx];
        $xtpl->assign('PODIUM_' . strtoupper($medal), $p);
        $xtpl->parse('main.podium.' . $medal);
    }
}
$xtpl->parse('main.podium');

foreach ($table_rows as $row) {
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.table.loop');
}
if (empty($table_rows) && empty($podium)) {
    $xtpl->parse('main.table.empty');
}
$xtpl->parse('main.table');

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

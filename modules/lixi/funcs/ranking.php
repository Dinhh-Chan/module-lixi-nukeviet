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

global $db, $module_data, $module_name, $page_title, $module_info, $my_head, $user_info, $db_config;

$page_title = $lang_module['ranking'];

$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

$prefix = NV_PREFIXLANG . '_' . $module_data;

$events = $db->query('SELECT id, title, alias FROM ' . $prefix . '_events WHERE status=1 ORDER BY add_time DESC')->fetchAll();
$event_id = $nv_Request->get_int('event_id', 'get', 0);
$current_event_title = $lang_module['ranking_for_all'];
if ($event_id > 0) {
    foreach ($events as $e) {
        if ((int) $e['id'] === $event_id) {
            $current_event_title = $e['title'];
            break;
        }
    }
}

$where = '';
if ($event_id > 0) {
    $where = ' WHERE p.event_id=' . $event_id;
}

$sql = 'SELECT p.fullname, p.userid,
    SUM(p.amount_received) as total,
    COUNT(DISTINCT p.event_id) as events_joined,
    MAX(p.join_time) as last_join_time
    FROM ' . $prefix . '_participants p' . $where . '
    GROUP BY p.userid, p.fullname
    HAVING total>0
    ORDER BY total DESC
    LIMIT 50';
$list = $db->query($sql)->fetchAll();

function lixi_relative_time($timestamp) {
    if (empty($timestamp)) return '';
    $diff = NV_CURRENTTIME - $timestamp;
    if ($diff < 60) return 'Vừa xong';
    if ($diff < 3600) return floor($diff / 60) . ' phút trước';
    if ($diff < 86400) return floor($diff / 3600) . ' giờ trước';
    if ($diff < 172800) return 'Hôm qua';
    if ($diff < 604800) return floor($diff / 86400) . ' ngày trước';
    return nv_date('d/m/Y', $timestamp);
}

$podium = [];
$table_rows = [];

foreach ($list as $i => $row) {
    $row['rank'] = $i + 1;
    $row['fullname'] = nv_htmlspecialchars($row['fullname']);
    $row['initial'] = mb_strtoupper(mb_substr($row['fullname'], 0, 1));
    if (empty($row['initial'])) $row['initial'] = '?';
    $row['total_fmt'] = number_format($row['total'], 0, ',', '.');
    $row['last_ago'] = lixi_relative_time($row['last_join_time']);
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

$stats_where = '';
if ($event_id > 0) {
    $stats_where = ' WHERE event_id=' . $event_id;
}

$stats = [
    'total_distributed' => $db->query('SELECT COALESCE(SUM(amount_received),0) FROM ' . $prefix . '_participants' . $stats_where)->fetchColumn(),
    'total_participants' => $db->query('SELECT COUNT(*) FROM ' . $prefix . '_participants' . $stats_where)->fetchColumn(),
    'events_hosted' => $db->query('SELECT COUNT(*) FROM ' . $prefix . '_events')->fetchColumn(),
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
    $user_balance_sql = 'SELECT COALESCE(SUM(amount_received),0) FROM ' . $prefix . '_participants WHERE userid=' . $user_info['userid'];
    if ($event_id > 0) {
        $user_balance_sql .= ' AND event_id=' . $event_id;
    }
    $user_balance = $db->query($user_balance_sql)->fetchColumn();
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
$ranking_for = ($event_id > 0) ? str_replace('{EVENT_TITLE}', nv_htmlspecialchars($current_event_title), $lang_module['ranking_for_event']) : $lang_module['ranking_for_all'];

$template = $module_info['template'];
if (!file_exists(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme'] . '/ranking.tpl')) {
    $template = 'default';
}

$xtpl = new XTemplate('ranking.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MENU', nv_theme_lixi_menu('ranking'));
$xtpl->assign('STATS', $stats);
$xtpl->assign('USER_AVATAR', $user_avatar);
$xtpl->assign('USER_LINK', $user_link);
$xtpl->assign('USER_BALANCE', $user_balance_fmt);
$xtpl->assign('SHOWING_RANKING', $showing_ranking);
$xtpl->assign('RANKING_FOR', $ranking_for);

$all_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ranking';
$xtpl->assign('FILTER_ALL', ['url' => $all_url]);
if (!empty($events)) {
    foreach ($events as $e) {
        $e['title'] = nv_htmlspecialchars($e['title']);
        $e['url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=ranking&event_id=' . $e['id'];
        $e['selected'] = ((int) $e['id'] === $event_id) ? ' selected' : '';
        $xtpl->assign('FILTER_EVENT', $e);
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

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

function nv_theme_lixi_menu($current_op = 'main')
{
    global $module_name;
    $base = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    return [
        'url_main' => $base,
        'url_create' => $base . '&' . NV_OP_VARIABLE . '=create',
        'url_my_events' => $base . '&' . NV_OP_VARIABLE . '=my_events',
        'url_history' => $base . '&' . NV_OP_VARIABLE . '=history',
        'url_ranking' => $base . '&' . NV_OP_VARIABLE . '=ranking',
        'active_main' => ($current_op == 'main' || $current_op == '') ? ' active' : '',
        'active_create' => $current_op == 'create' ? ' active' : '',
        'active_my_events' => $current_op == 'my_events' ? ' active' : '',
        'active_history' => $current_op == 'history' ? ' active' : '',
        'active_ranking' => $current_op == 'ranking' ? ' active' : ''
    ];
}

function nv_theme_lixi_main($list, $stats = [], $leaderboard = [], $user_avatar = '')
{
    global $module_info, $lang_module, $module_name;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('module_name', $module_name);
    $xtpl->assign('MENU', nv_theme_lixi_menu('main'));
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login';
    if (defined('NV_IS_USER')) {
        $user_link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=editinfo';
    }
    $xtpl->assign('USER_AVATAR', $user_avatar);
    $xtpl->assign('USER_LINK', $user_link);
    $xtpl->assign('STATS', $stats);
    $xtpl->assign('EVENT_COUNT', count($list));

    if (empty($list)) {
        $xtpl->parse('main.empty_events');
    } else {
        foreach ($list as $row) {
            $row['title'] = nv_htmlspecialchars($row['title']);
            $row['detail_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&alias=' . $row['alias'];
            $row['join_url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=join&alias=' . $row['alias'];
            $row['amount_label'] = ($row['amount_type'] == 'fixed') ? number_format($row['amount_fixed'], 0, ',', '.') . ' đ/phong bì' : number_format($row['amount_min'], 0, ',', '.') . '-' . number_format($row['amount_max'], 0, ',', '.') . ' đ';
            $row['progress'] = $row['num_envelopes'] > 0 ? min(100, round(($row['num_participants'] / $row['num_envelopes']) * 100)) : 0;
            $row['remaining'] = max(0, $row['num_envelopes'] - $row['num_participants']);
            if (!empty($row['end_time']) && $row['end_time'] > NV_CURRENTTIME) {
                $row['countdown_seconds'] = (int)($row['end_time'] - NV_CURRENTTIME);
                $row['countdown_formatted'] = gmdate('H:i:s', $row['countdown_seconds']);
            } else {
                $row['countdown_seconds'] = 0;
                $row['countdown_formatted'] = '';
            }
            $xtpl->assign('EVENT', $row);
            if ($row['countdown_seconds'] > 0) {
                $xtpl->parse('main.loop.countdown');
            }
            $xtpl->parse('main.loop');
        }
    }

    if (empty($leaderboard)) {
        $xtpl->parse('main.leaderboard.empty_leaderboard');
    } else {
        foreach ($leaderboard as $i => $row) {
            $row['stt'] = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
            $row['leader_class'] = ($i == 0) ? ' first' : '';
            $row['initial'] = nv_htmlspecialchars(mb_substr($row['fullname'], 0, 1));
            $row['fullname'] = nv_htmlspecialchars($row['fullname']);
            $xtpl->assign('LEADER', $row);
            $xtpl->parse('main.leaderboard.loop');
        }
    }
    $xtpl->parse('main.leaderboard');

    $xtpl->parse('main');
    return $xtpl->text('main');
}

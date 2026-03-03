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

global $db, $module_data, $page_title, $module_info, $module_name, $my_head, $user_info, $global_config;

$page_title = $lang_module['lixi_title'];

$lixi_css = NV_STATIC_URL . 'themes/' . $module_info['template'] . '/css/lixi.css';
if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/lixi.css')) {
    $my_head .= '<link rel="stylesheet" href="' . $lixi_css . '">';
}

$prefix = NV_PREFIXLANG . '_' . $module_data;

$sql = 'SELECT e.*, (SELECT COUNT(*) FROM ' . $prefix . '_participants p WHERE p.event_id=e.id) as num_participants FROM ' . $prefix . '_events e WHERE e.status=1 ORDER BY e.add_time DESC LIMIT 8';
$list = $db->query($sql)->fetchAll();

$stats = [
    'total_distributed' => $db->query('SELECT COALESCE(SUM(amount_received),0) FROM ' . $prefix . '_participants')->fetchColumn(),
    'total_participants' => $db->query('SELECT COUNT(*) FROM ' . $prefix . '_participants')->fetchColumn(),
    'total_envelopes' => $db->query('SELECT COUNT(*) FROM ' . $prefix . '_participants')->fetchColumn(),
    'luckiest_streak' => 0
];
$stats['total_distributed_fmt'] = number_format($stats['total_distributed'], 0, ',', '.');
$stats['total_participants_fmt'] = number_format($stats['total_participants'], 0, ',', '.');
$stats['total_envelopes_fmt'] = number_format($stats['total_envelopes'], 0, ',', '.');

$leaderboard = $db->query('SELECT p.fullname, SUM(p.amount_received) as total FROM ' . $prefix . '_participants p GROUP BY p.fullname HAVING total>0 ORDER BY total DESC LIMIT 5')->fetchAll();
foreach ($leaderboard as &$row) {
    $row['total_fmt'] = number_format($row['total'], 0, ',', '.');
}
unset($row);

$user_avatar = 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle fill="%23ddd" cx="50" cy="50" r="50"/><circle fill="%23999" cx="50" cy="40" r="18"/><path fill="%23999" d="M20 95 q15-25 60-25 t60 25z"/></svg>');
if (defined('NV_IS_USER') && !empty($user_info['photo'])) {
    $user_avatar = NV_BASE_SITEURL . $user_info['photo'];
}

$contents = nv_theme_lixi_main($list, $stats, $leaderboard, $user_avatar);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

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

$id = $nv_Request->get_int('id', 'get', 0);
if (!$id) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$event = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE id=' . $id)->fetch();
if (empty($event)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE event_id=' . $id . ' ORDER BY join_time ASC')->fetchAll();

$filename = 'lixi_' . $event['alias'] . '_' . nv_date('YmdHis', NV_CURRENTTIME) . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$out = fopen('php://output', 'w');
fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

fputcsv($out, ['STT', 'Họ tên', 'Năm sinh', 'Số TK', 'Ngân hàng', 'Số tiền', 'Thời gian'], ';');

foreach ($rows as $i => $row) {
    fputcsv($out, [
        $i + 1,
        $row['fullname'],
        $row['birthyear'],
        $row['bank_account'],
        $row['bank_name'],
        $row['amount_received'],
        nv_date('H:i d/m/Y', $row['join_time'])
    ], ';');
}

fclose($out);
exit;

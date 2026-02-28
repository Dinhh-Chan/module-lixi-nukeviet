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

$id = $nv_Request->get_int('id', 'post', 0);
$checkss = $nv_Request->get_string('checkss', 'post', '');

$content = 'NO_' . $id;

if ($id > 0 and md5($id . NV_CHECK_SESSION) === $checkss) {
    $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_participants WHERE event_id=' . $id);
    $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_invites WHERE event_id=' . $id);
    if ($db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_events WHERE id=' . $id)) {
        $nv_Cache->delMod($module_name);
        $content = 'OK_' . $id;
    }
}

exit($content);

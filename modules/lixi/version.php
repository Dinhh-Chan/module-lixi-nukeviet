<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2026 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$module_version = [
    'name' => 'Lì xì',
    'modfuncs' => 'main,create,join,detail,my_events,history,ranking',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '4.5.07',
    'date' => 'Tuesday, February 25, 2026 12:00:00 AM GMT+07:00',
    'author' => 'Custom module - Lì xì năm mới',
    'note' => 'Module lì xì trực tuyến - tạo sự kiện, mời người tham gia, bốc lì xì, xuất Excel',
    'uploads_dir' => [
        $module_upload
    ]
];

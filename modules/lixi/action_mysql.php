<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2026 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_invites;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_participants;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_events;';

$sql_create_module = $sql_drop_module;

// Bảng sự kiện lì xì
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_events (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 userid mediumint(8) unsigned NOT NULL DEFAULT '0',
 title varchar(250) NOT NULL,
 alias varchar(250) NOT NULL,
 description text,
 max_participants int(11) NOT NULL DEFAULT '10',
 num_envelopes int(11) NOT NULL DEFAULT '10',
 amount_type enum('fixed','random') NOT NULL DEFAULT 'fixed',
 amount_fixed decimal(15,0) NOT NULL DEFAULT '0',
 amount_min decimal(15,0) NOT NULL DEFAULT '0',
 amount_max decimal(15,0) NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '1',
 add_time int(11) NOT NULL DEFAULT '0',
 edit_time int(11) NOT NULL DEFAULT '0',
 start_time int(11) NOT NULL DEFAULT '0',
 end_time int(11) NOT NULL DEFAULT '0',
 hitstotal mediumint(8) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY userid (userid),
 KEY status (status)
) ENGINE=MyISAM";

// Bảng người tham gia / kết quả bốc lì xì
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_participants (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 event_id mediumint(8) unsigned NOT NULL,
 userid mediumint(8) unsigned NOT NULL DEFAULT '0',
 fullname varchar(100) NOT NULL DEFAULT '',
 birthyear varchar(10) NOT NULL DEFAULT '',
 bank_account varchar(50) NOT NULL DEFAULT '',
 bank_name varchar(100) NOT NULL DEFAULT '',
 amount_received decimal(15,0) NOT NULL DEFAULT '0',
 join_time int(11) NOT NULL DEFAULT '0',
 note text,
 PRIMARY KEY (id),
 KEY event_id (event_id),
 KEY userid (userid)
) ENGINE=MyISAM";

// Bảng lời mời tham gia
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_invites (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 event_id mediumint(8) unsigned NOT NULL,
 invited_userid mediumint(8) unsigned NOT NULL,
 inviter_userid mediumint(8) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 add_time int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 KEY event_id (event_id),
 KEY invited_userid (invited_userid)
) ENGINE=MyISAM";

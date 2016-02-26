<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Vàng Văn Quyn (quynlc@gmail.com)
 * @Copyright (C) 2016 Vàng Văn Quyn. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 25 Feb 2016 14:05:13 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_lophoc`";

$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $module_data . "_hocsinh`";


$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_lophoc` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Lớp',
  `Tenlop` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tên lớp',
  `Alias` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lọc alias',
  `Gvcn` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Giáo viên chủ nhiệm',
  `Weight` smallint(6) NOT NULL COMMENT 'Vị trí',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $module_data . "_hocsinh` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID học sinh',
  `idlop` int(11) NOT NULL COMMENT 'ID lớp',
  `Hoten` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Họ và tên',
  `Alias` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lọc Alias',
  `Gioitinh` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Giới tính',
  `Weight` smallint(6) NOT NULL COMMENT 'Vị trí',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM;";
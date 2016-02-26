<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Vàng Văn Quyn (quynlc@gmail.com)
 * @Copyright (C) 2016 Vàng Văn Quyn. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 25 Feb 2016 14:05:13 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['lophoc'] = $lang_module['lophoc'];
$submenu['hocsinh'] = $lang_module['hocsinh'];
$submenu['main'] = $lang_module['main'];

$allow_func = array( 'lophoc', 'hocsinh', 'main');

define( 'NV_IS_FILE_ADMIN', true );

?>
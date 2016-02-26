<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Vàng Văn Quyn (quynlc@gmail.com)
 * @Copyright (C) 2016 Vàng Văn Quyn. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 25 Feb 2016 14:05:13 GMT
 */

if ( ! defined( 'NV_IS_MOD_QLHS' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$array_data = array();



$contents = nv_theme_qlhs_hocsinh( $array_data );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';

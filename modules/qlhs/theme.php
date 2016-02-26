<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Vàng Văn Quyn (quynlc@gmail.com)
 * @Copyright (C) 2016 Vàng Văn Quyn. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 25 Feb 2016 14:05:13 GMT
 */

if ( ! defined( 'NV_IS_MOD_QLHS' ) ) die( 'Stop!!!' );

/**
 * nv_theme_qlhs_lophoc()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_qlhs_lophoc ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_qlhs_hocsinh()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_qlhs_hocsinh ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_qlhs_search()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_qlhs_search ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_qlhs_main()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_qlhs_main ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}
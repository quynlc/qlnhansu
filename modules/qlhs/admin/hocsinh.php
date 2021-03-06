<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 25 Feb 2016 14:23:37 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'get_alias_title', 'post' ) )
{
	$alias = $nv_Request->get_title( 'get_alias_title', 'post', '' );
	$alias = change_alias( $alias );
	die( $alias );
}

if( $nv_Request->isset_request( 'ajax_action', 'post' ) )
{
	$Id = $nv_Request->get_int( 'Id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$content = 'NO_' . $Id;
	if( $new_vid > 0 )
	{
		$sql = 'SELECT Id FROM ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh WHERE Id!=' . $Id . ' ORDER BY Weight ASC';
		$result = $db->query( $sql );
		$Weight = 0;
		while( $row = $result->fetch() )
		{
			++$Weight;
			if( $Weight == $new_vid ) ++$Weight;
			$sql = 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh SET Weight=' . $Weight . ' WHERE Id=' . $row['Id'];
			$db->query( $sql );
		}
		$sql = 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh SET Weight=' . $new_vid . ' WHERE Id=' . $Id;
		$db->query( $sql );
		$content = 'OK_' . $Id;
	}
	nv_del_moduleCache( $module_name );
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}
if ( $nv_Request->isset_request( 'delete_Id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$Id = $nv_Request->get_int( 'delete_Id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $Id > 0 and $delete_checkss == md5( $Id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$Weight=0;
		$sql = 'SELECT Weight FROM ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh WHERE Id =' . $db->quote( $Id );
		$result = $db->query( $sql );
		list( $Weight) = $result->fetch( 3 );
		
		$db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh  WHERE Id = ' . $db->quote( $Id ) );
		if( $Weight > 0)
		{
			$sql = 'SELECT Id, Weight FROM ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh WHERE Weight >' . $Weight;
			$result = $db->query( $sql );
			while(list( $Id, $Weight) = $result->fetch( 3 ))
			{
				$Weight--;
				$db->query( 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh SET Weight=' . $Weight . ' WHERE Id=' . intval( $Id ));
			}
		}
		nv_del_moduleCache( nvtools );
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}

$row = array();
$error = array();
$row['Id'] = $nv_Request->get_int( 'Id', 'post,get', 0 );
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['idlop'] = $nv_Request->get_int( 'idlop', 'post', 0 );
	$row['Hoten'] = $nv_Request->get_title( 'Hoten', 'post', '' );
	$row['Alias'] = $nv_Request->get_title( 'Alias', 'post', '' );
	$row['Alias'] = ( empty($row['Alias'] ))? change_alias( $row['title'] ) : change_alias( $row['Alias'] );
	$row['Gioitinh'] = $nv_Request->get_title( 'Gioitinh', 'post', '' );

	if( empty( $row['idlop'] ) )
	{
		$error[] = $lang_module['error_required_idlop'];
	}
	elseif( empty( $row['Hoten'] ) )
	{
		$error[] = $lang_module['error_required_Hoten'];
	}
	elseif( empty( $row['Gioitinh'] ) )
	{
		$error[] = $lang_module['error_required_Gioitinh'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['Id'] ) )
			{
				$stmt = $db->prepare( 'INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh (idlop, Hoten, Alias, Gioitinh, Weight) VALUES (:idlop, :Hoten, :Alias, :Gioitinh, :Weight)' );

				$weight = $db->query( 'SELECT max(Weight) FROM ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh' )->fetchColumn();
				$weight = intval( $weight ) + 1;
				$stmt->bindParam( ':Weight', $weight, PDO::PARAM_INT );


			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh SET idlop = :idlop, Hoten = :Hoten, Alias = :Alias, Gioitinh = :Gioitinh WHERE Id=' . $row['Id'] );
			}
			$stmt->bindParam( ':idlop', $row['idlop'], PDO::PARAM_INT );
			$stmt->bindParam( ':Hoten', $row['Hoten'], PDO::PARAM_STR );
			$stmt->bindParam( ':Alias', $row['Alias'], PDO::PARAM_STR );
			$stmt->bindParam( ':Gioitinh', $row['Gioitinh'], PDO::PARAM_STR );

			$exc = $stmt->execute();
			if( $exc )
			{
				nv_del_moduleCache( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
				die();
			}
		}
		catch( PDOException $e )
		{
			trigger_error( $e->getMessage() );
			die( $e->getMessage() ); //Remove this line after checks finished
		}
	}
}
elseif( $row['Id'] > 0 )
{
	$row = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_hocsinh WHERE Id=' . $row['Id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['Id'] = 0;
	$row['idlop'] = 0;
	$row['Hoten'] = '';
	$row['Alias'] = '';
	$row['Gioitinh'] = '';
}

$q = $nv_Request->get_title( 'q', 'post,get' );

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$show_view = true;
	$per_page = 5;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . $db_config['prefix'] . '_' . $module_data . '_hocsinh' );

	if( ! empty( $q ) )
	{
		$db->where( 'idlop LIKE :q_idlop OR Hoten LIKE :q_Hoten OR Gioitinh LIKE :q_Gioitinh' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_idlop', '%' . $q . '%' );
		$sth->bindValue( ':q_Hoten', '%' . $q . '%' );
		$sth->bindValue( ':q_Gioitinh', '%' . $q . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'Weight ASC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_idlop', '%' . $q . '%' );
		$sth->bindValue( ':q_Hoten', '%' . $q . '%' );
		$sth->bindValue( ':q_Gioitinh', '%' . $q . '%' );
	}
	$sth->execute();
}


$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'ROW', $row );
$xtpl->assign( 'Q', $q );

if( $show_view )
{
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	if( ! empty( $q ) )
	{
		$base_url .= '&q=' . $q;
	}
	$xtpl->assign( 'NV_GENERATE_PAGE', nv_generate_page( $base_url, $num_items, $per_page, $page) );

	while( $view = $sth->fetch() )
	{
		for( $i = 1; $i <= $num_items; ++$i )
		{
			$xtpl->assign( 'WEIGHT', array(
				'key' => $i,
				'title' => $i,
				'selected' => ( $i == $view['Weight'] ) ? ' selected="selected"' : '') );
			$xtpl->parse( 'main.view.loop.Weight_loop' );
		}
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;Id=' . $view['Id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_Id=' . $view['Id'] . '&amp;delete_checkss=' . md5( $view['Id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}


if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$array_select_idlop = array();

$array_select_idlop[0] = $lang_global['no'];
$array_select_idlop[1] = $lang_global['yes'];
foreach( $array_select_idlop as $key => $title )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $key,
		'title' => $title,
		'selected' => ($key == $row['idlop']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_idlop' );
}
if( empty( $row['Id'] ) )
{
	$xtpl->parse( 'main.auto_get_alias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['hocsinh'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
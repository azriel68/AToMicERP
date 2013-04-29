<?php

require('../inc.php');

$className = $_GET['className'];
$listName = $_GET['listName'];

$db=new TPDOdb;
//$db->debug = true;
$object = new $className;

$aColumns = $conf->list->{$className}->{$listName}['columns'];
$sTable = $object->get_table();
$sIndexColumn = 'id';

/* 
 * Paging
 */
$sLimit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
{
	$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
		mysql_real_escape_string( $_GET['iDisplayLength'] );
}


/*
 * Ordering
 */
if ( isset( $_GET['iSortCol_0'] ) )
{
	$sOrder = "ORDER BY  ";
	for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
	{
		if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
		{
			$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
			 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
		}
	}
	
	$sOrder = substr_replace( $sOrder, "", -2 );
	if ( $sOrder == "ORDER BY" )
	{
		$sOrder = "";
	}
}


/* 
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere = '';
if ( $_GET['sSearch'] != "" )
{
	$sWhere .= " AND (";
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
	}
	$sWhere = substr_replace( $sWhere, "", -3 );
	$sWhere .= ')';
}

/* Individual column filtering */
for ( $i=0 ; $i<count($aColumns) ; $i++ )
{
	if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
	{
		$sWhere .= " AND ";
		$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
	}
}

/*
 * SQL queries
 * Get data to display
 */
$params = array(
	'@user->id_entity@'=>!empty($_GET['id_entity']) ? $_GET['id_entity'] : 0
);
$sSQL = strtr($conf->list->{$className}->{$listName}['sql'], $params);
$sQuery = "
	$sSQL
	$sWhere
	$sOrder
	$sLimit
";

$db->Execute($sQuery);

/* Data set length after filtering */
$sQuery2 = "
	SELECT FOUND_ROWS() as nb_found
";
$rResultFilterTotal = $db->Execute($sQuery2);
$db->Get_line();
$iFilteredTotal = $db->Get_field('nb_found');

/* Total data set length */
$sQuery3 = "
	SELECT COUNT(".$sIndexColumn.") as nb_total
	FROM $sTable
";
$rResultTotal = $db->Execute($sQuery3);
$db->Get_line();
$iTotal = $db->Get_field('nb_total');


/*
 * Output
 */
$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $iTotal,
	"iTotalDisplayRecords" => $iFilteredTotal,
	"aaData" => array()
);

$db->Execute($sQuery);
while ( $db->Get_line() )
{
	$row = array();
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		/* General output */
		$row[] = $db->Get_field( $aColumns[$i] );
	}
	$output['aaData'][] = $row;
}

echo json_encode( $output );
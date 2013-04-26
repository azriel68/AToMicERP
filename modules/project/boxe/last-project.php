<?
	require('../../../inc.php');
	
	$db=new Tdb;
	
	$l = new TListviewTBS('list_lastProject');
		
	$sql = strtr($conf->list->TProject->index['sql'],array(
		'@user->id_entity@'=>$_REQUEST['id_entity']
	));
	
	$param = array_merge($conf->list->TProject->index['param'] , array(
		'limit'=>array('nbLine'=>10)
		,'orderBy'=>array('dt_cre'=>'DESC')
		,'hide'=>array('dr_maj','id','status')
		
	));
		
	?>
	<h2><?=__tr('lastProjects') ?></h2>
	<?	
	print $l->render($db, $sql, $param);
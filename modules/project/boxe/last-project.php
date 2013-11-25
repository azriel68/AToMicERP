<?
	require('../../../inc.php');
	
	$db=new TPDOdb;
	
	$l = new TListviewTBS('list_lastProject');
		
	$sql = strtr($conf->list->TProject->index['sql'],array(
		'@getEntity@'=>$user->getEntity()
	));
	
	$param = array_merge($conf->list->TProject->index['param'] , array(
		'limit'=>array('nbLine'=>10)
		,'orderBy'=>array('dt_cre'=>'DESC')
		,'hide'=>array('dt_maj','id','status')
		
	));
		
	?>
	<h2><?=__tr('lastProjects') ?></h2>
	<?	
	print $l->render($db, $sql, $param);
	
	
	?>
	
	<div class="buttons">
	<a href="./modules/project/project.php?action=new" class="butAction">__tr(newTProject)__</a>
	</div>
	
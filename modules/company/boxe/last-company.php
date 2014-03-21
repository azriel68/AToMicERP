<?
	require('../../../inc.php');
	
	$get = __get('get','');
	if($get=='parameters') {
		print __out(array(
			'rows'=>2
			,'columns'=>2
		));
		exit;
	}
	
	
	$db=new TPDOdb;
	
	$l = new TListviewTBS('list_lastCompany');
		
	$sql = strtr($conf->list->TCompany->companyList['sql'],array(
		'@getEntity@'=>$user->getEntity()
	));
	
	$param = array_merge($conf->list->TCompany->companyList['param'] , array(
		'limit'=>array('nbLine'=>10)
		,'orderBy'=>array('dt_cre'=>'DESC')
		,'hide'=>array('web','id','phone')
		,'search'=>array()
	));
		
	?>
	<h2><?php echo __tr('lastCompanies') ?></h2>
	<?	
	print $l->render($db, $sql, $param);
	
	?>
	<div class="buttons">
	<a href="./modules/company/company.php?action=new" class="butAction">__tr(newTCompany)__</a>
	</div>
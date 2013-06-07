<?
	require('../../../inc.php');
	
	$db=new Tdb;
	
	$l = new TListviewTBS('list_lastBill');
		
	$sql = strtr($conf->list->TBill->billList['sql'],array(
		'@getEntity@'=>$user->getEntity()
	));
	
	$param = array_merge($conf->list->TBill->billList['param'] , array(
		'limit'=>array('nbLine'=>10)
		,'orderBy'=>array('dt_cre'=>'DESC')
		,'hide'=>array('id')
	));
		
	?>
	<h2><?=__tr('lastBills') ?></h2>
	<?	
	print $l->render($db, $sql, $param);
	
	?>
	<div class="buttons">
	<a href="./modules/bill/bill.php?action=new" class="butAction">__tr(newTBill)__</a>
	</div>
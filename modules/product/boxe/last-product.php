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
	
	$l = new TListviewTBS('list_lastProduct');
		
	$sql = strtr($conf->list->TProduct->productList['sql'],array(
		'@getEntity@'=>$user->getEntity()
	));
	
	$param = array_merge($conf->list->TProduct->productList['param'] , array(
		'limit'=>array('nbLine'=>10)
		,'orderBy'=>array('dt_cre'=>'DESC')
		,'hide'=>array('dt_maj','id','description','price_ht')
		
	));
		
	?>
	<h2><?=__tr('lastProducts') ?></h2>
	<?	
	print $l->render($db, $sql, $param);
	
	
	?>
	
	<div class="buttons">
	<a href="./modules/product/product.php?action=new" class="butAction">__tr(newTProduct)__</a>
	</div>
	
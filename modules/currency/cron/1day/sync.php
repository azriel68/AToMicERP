<?

	require('../../../../inc.php');
	
	$id_entity = $_REQUEST['id_entity'] or die('id_entity ?');
	
	$local_conf = &$user->conf[$id_entity];
	
	$url_list = $local_conf['TCurrenty_list_source'];
	$url_rate =  strtr($local_conf['TCurrenty_rate_source'],array('{app_id}'=>$local_conf['TCurrenty_app_id']));
	
	$TCurrency = json_decode( file_get_contents($url_list) );
		
	$db=new TPDOdb;	
		
	foreach($TCurrency as $currency=>$label) {
		
		$c=new TCurrency;
	
		$c->loadByCode($db, $currency);
		
		$c->name = $label;
		$c->code = $currency;
		
		$c->save($db);
		
	}

	$TRate = json_decode( file_get_contents($url_rate) );
	list($from, $to) = explode('-', $local_conf['TCurrenty_from_to_rate']);
	
	$fromRate = 0;
	$toRate = 0;
	$coefRate = 0;
	//print_r($TRate);
	foreach($TRate->rates as $currency=>$rate) {
		if($currency==$from) $fromRate = $rate;
		if($currency==$to) $toRate = $rate;
	}

	$coefRate = $fromRate / $toRate; // transform USD cof to EUR coef

	print "$from = $fromRate, $to = $toRate :: coef = $coefRate";
	foreach($TRate->rates as $currency=>$rate) {

		$rate = $rate * $coefRate;
		
		$c=new TCurrency;
	
		if($c->loadByCode($db, $currency)) {
			$c->addRate($rate);
			
			$c->save($db);
		}
		
		
		
		

	}	
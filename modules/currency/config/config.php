<?php

/******************************************************************************************
 * Définition du module
 ******************************************************************************************/
$conf->modules['currency']=array(
	'name'=>'Currency'
	,'id'=>'currency'
	,'class'=>array('TCurrency','TCurrencyRate')
	
);

$conf->defaultConf['currency'] = array(
	'TCurrenty_app_id' => '8b986d8b3d514db8a519fb6914687512'
	,'TCurrenty_list_source' => 'http://openexchangerates.org/api/currencies.json'
	,'TCurrenty_rate_source' => 'http://openexchangerates.org/api/latest.json?app_id={app_id}'
	,'TCurrenty_activate'=>'EUR,USD,CHF'
	,'TCurrenty_from_to_rate'=>'USD-EUR'
);


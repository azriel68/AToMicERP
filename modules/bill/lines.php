<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$id_bill = __get('id_bill',0,'integer');
$id_line = __get('id_line',0,'integer');
$action = __get('action','view', 'string' , 30);

$db=new TPDOdb;

if($id_bill) {
	$form=new TFormCore;
	
	$bill=new TBill;
	$bill->load($db, $id_bill);	
	
	$TLine = array();
	
	foreach($bill->TBillLine as $k=>&$line) {
		
		 $viewLineMode = ($action=='edit-line' && $id_line == $line->id) ? 'edit' : 'view' ;
		 $form->Set_typeaff( $viewLineMode );
				
			$row = array_merge( $line->get_values(), array(
				'id_product'=>$form->combo('', 'TLine['+$k+'][id_product]', array_merge( array(0=>'') , TProduct::getProductForCombo($db))  , $line->id_product)
				,'title'=>$form->texte('', 'TLine['+$k+'][title]', $line->title, 80)		
				,'quantity'=>$form->texte('', 'TLine['+$k+'][quantity]', $line->quantity, 5)
				,'viewMode'=>$viewLineMode
				
			));
			
			
			$TLine[] = $row;
			
	}
	
	$form->Set_typeaff('edit');
	if($action=='edit-line') {
		$TLineAdd =array();
		
	}	
	else {
		$TLineAdd =array(
					'id_product'=>$form->combo('', 'TLineAdd[id_product]', array_merge( array(0=>'') , TProduct::getProductForCombo($db))  , $line->id_product)
					,'title'=>$form->texte('', 'TLineAdd[title]', '', 80)		
					,'quantity'=>$form->texte('', 'TLineAdd[quantity]', 1, 5)
		);	
		
	}
		
	

	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render($conf->template->TBill->lines
		,array(
			'button'=>array(
				/*'add'=>array(
					'href'=>$_SERVER['PHP_SELF'].'?action=add'
					,'class'=>'butAction'
					,'label'=>__tr('addLine')
				)*/
			)
			,'line'=>$TLine
		)
		,array(
			'bill'=>$bill->get_values()
			,'line_add'=>$TLineAdd
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Bill').' '.$bill->ref)
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $bill, 'details')
				,'self'=>$_SERVER['PHP_SELF']
			
			)
		)
	)); 
	
}
else {
	print 'id_bill require';
}

$db->close();

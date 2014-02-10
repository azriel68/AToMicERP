<?

require('../../inc.php');

if(!$user->isLogged()) {
	TTemplate::login($user);
}

$db=new TPDOdb;
//$db->debug=true;
$printer=new TPrinter;

$className = __get('object');

$object = new $className;

$action = TTemplate::actions($db, $user, $printer);

if($action!==false ) {

	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'model'=>TPrinter::getModel($db, $className)
	);
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $printer)
		,array(
			'button'=>TTemplate::buttons($user, $object, $action)
			,'listOfDoc'=>TDocument::getListOfDoc($conf, $className, __get('id'))
		)
		,array(
			'printer'=>$TForm
			,'tpl'=>array(
				'header'=>TTemplate::header($conf, __tr('Print'))
				,'footer'=>TTemplate::footer($conf)
				,'menu'=>TTemplate::menu($conf, $user)
				,'tabs'=>TTemplate::tabs($conf, $user, $object, 'printer')
				,'self'=>$_SERVER['PHP_SELF']
				,'mode'=>$action
			)
		)
	)); 
	
}

$db->close();

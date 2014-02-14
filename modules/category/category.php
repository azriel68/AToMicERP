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
$object->load($db, __get('id',0,'integer'));


$action=__get('action', false);




	if($action=='delete') {
		header('location:'.$_SERVER['PHP_SELF'].'?delete=ok');
	}

	$form=new TFormCore;
	$form->Set_typeaff($action);
	
	$TForm=array(
		'model'=>TPrinter::getModel($db, $className)
		,'addButton'=>$form->btsubmit(__tr('addModel'), 'addModel')
		,'printButton'=>$form->btsubmit(__tr('generate'), 'printButton')
		,'id_object'=>$object->getId()
		,'className'=>$className
		,'loadModel'=>$form->fichier('', 'newModel', '', '50')
	);
	
	$tbs=new TTemplateTBS;
	
	print __tr_view($tbs->render(TTemplate::getTemplate($conf, $printer)
		,array(
			'listOfDoc'=>TDocument::getListOfDoc($conf, $className, __get('id'))
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
	


$db->close();

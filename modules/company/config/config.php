<?php


	$conf->menu->top[] = array(
		'name'=>"Company"
		,'id'=>'TCompany'
		,'position'=>1
		,'url'=>HTTP.'modules/company/company.php'
	);
	
	$conf->tabs->TCompany=array(
		'fiche'=>array('label'=>'__tr(Card)__','url'=>'company.php?action=view&id=@id@')
		,'contact'=>array('label'=>'__tr(Contact)__','url'=>'contact.php?id_project=@id@')
	);
	
	$conf->modules['company']=array(
		'name'=>'Company'
		,'id'=>'TCompany'
		,'class'=>array('TCompany')
	);

	@$conf->template->TCompany->fiche = './template/company.html';
	
	@$conf->list->TCompany->companyList=array(
		'sql'=>"SELECT id, name, phone, email, web FROM ".DB_PREFIX."company WHERE id_entity=@user->id_entity@"
		,'param'=>array(
			'title'=>array(
				'name'=>'__tr(Name)__'
				,'phone'=>'__tr(Phone)__'
				,'email'=>'__tr(Email)__'
				,'web'=>'__tr(Web)__'
			)
			,'hide'=>array('id')
			,'link'=>array(
				'name'=>'<a href="?action=view&id=@id@">@name@</a>'
			)
		)
	);
	
	// Test datatable
	@$conf->list->TCompany->companyListDT=array(
		'sql'=>"SELECT SQL_CALC_FOUND_ROWS id, name, phone, email, web FROM ".DB_PREFIX."company WHERE id_entity=@user->id_entity@"
		,'columns'=>array('id', 'name', 'phone', 'email', 'web')
		,'header'=>array(
			array('name'=>'id', 'title' => 'ID')
			,array('name'=>'name', 'title' => '__tr(Name)__')
			,array('name'=>'phone', 'title' => '__tr(Phone)__')
			,array('name'=>'email', 'title' => '__tr(Email)__')
			,array('name'=>'web', 'title' => '__tr(Web)__')
		)
		,'where'=>'WHERE id_entity=@user->id_entity@'
		,'param'=>array(
			'title'=>array(
				'name'=>'__tr(Name)__'
				,'phone'=>'__tr(Phone)__'
				,'email'=>'__tr(Email)__'
				,'web'=>'__tr(Web)__'
			)
			,'hide'=>array('id')
			,'link'=>array(
				'name'=>'<a href="?action=view&id=@id@">@name@</a>'
			)
		)
	);

<?
class TTemplate {
	
	function show($tpl, $TBlock=array(), $TField=array(), $TParam=array()) {
	
		$TField = array_merge($TField,array(
			'tpl'=>array(
					'header'=>TTemplate::header($TParam)
					,'footer'=>TTemplate::footer($TParam)
					,'buttons'=>TTemplate::getButtons()
				)
		));
		
		print TTemplate::render($tpl, $TBlock, $TField, $TParam);
	}
	function render($tpl, $TBlock=array(), $TField=array(), $TParam=array()) {
			
		$TBS = new clsTinyButStrong;
		$TBS->noerr = true;
		
		$TBS->LoadTemplate($tpl);
	
		if(!empty($TBlock)) {
			foreach($TBlock as $nameBlock=>$block) {
				
				$TBS->MergeBlock($nameBlock, $block);
				
			}
			
		}

		if(!empty($TField)) {
			foreach($TField as $nameBlock=>$block) {
				
				$TBS->MergeField($nameBlock, $block);
				
			}
		}

		$TBS->Show( isset($TParam['TBS_OUTPUT']) ? $TParam['TBS_OUTPUT'] : TBS_NOTHING );
		
		return $TBS->Source;
		
	}
	function header(&$TParam ) {
		$canonical = isset($TParam['canonical']) ? $TParam['canonical'] : '';
		$titre = isset($TParam['title']) ? $TParam['title'] : "L'actualité de la construction et du BTP - Batiactu";
		$description= isset($TParam['description']) ? $TParam['description'] : "Batiactu est le support numéro un des professionnels du BTP, de la construction et de l'immobilier pour s'informer, recruter, détecter et gagner de nouveaux marchés.";
		$robots = isset($TParam['robots']) ? $TParam['robots'] : "index, follow";
		
		return TTemplate::render(TEMPLATE_DIR.'header.html'
			, array()
			, array(
				'tpl'=>array('title'=>$titre,'description'=>$description, 'canonical'=>$canonical, 'robots'=>$robots)
			)
		); 
		
	}	
	function footer(&$TParam) {
		$subsection = isset($TParam['subsection']) ? $TParam['subsection'] : 'Home Page';
		
		return TTemplate::render(TEMPLATE_DIR.'footer.html', array()
			, array( 'weborama'=> array('subsection'=>$subsection) )	); 
		
	}
	
	function field($name, $param) {
		
		$type = isset($param['type'])?$param['type']:'none';
		
		switch ($type) {
			case 'text':
				$r = '<input name="'.$name.'" id="xfield_'.$name.'" value="" class="xfield" />';
				
				break;
			case 'textarea':
				$r = '<textarea name="'.$name.'" id="xfield_'.$name.'" class="xfield"></textarea>';
				
				break;
			
			default:
				$r = '<span id="xfield_'.$name.'" class="xfield"></span>';
				break;
		}
		
		
		return $r;
		
	}

	function getButtons() {
		
		$r='<input type="button" name="bt_valid" value="valider" />';
		
		return $r;		
	}
}

?>

<?
class TTemplate {
	
	function show($tpl, $data=array()) {
	/*
	 * Fonction affichant le rendu d'une page frontend
	 *  
	 */
		$TBS = new clsTinyButStrong;
		
		
		$TBS->LoadTemplate($tpl);

		$TBS->MergeField('tpl',array(
			'header'=>file_get_contents( TEMPLATE_DIR.'header.php' )
			,'footer'=>file_get_contents( TEMPLATE_DIR.'footer.php' )
			,'buttons'=>TTemplate::getButtons()
		));

		foreach($data as $block=>$fields) {
			
			$Tab=array();
			foreach($fields as $k=>$param) {
				$Tab[$k] = TTemplate::field($k, $param);
			}
			
			$TBS->MergeField($block, $Tab);
		}

		$TBS->Show(TBS_OUTPUT+!TBS_EXIT);
		
		
		
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

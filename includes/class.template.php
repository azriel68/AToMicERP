<?
class TTemplate {
	
	function show($tpl) {
	
		
	
	
		$TBS = new clsTinyButStrong;
		
		
		$TBS->LoadTemplate($tpl);

		$TBS->MergeField('tpl',array(
			'header'=>file_get_contents( TEMPLATE_DIR.'header.php' )
			,'footer'=>file_get_contents( TEMPLATE_DIR.'footer.php' )
		));

		$TBS->Show();
		
	}
}
?>

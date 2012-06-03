<?
class TRequete {
	
	function get_something(&$db, $p1) {
		
		$sql="SELECT id FROM myTable WHERE something='$p1'";
		
		return TRequete::_get_id_by_sql($db, $sql);
		
	}
	
	function _get_id_by_sql(&$db, $sql) {
		$TResultat=array();	
		
		$db->Execute($sql);
		while($db->Get_line()){
			$TResultat[] = $db->Get_field('id');
		}
			
		return $TResultat;
	
	}
	
}

?>
<?php

class TUser extends TContact {
	
	function __construct() {
		
		parent::__construct();
		
		$this->t_connexion = 0;
		
	}
	
	function login (&$db, $login, $pwd) {
			
		$db->Execute("SELECT id FROM ".$this->get_table()." 
			WHERE login='".$db->quote($login)."' AND password='".$db->quote($pwd)."'")	;
			
		if($db->Get_line()) {
			
			$this->t_connexion = time();
			
			return $this->load($db, $db->Get_field('id'));
			
		}	
			
		return false;
	}
	
	function isLogged() {
		
		if(!empty($_SESSION['user']) && $this->t_connexion > 0 ) {
			return true;
			
		}
		
		return false;
	}
	function rights($module='main', $action='view') {
		
		if($this->isAdmin) return true;
		
		
		return false;
		
	}
	
	
}

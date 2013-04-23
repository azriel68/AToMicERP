<?php

class TUser extends TContact {
	
	function login ($login, $pwd) {
		return true;
	}
	
	function isLogged() {
		return true;
	}
}

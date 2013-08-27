<?php

namespace Libs\Auth;

require_once('Storage.php');
class Session extends Storage{
	public function __construct(){
		session_start();
	}
	public function set($key, $value){
		$_SESSION[$key] = $value;
	}
	public function get($key){
		if (isset($_SESSION[$key])) return $_SESSION[$key];
		else return NULL;
	}
	public function del($key){
		unset($_SESSION[$key]);
	}
}
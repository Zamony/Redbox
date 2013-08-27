<?php

namespace Libs\Auth;

class Auth{
	private $db;
	private $username;
	public function __construct($services, $storage = 0){
		$this->db = $services['db'];
		$this->storage = $services['session'];
	}
	public function check($user){
		if (md5($user['password']) === $this->db->hGet('app:info', 'password'))
			return True;
		else return False;
	}
	public function auth($user){
		if ($this->check($user)){
			if (isset($this->storage->time)) $this->storage->time = 604800;
			$this->storage->set('username', $user['username']);
		}
		else throw new \Exception("Username or password is incorrect");
	}
	public function isAuth(){
		$username = $this->storage->get('username');
		if ($username){
			$this->username = $username;
			return $username;
		}else return False;
	}
}
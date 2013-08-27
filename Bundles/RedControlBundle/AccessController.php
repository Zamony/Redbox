<?php

class AccessController{
	public $redirect_url = '/posts/dashboard/postsView';
	private $services;
	public function __construct($services){
		$this->services = $services;
	}
	public function login(){
		if (!$this->services['auth']->isAuth()){
			$this->services['render']->theme = $this->services['db']->hGet('app:info', 'admin_theme');
			$this->services['render']->page = 'login';
			$this->services['render']->inject('Only for dragons');
		} else{
			$route = $this->services['route'];
			$route::redirect($this->redirect_url);
		}
	}
	public function logout(){
		$this->services['RedControlBundle']->logout();
	}
	public function auth(){
		$this->services['RedControlBundle']->auth();
	}
}
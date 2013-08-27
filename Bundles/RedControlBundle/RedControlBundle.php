<?php
class RedControlBundle{
	public $redirect_url = 'http://zamony.dev/posts/dashboard/postsView';
	private $services;
	public $theme;

	public function __construct($services){
		$this->services = $services;
	}
	public function auth(){
		$this->services['auth']->auth($_POST);
		$route = $this->services['route'];
		$route::redirect($_SERVER['HTTP_REFERER']);
	}
	public function logout(){
		$this->services['session']->del('username');
		$route = $this->services['route'];
		$route::redirect("http://".$this->services['db']->hGet('app:info', 'home'));
	}
}
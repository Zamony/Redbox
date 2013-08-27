<?php
class DashboardSystemConfController{
	private $render;
	private $db;
	public function __construct($services){
		$this->db = $services['db'];
		$this->render = $services['render'];
		$services['render']->theme = $services['db']->hGet('app:info', 'admin_theme');
		$services['render']->data['dashboard-menu'] = $services['db']->hGet('app:menus', 'dashboard-menu');
	}
	public function edit(){
		$this->render->page = 'bundles/SystemConfBundle/edit';
		$this->render->data['info'] = $this->db->hGetAll('app:info');
		$this->render->inject("System Config Manager");
	}
	public function saveConf(){
		if (!$_POST['password']) unset($_POST['password']);
		else $_POST['password'] = md5($_POST['password']);
		foreach ($_POST as $rn =>$rv)
			$this->db->hSet('app:info', $rn, $rv);
	}
}
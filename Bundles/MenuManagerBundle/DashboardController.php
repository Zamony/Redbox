<?php
class DashboardMenuManagerController{
	private $render;
	private $db;
	public function __construct($services){
		$this->db = $services['db'];
		$this->render = $services['render'];
		$services['render']->theme = $services['db']->hGet('app:info', 'admin_theme');
		$services['render']->data['dashboard-menu'] = $services['db']->hGet('app:menus', 'dashboard-menu');
	}
	public function menu(){
		$this->render->page = 'bundles/MenuManagerBundle/menu';
		$this->render->data['menus'] = $this->db->hGetAll('app:menus');
		$this->render->inject("Menu Manager");
	}
	public function saveMenu(){
		return $this->db->hSet('app:menus', $_POST['menu_name'], $_POST['menu_content']);
	}
}
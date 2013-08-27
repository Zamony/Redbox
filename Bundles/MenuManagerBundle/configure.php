<?php
function deactivate($services){
	$menu = $services['db']->hGet('app:menus', 'dashboard-menu');
	$menu = json_decode($menu, True);
	unset($menu['Menu Manager']);
	$services['db']->hSet('app:menus', 'dashboard-menu', json_encode($menu));
}
function activate($services){
	$menu = $services['db']->hGet('app:menus', 'dashboard-menu');
	$menu = json_decode($menu, True);
	$menu['Menu Manager'] = '/menumanager/dashboardmenumanager/menu';
	$services['db']->hSet('app:menus', 'dashboard-menu', json_encode($menu));
}
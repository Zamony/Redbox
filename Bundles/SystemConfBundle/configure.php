<?php
function deactivate($services){
	$menu = $services['db']->hGet('app:menus', 'dashboard-menu');
	$menu = json_decode($menu, True);
	unset($menu['System']);
	$services['db']->hSet('app:menus', 'dashboard-menu', json_encode($menu));
}
function activate($services){
	$menu = $services['db']->hGet('app:menus', 'dashboard-menu');
	$menu = json_decode($menu, True);
	$menu['System'] = '/systemconf/dashboardsystemconf/edit';
	$services['db']->hSet('app:menus', 'dashboard-menu', json_encode($menu));
}
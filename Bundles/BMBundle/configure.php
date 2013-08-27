<?php
function deactivate($services){
	$menu = $services['db']->hGet('app:menus', 'dashboard-menu');
	$menu = json_decode($menu, True);
	unset($menu['Bundles']);
	$services['db']->hSet('app:menus', 'dashboard-menu', json_encode($menu));
}
function activate($services){
	$menu = $services['db']->hGet('app:menus', 'dashboard-menu');
	$menu = json_decode($menu, True);
	$menu['Bundles'] = array(
		'Bundles list'=>'/bm/dashboardbm/bundleList',
		'Install bundle'=>'/bm/dashboardbm/bundleList'
		);
	$services['db']->hSet('app:menus', 'dashboard-menu', json_encode($menu));
}
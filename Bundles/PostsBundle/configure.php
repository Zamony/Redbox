<?php
function deactivate($services){
	$services['db']->hDel('app:routes', '/');
	$services['db']->hDel('app:routes', '/tags');
	$services['db']->hDel('app:routes', '/page');
}
function activate($services){
	$services['db']->hSet('app:routes', '/', '/posts/category/view');
	$services['db']->hSet('app:routes', '/tags', '/posts/tags/view');
	$services['db']->hSet('app:routes', '/page', '/posts/page/view');
}
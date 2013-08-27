<?php
require_once('PostsBundle.php');
$redis = new Redis();
$redis->connect('localhost', 6379);
$redis->select(0);
$json_menu = json_encode(unserialize($redis->hget('app:menus', 'dashboard-menu')));
$json_menu = str_replace('\\', '', $json_menu);
$redis->hSet('app:menus', 'dashboard-menu', $json_menu);

// $config = parse_ini_file('config.ini');
// $redis->hSet('app:info', 'theme', $config['redbox_theme']);
// $redis->hSet('app:info', 'login', $config['redbox_login']);
// $redis->hSet('app:info', 'password', $config['redbox_password']);
// $redis->hSet('app:info', 'email', $config['redbox_email']);
// $redis->hSet('app:info', 'name', $config['redbox_app_name']);
// $redis->hSet('app:info', 'home', $_SERVER['SERVER_NAME'].'/');

// $redis->hSet('app:routes', '/', '/posts/category/view');
// $redis->hSet('app:routes', '/tags', '/posts/tags/view');
// $redis->hSet('app:routes', '/page', '/posts/page/view');

// $bundles = scandir('../Bundles');
// foreach ($bundles as $bundle){
// 	if ($bundle !== '.' and $bundle !=='..')
// 		$redis->sAdd('app:bundles', $bundle);
// }

// // Pimple emulation
// $services = array();
// $services['db'] = $redis;

// $posts = new PostsBundle($services);
// $post = array(
// 	'title'=>'Redbox на вашем сервере',
// 	'content'=>'Поздраляем, вы успешно завершили установку! Обо всех возможностях системы читайте в <a href="#">официальной документации</a>.',
// 	'category'=>'Uncategorized',
// 	'tags'=>'Redbox, Success Installation, Abient',
// 	'preview'=>'demo.jpg',
// 	'publish'=>1
// 	);
// $posts->addOne($post);
// $posts->publish();
// sleep(0.2);
// $post = array(
// 	'title'=>'Lorem Ipsum',
// 	'content'=>'Lorem Ipsum Dolor Sit Amet',
// 	'category'=>'Lorem',
// 	'tags'=>'Redbox, Lorem',
// 	'preview'=>'demo.jpg',
// 	'publish'=>1
// 	);
// $posts->addOne($post);
// $posts->publish();
// sleep(0.2);
// $post = array(
// 	'title'=>'Abient Corporation',
// 	'content'=>'Abient is the biggest corporion in the World. Today we attend their bussines-flat to discover how they work so succesfully.',
// 	'category'=>'Abient',
// 	'tags'=>'Redbox, Success Installation, Abient',
// 	'preview'=>'demo.jpg',
// 	'publish'=>1
// 	);
// $posts->addOne($post);
// $posts->publish();
$redis->close();
<?php
require_once('./Libs/Loader/Loader.php');

use Libs\Pimple\Pimple;
use Libs\Hooks\Hooks;
use Libs\Route\Request;
use Libs\Route\Route;
use Libs\Bundle\Bundle;
use Libs\Rendering\Render;
use Libs\Cache\Cache;
use Libs\Auth\Session;
use Libs\Auth\Auth;
use Libs\Auth\Storage;

$services = new Pimple();
$services['db'] = new Redis();
$services['db']->connect('localhost', 6379);

$loader = new Loader($services);
$loader->loadBundles();
$loader->registerServices($services);
$services['hooks'] = $services->share(function() use ($services){
	return new Hooks($services);
});
$services['hooks']->load($loader->bundles);
$services['request'] = $services->share(function() use ($services){
	return new Request($services);
});
$services['route'] = $services->share(function() use ($services){
	return new Route($services);
});
$services['render'] = $services->share(function() use ($services){
	return new Render($services);
});
$services['cache'] = $services->share(function() use ($services){
	return new Cache($services);
});
$services['session'] = $services->share(function(){
	return new Session();
});
$services['auth'] = $services->share(function() use ($services){
	return new Auth($services);
});
// var_dump($services['request']); // Don't delete
$services['route'];
$output = $services['cache']->cached;
if (!$output){
	$services['route']->callController($services);
	$output = $services['render']->join();
	if ($services['cache']->enable)
	$services['cache']->addPage($services['request']->args['url'],
								$output, 604800);
}
// var_dump($services);
echo $output;
$services['db']->close();
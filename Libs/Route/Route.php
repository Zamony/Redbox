<?php

namespace Libs\Route;

use Libs\Pimple\Pimple; 
use Libs\Rendering\Render;

class Route{
	public $bundle_path = './Bundles/';
	public $bundle = NULL;
	private $url = NULL;
	private $request = NULL;
	private $redis = NULL;
	private static $render = NULL;

	public function __construct(Pimple $services){
		$this->url = $services['request'];
		$this->redis = $services['db'];
		self::$render = $services['render'];
	}
	public function __destruct(){
		$this->redis->close();
	}
	public function callController($services){
		$class_name = $this->url->controller.'Controller';
		$action = $this->url->action;
		$permission = (substr($this->url->controller, 0, 9) !== 'Dashboard' or $services['auth']->isAuth());
		if (class_exists($class_name) and method_exists($class_name, $action) and $permission){
			$ctr = new $class_name($services);
			$ctr->{$action}($this->url->option);
		}else self::notFound();
	}
	public static function redirect($url){
		header('Location: '.$url);
	}
	public static function notFound(){
		header("HTTP/1.0 404 Not Found");
		self::$render->page = 'error404';
		self::$render->inject('404. Not found');
	}
}
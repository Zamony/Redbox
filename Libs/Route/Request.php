<?php

namespace Libs\Route;

use Libs\Pimple\Pimple;
use Libs\Cache\Cache;

class BadRequestException extends \Exception{}
class Request{
	public $url = NULL;
	public $bundle = NULL;
	public $controller = NULL;
	public $action = NULL;
	public $option = NULL;
	public $args = NULL;
	private $redis = NULL;

	public function __construct(Pimple $services){
		$this->redis = $services['db'];
		$this->url = $_SERVER['REQUEST_URI'];

		#Obtain cache if exists
		$cached = $services['cache']->isCached($this->url);
		if ($cached){
			$services['cache']->cached = $cached;
			// Here is a problem, hooks is called on every cached page, but it must
			// hooking only on post page
			$services['hooks']->call('post_view', array(end(explode('/', $this->url))));
			return;
		}
		#Hooks for parsing request
		$services['hooks']->call('request_init', array(&$this->url));
		// isPage($this->url);
		#Check if URL is short(user-friendly
		$addr = explode('/', $this->url);
		$option = array_pop($addr);
		$short = sizeof($addr)<2 ? '/' : implode('/', $addr);
		if ($this->redis->hexists('app:routes', $short)){
			$this->url = $this->redis->hget('app:routes', $short);
			$this->url .= '/'.$option;
			$url = explode('/', $this->url);
			$this->requestPartsSetter($url);
		}else{
			$url = explode('/', $this->url);
			if (sizeof($url)===4) $url[] = NULL;
			if (sizeof($url)===5)
				$this->requestPartsSetter($url);
		}
	}
	private function requestPartsSetter($url){
		list($empty, $this->bundle, $this->controller, $this->action, $this->option) = $url;
		$this->bundle = ucfirst($this->bundle);
		$this->controller = ucfirst($this->controller);
		$this->action = explode('?', $this->action, 2)[0];
		$this->option = strtolower($this->option);
		$this->args = $_GET;
		$this->args['url'] = $_SERVER['REQUEST_URI'];
	}
}
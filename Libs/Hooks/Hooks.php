<?php

namespace Libs\Hooks;

class Hooks{
	public $hooks = array();
	public $enable = True;
	private $services = NULL;
	public function __construct($services){
		$this->services = $services;
	}
	public function add($hook_name, $func){
		$this->hooks[$hook_name][] = is_array($func) ?
		 array($func[0], $func[1]) : $func;
	}
	public function call($hook_name, $param){
		if (!isset($this->hooks[$hook_name])) return;
		foreach ($this->hooks[$hook_name] as $hook){
			if (!is_array($hook))
				call_user_func_array($hook, $param);
			else 
				call_user_func_array(array($this->services[$hook[0]], $hook[1]), $param);
		}
	}
	public function load($bundles){
		if ($this->enable)
			$this->loadHooks($bundles);
	}
	private function loadHooks($bundles){
		foreach ($bundles as $bundle){
			$bundle_path = "./Bundles/$bundle/hooks.php";
			if (file_exists($bundle_path))
				include_once($bundle_path);
		}
	}
}
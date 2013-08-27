<?php

class Loader{
	private $db = NULL;
	public $bundles = array();
	public function __construct($services){
		$this->db = $services['db'];
		$this->bundles = $services['db']->sMembers('app:bundles:activated');
	}
	public static function loadLib($name){
		$name = implode('/', explode("\\", $name));
		if (file_exists("./$name.php")) require_once("./$name.php");
	}
	public function loadBundles(){
		foreach($this->bundles as $bundle){
			$bundle_path = "./Bundles/$bundle";
			$files = scandir($bundle_path);
			foreach ($files as $file){
				if ($file !== '.' and $file !== '..' and $file === ucfirst($file))
					require_once("$bundle_path/$file");
			}
		}
	}
	public function registerServices(&$services){
		foreach ($this->bundles as $bundle){
			if (class_exists($bundle)){
				// $binstance = new $bundle($services);
				$services[$bundle] = $services->share(function() use ($bundle, $services){
					return new $bundle($services);
				});
			}
		}
	}
}
spl_autoload_register(array('Loader', 'loadLib'));